import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import RegulationsExplorer from "@/components/regulations/RegulationsExplorer";
import { getRegulations } from "@/lib/regulations/regulationsCatalog";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "Marco institucional",
    title: "Normativas",
    intro:
      "Reglamentos, resoluciones, políticas y documentos oficiales vinculados a internacionalización, movilidad académica, cooperación y convenios de la UMSS.",
  },
  en: {
    eyebrow: "Institutional framework",
    title: "Regulations",
    intro:
      "Official regulations, resolutions, policies, and institutional documents related to UMSS internationalization, academic mobility, cooperation, and agreements.",
  },
};

export default async function NormativasPage({ params }: Props) {
  const { locale } = await params;
  const language = locale === "en" ? "en" : "es";
  const t = content[language];
  const regulations = getRegulations(language);

  return (
    <main className="dric-theme-page dric-regulations-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-regulations-section relative px-5 pb-28 pt-44 md:px-8">
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(0,55,112,0.18),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(227,6,19,0.12),transparent_34%)]" />

        <div className="mx-auto max-w-7xl">
          <div className="max-w-4xl">
            <p className="text-sm uppercase tracking-[0.35em] text-cyan-300">
              {t.eyebrow}
            </p>

            <h1 className="mt-6 text-6xl font-light tracking-wide md:text-8xl">
              {t.title}
            </h1>

            <p className="mt-8 max-w-3xl text-xl leading-relaxed text-white/60">
              {t.intro}
            </p>
          </div>

          <RegulationsExplorer locale={language} regulations={regulations} />
        </div>
      </section>

      <Footer />
    </main>
  );
}
