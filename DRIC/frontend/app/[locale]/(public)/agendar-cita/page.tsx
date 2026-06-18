"use client";

import { useState } from "react";
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

  params.then(({ locale }) => {
    if (locale === "en" && t !== content.en) setLocale("en");
  });

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
    <main className="min-h-screen overflow-x-hidden bg-white text-slate-950 dark:bg-[#020617] dark:text-white">
      <Header />

      <section className="relative px-6 pb-28 pt-44">
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.18),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(181,18,27,0.14),transparent_36%)]" />

        <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
          <div>
            <p className="text-sm uppercase tracking-[0.35em] text-cyan-500 dark:text-cyan-300">
              {t.eyebrow}
            </p>

            <h1 className="mt-6 text-5xl font-light leading-tight tracking-wide md:text-7xl">
              {t.title}
            </h1>

            <p className="mt-8 max-w-2xl text-lg leading-relaxed text-slate-600 dark:text-white/60">
              {t.intro}
            </p>

            <div className="mt-10 rounded-3xl border border-slate-200 bg-white/70 p-6 shadow-2xl backdrop-blur-xl dark:border-white/10 dark:bg-white/[0.04]">
              <p className="text-sm leading-7 text-slate-600 dark:text-white/60">
                {t.note}
              </p>
            </div>
          </div>

          <form
            onSubmit={handleSubmit}
            className="rounded-[2rem] border border-slate-200 bg-white/80 p-6 shadow-2xl backdrop-blur-xl dark:border-white/10 dark:bg-white/[0.05] md:p-8"
          >
            <div className="grid gap-5 md:grid-cols-2">
              <input required placeholder={t.name} value={form.name} onChange={(e) => updateField("name", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]" />
              <input required type="email" placeholder={t.email} value={form.email} onChange={(e) => updateField("email", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]" />
              <input placeholder={t.phone} value={form.phone} onChange={(e) => updateField("phone", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]" />

              <select required value={form.topic} onChange={(e) => updateField("topic", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-[#071126]">
                <option value="">{t.topic}</option>
                {t.topics.map((topic) => (
                  <option key={topic}>{topic}</option>
                ))}
              </select>

              <input type="date" value={form.date} onChange={(e) => updateField("date", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]" />
              <input type="time" value={form.time} onChange={(e) => updateField("time", e.target.value)} className="rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]" />
            </div>

            <textarea
              required
              placeholder={t.message}
              value={form.message}
              onChange={(e) => updateField("message", e.target.value)}
              rows={6}
              className="mt-5 w-full rounded-2xl border border-slate-200 bg-white px-5 py-4 outline-none focus:border-cyan-400 dark:border-white/10 dark:bg-white/[0.04]"
            />

            <button
              type="submit"
              className="mt-6 w-full rounded-full border border-cyan-300/40 bg-cyan-300/10 px-8 py-4 font-semibold text-cyan-700 shadow-[0_0_40px_rgba(34,211,238,0.18)] transition hover:scale-[1.01] hover:bg-cyan-300/20 dark:text-cyan-200"
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