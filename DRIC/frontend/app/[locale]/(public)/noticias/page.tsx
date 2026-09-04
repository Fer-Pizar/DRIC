import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import NewsExplorer from "@/components/news/NewsExplorer";
import { getNews } from "@/lib/news/newsCatalog";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function NoticiasPage({ params }: Props) {
  const { locale } = await params;
  const activeLocale = locale === "en" ? "en" : "es";
  const cmsPage = await getOptionalPageBySlug("noticias", activeLocale);
  const cmsItems = cmsNews(cmsPage, activeLocale);
  const news = mergeNewsItems(cmsItems, getNews(locale));
  const copy = mergeNewsCopy({
    title: activeLocale === "en" ? "News" : "Noticias",
    summary: activeLocale === "en"
      ? "Institutional news, academic mobility updates, international cooperation activities and opportunities from DRIC."
      : "Noticias institucionales, movilidad académica, cooperación internacional y actividades destacadas de la DRIC.",
    kicker: activeLocale === "en" ? "Explore" : "Explorar",
    sectionTitle: activeLocale === "en" ? "Latest institutional updates" : "Últimas noticias institucionales",
    searchPlaceholder: activeLocale === "en" ? "Search news..." : "Buscar noticias...",
    readMoreLabel: activeLocale === "en" ? "Read more" : "Leer más",
  }, cmsPage);

  return (
    <main className="dric-theme-page dric-news-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {copy.title}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {copy.summary}
          </p>
        </div>
      </section>

      <NewsExplorer
        locale={locale}
        news={news}
        kicker={copy.kicker}
        title={copy.sectionTitle}
        searchPlaceholder={copy.searchPlaceholder}
        readMoreLabel={copy.readMoreLabel}
      />

      <Footer />
    </main>
  );
}

function mergeNewsCopy(defaults: {
  title: string;
  summary: string;
  kicker: string;
  sectionTitle: string;
  searchPlaceholder: string;
  readMoreLabel: string;
}, page: CmsPage | null) {
  const hero = section(page, "news.hero");
  const list = section(page, "news.list");

  return {
    title: page?.title || hero?.title || defaults.title,
    summary: hero?.summary || page?.summary || defaults.summary,
    kicker: list?.subtitle || defaults.kicker,
    sectionTitle: list?.title || defaults.sectionTitle,
    searchPlaceholder: list?.summary || defaults.searchPlaceholder,
    readMoreLabel: list?.body || defaults.readMoreLabel,
  };
}

function cmsNews(page: CmsPage | null, locale: string) {
  return (
    section(page, "news.list")
      ?.blocks.filter((block) => block.type === "news_item")
      .map((block) => {
        const href = dataString(block, "href") || "#";

        return {
          id: String(block.id),
          title: block.title?.trim() ?? "",
          date: block.cta_label?.trim() || dataString(block, "published_at") || "",
          publishedAt: dataString(block, "published_at") || "",
          category: block.subtitle?.trim() ?? "",
          excerpt: block.summary?.trim() ?? "",
          href: normalizeHref(href, locale),
        };
      })
      .filter((item) => item.title && item.date && item.category && item.excerpt && item.href) ?? []
  );
}

function mergeNewsItems<T extends { title: string; href: string; publishedAt: string }>(cmsItems: T[], catalogItems: T[]): T[] {
  const seen = new Set<string>();

  return [...cmsItems, ...catalogItems]
    .filter((item) => {
      const key = item.href && item.href !== "#" ? item.href.toLowerCase() : item.title.toLowerCase();

      if (seen.has(key)) {
        return false;
      }

      seen.add(key);
      return true;
    })
    .sort((a, b) => b.publishedAt.localeCompare(a.publishedAt));
}

function normalizeHref(href: string, locale: string): string {
  if (/^https?:\/\//i.test(href) || href === "#") return href;
  if (href.startsWith(`/${locale}/`)) return href;
  if (href.startsWith("/")) return `/${locale}${href}`;

  return href;
}

function section(page: CmsPage | null, key: string): CmsSection | undefined {
  return page?.sections.find((item) => item.section_key === key);
}

function dataString(block: CmsBlock, key: string): string | null {
  const value = block.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}
