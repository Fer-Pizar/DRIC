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

export default async function ProyectosPage({ params }: Props) {
  const { locale } = await params;

  return (
    <main className="dric-theme-page dric-projects-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-projects-hero relative isolate overflow-hidden px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(180,20,35,0.34),transparent_35%),radial-gradient(circle_at_top_right,rgba(30,70,160,0.32),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_48%,#12070a_100%)]" />
        <div className="dric-projects-hero-glow absolute left-1/2 top-20 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-white/10 blur-[130px]" />

        <div className="mx-auto max-w-7xl">
          <div className="max-w-4xl">
            <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              DRIC · UMSS
            </p>

            <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
              Proyectos
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/72 md:text-lg">
              Gestionamos, asesoramos y facilitamos solicitudes de proyectos con financiamiento nacional e internacional, fortaleciendo la cooperación académica, científica e institucional de la Universidad Mayor de San Simón.
            </p>

            <div className="mt-10 flex flex-col gap-4 sm:flex-row">
              <Link href={`/${locale}/normativas`} className="inline-flex">
                <Button
                  variant="contained"
                  endIcon={<PictureAsPdfRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.4,
                    background: "linear-gradient(135deg,#b5121b,#e1242f)",
                    textTransform: "none",
                    fontWeight: 700,
                    boxShadow: "0 18px 45px rgba(181,18,27,0.35)",
                  }}
                >
                  Procedimiento UMSS
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
                  Contactar DRIC
                </Button>
              </Link>
            </div>
          </div>

          <div className="mt-20 grid gap-8 lg:grid-cols-2">
            <ProjectCard
              locale={locale}
              title="Proyectos Internacionales"
              description="Proyectos desarrollados con cooperación internacional en la UMSS, orientados a investigación, innovación, fortalecimiento institucional y vinculación global."
              href={`/${locale}/proyectos#internacionales`}
              image="/images/hero/hero-dric.jpg"
              icon="world"
              button="Ver proyectos"
            />

            <ProjectCard
              locale={locale}
              title="Apoyo Financiero"
              description="Información sobre convocatorias, oportunidades de financiamiento y recursos para fortalecer iniciativas académicas e institucionales."
              href={`/${locale}/proyectos#apoyo-financiero`}
              image="/images/agreements/international-flags.jpg"
              icon="finance"
              button="Ver convocatorias"
            />
          </div>
        </div>
      </section>

      <section id="internacionales" className="dric-projects-section relative isolate overflow-hidden px-5 py-24 text-white md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.24),transparent_34%),radial-gradient(circle_at_center_right,rgba(22,65,148,0.28),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#10070b_100%)]" />
        <div className="absolute right-[-8rem] top-20 -z-10 h-[430px] w-[430px] rounded-full bg-cyan-300/10 blur-[135px]" />

        <div className="mx-auto max-w-7xl">
          <div className="mb-12 max-w-3xl">
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
              Cooperación internacional
            </p>

            <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
              Proyectos Internacionales
            </h2>

            <p className="mt-5 text-lg leading-8 text-white/68">
              Este apartado centraliza iniciativas gestionadas mediante cooperación internacional, articulando alianzas, financiamiento y capacidades institucionales.
            </p>
          </div>

          <div className="grid gap-5 md:grid-cols-3">
            {[
              "Gestión de cooperación académica",
              "Seguimiento de proyectos",
              "Vinculación con instituciones extranjeras",
            ].map((item) => (
              <div key={item} className="dric-projects-info-card rounded-3xl border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <PublicRoundedIcon sx={{ color: "#b5121b", fontSize: 34 }} />

                <h3 className="mt-5 text-xl font-bold">{item}</h3>

                <p className="mt-3 text-sm leading-7 text-white/62">
                  Información editable desde el CMS para mantener el contenido actualizado y consistente.
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section id="apoyo-financiero" className="dric-projects-section relative isolate overflow-hidden px-5 py-24 text-white md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_right,rgba(181,18,27,0.20),transparent_34%),radial-gradient(circle_at_bottom_left,rgba(22,65,148,0.34),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />
        <div className="absolute left-[-10rem] bottom-[-8rem] -z-10 h-[460px] w-[460px] rounded-full bg-blue-400/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl">
          <div className="dric-projects-finance-panel rounded-[2rem] border border-white/10 bg-white/[0.06] p-8 shadow-2xl shadow-black/25 backdrop-blur-xl md:p-12">
            <div className="grid gap-10 lg:grid-cols-[1fr_0.8fr] lg:items-center">
              <div>
                <p className="text-sm font-bold uppercase tracking-[0.25em] text-cyan-300">
                  Convocatorias y recursos
                </p>

                <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                  Apoyo Financiero
                </h2>

                <p className="mt-5 text-lg leading-8 text-white/68">
                  Espacio para publicar oportunidades de financiamiento, documentos PDF, guías, formularios y enlaces relevantes para la comunidad universitaria.
                </p>
              </div>

              <div className="dric-projects-doc-card rounded-[1.5rem] bg-[#020617] p-7 text-white">
                <PictureAsPdfRoundedIcon sx={{ color: "#ef4444", fontSize: 38 }} />

                <h3 className="mt-5 text-2xl font-bold">Documentos disponibles</h3>

                <p className="mt-3 text-sm leading-7 text-white/65">
                  Próximamente conectado con la base de datos para listar PDFs descargables desde el CMS.
                </p>

                <Link href={`/${locale}/normativas`} className="inline-flex">
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
                    Ver documentos
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
  locale: string;
  title: string;
  description: string;
  href: string;
  image: string;
  icon: "world" | "finance";
  button: string;
}) {
  return (
    <Card
      className="dric-projects-feature-card"
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

        <Link href={href} className="inline-flex">
          <Button
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
        </Link>
      </CardContent>
    </Card>
  );
}
