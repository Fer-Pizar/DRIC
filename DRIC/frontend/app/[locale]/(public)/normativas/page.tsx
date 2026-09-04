import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import RegulationsExplorer from "@/components/regulations/RegulationsExplorer";
import { publicAssetHref } from "@/lib/api/assets";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import { getRegulations, type RegulationCategory, type RegulationItem } from "@/lib/regulations/regulationsCatalog";
import type { CmsBlock, CmsPage } from "@/types/cms";

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
  const cmsPage = await getOptionalPageBySlug("normativas", language);
  const t = cmsContent(cmsPage, language);
  const regulations = cmsRegulations(cmsPage, language) ?? getRegulations(language);

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

function cmsContent(page: CmsPage | null, locale: "es" | "en") {
  const hero = page?.sections.find((section) => section.section_key === "regulations.hero");

  return {
    eyebrow: hero?.subtitle || page?.seo?.meta_title || content[locale].eyebrow,
    title: page?.title || hero?.title || content[locale].title,
    intro: hero?.summary || page?.summary || content[locale].intro,
  };
}

function cmsRegulations(page: CmsPage | null, locale: "es" | "en"): RegulationItem[] | null {
  const blocks = page?.sections
    .find((section) => section.section_key === "regulations.list")
    ?.blocks
    .filter((block) => block.type === "regulation_document");

  if (!blocks?.length) {
    return null;
  }

  const items = blocks
    .map((block) => regulationFromBlock(block, locale))
    .filter((item): item is RegulationItem => Boolean(item));

  return items.length ? items : null;
}

function regulationFromBlock(block: CmsBlock, locale: "es" | "en"): RegulationItem | null {
  if (!block.title) {
    return null;
  }

  const categoryKey = dataString(block, "category") as RegulationCategory | null;

  if (!categoryKey || !["primero", "segundo", "tercero"].includes(categoryKey)) {
    return null;
  }

  return {
    id: String(block.id),
    code: dataString(block, "code") || "",
    title: block.title,
    category: dataString(block, `category_label_${locale}`) || categoryLabels[locale][categoryKey],
    categoryKey,
    categoryUrl: dataString(block, "category_url") || `https://dric.umss.edu.bo/document-category/${categoryKey}/`,
    downloadUrl: publicAssetHref(dataString(block, "download_url")),
  };
}

const categoryLabels = {
  es: {
    primero: "Primero",
    segundo: "Segundo",
    tercero: "Tercero",
  },
  en: {
    primero: "First",
    segundo: "Second",
    tercero: "Third",
  },
};

function dataString(block: CmsBlock, key: string): string | null {
  const value = block.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}
