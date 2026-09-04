import Link from "next/link";
import { notFound, redirect } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import NewsImageCarousel from "@/components/news/NewsImageCarousel";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import NewspaperRoundedIcon from "@mui/icons-material/NewspaperRounded";
import { publicAssetUrl } from "@/lib/api/assets";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import { getNewsRecordBySlug, newsCatalog, type Locale, type LocalizedText, type NewsRecord } from "@/lib/news/newsCatalog";
import type { CmsBlock, CmsPage } from "@/types/cms";

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
  return newsCatalog.flatMap((item) => [
    { locale: "es", newsId: item.id },
    { locale: "en", newsId: item.id },
  ]);
}

export default async function NewsArticlePage({ params }: Props) {
  const { locale, newsId } = await params;
  const language: Locale = locale === "en" ? "en" : "es";
  const t = copy[language];
  const cmsPage = await getOptionalPageBySlug("noticias", language);
  const article = getCmsArticle(cmsPage, newsId, language) ?? catalogArticle(getNewsRecordBySlug(newsId));

  if (!article) {
    notFound();
  }

  if (/^\d+$/.test(newsId) && article.id !== newsId) {
    redirect(`/${language}/noticias/${article.id}`);
  }

  const images = article.images ?? (article.image ? [article.image] : []);
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

          <NewsImageCarousel images={images} alt={article.title[language]} />

          <div className="dric-news-article-body mx-auto mt-12 max-w-3xl">
            {article.detailTitle ? (
              <h2 className="dric-news-article-drop-title text-4xl font-semibold leading-tight tracking-[-0.03em] text-white md:text-5xl">
                {article.detailTitle[language]}
              </h2>
            ) : !article.bodyHtml ? (
              body?.heading ? (
                <h2 className="dric-news-article-drop-title text-4xl font-semibold leading-tight tracking-[-0.03em] text-white md:text-5xl">
                  {body.heading[language]}
                </h2>
              ) : (
                <h2 className="dric-news-article-drop-title text-4xl font-semibold leading-tight tracking-[-0.03em] text-white md:text-5xl">
                  {t.pendingTitle}
                </h2>
              )
            ) : null}

            {article.bodyHtml ? (
              <div
                className="dric-news-article-rich mt-7"
                dangerouslySetInnerHTML={{ __html: article.bodyHtml[language] }}
              />
            ) : (
              (body?.paragraphs ?? [article.excerpt, { es: t.pendingBody, en: t.pendingBody }]).map((paragraph, index) => (
                <div key={`${paragraph.es}-${index}`}>
                  <p className="dric-news-dropcap mt-7 text-xl leading-10 text-white/78">
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
              ))
            )}
          </div>
        </div>
      </article>

      <Footer />
    </main>
  );
}

type Article = {
  id: string;
  title: LocalizedText;
  date: LocalizedText;
  publishedAt: string;
  category: LocalizedText;
  excerpt: LocalizedText;
  deck?: LocalizedText;
  detailTitle?: LocalizedText;
  image?: string;
  images?: string[];
  bodyHtml?: LocalizedText;
  body?: {
    heading?: LocalizedText;
    paragraphs: LocalizedText[];
    bullets?: LocalizedText[];
  };
};

function getCmsArticle(page: CmsPage | null, slug: string, locale: Locale): Article | null {
  const block = page?.sections
    .find((section) => section.section_key === "news.list")
    ?.blocks.find((item) => item.type === "news_item" && blockSlug(item, locale) === slug);

  if (!block || !block.title || !block.summary) {
    return null;
  }

  const articleSlug = blockSlug(block, locale);
  const catalogArticle = getNewsRecordBySlug(articleSlug);

  return {
    id: articleSlug,
    title: localized(block.title),
    date: localized(block.cta_label || dataString(block, "published_at") || ""),
    publishedAt: dataString(block, "published_at") || "",
    category: localized(block.subtitle || ""),
    excerpt: localized(block.summary),
    deck: localizedOptional(dataString(block, `deck_${locale}`)) ?? catalogArticle?.deck,
    detailTitle: localizedOptional(dataString(block, `detail_title_${locale}`)),
    image: catalogArticle?.image,
    images: galleryImages(block),
    bodyHtml: block.body ? localized(richBodyHtml(block.body)) : undefined,
    body: block.body
      ? undefined
      : catalogArticle?.body,
  };
}

function catalogArticle(record: NewsRecord | null): Article | null {
  if (!record) return null;

  return {
    id: record.id,
    title: record.title,
    date: record.date,
    publishedAt: record.publishedAt,
    category: record.category,
    excerpt: record.excerpt,
    deck: record.deck,
    image: record.image,
    body: record.body,
  };
}

function blockSlug(block: CmsBlock, locale: Locale): string {
  const href = dataString(block, "href") || "";
  const withoutLocale = href.replace(new RegExp(`^/${locale}/noticias/`), "").replace(/^\/noticias\//, "");

  return dataString(block, "slug") || withoutLocale || String(block.id);
}

function localized(value: string): LocalizedText {
  return { es: value, en: value };
}

function localizedOptional(value: string | null): LocalizedText | undefined {
  return value ? localized(value) : undefined;
}

function richBodyHtml(value: string): string {
  const html = repairListMarkup(value.trim());

  if (!html) {
    return "";
  }

  if (/<(p|h2|h3|ul|ol|li|blockquote)\b/i.test(html)) {
    return markEditorialParagraphs(html);
  }

  return html
    .split(/\n{2,}/)
    .map((paragraph) => paragraph.trim())
    .filter(Boolean)
    .map((paragraph) => {
      const className = shouldUseDropCap(paragraph) ? ' class="dric-news-dropcap"' : "";

      return `<p${className}>${paragraph.replace(/\n/g, "<br>")}</p>`;
    })
    .join("");
}

function markEditorialParagraphs(html: string): string {
  return html.replace(/<p(\s[^>]*)?>([\s\S]*?)<\/p>/gi, (match, attrs = "", content = "") => {
    if (!shouldUseDropCap(content)) {
      return match;
    }

    const cleanedAttrs = String(attrs);
    if (/class\s*=/.test(cleanedAttrs)) {
      return `<p${cleanedAttrs.replace(/class\s*=\s*"([^"]*)"/, 'class="$1 dric-news-dropcap"')}>${content}</p>`;
    }

    return `<p${cleanedAttrs} class="dric-news-dropcap">${content}</p>`;
  });
}

function repairListMarkup(html: string): string {
  return html
    .replace(/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/p>/gi, "$1")
    .replace(/<p>\s*(<ul\b[^>]*>)/gi, "$1")
    .replace(/(<\/ul>|<\/ol>)\s*<\/p>/gi, "$1")
    .replace(/<\/li>\s*<br\s*\/?>/gi, "</li>");
}

function shouldUseDropCap(value: string): boolean {
  const text = value
    .replace(/<[^>]+>/g, "")
    .replace(/&nbsp;/g, " ")
    .trim();

  return text.length >= 80;
}

function galleryImages(block: CmsBlock): string[] | undefined {
  const images = block.data?.images;

  if (!Array.isArray(images)) {
    return undefined;
  }

  const urls = images
    .map((image) => {
      if (!image || typeof image !== "object") return undefined;
      const url = "url" in image && typeof image.url === "string" ? image.url : undefined;

      return publicAssetUrl(url);
    })
    .filter((url): url is string => Boolean(url));

  return urls.length ? urls : undefined;
}

function dataString(block: CmsBlock, key: string): string | null {
  const value = block.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}
