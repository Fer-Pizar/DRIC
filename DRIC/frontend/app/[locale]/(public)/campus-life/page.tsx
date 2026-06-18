import Image from "next/image";
import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import ArrowOutwardRoundedIcon from "@mui/icons-material/ArrowOutwardRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function CampusLifePage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";

  const t = {
    badge: isEnglish ? "UMSS experience" : "Experiencia UMSS",
    title: "Campus Life",
    subtitle: isEnglish
      ? "A university rooted in Cochabamba, connected to Bolivia and open to the world."
      : "Una universidad enraizada en Cochabamba, conectada con Bolivia y abierta al mundo.",
    basic: isEnglish ? "Basic information" : "Información básica",
    basicText: isEnglish
      ? "Universidad Mayor de San Simón was founded by law on November 5, 1832. Today it is a public autonomous university with academic, scientific, technological and social outreach functions."
      : "La Universidad Mayor de San Simón fue fundada por Ley del 5 de noviembre de 1832. Es una universidad pública autónoma con funciones de formación académica, investigación científica y tecnológica e interacción social.",
    features: isEnglish ? "University character" : "Características de la universidad",
    strengths: isEnglish ? "Strengths" : "Fortalezas",
    other: isEnglish ? "Cochabamba and institutional life" : "Cochabamba y vida institucional",
    official: isEnglish ? "Official UMSS website" : "Sitio oficial UMSS",
    explore: isEnglish ? "Explore Cochabamba" : "Explorar Cochabamba",
  };

  const stats = [
    {
      value: "1832",
      label: isEnglish ? "Year of foundation" : "Año de fundación",
    },
    {
      value: "10+",
      label: isEnglish ? "Faculties and academic units" : "Facultades y unidades académicas",
    },
    {
      value: "77k+",
      label: isEnglish ? "Students and academic community" : "Estudiantes y comunidad académica",
    },
  ];

  const cards = [
    {
      icon: <SchoolRoundedIcon />,
      title: isEnglish ? "Academic programs" : "Programas académicos",
      text: isEnglish
        ? "Undergraduate and postgraduate education across diverse areas of knowledge."
        : "Formación de pregrado y posgrado en diversas áreas del conocimiento.",
    },
    {
      icon: <GroupsRoundedIcon />,
      title: isEnglish ? "Community contribution" : "Contribución a la comunidad",
      text: isEnglish
        ? "Teaching, research and social outreach connected with regional needs."
        : "Enseñanza, investigación e interacción social vinculadas a las necesidades regionales.",
    },
    {
      icon: <PublicRoundedIcon />,
      title: isEnglish ? "International orientation" : "Orientación internacional",
      text: isEnglish
        ? "Cooperation, agreements, mobility and academic opportunities promoted through DRIC."
        : "Cooperación, convenios, movilidad y oportunidades académicas promovidas desde la DRIC.",
    },
  ];

  const magazineSections = [
    {
      title: isEnglish ? "Libraries and learning spaces" : "Bibliotecas y espacios de aprendizaje",
      text: isEnglish
        ? "Academic life is supported by learning spaces, research culture and university services."
        : "La vida académica se fortalece mediante espacios de aprendizaje, cultura investigativa y servicios universitarios.",
      image: "/images/campus-life/library.png",
    },
    {
      title: isEnglish ? "Faculties and knowledge areas" : "Facultades y áreas de conocimiento",
      text: isEnglish
        ? "UMSS brings together faculties, institutes and academic units that support professional formation."
        : "La UMSS integra facultades, institutos y unidades académicas que sostienen la formación profesional.",
      image: "/images/campus-life/faculties.png",
    },
    {
      title: isEnglish ? "Cochabamba: university city" : "Cochabamba: ciudad universitaria",
      text: isEnglish
        ? "The university experience is connected to the cultural, social and geographic identity of Cochabamba."
        : "La experiencia universitaria se conecta con la identidad cultural, social y geográfica de Cochabamba.",
      image: "/images/campus-life/cochabamba.png",
    },
  ];

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate min-h-screen px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <Image
          src="/images/campus-life/uni-view.png"
          alt="UMSS campus view"
          fill
          priority
          className="absolute inset-0 -z-30 object-cover"
        />
        <div className="absolute inset-0 -z-20 bg-gradient-to-b from-[#020617]/80 via-[#020617]/62 to-[#020617]" />
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.38),transparent_35%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.42),transparent_38%)]" />

        <div className="mx-auto grid min-h-[72vh] max-w-7xl gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-end">
          <div>
            <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              {t.badge}
            </p>

            <h1 className="max-w-5xl text-6xl font-light uppercase leading-[0.86] tracking-[-0.08em] md:text-8xl lg:text-9xl">
              {t.title}
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/75 md:text-xl">
              {t.subtitle}
            </p>
          </div>

          <Card
            sx={{
              borderRadius: "36px",
              background: "rgba(255,255,255,0.10)",
              color: "white",
              border: "1px solid rgba(255,255,255,0.14)",
              backdropFilter: "blur(20px)",
              boxShadow: "0 30px 90px rgba(0,0,0,0.28)",
            }}
          >
            <div className="p-8 md:p-10">
              <Link href="https://www.umss.edu.bo/" target="_blank" className="inline-flex items-center gap-5">
                <div className="relative h-24 w-24 overflow-hidden rounded-full bg-white">
                  <Image
                    src="/images/campus-life/umss-logo.png"
                    alt="UMSS logo"
                    fill
                    className="scale-[1.55] object-contain"
                  />
                </div>

                <div>
                  <p className="text-xs font-bold uppercase tracking-[0.25em] text-white/55">
                    Universidad Mayor de San Simón
                  </p>
                  <p className="mt-2 text-2xl font-semibold tracking-[-0.04em]">
                    {t.official}
                  </p>
                </div>
              </Link>

              <p className="mt-8 text-sm leading-7 text-white/68">{t.basicText}</p>

              <Link href="https://www.umss.edu.bo/" target="_blank" className="mt-8 inline-flex">
                <Button
                  variant="contained"
                  endIcon={<ArrowOutwardRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.2,
                    background: "linear-gradient(135deg,#b5121b,#e1242f)",
                    textTransform: "none",
                    fontWeight: 800,
                  }}
                >
                  {t.official}
                </Button>
              </Link>
            </div>
          </Card>
        </div>
      </section>

      <section className="bg-[#f8fafc] px-5 py-16 text-slate-950 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-16 border-y border-slate-200 bg-white/60 px-4 py-10 backdrop-blur md:px-8">
            <div className="grid gap-8 text-center md:grid-cols-3">
              {stats.map((stat) => (
                <div key={stat.label}>
                  <p className="text-4xl font-black tracking-[-0.05em] text-[#020617] md:text-5xl">
                    {stat.value}
                  </p>
                  <p className="mt-3 text-sm font-semibold text-slate-600 md:text-base">
                    {stat.label}
                  </p>
                </div>
              ))}
            </div>
          </div>

          <div className="grid gap-7 md:grid-cols-3">
            {cards.map((card) => (
              <Card
                key={card.title}
                sx={{
                  borderRadius: "34px",
                  border: "1px solid rgba(15,23,42,0.08)",
                  boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
                }}
              >
                <div className="min-h-[280px] bg-white p-8">
                  <div className="flex h-14 w-14 items-center justify-center rounded-3xl bg-[#020617] text-white">
                    {card.icon}
                  </div>
                  <h2 className="mt-8 text-3xl font-bold tracking-[-0.05em]">{card.title}</h2>
                  <p className="mt-5 text-sm leading-7 text-slate-600">{card.text}</p>
                </div>
              </Card>
            ))}
          </div>

          <div className="mt-24 border-t border-slate-200 pt-16">
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
              {t.basic}
            </p>
            <h2 className="mt-4 max-w-4xl text-5xl font-semibold tracking-[-0.06em]">
              {isEnglish
                ? "A historic public university with regional impact"
                : "Una universidad pública histórica con impacto regional"}
            </h2>
            <p className="mt-6 max-w-4xl text-base leading-8 text-slate-600">{t.basicText}</p>
          </div>

          <div className="mt-16 space-y-10">
            {magazineSections.map((section, index) => (
              <div
                key={section.title}
                className="grid overflow-hidden rounded-[2.5rem] bg-white shadow-2xl shadow-slate-200/70 lg:grid-cols-2"
              >
                <div className={index % 2 === 1 ? "relative h-[420px] lg:order-2" : "relative h-[420px]"}>
                  <Image src={section.image} alt={section.title} fill className="object-cover" />
                </div>

                <div className="flex flex-col justify-center p-8 md:p-12">
                  <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#164194]">
                    {index === 0 ? t.features : index === 1 ? t.strengths : t.other}
                  </p>
                  <h3 className="mt-5 text-4xl font-semibold tracking-[-0.05em]">{section.title}</h3>
                  <p className="mt-6 text-sm leading-8 text-slate-600">{section.text}</p>
                </div>
              </div>
            ))}
          </div>

          <div className="mt-20 overflow-hidden rounded-[2.5rem] bg-[#020617] text-white shadow-2xl shadow-slate-300/60">
            <div className="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
              <div className="p-8 md:p-12">
                <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#ef4444]">
                  {isEnglish ? "Getting around" : "Recorriendo Cochabamba"}
                </p>
                <h2 className="mt-5 text-5xl font-semibold tracking-[-0.06em]">
                  {isEnglish ? "Beyond campus" : "Más allá del campus"}
                </h2>
                <p className="mt-6 max-w-xl text-sm leading-8 text-white/68">
                  {isEnglish
                    ? "Campus life is also connected to Cochabamba: its historic center, culture, gastronomy, landscapes and public spaces."
                    : "La vida universitaria también se conecta con Cochabamba: su centro histórico, cultura, gastronomía, paisajes y espacios públicos."}
                </p>

                <Link href="https://visita.cochabamba.bo/" target="_blank" className="mt-8 inline-flex">
                  <Button
                    variant="contained"
                    endIcon={<ArrowOutwardRoundedIcon />}
                    sx={{
                      borderRadius: "999px",
                      px: 4,
                      py: 1.2,
                      background: "#ffffff",
                      color: "#020617",
                      textTransform: "none",
                      fontWeight: 900,
                    }}
                  >
                    {t.explore}
                  </Button>
                </Link>
              </div>

              <div className="relative min-h-[390px]">
                <Image src="/images/campus-life/cochabamba.png" alt="Cochabamba" fill className="object-cover" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
