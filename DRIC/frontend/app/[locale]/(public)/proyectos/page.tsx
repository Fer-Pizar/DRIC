import Link from "next/link";
import Image from "next/image";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
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
    contact: "Contactar DRIC",
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
    finance: {
      eyebrow: "Convocatorias y recursos",
      title: "Apoyo Financiero",
      description:
        "Espacio para publicar oportunidades de financiamiento, documentos PDF, guías, formularios y enlaces relevantes para la comunidad universitaria.",
      docsTitle: "Documentos disponibles",
      docsDescription:
        "Próximamente conectado con la base de datos para listar PDFs descargables desde el CMS.",
      button: "Ver documentos",
    },
  },
  en: {
    title: "Projects",
    intro:
      "We manage, advise on, and support project requests with national and international funding, strengthening the academic, scientific, and institutional cooperation of Universidad Mayor de San Simón.",
    procedure: "UMSS Procedure",
    contact: "Contact DRIC",
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
    finance: {
      eyebrow: "Calls and resources",
      title: "Financial Support",
      description:
        "A space for publishing funding opportunities, PDF documents, guides, forms, and relevant links for the university community.",
      docsTitle: "Available documents",
      docsDescription:
        "Soon to be connected to the database to list downloadable PDFs from the CMS.",
      button: "View documents",
    },
  },
};

export default async function ProyectosPage({ params }: Props) {
  const { locale } = await params;
  const text = locale === "en" ? projectsCopy.en : projectsCopy.es;

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
              <Link href="https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf" className="inline-flex">
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

              <Link href={`/${locale}/contacto`} className="inline-flex">
                <Button
                  className="dric-projects-outline-button"
                  variant="outlined"
                  endIcon={<ArrowForwardRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.4,
                    color: "white",
                    borderColor: "rgba(255,255,255,0.24)",
                    textTransform: "none",
                    fontWeight: 700,
                    backdropFilter: "blur(14px)",
                  }}
                >
                  {text.contact}
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

      <section id="apoyo-financiero" className="dric-projects-section relative isolate overflow-hidden px-5 py-24 text-white md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="dric-projects-finance-panel rounded-[2rem] border border-white/10 bg-white/[0.06] p-8 shadow-2xl shadow-black/25 backdrop-blur-xl md:p-12">
            <div className="grid gap-10 lg:grid-cols-[1fr_0.8fr] lg:items-center">
              <div>
                <p className="text-sm font-bold uppercase tracking-[0.25em] text-cyan-300">
                  {text.finance.eyebrow}
                </p>

                <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                  {text.finance.title}
                </h2>

                <p className="mt-5 text-lg leading-8 text-white/68">
                  {text.finance.description}
                </p>
              </div>

              <div className="dric-projects-doc-card rounded-[1.5rem] bg-[#020617] p-7">
                <PictureAsPdfRoundedIcon sx={{ color: "#E30613", fontSize: 38 }} />

                <h3 className="dric-projects-doc-title mt-5 text-2xl font-bold">
                  {text.finance.docsTitle}
                </h3>

                <p className="dric-projects-doc-copy mt-3 text-sm leading-7">
                  {text.finance.docsDescription}
                </p>

                <Link href={`/${locale}/proyectos/apoyo-financiero`} className="inline-flex">
                  <Button
                    variant="contained"
                    sx={{
                      mt: 4,
                      borderRadius: "999px",
                      backgroundColor: "#ffffff",
                      color: "#020617",
                      textTransform: "none",
                      fontWeight: 800,
                      "&:hover": { backgroundColor: "#e5e7eb" },
                    }}
                  >
                    {text.finance.button}
                  </Button>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
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
