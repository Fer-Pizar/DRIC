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
    time: "Hora sugerida",
    message: "Describe tu consulta",
    button: "Preparar solicitud",
    note: "Se abrirá tu aplicación de correo con el mensaje listo para enviar.",
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
    time: "Suggested time",
    message: "Describe your request",
    button: "Prepare request",
    note: "Your email app will open with the message ready to send.",
    topics: [
      "Agreements",
      "Scholarships and mobility",
      "Certificates",
      "International cooperation",
      "Other",
    ],
  },
};

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
    time: "",
    message: "",
  });

  const updateField = (field: string, value: string) => {
    setForm((prev) => ({ ...prev, [field]: value }));
  };

  const handleSubmit = (event: React.FormEvent) => {
    event.preventDefault();

    const subject =
      locale === "es"
        ? `Solicitud de cita DRIC - ${form.name}`
        : `DRIC appointment request - ${form.name}`;

    const body =
      locale === "es"
        ? `
Nombre completo: ${form.name}
Correo electrónico: ${form.email}
Teléfono / WhatsApp: ${form.phone}
Motivo de la cita: ${form.topic}
Fecha sugerida: ${form.date}
Hora sugerida: ${form.time}

Consulta:
${form.message}
`
        : `
Full name: ${form.name}
Email address: ${form.email}
Phone / WhatsApp: ${form.phone}
Appointment topic: ${form.topic}
Suggested date: ${form.date}
Suggested time: ${form.time}

Request:
${form.message}
`;

    window.location.href = `mailto:dric@umss.edu?subject=${encodeURIComponent(
      subject
    )}&body=${encodeURIComponent(body)}`;
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

            <div className="dric-appointment-note mt-8 rounded-3xl border border-white/10 bg-white/[0.04] p-5 shadow-2xl backdrop-blur-xl sm:mt-10 sm:p-6">
              <p className="dric-appointment-muted text-sm leading-7 text-white/60 sm:text-base">
                {t.note}
              </p>
            </div>
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
              <input type="time" value={form.time} onChange={(e) => updateField("time", e.target.value)} className="dric-appointment-field min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:px-5 sm:py-4" />
            </div>

            <textarea
              required
              placeholder={t.message}
              value={form.message}
              onChange={(e) => updateField("message", e.target.value)}
              rows={6}
              className="dric-appointment-field mt-4 min-h-44 w-full min-w-0 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-base outline-none focus:border-[#003770] sm:mt-5 sm:px-5 sm:py-4"
            />

            <button
              type="submit"
              className="dric-appointment-submit mt-5 w-full rounded-full border border-white/20 bg-[#003770] px-6 py-4 text-base font-semibold text-white shadow-[0_0_40px_rgba(0,55,112,0.18)] transition hover:scale-[1.01] hover:bg-[#E30613] sm:mt-6 sm:px-8 sm:text-lg"
            >
              {t.button}
            </button>
          </form>
        </div>
      </section>

      <Footer />
    </main>
  );
}
