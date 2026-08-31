import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import NewspaperRoundedIcon from "@mui/icons-material/NewspaperRounded";
import { getNewsRecordByNumber, newsCatalog, type Locale } from "@/lib/news/newsCatalog";

type Props = {
  params: Promise<{
    locale: string;
    newsId: string;
  }>;
};

const copy = {
  es: {
    back: "Volver a noticias",
    photo: "Espacio reservado para fotografía",
    pendingTitle: "Desarrollo editorial pendiente",
    pendingBody:
      "Este artículo ya está preparado para CMS. Cuando se agregue el texto completo desde administración, esta vista mantendrá el mismo formato editorial.",
    imageNote: "Sube la imagen como",
  },
  en: {
    back: "Back to news",
    photo: "Reserved photo space",
    pendingTitle: "Editorial body pending",
    pendingBody:
      "This article is already CMS-ready. Once the full text is added from administration, this view will keep the same editorial format.",
    imageNote: "Upload the image as",
  },
};

export function generateStaticParams() {
  return newsCatalog.flatMap((_, index) => [
    { locale: "es", newsId: String(index + 1) },
    { locale: "en", newsId: String(index + 1) },
  ]);
}

export default async function NewsArticlePage({ params }: Props) {
  const { locale, newsId } = await params;
  const language: Locale = locale === "en" ? "en" : "es";
  const t = copy[language];
  const article = getNewsRecordByNumber(newsId);

  if (!article) {
    notFound();
  }

  const imagePath = article.image ?? `/images/news/noticia-${newsId}.png`;
  const body = article.body;

  return (
    <main className="dric-theme-page dric-news-article-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <article className="relative isolate px-5 pb-24 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-6xl">
          <Link
            href={`/${locale}/noticias`}
            className="dric-news-article-back inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white/72 backdrop-blur transition hover:border-white/25 hover:bg-white/15 hover:text-white"
          >
            <ArrowBackRoundedIcon fontSize="small" />
            {t.back}
          </Link>

          <header className="mt-14 border-b border-white/12 pb-10 text-center">
            <div className="mb-6 flex flex-wrap items-center justify-center gap-3 text-xs font-bold uppercase tracking-[0.18em] text-[#67e8f9]">
              <span className="inline-flex items-center gap-2">
                <NewspaperRoundedIcon sx={{ fontSize: 18 }} />
                {article.category[language]}
              </span>
              <span className="h-1 w-1 rounded-full bg-white/30" />
              <span className="inline-flex items-center gap-2">
                <CalendarMonthRoundedIcon sx={{ fontSize: 18 }} />
                {article.date[language]}
              </span>
            </div>

            <h1 className="dric-news-article-title mx-auto max-w-5xl text-balance text-5xl font-semibold uppercase leading-[0.95] tracking-[-0.05em] text-white md:text-7xl">
              {article.title[language]}
            </h1>

            <p className="mx-auto mt-7 max-w-3xl text-xl leading-9 text-white/68 md:text-2xl">
              {(article.deck ?? article.excerpt)[language]}
            </p>
          </header>

          <figure className="dric-news-article-photo relative mt-10 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04]">
            <div className="dric-news-article-photo-placeholder absolute inset-0 flex items-center justify-center px-6 text-center">
              <span className="rounded-full border border-white/12 bg-[#020617]/45 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/62 backdrop-blur">
                {t.photo} · {t.imageNote} noticia-{newsId}.png
              </span>
            </div>
            <Image
              src={imagePath}
              alt={article.title[language]}
              fill
              sizes="(min-width: 1024px) 960px, 100vw"
              className="object-cover"
            />
          </figure>

          <div className="dric-news-article-body mx-auto mt-12 max-w-3xl">
            {body?.heading ? (
              <h2 className="dric-news-article-drop-title text-4xl font-semibold leading-tight tracking-[-0.03em] text-white md:text-5xl">
                {body.heading[language]}
              </h2>
            ) : (
              <h2 className="dric-news-article-drop-title text-4xl font-semibold leading-tight tracking-[-0.03em] text-white md:text-5xl">
                {t.pendingTitle}
              </h2>
            )}

            {(body?.paragraphs ?? [article.excerpt, { es: t.pendingBody, en: t.pendingBody }]).map((paragraph, index) => (
              <div key={`${paragraph.es}-${index}`}>
                <p className="mt-7 text-xl leading-10 text-white/78">
                  {paragraph[language]}
                </p>

                {index === 2 && body?.bullets?.length ? (
                  <ul className="mt-7 space-y-5 border-y border-white/12 py-7">
                    {body.bullets.map((bullet) => (
                      <li key={bullet.es} className="flex gap-4 text-lg leading-9 text-white/74">
                        <span className="mt-4 h-2 w-2 shrink-0 rounded-full bg-[#67e8f9]" />
                        <span>{bullet[language]}</span>
                      </li>
                    ))}
                  </ul>
                ) : null}
              </div>
            ))}
          </div>
        </div>
      </article>

      <Footer />
    </main>
  );
}
