import Link from "next/link";
import Image from "next/image";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage } from "@/types/cms";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import Button from "@mui/material/Button";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import PictureAsPdfRoundedIcon from "@mui/icons-material/PictureAsPdfRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import AccountBalanceRoundedIcon from "@mui/icons-material/AccountBalanceRounded";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

const projectsCopy = {
  es: {
    title: "Proyectos",
    intro:
      "Gestionamos, asesoramos y facilitamos solicitudes de proyectos con financiamiento nacional e internacional, fortaleciendo la cooperación académica, científica e institucional de la Universidad Mayor de San Simón.",
    procedure: "Procedimiento UMSS",
    cards: [
      {
        title: "Proyectos Internacionales",
        description:
          "Proyectos desarrollados con cooperación internacional en la UMSS, orientados a investigación, innovación, fortalecimiento institucional y vinculación global.",
        href: "https://conveniosdric.umss.edu.bo/proyectos",
        image: "/images/hero/hero-dric.jpg",
        icon: "world" as const,
        button: "Ver proyectos",
      },
      {
        title: "Apoyo Financiero",
        description:
          "Información sobre convocatorias, oportunidades de financiamiento y recursos para fortalecer iniciativas académicas e institucionales.",
        href: "apoyo-financiero",
        image: "/images/agreements/international-flags.jpg",
        icon: "finance" as const,
        button: "Ver convocatorias",
      },
    ],
  },
  en: {
    title: "Projects",
    intro:
      "We manage, advise on, and support project requests with national and international funding, strengthening the academic, scientific, and institutional cooperation of Universidad Mayor de San Simón.",
    procedure: "UMSS Procedure",
    cards: [
      {
        title: "International Projects",
        description:
          "Projects developed through international cooperation at UMSS, focused on research, innovation, institutional strengthening, and global engagement.",
        href: "https://conveniosdric.umss.edu.bo/proyectos",
        image: "/images/hero/hero-dric.jpg",
        icon: "world" as const,
        button: "View projects",
      },
      {
        title: "Financial Support",
        description:
          "Information about calls for proposals, funding opportunities, and resources to strengthen academic and institutional initiatives.",
        href: "apoyo-financiero",
        image: "/images/agreements/international-flags.jpg",
        icon: "finance" as const,
        button: "View calls",
      },
    ],
  },
};

export default async function ProyectosPage({ params }: Props) {
  const { locale } = await params;
  const activeLocale = locale === "en" ? "en" : "es";
  const cmsPage = await getOptionalPageBySlug("proyectos", activeLocale);
  const text = mergeProjectsCopy(projectsCopy[activeLocale], cmsPage);

  return (
    <main className="dric-theme-page dric-projects-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-projects-hero relative isolate overflow-hidden px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="max-w-4xl">
            <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              DRIC · UMSS
            </p>

            <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
              {text.title}
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/72 md:text-lg">
              {text.intro}
            </p>

            <div className="mt-10 flex flex-col gap-4 sm:flex-row">
              <Link href={text.procedureHref} className="inline-flex">
                <Button
                  variant="contained"
                  endIcon={<PictureAsPdfRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.4,
                    background: "linear-gradient(135deg,#E30613,#E30613)",
                    textTransform: "none",
                    fontWeight: 700,
                    boxShadow: "0 18px 45px rgba(227,6,19,0.35)",
                  }}
                >
                  {text.procedure}
                </Button>
              </Link>
            </div>
          </div>

          <div className="mt-20 grid gap-8 lg:grid-cols-2">
            {text.cards.map((card) => (
              <ProjectCard
                key={card.title}
                title={card.title}
                description={card.description}
                href={
                  card.href === "apoyo-financiero"
                    ? `/${locale}/proyectos/apoyo-financiero`
                    : card.href
                }
                image={card.image}
                icon={card.icon}
                button={card.button}
              />
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function mergeProjectsCopy(defaults: (typeof projectsCopy)["es"], page: CmsPage | null) {
  const hero = section(page, "projects.hero");
  const procedure = block(page, "projects.procedure");
  const cards = [1, 2].map((index) => {
    const fallback = defaults.cards[index - 1];
    const cmsCard = block(page, `projects.card.${index}`);

    return {
      title: cmsCard?.title || fallback.title,
      description: cmsCard?.summary || fallback.description,
      href: dataString(cmsCard, "href") || fallback.href,
      image: cmsCard?.media?.url || fallback.image,
      icon: dataString(cmsCard, "icon") === "finance" ? "finance" as const : fallback.icon,
      button: cmsCard?.cta_label || fallback.button,
    };
  });

  return {
    title: page?.title || hero?.title || defaults.title,
    intro: hero?.summary || page?.summary || defaults.intro,
    procedure: procedure?.title || defaults.procedure,
    procedureHref: procedure?.media?.url || dataString(procedure, "url") || "https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf",
    cards,
  };
}

function section(page: CmsPage | null, key: string) {
  return page?.sections.find((item) => item.section_key === key);
}

function block(page: CmsPage | null, key: string): CmsBlock | undefined {
  return page?.sections.flatMap((item) => item.blocks).find((item) => item.link_url === key);
}

function dataString(block: CmsBlock | undefined, key: string): string | null {
  const value = block?.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}

function ProjectCard({
  title,
  description,
  href,
  image,
  icon,
  button,
}: {
  title: string;
  description: string;
  href: string;
  image: string;
  icon: "world" | "finance";
  button: string;
}) {
  return (
    <Link href={href} className="block h-full">
      <Card
        className="dric-projects-feature-card h-full"
        sx={{
          borderRadius: "32px",
          overflow: "hidden",
          background: "rgba(255,255,255,0.08)",
          border: "1px solid rgba(255,255,255,0.12)",
          backdropFilter: "blur(18px)",
          boxShadow: "0 28px 80px rgba(0,0,0,0.28)",
          color: "white",
        }}
      >
        <div className="relative h-72 overflow-hidden">
          <Image
            src={image}
            alt={title}
            fill
            className="object-cover opacity-85 transition duration-700 hover:scale-105"
          />

          <div className="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/20 to-transparent" />
        </div>

        <CardContent sx={{ p: { xs: 4, md: 5 } }}>
          <div className="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
            {icon === "world" ? (
              <PublicRoundedIcon sx={{ color: "#ffffff" }} />
            ) : (
              <AccountBalanceRoundedIcon sx={{ color: "#ffffff" }} />
            )}
          </div>

          <h2 className="text-3xl font-semibold tracking-[-0.04em]">{title}</h2>

          <p className="mt-4 min-h-[88px] text-sm leading-7 text-white/65">
            {description}
          </p>

          <span className="inline-flex">
          <Button
            component="span"
            className="dric-projects-card-button"
            variant="outlined"
            endIcon={<ArrowForwardRoundedIcon />}
            sx={{
              mt: 4,
              borderRadius: "999px",
              px: 3,
              py: 1.2,
              color: "white",
              borderColor: "rgba(255,255,255,0.24)",
              textTransform: "none",
              fontWeight: 800,
              "&:hover": {
                borderColor: "rgba(255,255,255,0.55)",
                backgroundColor: "rgba(255,255,255,0.08)",
              },
            }}
          >
            {button}
          </Button>
          </span>
        </CardContent>
      </Card>
    </Link>
  );
}
