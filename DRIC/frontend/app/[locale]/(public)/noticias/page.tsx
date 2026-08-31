import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import NewsExplorer from "@/components/news/NewsExplorer";
import { getNews } from "@/lib/news/newsCatalog";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function NoticiasPage({ params }: Props) {
  const { locale } = await params;
  const news = getNews(locale);

  return (
    <main className="dric-theme-page dric-news-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
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
