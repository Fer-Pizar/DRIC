"use client";

import { FormEvent, useState } from "react";
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

export default function ValidateCertificatePage() {
  const locale = useLocale();
  const t = useTranslations("certificateVerification");

  const [code, setCode] = useState("");
  const [certificate, setCertificate] = useState<CertificateData | null>(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const apiUrl = process.env.NEXT_PUBLIC_API_URL ?? "http://127.0.0.1:8000/api";

  const formatDate = (date: string) => {
    return new Intl.DateTimeFormat(locale === "es" ? "es-BO" : "en-US").format(new Date(date));
  };

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    const cleanCode = code.trim().toUpperCase();

    setError("");
    setCertificate(null);

    if (!/^[A-Z0-9]{7}$/.test(cleanCode)) {
      setError(t("invalidCode"));
      return;
    }

    setLoading(true);

    try {
      const response = await fetch(`${apiUrl}/certificates/verify`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ code: cleanCode }),
      });

      const result = await response.json();

      if (!response.ok) {
        setError(t("notFound"));
        return;
      }

      setCertificate({
        code: result.data.code,
        full_name: result.data.full_name,
        certificate_type: result.data.certificate_type,
        issue_date: result.data.issue_date ?? result.data.start_date,
        description: result.data.description ?? result.data.end_date,
      });
    } catch {
      setError(t("serverError"));
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Header />

      <main className="dric-certificate-page relative min-h-screen overflow-hidden px-4 pb-24 pt-32 sm:px-6 md:pt-36">
        <section className="relative mx-auto max-w-6xl">
          <div className="dric-certificate-glass rounded-3xl p-5 sm:p-8 md:rounded-[2.8rem] md:p-12">
            <p className="mb-4 max-w-full text-xs font-semibold uppercase leading-relaxed tracking-[0.22em] text-[#E30613] sm:tracking-[0.38em]">
              {t("eyebrow")}
            </p>

            <h1 className="dric-certificate-title max-w-[18rem] break-words text-[2.41rem] font-light uppercase leading-[1.04] tracking-[-0.025em] sm:max-w-2xl sm:text-5xl md:max-w-5xl md:text-7xl md:leading-none md:tracking-[-0.075em]">
              {t("title")}
            </h1>

            <p className="dric-certificate-muted mt-5 max-w-2xl text-sm leading-7 md:mt-6 md:text-base">
              {t("description")}
            </p>

            <form onSubmit={handleSubmit} className="mt-10 max-w-2xl md:mt-12">
              <label className="dric-certificate-label mb-4 block text-sm font-medium">
                {t("inputLabel")}
              </label>

              <div className="dric-certificate-input-shell flex flex-col gap-4 rounded-3xl p-3 md:flex-row">
                <input
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
