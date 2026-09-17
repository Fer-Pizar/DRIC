"use client";

import { useEffect, useState } from "react";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "Atención DRIC",
    title: "Agenda una cita con la DRIC",
    intro:
      "Cuéntanos brevemente el motivo de tu consulta para orientar mejor tu atención. El mensaje será preparado para enviarse al correo institucional de la DRIC.",
    name: "Nombre completo",
    email: "Correo electrónico",
    phone: "Teléfono o WhatsApp",
    topic: "Motivo de la cita",
    date: "Fecha sugerida",
    message: "Describe tu consulta",
    consent:
      "Acepto que mis datos sean usados únicamente para gestionar esta solicitud de cita.",
    button: "Preparar solicitud",
    sending: "Enviando solicitud...",
    success: "Tu solicitud fue enviada correctamente. La DRIC recibirá el mensaje por correo electrónico.",
    error: "No se pudo enviar la solicitud. Inténtalo nuevamente en unos minutos.",
    topics: [
      "Convenios",
      "Becas y movilidad",
      "Certificados",
      "Cooperación internacional",
      "Otro",
    ],
  },
  en: {
    eyebrow: "DRIC Assistance",
    title: "Schedule an appointment with DRIC",
    intro:
      "Tell us briefly the reason for your request so we can guide your appointment properly. The message will be prepared to be sent to DRIC’s institutional email.",
    name: "Full name",
    email: "Email address",
    phone: "Phone or WhatsApp",
    topic: "Appointment topic",
    date: "Suggested date",
    message: "Describe your request",
    consent:
      "I agree that my data will be used only to manage this appointment request.",
    button: "Prepare request",
    sending: "Sending request...",
    success: "Your request was sent successfully. DRIC will receive the message by email.",
    error: "The request could not be sent. Please try again in a few minutes.",
    topics: [
      "Agreements",
      "Scholarships and mobility",
      "Certificates",
      "International cooperation",
      "Other",
    ],
  },
};

const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://127.0.0.1:8000/api";

export default function AgendarCitaPage({ params }: Props) {
  const [locale, setLocale] = useState<"es" | "en">("es");
  const t = content[locale];

  useEffect(() => {
    params.then(({ locale }) => {
      setLocale(locale === "en" ? "en" : "es");
    });
  }, [params]);

  const [form, setForm] = useState({
    name: "",
    email: "",
    phone: "",
    topic: "",
    date: "",
    message: "",
    consent: false,
  });
  const [status, setStatus] = useState<"idle" | "sending" | "success" | "error">("idle");

  const updateField = (field: string, value: string) => {
    setForm((prev) => ({ ...prev, [field]: value }));
  };

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();

    setStatus("sending");

    try {
      const response = await fetch(`${API_BASE_URL}/appointments`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          ...form,
          locale,
        }),
      });

      if (!response.ok) {
        throw new Error("Appointment request failed");
      }

      setForm({
        name: "",
        email: "",
        phone: "",
        topic: "",
        date: "",
        message: "",
        consent: false,
      });
      setStatus("success");
    } catch {
      setStatus("error");
    }
  };

  return (
    <main className="dric-theme-page dric-appointment-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-appointment-section relative isolate px-4 pb-20 pt-36 sm:px-6 sm:pb-24 sm:pt-40 md:pb-28 md:pt-44">
        <div className="dric-appointment-glow absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(0,55,112,0.18),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(227,6,19,0.14),transparent_36%)]" />

        <div className="mx-auto grid max-w-7xl gap-8 sm:gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:gap-12">
          <div className="min-w-0">
            <p className="text-xs uppercase tracking-[0.22em] text-[#E30613] sm:text-sm sm:tracking-[0.35em]">
              {t.eyebrow}
            </p>

            <h1 className="mt-5 max-w-full break-words text-[2.7rem] font-light leading-[1.08] tracking-[-0.025em] sm:mt-6 sm:text-5xl sm:leading-tight sm:tracking-wide md:text-6xl lg:text-7xl">
              {t.title}
            </h1>

            <p className="dric-appointment-muted mt-6 max-w-2xl text-base leading-8 text-white/60 sm:mt-8 sm:text-lg sm:leading-relaxed">
              {t.intro}
            </p>

          </div>

          <form
            onSubmit={handleSubmit}
            className="dric-appointment-form min-w-0 rounded-[1.75rem] border border-white/10 bg-white/[0.05] p-4 shadow-2xl backdrop-blur-xl sm:rounded-[2rem] sm:p-6 md:p-8"
          >
            <div className="grid min-w-0 gap-4 sm:gap-5 md:grid-cols-2">
              <input required placeholder={t.name} value={form.name} onChange={(e) => updateField("name", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4" />
              <input required type="email" placeholder={t.email} value={form.email} onChange={(e) => updateField("email", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4" />
              <input placeholder={t.phone} value={form.phone} onChange={(e) => updateField("phone", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4" />

              <select required value={form.topic} onChange={(e) => updateField("topic", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-[#071126] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4">
                <option value="">{t.topic}</option>
                {t.topics.map((topic) => (
                  <option key={topic}>{topic}</option>
                ))}
              </select>

              <input type="date" value={form.date} onChange={(e) => updateField("date", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4" />
            </div>

            <textarea
              required
              placeholder={t.message}
              value={form.message}
              onChange={(e) => updateField("message", e.target.value)}
              rows={6}
              className="dric-appointment-field mt-4 min-h-44 w-full min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:mt-5 sm:px-5 sm:py-4"
            />

            <label className="mt-5 flex items-start gap-3 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-sm leading-6 text-white/70 sm:px-5">
              <input
                required
                type="checkbox"
                checked={form.consent}
                onChange={(e) => setForm((prev) => ({ ...prev, consent: e.target.checked }))}
                className="mt-1 h-4 w-4 rounded border-white/30 bg-transparent accent-[#E30613]"
              />
              <span>{t.consent}</span>
            </label>

            <button
              type="submit"
              disabled={status === "sending"}
              className="dric-appointment-submit mt-5 w-full rounded-full border border-white/20 bg-[#003770] px-6 py-4 text-base font-semibold text-white shadow-[0_0_40px_rgba(0,55,112,0.18)] transition hover:scale-[1.01] hover:bg-[#E30613] sm:mt-6 sm:px-8 sm:text-lg"
            >
              {status === "sending" ? t.sending : t.button}
            </button>

            {status === "success" || status === "error" ? (
              <p
                className={`mt-4 rounded-2xl border px-4 py-3 text-sm leading-6 ${
                  status === "success"
                    ? "border-emerald-300/30 bg-emerald-400/10 text-emerald-100"
                    : "border-red-300/30 bg-red-400/10 text-red-100"
                }`}
                role="status"
              >
                {status === "success" ? t.success : t.error}
              </p>
            ) : null}
          </form>
        </div>
      </section>

      <Footer />
    </main>
  );
}
