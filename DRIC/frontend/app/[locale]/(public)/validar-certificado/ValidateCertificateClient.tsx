"use client";

import { FormEvent, useCallback, useEffect, useLayoutEffect, useRef, useState } from "react";
import { useLocale, useTranslations } from "next-intl";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

type CertificateData = {
  code: string;
  full_name: string;
  certificate_type: string;
  issue_date: string;
  description: string;
};

type EditableText = {
  eyebrow: string;
  title: string;
  description: string;
};

type Props = {
  editableText: EditableText;
};

const CERTIFICATE_SESSION_KEY = "dric-certificate-verification";

export default function ValidateCertificateClient({ editableText }: Props) {
  const locale = useLocale();
  const t = useTranslations("certificateVerification");

  const [code, setCode] = useState("");
  const [certificate, setCertificate] = useState<CertificateData | null>(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const verificationRequestRef = useRef<AbortController | null>(null);

  const apiUrl = process.env.NEXT_PUBLIC_API_URL ?? "http://127.0.0.1:8000/api";

  const formatDate = (date: string) => {
    return new Intl.DateTimeFormat(locale === "es" ? "es-BO" : "en-US").format(new Date(date));
  };

  const resetVerification = useCallback(() => {
    verificationRequestRef.current?.abort();
    verificationRequestRef.current = null;
    setCode("");
    setCertificate(null);
    setError("");
    setLoading(false);
  }, []);

  useEffect(() => {
    resetVerification();

    try {
      sessionStorage.removeItem(CERTIFICATE_SESSION_KEY);
    } catch {
    }

    const handlePageShow = (event: PageTransitionEvent) => {
      if (event.persisted) resetVerification();
    };

    window.addEventListener("pagehide", resetVerification);
    window.addEventListener("pageshow", handlePageShow);

    return () => {
      verificationRequestRef.current?.abort();
      verificationRequestRef.current = null;
      window.removeEventListener("pagehide", resetVerification);
      window.removeEventListener("pageshow", handlePageShow);
    };
  }, [locale, resetVerification]);

  const verifyCertificate = useCallback(async (cleanCode: string) => {
    verificationRequestRef.current?.abort();
    verificationRequestRef.current = null;
    setError("");
    setCertificate(null);
    setLoading(false);

    if (!/^[A-Z0-9]{7}$/.test(cleanCode)) {
      setError(t("invalidCode"));
      return;
    }

    const controller = new AbortController();
    verificationRequestRef.current = controller;
    setLoading(true);

    try {
      const response = await fetch(`${apiUrl}/certificates/verify`, {
        method: "POST",
        signal: controller.signal,
        cache: "no-store",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ code: cleanCode, locale }),
      });

      const result = await response.json();
      if (controller.signal.aborted) return;

      if (!response.ok) {
        setError(t("notFound"));
        return;
      }

      const nextCertificate = {
        code: result.data.code,
        full_name: result.data.full_name,
        certificate_type: result.data.certificate_type,
        issue_date: result.data.issue_date ?? result.data.start_date,
        description: result.data.description ?? result.data.end_date,
      };

      setCertificate(nextCertificate);
    } catch {
      if (!controller.signal.aborted) setError(t("serverError"));
    } finally {
      if (verificationRequestRef.current === controller) {
        verificationRequestRef.current = null;
        setLoading(false);
      }
    }
  }, [apiUrl, locale, t]);

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    const cleanCode = code.trim().toUpperCase();

    await verifyCertificate(cleanCode);
  };

  return (
    <>
      <Header />

      <main className="dric-certificate-page relative overflow-hidden px-4 pb-[49px] pt-[135px] sm:px-6 sm:pt-[149px] md:pt-[153px]">
        <section className="relative mx-auto max-w-6xl">
          <div className="dric-certificate-glass rounded-3xl p-5 sm:p-8 md:rounded-[2.8rem] md:p-12">
            <p className="mb-4 max-w-full text-xs font-semibold uppercase leading-relaxed tracking-[0.22em] text-[#E30613] sm:tracking-[0.38em]">
              {editableText.eyebrow}
            </p>

            <ResponsiveCertificateTitle title={editableText.title} />

            <p className="dric-certificate-muted mt-5 w-full min-w-0 hyphens-none text-justify text-sm leading-7 [text-align-last:left] md:mt-6 md:text-base">
              {editableText.description}
            </p>

            <form onSubmit={handleSubmit} className="mt-10 max-w-2xl md:mt-12">
              <label className="dric-certificate-label mb-4 block text-sm font-medium">
                {t("inputLabel")}
              </label>

              <div className="dric-certificate-input-shell flex flex-col gap-4 rounded-3xl p-3 md:flex-row">
                <input
                  autoComplete="off"
                  value={code}
                  onChange={(event) => setCode(event.target.value.toUpperCase())}
                  maxLength={7}
                  placeholder="1A2BC3D"
                  className="dric-certificate-input min-h-14 flex-1 rounded-2xl px-5 text-base uppercase tracking-[0.18em] outline-none transition sm:text-lg sm:tracking-[0.22em]"
                />

                <button
                  type="submit"
                  disabled={loading}
                  className="dric-certificate-button rounded-2xl px-5 py-4 text-sm font-semibold uppercase tracking-[0.14em] transition disabled:cursor-not-allowed disabled:opacity-60 sm:px-7 sm:tracking-[0.18em]"
                >
                  {loading ? t("checking") : t("button")}
                </button>
              </div>

              {error && (
                <p className="mt-4 rounded-2xl border border-red-300/70 bg-red-50/80 px-5 py-4 text-sm text-red-700 backdrop-blur-xl">
                  {error}
                </p>
              )}
            </form>

            {certificate && (
              <div className="dric-certificate-table mt-12 overflow-hidden rounded-[2rem]">
                <div className="dric-certificate-table-header px-6 py-5">
                  <p className="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-700">
                    {t("resultTitle")}
                  </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-4">
                  <div className="dric-certificate-cell p-6">
                    <p className="dric-certificate-cell-label text-xs uppercase tracking-[0.24em]">
                      {t("fullName")}
                    </p>
                    <p className="dric-certificate-cell-value mt-3 text-lg">
                      {certificate.full_name}
                    </p>
                  </div>

                  <div className="dric-certificate-cell p-6">
                    <p className="dric-certificate-cell-label text-xs uppercase tracking-[0.24em]">
                      {t("certificate")}
                    </p>
                    <p className="dric-certificate-cell-value mt-3 text-lg">
                      {certificate.certificate_type}
                    </p>
                  </div>

                  <div className="dric-certificate-cell p-6">
                    <p className="dric-certificate-cell-label text-xs uppercase tracking-[0.24em]">
                      {t("issueDate")}
                    </p>
                    <p className="dric-certificate-cell-value mt-3 text-lg">
                      {formatDate(certificate.issue_date)}
                    </p>
                  </div>

                  <div className="dric-certificate-cell p-6">
                    <p className="dric-certificate-cell-label text-xs uppercase tracking-[0.24em]">
                      {t("certificateDescription")}
                    </p>
                    <p className="dric-certificate-cell-value mt-3 text-lg leading-7">
                      {certificate.description}
                    </p>
                  </div>
                </div>
              </div>
            )}
          </div>
        </section>
      </main>

      <Footer />
    </>
  );
}

function ResponsiveCertificateTitle({ title }: { title: string }) {
  const headingRef = useRef<HTMLHeadingElement>(null);
  const [scale, setScale] = useState(1);

  useLayoutEffect(() => {
    const heading = headingRef.current;
    const container = heading?.parentElement;
    if (!heading || !container) return;

    let active = true;
    let frame = 0;

    const update = () => {
      if (!active) return;
      if (!window.matchMedia("(max-width: 639px)").matches) {
        setScale(1);
        return;
      }

      const availableWidth = container.clientWidth;
      if (!availableWidth) return;

      const computed = window.getComputedStyle(heading);
      const probe = document.createElement("span");
      probe.style.position = "fixed";
      probe.style.visibility = "hidden";
      probe.style.whiteSpace = "nowrap";
      probe.style.fontFamily = computed.fontFamily;
      probe.style.fontSize = computed.fontSize;
      probe.style.fontWeight = computed.fontWeight;
      probe.style.fontStyle = computed.fontStyle;
      probe.style.letterSpacing = computed.letterSpacing;
      probe.style.textTransform = computed.textTransform;
      document.body.appendChild(probe);

      const longestWord = Math.max(0, ...title.trim().split(/\s+/u).map((word) => {
        probe.textContent = word;
        return probe.getBoundingClientRect().width;
      }));
      probe.remove();

      const nextScale = longestWord > availableWidth - 2
        ? (availableWidth - 2) / longestWord
        : 1;
      setScale((current) => Math.abs(current - nextScale) < 0.001 ? current : nextScale);
    };

    const schedule = () => {
      if (!active) return;
      cancelAnimationFrame(frame);
      frame = requestAnimationFrame(update);
    };

    const observer = new ResizeObserver(schedule);
    observer.observe(container);
    window.addEventListener("resize", schedule);
    void document.fonts.ready.then(schedule);
    schedule();

    return () => {
      active = false;
      cancelAnimationFrame(frame);
      observer.disconnect();
      window.removeEventListener("resize", schedule);
    };
  }, [title]);

  return (
    <div className="w-full min-w-0 max-w-[18rem] sm:max-w-2xl md:max-w-5xl">
      <h1
        ref={headingRef}
        className="dric-certificate-title w-full break-normal hyphens-none text-[2.41rem] font-light uppercase leading-[1.04] tracking-[-0.025em] [overflow-wrap:normal] sm:break-words sm:text-5xl sm:[overflow-wrap:break-word] md:text-7xl md:leading-none md:tracking-[-0.075em]"
        style={scale < 1 ? {
          width: `${100 / scale}%`,
          transform: `scaleX(${scale})`,
          transformOrigin: "left top",
        } : undefined}
      >
        {title}
      </h1>
    </div>
  );
}
