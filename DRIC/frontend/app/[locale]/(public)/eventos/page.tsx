import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "Agenda institucional",
    title: "Eventos",
    intro:
      "Conoce las actividades, encuentros académicos, convocatorias y espacios de cooperación internacional difundidos por la DRIC.",
    status: "Próximamente",
    description:
      "Este espacio quedará conectado al CMS para publicar eventos, fechas, enlaces de registro y materiales informativos.",
  },
  en: {
    eyebrow: "Institutional agenda",
    title: "Events",
    intro:
      "Discover activities, academic meetings, calls, and international cooperation spaces shared by DRIC.",
    status: "Coming soon",
    description:
      "This area will be connected to the CMS to publish events, dates, registration links, and informational materials.",
  },
};

export default async function EventosPage({ params }: Props) {
  const { locale } = await params;
  const t = content[locale as "es" | "en"] ?? content.es;

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-24 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.40),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.48),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="absolute left-1/2 top-24 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            {t.eyebrow}
          </p>

          <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {t.title}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {t.intro}
          </p>

          <div className="mt-16 max-w-3xl rounded-[2rem] border border-white/10 bg-white/[0.04] p-8 shadow-2xl backdrop-blur-xl md:p-10">
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-cyan-300">
              {t.status}
            </p>

            <p className="mt-5 text-lg leading-8 text-white/65">
              {t.description}
            </p>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
