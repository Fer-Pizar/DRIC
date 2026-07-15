import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import NewsExplorer from "@/components/news/NewsExplorer";

type Props = {
  params: Promise<{ locale: string }>;
};

const news = [
  {
    title: "Movilidad académica administrativa: experiencia de Jimmy Delgado en la UNJU, Argentina",
    date: "Dic 4, 2024",
    category: "Movilidad académica",
    excerpt:
      "Del 18 al 22 de noviembre de 2024, Jimmy Delgado Villca vivió una enriquecedora experiencia académica internacional.",
  },
  {
    title: "Movilidad académica programa Escala Docente de AUGM – Montevideo, Uruguay",
    date: "Nov 29, 2024",
    category: "Cooperación internacional",
    excerpt:
      "Docentes de la UMSS fortalecen vínculos académicos mediante programas internacionales de movilidad.",
  },
  {
    title: "Participación de la UMSS en las 31° Jornadas de Jóvenes Investigadores de la AUGM",
    date: "Nov 13, 2024",
    category: "Investigación",
    excerpt:
      "La UMSS estuvo presente en un importante espacio regional de investigación universitaria.",
  },
];

export default async function NoticiasPage({ params }: Props) {
  const { locale } = await params;

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(0,55,112,0.48),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />

        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {locale === "en" ? "News" : "Noticias"}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {locale === "en"
              ? "Institutional news, academic mobility updates, international cooperation activities and opportunities from DRIC."
              : "Noticias institucionales, movilidad académica, cooperación internacional y actividades destacadas de la DRIC."}
          </p>
        </div>
      </section>

      <NewsExplorer locale={locale} news={news} />

      <Footer />
    </main>
  );
}
