import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import FlightTakeoffRoundedIcon from "@mui/icons-material/FlightTakeoffRounded";
import EmojiEventsRoundedIcon from "@mui/icons-material/EmojiEventsRounded";
import InfoRoundedIcon from "@mui/icons-material/InfoRounded";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function BecasMovilidadPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";

  const cards = [
    {
      title: isEnglish ? "Undergraduate and postgraduate scholarships" : "Becas de posgrado y pregrado",
      description: isEnglish
        ? "Scholarship opportunities offered by governments, universities and international organizations."
        : "Programas de becas ofertados por gobiernos, universidades y organismos internacionales.",
      href: `/${locale}/becas-movilidad/becas`,
      label: isEnglish ? "View scholarships" : "Ver becas",
      icon: <SchoolRoundedIcon />,
      accent: "#b5121b",
    },
    {
      title: isEnglish ? "Mobility and international internships" : "Movilidad y pasantías internacionales",
      description: isEnglish
        ? "Academic, teaching, student and administrative mobility programs."
        : "Programas de movilidad docente, estudiantil, administrativa y pasantías internacionales.",
      href: `/${locale}/becas-movilidad/movilidad-pasantias`,
      label: isEnglish ? "View programs" : "Ver programas",
      icon: <FlightTakeoffRoundedIcon />,
      accent: "#164194",
    },
    {
      title: isEnglish ? "Awards, events, courses and contests" : "Premios, eventos, cursos y concursos",
      description: isEnglish
        ? "Calls, courses, contests and academic opportunities for the university community."
        : "Convocatorias, cursos, concursos y oportunidades académicas para la comunidad universitaria.",
      href: `/${locale}/becas-movilidad/premios-eventos-cursos-concursos`,
      label: isEnglish ? "View calls" : "Ver convocatorias",
      icon: <EmojiEventsRoundedIcon />,
      accent: "#b5121b",
    },
    {
      title: isEnglish ? "Information for nationals and foreigners" : "Información para nacionales y extranjeros",
      description: isEnglish
        ? "Useful information, procedures and guidance for national and international visitors."
        : "Información útil, trámites y orientación para ciudadanos nacionales y extranjeros.",
      href: `/${locale}/becas-movilidad/informacion-nacionales-extranjeros`,
      label: isEnglish ? "View information" : "Ver información",
      icon: <InfoRoundedIcon />,
      accent: "#164194",
    },
  ];

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.50),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="absolute left-1/2 top-24 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="max-w-6xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {isEnglish ? "Scholarships and Mobility" : "Becas y Movilidad"}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {isEnglish
              ? "DRIC promotes academic internationalization through scholarships, mobility programs, internships, calls and institutional guidance for national and international communities."
              : "La DRIC impulsa la internacionalización académica mediante becas, programas de movilidad, pasantías, convocatorias y orientación institucional para la comunidad nacional e internacional."}
          </p>
        </div>
      </section>

      <section className="bg-[#f8fafc] px-5 py-20 text-slate-950 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-14 max-w-3xl">
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
              {isEnglish ? "Explore opportunities" : "Explora oportunidades"}
            </p>

            <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
              {isEnglish
                ? "International academic pathways"
                : "Rutas académicas internacionales"}
            </h2>

            <p className="mt-5 text-sm leading-7 text-slate-600 md:text-base">
              {isEnglish
                ? "This section is prepared to later connect with the CMS and allow administrators to update scholarships, links, PDFs and opportunities directly from the database."
                : "Esta sección está preparada para conectarse posteriormente con el CMS y permitir que el administrador actualice becas, enlaces, PDFs y oportunidades directamente desde la base de datos."}
            </p>
          </div>

          <div className="grid gap-7 md:grid-cols-2">
            {cards.map((card) => (
              <Card
                key={card.title}
                sx={{
                  borderRadius: "34px",
                  overflow: "hidden",
                  border: "1px solid rgba(15,23,42,0.08)",
                  boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
                }}
              >
                <div className="group relative min-h-[390px] bg-white p-8 transition duration-500 hover:-translate-y-1 md:p-10">
                  <div
                    className="absolute right-[-60px] top-[-60px] h-44 w-44 rounded-full blur-3xl"
                    style={{ backgroundColor: `${card.accent}22` }}
                  />
                  <div
                    className="absolute inset-x-0 bottom-0 h-1"
                    style={{
                      background: `linear-gradient(90deg, ${card.accent}, #164194, #ffffff)`,
                    }}
                  />

                  <div
                    className="flex h-16 w-16 items-center justify-center rounded-3xl text-white shadow-xl"
                    style={{ backgroundColor: card.accent }}
                  >
                    {card.icon}
                  </div>

                  <h3 className="mt-8 max-w-xl text-3xl font-bold leading-tight tracking-[-0.05em] text-slate-950">
                    {card.title}
                  </h3>

                  <p className="mt-5 max-w-xl text-sm leading-7 text-slate-600">
                    {card.description}
                  </p>

                  <Link href={card.href} className="mt-10 inline-flex">
                    <Button
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
