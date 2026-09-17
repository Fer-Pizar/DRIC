import Link from "next/link";
import type { ReactNode } from "react";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import FlightTakeoffRoundedIcon from "@mui/icons-material/FlightTakeoffRounded";
import EmojiEventsRoundedIcon from "@mui/icons-material/EmojiEventsRounded";
import InfoRoundedIcon from "@mui/icons-material/InfoRounded";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function BecasMovilidadPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";
  const cmsPage = await getOptionalPageBySlug("becas-movilidad", isEnglish ? "en" : "es");

  const t = mergeScholarshipHubCopy({
    badge: "DRIC · UMSS",
    title: isEnglish ? "Scholarships and Mobility" : "Becas y Movilidad",
    intro: isEnglish
      ? "DRIC promotes academic internationalization through scholarships, mobility programs, internships, calls and institutional guidance for national and international communities."
      : "La DRIC impulsa la internacionalización académica mediante becas, programas de movilidad, pasantías, convocatorias y orientación institucional para la comunidad nacional e internacional.",
    exploreBadge: isEnglish ? "Explore opportunities" : "Explora oportunidades",
    exploreTitle: isEnglish
      ? "International academic pathways"
      : "Rutas académicas internacionales",
    exploreIntro: isEnglish
      ? "This section brings together scholarships, mobility, internships, calls and institutional information to guide the university community."
      : "Esta sección reúne becas, movilidad, pasantías, convocatorias e información institucional para orientar a la comunidad universitaria.",
  }, cmsPage);

  const cards = cmsCards(cmsPage, [
    {
      title: isEnglish ? "Undergraduate and postgraduate scholarships" : "Becas de pregrado y posgrado",
      description: isEnglish
        ? "Scholarship opportunities offered by governments, universities and international organizations."
        : "Programas de becas ofertados por gobiernos, universidades y organismos internacionales.",
      href: "/becas-movilidad/becas",
      label: isEnglish ? "View scholarships" : "Ver becas",
      icon: <SchoolRoundedIcon />,
      iconKey: "school",
      accent: "#E30613",
    },
    {
      title: isEnglish ? "Mobility and international internships" : "Movilidad y pasantías internacionales",
      description: isEnglish
        ? "Academic, teaching, student and administrative mobility programs."
        : "Programas de movilidad docente, estudiantil, administrativa y pasantías internacionales.",
      href: "/becas-movilidad/movilidad-pasantias",
      label: isEnglish ? "View programs" : "Ver programas",
      icon: <FlightTakeoffRoundedIcon />,
      iconKey: "flight",
      accent: "#003770",
    },
    {
      title: isEnglish ? "Awards, events, courses and contests" : "Premios, eventos, cursos y concursos",
      description: isEnglish
        ? "Calls, courses, contests and academic opportunities for the university community."
        : "Convocatorias, cursos, concursos y oportunidades académicas para la comunidad universitaria.",
      href: "/becas-movilidad/premios-eventos-cursos-concursos",
      label: isEnglish ? "View calls" : "Ver convocatorias",
      icon: <EmojiEventsRoundedIcon />,
      iconKey: "awards",
      accent: "#E30613",
    },
    {
      title: isEnglish ? "Information for nationals and foreigners" : "Información para nacionales y extranjeros",
      description: isEnglish
        ? "Useful information, procedures and guidance for national and international visitors."
        : "Información útil, trámites y orientación para ciudadanos nacionales y extranjeros.",
      href: "/becas-movilidad/informacion-nacionales-extranjeros",
      label: isEnglish ? "View information" : "Ver información",
      icon: <InfoRoundedIcon />,
      iconKey: "info",
      accent: "#003770",
    },
  ]);

  return (
    <main className="dric-theme-page dric-mobility-page dric-scholarships-hub-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-mobility-hero relative isolate px-5 pb-10 pt-36 md:px-10 md:pb-12 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            {t.badge}
          </p>

          <h1
            className={`max-w-5xl font-light uppercase ${
              isEnglish
                ? "text-[2.47rem] leading-[1.00] tracking-[-0.025em] sm:text-5xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-7xl"
                : "text-5xl leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-7xl"
            }`}
          >
            {t.title}
          </h1>

          <p className="dric-scholarships-hub-hero-copy mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {t.intro}
          </p>
        </div>
      </section>

      <section className="dric-mobility-section relative isolate overflow-hidden px-5 pb-20 pt-8 text-white md:px-10 md:pt-10 lg:px-12 lg:pt-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-14 max-w-3xl">
            <p className="dric-scholarships-hub-eyebrow text-sm font-bold uppercase tracking-[0.25em]">
              {t.exploreBadge}
            </p>

            <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
              {t.exploreTitle}
            </h2>

            <p className="mt-5 text-sm leading-7 text-white/68 md:text-base">
              {t.exploreIntro}
            </p>
          </div>

          <div className="grid gap-7 md:grid-cols-2">
            {cards.map((card) => (
              <Card
                className="dric-mobility-card"
                key={card.title}
                sx={{
                  borderRadius: "34px",
                  overflow: "hidden",
                  background: "rgba(255,255,255,0.06)",
                  border: "1px solid rgba(255,255,255,0.10)",
                  boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                  color: "white",
                }}
              >
                <div className="dric-mobility-card-inner group relative min-h-[390px] bg-white/[0.06] p-8 transition duration-500 hover:-translate-y-1 md:p-10">
                  <div
                    className="absolute right-[-60px] top-[-60px] h-44 w-44 rounded-full blur-3xl"
                    style={{ backgroundColor: `${card.accent}22` }}
                  />
                  <div
                    className="absolute inset-x-0 bottom-0 h-1"
                    style={{
                      background: `linear-gradient(90deg, ${card.accent}, #003770, #ffffff)`,
                    }}
                  />

                  <div
                    className="flex h-16 w-16 items-center justify-center rounded-3xl text-white shadow-xl"
                    style={{ backgroundColor: card.accent }}
                  >
                    {card.icon}
                  </div>

                  <h3 className="mt-8 max-w-xl text-3xl font-bold leading-tight tracking-[-0.05em] text-white">
                    {card.title}
                  </h3>

                  <p className="mt-5 max-w-xl text-sm leading-7 text-white/62">
                    {card.description}
                  </p>

                  <Link href={localizedHref(card.href, locale)} className="mt-10 inline-flex">
                    <Button
                      className="dric-mobility-card-button"
                      variant="outlined"
                      endIcon={<ArrowForwardRoundedIcon />}
                      sx={{
                        borderRadius: "999px",
                        px: 3.5,
                        py: 1.2,
                        color: card.accent,
                        borderColor: `${card.accent}66`,
                        textTransform: "none",
                        fontWeight: 800,
                        "&:hover": {
                          borderColor: card.accent,
                          backgroundColor: `${card.accent}0D`,
                        },
                      }}
                    >
                      {card.label}
                    </Button>
                  </Link>
                </div>
              </Card>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function mergeScholarshipHubCopy(defaults: {
  badge: string;
  title: string;
  intro: string;
  exploreBadge: string;
  exploreTitle: string;
  exploreIntro: string;
}, page: CmsPage | null) {
  const hero = section(page, "scholarship_hub.hero");
  const explore = section(page, "scholarship_hub.explore");

  return {
    badge: hero?.subtitle || page?.menu_label || defaults.badge,
    title: page?.title || hero?.title || defaults.title,
    intro: hero?.summary || page?.summary || defaults.intro,
    exploreBadge: explore?.subtitle || defaults.exploreBadge,
    exploreTitle: explore?.title || defaults.exploreTitle,
    exploreIntro: explore?.summary || defaults.exploreIntro,
  };
}

function cmsCards(
  page: CmsPage | null,
  defaults: Array<{
    title: string;
    description: string;
    href: string;
    label: string;
    icon: ReactNode;
    iconKey: string;
    accent: string;
  }>
) {
  const cards = section(page, "scholarship_hub.cards")?.blocks.filter((item) => item.type === "scholarship_hub_card") ?? [];

  if (cards.length < 4) return defaults;

  return cards.slice(0, 4).map((card, index) => ({
    title: card.title || defaults[index]?.title || "",
    description: card.summary || defaults[index]?.description || "",
    href: dataString(card, "href") || defaults[index]?.href || "#",
    label: card.cta_label || defaults[index]?.label || "",
    icon: iconForCard(dataString(card, "icon") || defaults[index]?.iconKey || "info"),
    iconKey: dataString(card, "icon") || defaults[index]?.iconKey || "info",
    accent: dataString(card, "accent") || defaults[index]?.accent || "#003770",
  }));
}

function iconForCard(icon: string) {
  if (icon === "school") return <SchoolRoundedIcon />;
  if (icon === "flight") return <FlightTakeoffRoundedIcon />;
  if (icon === "awards") return <EmojiEventsRoundedIcon />;

  return <InfoRoundedIcon />;
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
