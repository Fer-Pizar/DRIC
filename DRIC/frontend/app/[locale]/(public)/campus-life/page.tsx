import Image from "next/image";
import Link from "next/link";
import type { ReactNode } from "react";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import ArrowOutwardRoundedIcon from "@mui/icons-material/ArrowOutwardRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function CampusLifePage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";
  const cmsPage = await getOptionalPageBySlug("campus-life", isEnglish ? "en" : "es");

  const t = mergeCampusCopy({
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
    officialLabel: "Universidad Mayor de San Simón",
    basicTitle: isEnglish
      ? "A historic public university with regional impact"
      : "Una universidad pública histórica con impacto regional",
    officialUrl: "https://www.umss.edu.bo/",
    heroImage: "/images/campus-life/uni-view.png",
    officialLogo: "/images/campus-life/umss-logo.png",
  }, cmsPage);

  const stats = cmsStats(cmsPage, [
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
  ]);

  const cards = cmsFeatures(cmsPage, [
    {
      icon: <SchoolRoundedIcon />,
      iconKey: "school",
      title: isEnglish ? "Academic programs" : "Programas académicos",
      text: isEnglish
        ? "Undergraduate and postgraduate education across diverse areas of knowledge."
        : "Formación de pregrado y posgrado en diversas áreas del conocimiento.",
    },
    {
      icon: <GroupsRoundedIcon />,
      iconKey: "groups",
      title: isEnglish ? "Community contribution" : "Contribución a la comunidad",
      text: isEnglish
        ? "Teaching, research and social outreach connected with regional needs."
        : "Enseñanza, investigación e interacción social vinculadas a las necesidades regionales.",
    },
    {
      icon: <PublicRoundedIcon />,
      iconKey: "public",
      title: isEnglish ? "International orientation" : "Orientación internacional",
      text: isEnglish
        ? "Cooperation, agreements, mobility and academic opportunities promoted through DRIC."
        : "Cooperación, convenios, movilidad y oportunidades académicas promovidas desde la DRIC.",
    },
  ]);

  const storyItems = cmsStories(cmsPage);
  const magazineSections = storyItems.slice(0, 2);
  const museumSection = storyItems[2];
  const cochabambaSection = storyItems[3];

  const fallbackMagazineSections = [
    {
      title: isEnglish ? "Libraries and learning spaces" : "Bibliotecas y espacios de aprendizaje",
      text: isEnglish
        ? "Provides access to books, theses, scientific articles and academic publications from its faculties and research centers, promoting the consultation, dissemination and access to academic and scientific knowledge for the university community."
        : "Facilita el acceso a libros, tesis, artículos científicos y publicaciones académicas de sus facultades y centros de investigación, promoviendo la consulta, difusión y acceso al conocimiento académico y científico de la comunidad universitaria.",
      image: "/images/campus-life/library.png",
      href: "http://bibliotecas.umss.edu.bo/site/php/index.php",
    },
    {
      title: isEnglish ? "Faculties and careers" : "Facultades y carreras",
      text: isEnglish
        ? "UMSS has a wide diversity of faculties covering different areas of knowledge, offering academic training in sciences, technology, health, humanities, social sciences and other disciplines. This variety strengthens a multidisciplinary and diverse university community."
        : "La UMSS cuenta con una amplia diversidad de facultades que abarcan distintas áreas del conocimiento, ofreciendo formación académica en ciencias, tecnología, salud, humanidades, ciencias sociales y otras disciplinas. Esta variedad fortalece una comunidad universitaria multidisciplinaria y diversa.",
      image: "/images/campus-life/faculties.png",
      href: "https://www.umss.edu.bo/facultades/",
    },
  ];

  const fallbackMuseumSection = {
    eyebrow: isEnglish ? "History" : "Historia",
    title: "INIAM Museo UMSS",
    text: isEnglish
      ? "Founded in 1951 as the Archaeological and Ethnographic Museum of UMSS, it gave rise in 1963 to Bolivia's first School of Anthropology and Archaeology. In 1980, it was consolidated as the Institute of Anthropological Research and Archaeological Museum (INIAM-UMSS)."
      : "Fundado en 1951 como Museo Arqueológico y Etnográfico de la UMSS, dio origen en 1963 a la primera Escuela de Antropología y Arqueología de Bolivia. En 1980 fue consolidado como el Instituto de Investigaciones Antropológicas y Museo Arqueológico (INIAM-UMSS).",
    image: "/images/campus-life/uni-view.png",
    href: "https://museo.umss.edu.bo/",
  };

  const fallbackCochabambaSection = {
    eyebrow: isEnglish ? "Getting around" : "Recorriendo Cochabamba",
    title: isEnglish ? "Beyond campus" : "Más allá del campus",
    text: isEnglish
      ? "Campus life is also connected to Cochabamba: its historic center, culture, gastronomy, landscapes and public spaces."
      : "La vida universitaria también se conecta con Cochabamba: su centro histórico, cultura, gastronomía, paisajes y espacios públicos.",
    button: t.explore,
    image: "/images/campus-life/cochabamba.png",
    href: "https://visita.cochabamba.bo/",
  };

  const resolvedMagazineSections = magazineSections.length >= 2 ? magazineSections : fallbackMagazineSections;
  const resolvedMuseumSection = museumSection ?? fallbackMuseumSection;
  const resolvedCochabambaSection = cochabambaSection ?? fallbackCochabambaSection;

  return (
    <main className="dric-theme-page dric-campus-life-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate min-h-screen px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <Image
          src={t.heroImage}
          alt="UMSS campus view"
          fill
          priority
          className="absolute inset-0 -z-30 object-cover"
        />
        <div className="absolute inset-0 -z-20 bg-gradient-to-b from-[#020617]/80 via-[#020617]/62 to-[#020617]" />
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.38),transparent_35%),radial-gradient(circle_at_top_right,rgba(0,55,112,0.42),transparent_38%)]" />

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
              <Link href={t.officialUrl} target="_blank" className="inline-flex items-center gap-5">
                <div className="relative h-24 w-24 overflow-hidden rounded-full bg-white">
                  <Image
                    src={t.officialLogo}
                    alt="UMSS logo"
                    fill
                    className="scale-[1.55] object-contain"
                  />
                </div>

                <div>
                  <p className="text-xs font-bold uppercase tracking-[0.25em] text-white/55">
                    {t.officialLabel}
                  </p>
                  <p className="mt-2 text-2xl font-semibold tracking-[-0.04em]">
                    {t.official}
                  </p>
                </div>
              </Link>

              <p className="mt-8 text-sm leading-7 text-white/68">{t.basicText}</p>

              <Link href={t.officialUrl} target="_blank" className="mt-8 inline-flex">
                <Button
                  variant="contained"
                  endIcon={<ArrowOutwardRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.2,
                    background: "linear-gradient(135deg,#E30613,#E30613)",
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

      <section className="relative isolate overflow-hidden px-5 py-16 text-white md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.22),transparent_34%),radial-gradient(circle_at_center_right,rgba(0,55,112,0.30),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />
        <div className="absolute right-[-9rem] top-16 -z-10 h-[430px] w-[430px] rounded-full bg-cyan-300/10 blur-[135px]" />

        <div className="mx-auto max-w-7xl">
          <div className="mb-16 border-y border-white/10 bg-white/[0.06] px-4 py-10 shadow-2xl shadow-black/20 backdrop-blur-xl md:px-8">
            <div className="grid gap-8 text-center md:grid-cols-3">
              {stats.map((stat) => (
                <div key={stat.label}>
                  <p className="text-4xl font-black tracking-[-0.05em] text-white md:text-5xl">
                    {stat.value}
                  </p>
                  <p className="mt-3 text-sm font-semibold text-white/62 md:text-base">
                    {stat.label}
                  </p>
                </div>
              ))}
            </div>
          </div>

          <div className="grid gap-7 md:grid-cols-3">
            {cards.map((card) => (
              <Card
                className="dric-campus-feature-card relative overflow-hidden rounded-[2rem] p-[1px] shadow-2xl shadow-black/25"
                key={card.title}
                sx={{
                  borderRadius: "2rem",
                  background: "transparent",
                  color: "white",
                }}
              >
                <div className="dric-campus-feature-card-inner h-full min-h-[280px] rounded-[calc(2rem-1px)] p-8">
                  <div className="flex h-14 w-14 items-center justify-center rounded-3xl bg-white/10 text-cyan-300">
                    {card.icon}
                  </div>
                  <h2 className="mt-8 text-3xl font-bold tracking-[-0.05em]">{card.title}</h2>
                  <p className="mt-5 text-sm leading-7 text-white/62">{card.text}</p>
                </div>
              </Card>
            ))}
          </div>

          <div className="mt-24 border-t border-white/10 pt-16">
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#E30613]">
              {t.basic}
            </p>
            <h2 className="mt-4 max-w-4xl text-5xl font-semibold tracking-[-0.06em]">
              {t.basicTitle}
            </h2>
            <p className="mt-6 max-w-4xl text-base leading-8 text-white/68">{t.basicText}</p>
          </div>

          <div className="mt-16 space-y-10">
            {resolvedMagazineSections.map((section, index) => {
              const content = (
                <>
                  <div className={index % 2 === 1 ? "relative h-[420px] lg:order-2" : "relative h-[420px]"}>
                    <Image src={section.image} alt={section.title} fill className="object-cover" />
                  </div>

                  <div className="flex flex-col justify-center p-8 md:p-12">
                    <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#003770]">
                      {index === 0 ? t.features : index === 1 ? t.strengths : t.other}
                    </p>
                    <h3 className="mt-5 text-4xl font-semibold tracking-[-0.05em]">{section.title}</h3>
                    <p className="mt-6 text-sm leading-8 text-white/62">
                      {section.text}
                    </p>
                  </div>
                </>
              );

              return section.href ? (
                <Link
                  key={section.title}
                  href={section.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="grid overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/[0.06] text-white shadow-2xl shadow-black/25 backdrop-blur-xl transition duration-500 hover:-translate-y-1 hover:border-white/25 lg:grid-cols-2"
                >
                  {content}
                </Link>
              ) : (
                <div
                  key={section.title}
                  className="grid overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/[0.06] shadow-2xl shadow-black/25 backdrop-blur-xl lg:grid-cols-2"
                >
                  {content}
                </div>
              );
            })}
          </div>

          <Link
            href={resolvedMuseumSection.href}
            target="_blank"
            rel="noopener noreferrer"
            className="mt-10 grid overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/[0.06] text-white shadow-2xl shadow-black/25 backdrop-blur-xl transition duration-500 hover:-translate-y-1 hover:border-white/25 lg:grid-cols-2"
          >
            <div className="relative h-[420px]">
              <Image src={resolvedMuseumSection.image} alt={resolvedMuseumSection.title} fill className="object-cover" />
            </div>

            <div className="flex flex-col justify-center p-8 md:p-12">
              <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#E30613]">
                {resolvedMuseumSection.eyebrow}
              </p>
              <h3 className="mt-5 text-4xl font-semibold tracking-[-0.05em]">{resolvedMuseumSection.title}</h3>
              <p className="mt-6 text-sm leading-8 text-white/62">{resolvedMuseumSection.text}</p>
            </div>
          </Link>

          <div className="mt-20 overflow-hidden rounded-[2.5rem] bg-[#020617] text-white shadow-2xl shadow-slate-300/60">
            <div className="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
              <div className="p-8 md:p-12">
                <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#E30613]">
                  {resolvedCochabambaSection.eyebrow}
                </p>
                <h2 className="mt-5 text-5xl font-semibold tracking-[-0.06em]">
                  {resolvedCochabambaSection.title}
                </h2>
                <p className="mt-6 max-w-xl text-sm leading-8 text-white/68">
                  {resolvedCochabambaSection.text}
                </p>

                <Link href={resolvedCochabambaSection.href} target="_blank" className="mt-8 inline-flex">
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
                    {resolvedCochabambaSection.button || t.explore}
                  </Button>
                </Link>
              </div>

              <div className="relative min-h-[390px]">
                <Image src={resolvedCochabambaSection.image} alt={resolvedCochabambaSection.title} fill className="object-cover" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function mergeCampusCopy(defaults: {
  badge: string;
  title: string;
  subtitle: string;
  basic: string;
  basicText: string;
  features: string;
  strengths: string;
  other: string;
  official: string;
  explore: string;
  officialLabel: string;
  basicTitle: string;
  officialUrl: string;
  heroImage: string;
  officialLogo: string;
}, page: CmsPage | null) {
  const hero = section(page, "campus.hero");
  const official = section(page, "campus.official");
  const basic = section(page, "campus.basic");
  const officialLogo = block(page, "campus.official.logo");

  return {
    ...defaults,
    badge: hero?.subtitle || page?.menu_label || defaults.badge,
    title: page?.title || hero?.title || defaults.title,
    subtitle: hero?.summary || page?.summary || defaults.subtitle,
    officialLabel: official?.subtitle || defaults.officialLabel,
    official: official?.title || defaults.official,
    basic: basic?.subtitle || defaults.basic,
    basicTitle: basic?.title || defaults.basicTitle,
    basicText: basic?.summary || official?.summary || defaults.basicText,
    officialUrl: dataString(officialLogo, "url") || defaults.officialUrl,
    heroImage: defaults.heroImage,
    officialLogo: defaults.officialLogo,
  };
}

function cmsStats(page: CmsPage | null, defaults: Array<{ value: string; label: string }>) {
  const stats = section(page, "campus.stats")?.blocks.filter((item) => item.type === "campus_stat") ?? [];

  if (stats.length < 3) return defaults;

  return stats.slice(0, 3).map((stat, index) => ({
    value: stat.title || defaults[index]?.value || "",
    label: stat.summary || defaults[index]?.label || "",
  }));
}

function cmsFeatures(page: CmsPage | null, defaults: Array<{ icon: ReactNode; iconKey: string; title: string; text: string }>) {
  const features = section(page, "campus.features")?.blocks.filter((item) => item.type === "campus_feature") ?? [];

  if (features.length < 3) return defaults;

  return features.slice(0, 3).map((feature, index) => ({
    icon: iconForFeature(dataString(feature, "icon") || defaults[index]?.iconKey || "public"),
    iconKey: dataString(feature, "icon") || defaults[index]?.iconKey || "public",
    title: feature.title || defaults[index]?.title || "",
    text: feature.summary || defaults[index]?.text || "",
  }));
}

function cmsStories(page: CmsPage | null) {
  const systemImages = [
    "/images/campus-life/library.png",
    "/images/campus-life/faculties.png",
    "/images/campus-life/uni-view.png",
    "/images/campus-life/cochabamba.png",
  ];

  return (
    section(page, "campus.stories")
      ?.blocks.filter((item) => item.type === "campus_story")
      .map((story, index) => ({
        eyebrow: story.subtitle || "",
        title: story.title || "",
        text: story.summary || "",
        button: story.cta_label || null,
        image: systemImages[index] || "/images/campus-life/library.png",
        href: dataString(story, "url") || "#",
      }))
      .filter((story) => story.title && story.text) ?? []
  );
}

function iconForFeature(icon: string) {
  if (icon === "school") return <SchoolRoundedIcon />;
  if (icon === "groups") return <GroupsRoundedIcon />;

  return <PublicRoundedIcon />;
}

function section(page: CmsPage | null, key: string): CmsSection | undefined {
  return page?.sections.find((item) => item.section_key === key);
}

function block(page: CmsPage | null, key: string): CmsBlock | undefined {
  return page?.sections.flatMap((item) => item.blocks).find((item) => item.link_url === key);
}

function dataString(block: CmsBlock | undefined, key: string): string | null {
  const value = block?.data?.[key];

  return typeof value === "string" && value.trim() ? value : null;
}
