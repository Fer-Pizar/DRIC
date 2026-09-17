import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ScholarshipOrgCarousel from "@/components/sections/scholarships/ScholarshipOrgCarousel";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import WorkspacePremiumRoundedIcon from "@mui/icons-material/WorkspacePremiumRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import {
  scholarshipCountries,
  scholarshipOrganizations,
  type ScholarshipCatalogItem,
} from "@/lib/scholarships/becasCatalog";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

function CatalogCard({
  item,
  locale,
}: {
  item: ScholarshipCatalogItem;
  locale: string;
}) {
  const language = locale === "en" ? "en" : "es";
  const href = localizedHref(item.href ?? `/becas-movilidad/becas/${item.slug}`, locale);

  return (
    <article className="dric-scholarship-option group relative min-h-[250px] overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 text-white shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-500 hover:-translate-y-1 hover:border-white/25 hover:bg-white/[0.085] md:p-7">
      <div
        className="absolute right-[-56px] top-[-64px] h-40 w-40 rounded-full blur-3xl transition duration-500 group-hover:scale-125"
        style={{ backgroundColor: `${item.accent}33` }}
      />

      <div className="relative flex h-full flex-col">
        <div className="flex items-start">
          <div
            className="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl text-white shadow-xl shadow-black/20"
            style={{ backgroundColor: item.accent }}
          >
            {item.type === "country" ? <PublicRoundedIcon /> : <WorkspacePremiumRoundedIcon />}
          </div>
        </div>

        <p className="mt-7 text-xs font-bold uppercase tracking-[0.22em] text-white/45">
          {item.region[language]}
        </p>

        <h2 className="mt-3 text-3xl font-semibold leading-tight tracking-[-0.045em]">
          {item.name[language]}
        </h2>

        <p className="mt-4 flex-1 text-sm leading-7 text-white/62">
          {item.summary[language]}
        </p>

        {item.children && item.children.length > 0 ? (
          <div className="mt-6 flex flex-wrap gap-2">
            {item.children.map((child) => (
              <Link
                key={child.slug}
                href={`/${locale}/becas-movilidad/becas/${child.slug}`}
                className="rounded-full border border-white/12 bg-white/10 px-4 py-2 text-xs font-semibold text-white/72 transition hover:border-white/30 hover:bg-white/16 hover:text-white"
              >
                {child.name[language]}
              </Link>
            ))}
          </div>
        ) : null}

        <Link
          href={href}
          className="mt-7 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-cyan-200"
        >
          {language === "en" ? "Open opportunities" : "Ver oportunidades"}
          <ArrowForwardRoundedIcon fontSize="small" />
        </Link>
      </div>
    </article>
  );
}

export default async function BecasPage({ params }: Props) {
  const { locale } = await params;
  const language = locale === "en" ? "en" : "es";
  const cmsPage = await getOptionalPageBySlug("becas", language);
  const copy = mergeCopy(cmsPage, language);
  const countries = cmsCatalogItems(cmsPage, "country", scholarshipCountries);
  const organizations = cmsCatalogItems(cmsPage, "organization", scholarshipOrganizations);

  return (
    <main className="dric-theme-page dric-scholarship-index-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-16 pt-36 md:px-10 md:pb-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.26em] text-white/80 backdrop-blur">
            {copy.badge}
          </p>

          <div className="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-end">
            <h1 className="max-w-5xl text-[2.65rem] font-light uppercase leading-[0.96] tracking-[-0.055em] sm:text-6xl md:text-7xl lg:text-8xl">
              {copy.title}
            </h1>

            <p className="max-w-2xl text-base leading-8 text-white/68 md:text-lg">
              {copy.intro}
            </p>
          </div>
        </div>
      </section>

      <section className="relative isolate overflow-hidden px-5 py-16 text-white md:px-10 md:py-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-10 flex flex-col gap-4 md:mb-12 md:flex-row md:items-end md:justify-between">
            <div>
              <p className="text-xs font-bold uppercase tracking-[0.24em] text-[#E30613]">
                {copy.countriesBadge}
              </p>
              <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
                {copy.countriesTitle}
              </h2>
            </div>

          </div>

          <div className="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            {countries.map((country) => (
              <CatalogCard key={country.slug} item={country} locale={locale} />
            ))}
          </div>

          <div className="mt-20">
            <div className="mb-10 max-w-3xl">
              <p className="text-xs font-bold uppercase tracking-[0.24em] text-cyan-300">
                {copy.organizationsBadge}
              </p>
              <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
                {copy.organizationsTitle}
              </h2>
            </div>

            <ScholarshipOrgCarousel items={organizations} locale={locale} />
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function mergeCopy(page: CmsPage | null, language: "es" | "en") {
  const countrySection = section(page, "scholarship.catalog");
  const organizationSection = section(page, "scholarship.organizations");

  return {
    badge: page?.menu_label || (language === "en" ? "Scholarship calls" : "Convocatoria de becas"),
    title: page?.title || (language === "en" ? "Explore scholarships by destination" : "Explora becas por destino"),
    intro: page?.summary || (language === "en"
      ? "A clear, organized catalog of countries and international programs."
      : "Un catálogo claro y organizado de países y programas internacionales."),
    countriesBadge: countrySection?.subtitle || (language === "en" ? "Countries" : "Países"),
    countriesTitle: countrySection?.title || (language === "en" ? "International Programs" : "Programas Internacionales"),
    organizationsBadge: organizationSection?.subtitle || (language === "en" ? "Programs and organizations" : "Programas y organismos"),
    organizationsTitle: organizationSection?.title || (language === "en" ? "Other scholarship channels" : "Otros canales de becas"),
  };
}

function cmsCatalogItems(page: CmsPage | null, type: "country" | "organization", fallback: ScholarshipCatalogItem[]) {
  const blocks = page?.sections
    .flatMap((item) => item.blocks)
    .filter((item) => item.type === type) ?? [];

  if (blocks.length === 0) return fallback;

  return blocks.map((item, index) => {
    const slug = dataString(item, "slug") || slugify(item.title || `${type}-${index + 1}`);

    return {
      slug,
      type,
      name: {
        es: item.title || "",
        en: item.title || "",
      },
      region: {
        es: dataString(item, "region_es") || item.subtitle || "",
        en: dataString(item, "region_en") || item.subtitle || "",
      },
      summary: {
        es: item.summary || "",
        en: item.summary || "",
      },
      href: dataString(item, "href") || `/becas-movilidad/becas/${slug}`,
      accent: dataString(item, "accent") || (type === "country" ? "#003770" : "#E30613"),
    };
  });
}

function localizedHref(href: string, locale: string): string {
  if (href.startsWith("http://") || href.startsWith("https://") || href.startsWith("mailto:")) {
    return href;
  }

  return `/${locale}/${href.replace(/^\/+/, "")}`;
}

function section(page: CmsPage | null, key: string): CmsSection | undefined {
  return page?.sections.find((item) => item.section_key === key);
}

function dataString(block: CmsBlock | undefined, key: string): string | null {
  const value = block?.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}

function slugify(value: string): string {
  return value
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "") || "beca";
}
