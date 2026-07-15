import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "Marco institucional",
    title: "Normativas",
    intro:
      "Consulta reglamentos, resoluciones, políticas y documentos institucionales vinculados a movilidad, cooperación académica, internacionalización y convenios de la UMSS.",
    search: "Buscar normativa...",
    category: "Categoría",
    download: "Descargar",
    view: "Ver documento",
    items: [
      {
        code: "RED-INT.-AUGM",
        title: "Programa Escala de Estudiantes de Posgrado",
        category: "Tercero",
        file: "#",
      },
      {
        code: "RED-INT.-CRISCOS",
        title: "Programa de Movilidad Estudiantil CRISCOS",
        category: "Tercero",
        file: "#",
      },
      {
        code: "SUB-MAR/2024",
        title: "Reglamento de Internacionalización Universitaria",
        category: "Primero",
        file: "#",
      },
      {
        code: "SUB-MAR/2024",
        title: "Reglamento para elaboración y suscripción de convenios",
        category: "Primero",
        file: "#",
      },
    ],
  },
  en: {
    eyebrow: "Institutional framework",
    title: "Regulations",
    intro:
      "Browse regulations, resolutions, policies, and institutional documents related to mobility, academic cooperation, internationalization, and UMSS agreements.",
    search: "Search regulation...",
    category: "Category",
    download: "Download",
    view: "View document",
    items: [
      {
        code: "RED-INT.-AUGM",
        title: "Graduate Student Scale Program",
        category: "Third",
        file: "#",
      },
      {
        code: "RED-INT.-CRISCOS",
        title: "CRISCOS Student Mobility Program",
        category: "Third",
        file: "#",
      },
      {
        code: "SUB-MAR/2024",
        title: "University Internationalization Regulation",
        category: "First",
        file: "#",
      },
      {
        code: "SUB-MAR/2024",
        title: "Regulation for drafting and signing agreements",
        category: "First",
        file: "#",
      },
    ],
  },
};

export default async function NormativasPage({ params }: Props) {
  const { locale } = await params;
  const t = content[locale as "es" | "en"] ?? content.es;

  return (
    <main className="dric-theme-page dric-regulations-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-regulations-section relative px-6 pb-28 pt-44">
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(0,55,112,0.18),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(227,6,19,0.12),transparent_34%)]" />

        <div className="mx-auto max-w-7xl">
          <div className="max-w-4xl">
            <p className="text-sm uppercase tracking-[0.35em] text-cyan-300">
              {t.eyebrow}
            </p>

            <h1 className="mt-6 text-6xl font-light tracking-wide md:text-8xl">
              {t.title}
            </h1>

            <p className="mt-8 text-xl leading-relaxed text-white/60">
              {t.intro}
            </p>
          </div>

          <div className="dric-regulations-panel mt-16 rounded-[2rem] border border-white/10 bg-white/[0.04] p-6 shadow-2xl backdrop-blur-xl">
            <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
              <input
                placeholder={t.search}
                className="dric-regulations-input w-full rounded-full border border-white/10 bg-white/[0.04] px-6 py-4 text-sm text-white outline-none placeholder:text-white/35 focus:border-cyan-300/60 md:max-w-md"
              />

              <select className="dric-regulations-select rounded-full border border-white/10 bg-[#071126] px-6 py-4 text-sm text-white outline-none focus:border-cyan-300/60">
                <option>{t.category}</option>
                <option>Primero</option>
                <option>Tercero</option>
              </select>
            </div>

            <div className="dric-regulations-list overflow-hidden rounded-[1.5rem] border border-white/10">
              {t.items.map((item) => (
                <a
                  key={`${item.code}-${item.title}`}
                  href={item.file}
                  className="dric-regulations-row group grid gap-4 border-b border-white/10 bg-white/[0.02] p-6 transition hover:bg-cyan-300/[0.07] md:grid-cols-[180px_1fr_140px_150px] md:items-center"
                >
                  <span className="text-sm font-semibold uppercase tracking-[0.18em] text-cyan-200">
                    {item.code}
                  </span>

                  <span className="text-lg text-white/80 transition group-hover:text-white">
                    {item.title}
                  </span>

                  <span className="w-fit rounded-full border border-red-300/30 bg-red-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-red-200">
                    {item.category}
                  </span>

                  <span className="text-sm font-semibold text-cyan-300 transition group-hover:text-white">
                    {t.download} →
                  </span>
                </a>
              ))}
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
