import Link from "next/link";
import { notFound } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import LinkRoundedIcon from "@mui/icons-material/LinkRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import {
  findScholarshipCatalogItem,
  type ScholarshipCatalogItem,
  type ScholarshipOpportunity,
  type ScholarshipOpportunityBullet,
  type ScholarshipOpportunitySection,
  type ScholarshipOpportunityLink,
} from "@/lib/scholarships/becasCatalog";
import type { CmsBlock, CmsPage } from "@/types/cms";

type Props = {
  params: Promise<{
    locale: string;
    country: string;
  }>;
};

const cmsReadyItems = [
  {
    icon: <CalendarMonthRoundedIcon />,
    es: "Fechas de convocatoria",
    en: "Call dates",
  },
  {
    icon: <DescriptionRoundedIcon />,
    es: "Requisitos y documentos",
    en: "Requirements and documents",
  },
  {
    icon: <LinkRoundedIcon />,
    es: "Enlaces oficiales y PDFs",
    en: "Official links and PDFs",
  },
];

export default async function ScholarshipDestinationPage({ params }: Props) {
  const { locale, country } = await params;
  const language = locale === "en" ? "en" : "es";
  const staticItem = findScholarshipCatalogItem(country);
  const cmsPage = await getOptionalPageBySlug("becas", language);
  const cmsItem = cmsPage ? cmsCatalogItem(cmsPage, country, language, staticItem) : null;
  const item = cmsItem ?? staticItem;

  if (!item) {
    notFound();
  }

  const opportunities = item.opportunities ?? [];

  return (
    <main className="dric-theme-page dric-scholarship-detail-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <Link
            href={`/${locale}/becas-movilidad/becas`}
            className="mb-8 inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white/72 backdrop-blur transition hover:border-white/25 hover:bg-white/15 hover:text-white"
          >
            <ArrowBackRoundedIcon fontSize="small" />
            {language === "en" ? "Back to scholarships" : "Volver a becas"}
          </Link>

          <div>
            <h1 className="dric-neon-country-title max-w-5xl">
              {item.name[language]}
            </h1>

            <p className="mt-7 max-w-3xl text-base leading-8 text-white/68 md:text-lg">
              {item.summary[language]}
            </p>
          </div>
        </div>
      </section>

      <section className="relative isolate overflow-hidden px-5 py-16 text-white md:px-10 md:py-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          {opportunities.length > 0 ? (
            <>
              <div className="mb-10 max-w-3xl">
                <p className="text-xs font-bold uppercase tracking-[0.24em] text-[#E30613]">
                  {language === "en" ? "Available programmes" : "Programas disponibles"}
                </p>
                <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
                  {language === "en"
                    ? `Scholarship channels for ${item.name.en}`
                    : `Canales de becas para ${item.name.es}`}
                </h2>
              </div>

              <div className="mx-auto flex max-w-6xl flex-col gap-8">
                {opportunities.map((opportunity) => {
                  const links = opportunity.links?.length
                    ? opportunity.links
                    : opportunity.href && opportunity.href !== "#"
                      ? [
                          {
                            href: opportunity.href,
                            label: opportunity.linkLabel,
                          },
                        ]
                      : [];

                  return (
                  <article
                    key={opportunity.slug}
                    className="dric-scholarship-program-card group relative overflow-hidden rounded-[2rem] p-[1px] shadow-2xl shadow-black/25 transition duration-500 hover:-translate-y-1"
                  >
                    <div className="dric-scholarship-program-card-inner relative flex min-h-[430px] flex-col rounded-[calc(2rem-1px)] px-7 py-8 md:min-h-[470px] md:px-12 md:py-11 lg:px-14">
                      <h3 className="max-w-5xl text-3xl font-normal leading-tight tracking-[-0.035em] text-white md:text-4xl lg:text-[2.65rem]">
                        {opportunity.title[language]}
                      </h3>

                      <div className="mt-9 flex-1 space-y-7 text-justify text-base leading-8 text-white/72 md:text-lg md:leading-9">
                        {opportunity.contentSections ? (
                          opportunity.contentSections.map((section, sectionIndex) => (
                            <section key={`${opportunity.slug}-section-${sectionIndex}`} className="space-y-3">
                              {section.heading ? (
                                <h4 className="text-left text-xl font-semibold text-white md:text-2xl">
                                  {renderInline(section.heading[language])}
                                </h4>
                              ) : null}

                              {section.paragraphs?.map((paragraph, paragraphIndex) => (
                                <p key={`${opportunity.slug}-paragraph-${paragraphIndex}`}>
                                  {renderInline(paragraph[language])}
                                </p>
                              ))}

                              {section.bullets ? (
                                <ul className="space-y-2 pl-5 text-left">
                                  {section.bullets.map((bullet, bulletIndex) => (
                                    <li key={`${opportunity.slug}-bullet-${bulletIndex}`} className="list-disc">
                                      {bullet.label ? (
                                        <>
                                          <span className="font-semibold text-white">
                                            {renderInline(bullet.label[language])}:
                                          </span>{" "}
                                        </>
                                      ) : null}
                                      <span>{renderInline(bullet.text[language])}</span>
                                      {bullet.children ? (
                                        <ul className="mt-2 space-y-1 pl-5">
                                          {bullet.children.map((child, childIndex) => (
                                            <li
                                              key={`${opportunity.slug}-bullet-${bulletIndex}-${childIndex}`}
                                              className="list-disc"
                                            >
                                              {child.label ? (
                                                <>
                                                  <span className="font-semibold text-white">
                                                    {renderInline(child.label[language])}:
                                                  </span>{" "}
                                                </>
                                              ) : null}
                                              <span>{renderInline(child.text[language])}</span>
                                            </li>
                                          ))}
                                        </ul>
                                      ) : null}
                                    </li>
                                  ))}
                                </ul>
                              ) : null}
                            </section>
                          ))
                        ) : (
                          <p>{renderInline(opportunity.body[language])}</p>
                        )}
                      </div>

                      {links.length > 0 ? (
                        <>
                          <div className="dric-scholarship-program-divider mt-10" />

                          <div className="mt-7 flex flex-wrap justify-center gap-4">
                            {links.map((link) => (
                              <a
                                key={link.href}
                                href={link.href}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="dric-scholarship-program-link inline-flex max-w-full items-center justify-center gap-3 rounded-full px-5 py-3 text-left text-sm font-normal text-white transition hover:scale-[1.02] sm:px-6 sm:text-base md:px-7 md:text-xl"
                              >
                                {link.label[language]}
                                <OpenInNewRoundedIcon className="shrink-0 text-[1.35em]" />
                              </a>
                            ))}
                          </div>
                        </>
                      ) : null}
                    </div>
                  </article>
                );
                })}
              </div>
            </>
          ) : (
            <>
              <div className="grid gap-5 md:grid-cols-3">
                {cmsReadyItems.map((readyItem) => (
                  <div
                    key={readyItem.es}
                    className="rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl"
                  >
                    <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                      {readyItem.icon}
                    </div>
                    <h2 className="mt-6 text-2xl font-semibold tracking-[-0.035em]">
                      {readyItem[language]}
                    </h2>
                    <p className="mt-4 text-sm leading-7 text-white/58">
                      {language === "en"
                        ? "The content for this area will come from the administrative database."
                        : "El contenido de esta area vendra desde la base de datos administrativa."}
                    </p>
                  </div>
                ))}
              </div>

              <div className="mt-8 rounded-[2rem] border border-dashed border-white/18 bg-white/[0.035] p-8 text-center backdrop-blur-xl md:p-10">
                <p className="text-sm font-bold uppercase tracking-[0.24em] text-[#E30613]">
                  {language === "en" ? "No active calls yet" : "Sin convocatorias activas aún"}
                </p>
                <p className="mx-auto mt-4 max-w-2xl text-sm leading-7 text-white/60 md:text-base">
                  {language === "en"
                    ? "When the admin module is connected, published opportunities for this destination will appear here automatically."
                    : "Cuando se conecte el módulo administrativo, las oportunidades publicadas para este destino apareceran aqui automaticamente."}
                </p>
              </div>
            </>
          )}
        </div>
      </section>

      <Footer />
    </main>
  );
}

function cmsCatalogItem(
  page: CmsPage,
  requestedSlug: string,
  language: "es" | "en",
  staticItem?: ScholarshipCatalogItem,
): ScholarshipCatalogItem | null {
  const block = page.sections
    .flatMap((section) => section.blocks)
    .find((candidate) => {
      const slug = stringValue(candidate.data.slug);
      const linkSlug = candidate.link_url?.split("/").filter(Boolean).pop();

      return slug === requestedSlug || linkSlug === requestedSlug;
    });

  if (!block) {
    return null;
  }

  const type = block.block_type === "organization" || block.type === "organization" ? "organization" : "country";
  const name = block.title ?? requestedSlug;
  const summary = block.summary ?? "";
  const cmsDetailWasEdited = block.data.detail_edited === true;
  const cmsDetail = cmsOpportunities(block);
  const region = language === "en"
    ? stringValue(block.data.region_en) || block.subtitle || ""
    : stringValue(block.data.region_es) || block.subtitle || "";

  return {
    slug: stringValue(block.data.slug) || requestedSlug,
    type,
    name: {
      es: name,
      en: name,
    },
    region: {
      es: region,
      en: region,
    },
    summary: {
      es: summary,
      en: summary,
    },
    href: stringValue(block.data.href) || block.link_url || `/becas-movilidad/becas/${requestedSlug}`,
    accent: stringValue(block.data.accent) || (type === "country" ? "#003770" : "#E30613"),
    opportunities: cmsDetailWasEdited ? cmsDetail : (staticItem?.opportunities ?? cmsDetail),
  };
}

function cmsOpportunities(block: CmsBlock): ScholarshipOpportunity[] {
  const rawItems = Array.isArray(block.data.opportunities) ? block.data.opportunities : [];

  return rawItems
    .map((rawItem, index): ScholarshipOpportunity | null => {
      if (!isRecord(rawItem)) {
        return null;
      }

      const title = localizedRecord(rawItem.title, stringValue(rawItem.title_es) || `Contenido ${index + 1}`);
      const body = localizedRecord(rawItem.body, stringValue(rawItem.body_es));
      const links = cmsLinks(rawItem.links);
      const firstLink = links[0] ?? {
        href: stringValue(rawItem.href) || "#",
        label: localizedRecord(rawItem.linkLabel ?? rawItem.link_label, "Ver enlace"),
      };

      return {
        slug: stringValue(rawItem.slug) || stringValue(rawItem.id) || `contenido-${index + 1}`,
        title,
        body,
        href: firstLink.href,
        linkLabel: firstLink.label,
        links,
        contentSections: cmsContentSections(rawItem.contentSections ?? rawItem.content_sections),
      };
    })
    .filter((item): item is ScholarshipOpportunity => item !== null);
}

function cmsLinks(value: unknown): ScholarshipOpportunityLink[] {
  if (!Array.isArray(value)) {
    return [];
  }

  return value
    .map((link) => {
      if (!isRecord(link)) {
        return null;
      }

      const href = stringValue(link.href);
      const label = localizedRecord(link.label, stringValue(link.label_es) || "Ver enlace");

      return href && label.es ? { href, label } : null;
    })
    .filter((link): link is NonNullable<ScholarshipOpportunity["links"]>[number] => link !== null);
}

function cmsContentSections(value: unknown): ScholarshipOpportunitySection[] | undefined {
  if (!Array.isArray(value)) {
    return undefined;
  }

  return value
    .map((section): ScholarshipOpportunitySection | null => {
      if (!isRecord(section)) {
        return null;
      }

      const paragraphs = Array.isArray(section.paragraphs)
        ? section.paragraphs.map((paragraph) => localizedRecord(paragraph, "")).filter((paragraph) => paragraph.es || paragraph.en)
        : undefined;
      const bullets = Array.isArray(section.bullets)
        ? section.bullets
            .map((bullet): ScholarshipOpportunityBullet | null => {
              if (!isRecord(bullet)) {
                return null;
              }

              return {
                label: isRecord(bullet.label) ? localizedRecord(bullet.label, "") : undefined,
                text: localizedRecord(bullet.text, stringValue(bullet.text_es)),
              };
            })
            .filter((bullet): bullet is NonNullable<ScholarshipOpportunitySection["bullets"]>[number] => Boolean(bullet?.text.es || bullet?.text.en))
        : undefined;

      return paragraphs?.length || bullets?.length
        ? {
            heading: section.heading ? localizedRecord(section.heading, "") : undefined,
            paragraphs,
            bullets,
          }
        : null;
    })
    .filter((section): section is ScholarshipOpportunitySection => section !== null);
}

function localizedRecord(value: unknown, fallback: string): { es: string; en: string } {
  if (isRecord(value)) {
    const es = stringValue(value.es) || fallback;
    const en = stringValue(value.en) || es;

    return { es, en };
  }

  return { es: fallback, en: fallback };
}

function renderInline(text: string) {
  const parts = text.split(/(\*\*[^*]+\*\*|_[^_]+_)/g);

  return parts.map((part, index) => {
    if (part.startsWith("**") && part.endsWith("**")) {
      return <strong key={`${part}-${index}`}>{part.slice(2, -2)}</strong>;
    }

    if (part.startsWith("_") && part.endsWith("_")) {
      return <em key={`${part}-${index}`}>{part.slice(1, -1)}</em>;
    }

    return part;
  });
}

function stringValue(value: unknown): string {
  return typeof value === "string" ? value : "";
}

function isRecord(value: unknown): value is Record<string, unknown> {
  return Boolean(value && typeof value === "object" && !Array.isArray(value));
}
