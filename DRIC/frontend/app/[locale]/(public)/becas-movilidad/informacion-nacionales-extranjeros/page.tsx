import Image from "next/image";
import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import FlightTakeoffRoundedIcon from "@mui/icons-material/FlightTakeoffRounded";
import LinkRoundedIcon from "@mui/icons-material/LinkRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import TravelExploreRoundedIcon from "@mui/icons-material/TravelExploreRounded";

type Locale = "es" | "en";
type LocalizedText = Record<Locale, string>;

type InfoLink = {
  label: LocalizedText;
  href: string;
};

type MobilityInfoSection = {
  id: string;
  title: LocalizedText;
  eyebrow: LocalizedText;
  summary: LocalizedText;
  image: string;
  imageAlt: LocalizedText;
  points: LocalizedText[];
  links: InfoLink[];
};

const copy = {
  es: {
    back: "Volver a Becas y Movilidad",
    eyebrow: "Información de interés",
    title: "Información para nacionales y extranjeros",
    intro:
      "Guía esencial para estudiantes, docentes, personal administrativo y visitantes internacionales que participan en procesos de movilidad vinculados con la UMSS.",
    keyInfo: "Información clave",
    resources: "Recursos oficiales",
    open: "Abrir enlace",
    photoSlot: "Espacio reservado para imagen",
  },
  en: {
    back: "Back to Scholarships and Mobility",
    eyebrow: "Useful information",
    title: "Information for nationals and foreigners",
    intro:
      "Essential guidance for students, faculty, administrative staff, and international visitors participating in mobility processes linked to UMSS.",
    keyInfo: "Key information",
    resources: "Official resources",
    open: "Open link",
    photoSlot: "Reserved image space",
  },
};

const sections: MobilityInfoSection[] = [
  {
    id: "saliente",
    title: {
      es: "Movilidad Saliente",
      en: "Outgoing Mobility",
    },
    eyebrow: {
      es: "Comunidad UMSS hacia el exterior",
      en: "UMSS community abroad",
    },
    summary: {
      es: "Lineamientos y recursos para estudiantes, docentes y personal administrativo de la UMSS que realizarán movilidad, estudios o actividades académicas fuera del país.",
      en: "Guidelines and resources for UMSS students, faculty, and administrative staff undertaking mobility, studies, or academic activities abroad.",
    },
    image: "/images/mobility/saliente.png",
    imageAlt: {
      es: "Imagen para movilidad saliente",
      en: "Outgoing mobility image",
    },
    points: [
      {
        es: "Los estudiantes deben mantener la condición de alumnos regulares durante el periodo de movilidad.",
        en: "Students must maintain regular student status throughout the mobility period.",
      },
      {
        es: "Después de concluir los estudios, los estudiantes podrán solicitar el reconocimiento de estudios.",
        en: "After completing their studies, students may request recognition of completed coursework.",
      },
      {
        es: "El trámite para obtener la visa respectiva será responsabilidad del interesado, así como los gastos necesarios.",
        en: "The visa process and all related expenses are the responsibility of the applicant.",
      },
      {
        es: "El personal académico y administrativo debe mantener su condición de vinculación laboral con la UMSS.",
        en: "Academic and administrative staff must maintain their employment relationship with UMSS.",
      },
    ],
    links: [
      {
        label: {
          es: "Información importante sobre el visado a España",
          en: "Important information about visas for Spain",
        },
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESwvbdGaAFxAmTAjk0Wy8BkB0dwgmPSJ_iasa3COcB20cA?e=jHUDBl",
      },
      {
        label: {
          es: "Requisitos para postulantes nacionales bolivianos que desean estudiar en la UMSS",
          en: "Requirements for Bolivian national applicants who wish to study at UMSS",
        },
        href: "https://drive.google.com/file/d/1N_M4mMfnr1t7qcCyDTAQYu8EuWkianhv/view?usp=sharing",
      },
      {
        label: {
          es: "Ministerio de Relaciones Exteriores de Bolivia",
          en: "Ministry of Foreign Affairs of Bolivia",
        },
        href: "https://cancilleria.gob.bo/webmre/",
      },
      {
        label: {
          es: "Reglamento del Sistema de créditos académicos de la UMSS",
          en: "UMSS Academic Credit System Regulations",
        },
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETg713v93xJMpcMxQ4uBGrMBCHduBg9lMV7UhwuMDiAz8w?e=piGTKA",
      },
      {
        label: {
          es: "Representaciones de Bolivia en el exterior",
          en: "Bolivian representations abroad",
        },
        href: "https://cancilleria.gob.bo/mre/emergencia/",
      },
    ],
  },
  {
    id: "entrante",
    title: {
      es: "Movilidad Entrante",
      en: "Incoming Mobility",
    },
    eyebrow: {
      es: "Visitantes nacionales e internacionales",
      en: "National and international visitors",
    },
    summary: {
      es: "Información académica, migratoria e institucional para personas que desean realizar estudios, movilidad o actividades académicas en la Universidad Mayor de San Simón.",
      en: "Academic, migration, and institutional information for visitors who wish to study, undertake mobility, or participate in academic activities at Universidad Mayor de San Simón.",
    },
    image: "/images/mobility/entrante.png",
    imageAlt: {
      es: "Imagen para movilidad entrante",
      en: "Incoming mobility image",
    },
    points: [
      {
        es: "El sistema webSISS reúne carreras ofrecidas por las Facultades de la UMSS, pensum, horarios y otra información académica útil.",
        en: "The webSISS system includes UMSS degree programs by Faculty, curricula, schedules, and other useful academic information.",
      },
      {
        es: "La ficha informativa UMSS y el calendario académico permiten planificar la estancia académica con mayor precisión.",
        en: "The UMSS information sheet and academic calendar help visitors plan their academic stay with greater precision.",
      },
      {
        es: "La información de visa y migración orienta el ingreso y permanencia en Bolivia para fines de estudio.",
        en: "Visa and migration information guides entry and stay in Bolivia for study purposes.",
      },
      {
        es: "La información general sobre Cochabamba ayuda a preparar la llegada, adaptación y vida cotidiana en la ciudad.",
        en: "General information about Cochabamba helps visitors prepare for arrival, adaptation, and daily life in the city.",
      },
    ],
    links: [
      {
        label: {
          es: "Sistema de Información Estudiantil de la UMSS - webSISS",
          en: "UMSS Student Information System - webSISS",
        },
        href: "http://websis.umss.edu.bo/",
      },
      {
        label: {
          es: "Ficha informativa UMSS AUGM",
          en: "UMSS AUGM information sheet",
        },
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXQxIhDtK51HsdtD-Rh8Jy4B0rgfrknvri1xc1_PTCS5gQ?e=ofcaiY",
      },
      {
        label: {
          es: "Calendario Académico Gestión 2025",
          en: "Academic Calendar 2025",
        },
        href: "http://plataforma.dpa.umss.edu.bo/plataforma/?page_id=2388",
      },
      {
        label: {
          es: "Oferta Académica de pregrado 2025",
          en: "Undergraduate academic offer 2025",
        },
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXxpbnaymy1FsAUE93zRUA8BpbMTr91tt_x-aVTO4lFJuA?e=NpfoCV",
      },
      {
        label: {
          es: "Oferta académica de Posgrado",
          en: "Graduate academic offer",
        },
        href: "http://www.posgrado.umss.edu.bo/",
      },
      {
        label: {
          es: "Reglamento del Programa de Movilidad Estudiantil Internacional de la UMSS",
          en: "UMSS International Student Mobility Program Regulations",
        },
        href: "https://drive.google.com/file/d/14FtDy4LNtRWZPwWxuyKheDtcs5j-uVKP/view?usp=sharing",
      },
      {
        label: {
          es: "Escalas de calificación en la UMSS / Grading Scale at UMSS",
          en: "Grading Scale at UMSS",
        },
        href: "https://drive.google.com/file/d/1tbpMAyqvh8Sl_-Ceka2OqjLk9T-XuGHE/view?usp=sharing",
      },
      {
        label: {
          es: "VISA: lista de países que no requieren visa para ingresar a Bolivia",
          en: "VISA: countries that do not require a visa to enter Bolivia",
        },
        href: "https://drive.google.com/file/d/15GR5TWU4Ywgge-srLYjWPPgf9TOJK583/view?usp=sharing",
      },
      {
        label: {
          es: "Resolución Biministerial Nº 01/2007",
          en: "Biministerial Resolution No. 01/2007",
        },
        href: "https://drive.google.com/file/d/1PoZh9m4vfTJBnb8MrImhpn1bhcMqXwNE/view?usp=sharing",
      },
      {
        label: {
          es: "Guía Informativa Nº 1: estudiar en Bolivia",
          en: "Information Guide No. 1: studying in Bolivia",
        },
        href: "https://drive.google.com/file/d/11q-f4c9IllOy21g6xqGau9ATDX1k5-fa/view?usp=sharing",
      },
      {
        label: {
          es: "Dirección General de Migración",
          en: "General Directorate of Migration",
        },
        href: "http://www.migracion.gob.bo/",
      },
      {
        label: {
          es: "Ministerio de Relaciones Exteriores de Bolivia",
          en: "Ministry of Foreign Affairs of Bolivia",
        },
        href: "https://cancilleria.gob.bo/webmre/",
      },
      {
        label: {
          es: "Representaciones del exterior en Bolivia",
          en: "Foreign representations in Bolivia",
        },
        href: "https://cancilleria.gob.bo/mre/emergencia/",
      },
      {
        label: {
          es: "Información general sobre Cochabamba, Bolivia",
          en: "General information about Cochabamba, Bolivia",
        },
        href: "https://cochabambabolivia.net/",
      },
    ],
  },
];

export default async function InformacionNacionalesExtranjerosPage({
  params,
}: {
  params: Promise<{ locale: string }>;
}) {
  const { locale } = await params;
  const language: Locale = locale === "en" ? "en" : "es";
  const t = copy[language];

  return (
    <main className="dric-theme-page dric-info-mobility-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-14 pt-36 md:px-10 md:pb-16 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <Link
            href={`/${locale}/becas-movilidad`}
            className="dric-info-back inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white/72 backdrop-blur transition hover:border-white/25 hover:bg-white/15 hover:text-white"
          >
            <ArrowBackRoundedIcon fontSize="small" />
            {t.back}
          </Link>

          <div className="mt-14 max-w-5xl">
            <p className="dric-info-eyebrow mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              DRIC · UMSS
            </p>

            <p className="mb-5 text-xs font-bold uppercase tracking-[0.25em] text-cyan-200">
              {t.eyebrow}
            </p>

            <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
              {t.title}
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
              {t.intro}
            </p>
          </div>
        </div>
      </section>

      <section className="relative isolate px-5 pb-24 md:px-10 lg:px-12">
        <div className="mx-auto grid max-w-7xl gap-8">
          {sections.map((section, index) => (
            <article
              key={section.id}
              className="dric-info-card relative overflow-hidden rounded-[2rem] p-[1px]"
            >
              <div className="dric-info-card-inner relative grid gap-8 rounded-[calc(2rem-1px)] p-6 md:p-8 lg:grid-cols-[0.86fr_1.14fr] lg:gap-10">
                <div className={`${index % 2 === 1 ? "lg:order-2" : ""}`}>
                  <div className="dric-info-image relative flex min-h-[280px] overflow-hidden rounded-[1.6rem] border border-white/10 bg-white/[0.045]">
                    <div className="dric-info-image-placeholder absolute inset-0 flex items-center justify-center px-6 text-center">
                      <span className="rounded-full border border-white/12 bg-[#020617]/45 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white/62 backdrop-blur">
                        {t.photoSlot}: {section.id}.png
                      </span>
                    </div>
                    <Image
                      src={section.image}
                      alt={section.imageAlt[language]}
                      fill
                      sizes="(min-width: 1024px) 40vw, 100vw"
                      className="object-cover"
                    />
                  </div>
                </div>

                <div className="flex min-w-0 flex-col">
                  <div className="flex flex-wrap items-center gap-4">
                    <div className="dric-info-icon flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl text-white">
                      {section.id === "saliente" ? <FlightTakeoffRoundedIcon /> : <TravelExploreRoundedIcon />}
                    </div>

                    <div className="min-w-0">
                      <p className="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">
                        {section.eyebrow[language]}
                      </p>
                      <h2 className="mt-2 text-3xl font-semibold tracking-[-0.04em] text-white md:text-5xl">
                        {section.title[language]}
                      </h2>
                    </div>
                  </div>

                  <p className="mt-6 text-base leading-8 text-white/68">
                    {section.summary[language]}
                  </p>

                  <div className="mt-8 grid gap-6 xl:grid-cols-[0.92fr_1.08fr]">
                    <div className="dric-info-panel rounded-3xl border border-white/10 bg-[#020617]/36 p-5">
                      <div className="mb-4 flex items-center gap-2 text-sm font-bold text-white">
                        <SchoolRoundedIcon sx={{ color: "#E30613", fontSize: 20 }} />
                        {t.keyInfo}
                      </div>

                      <ul className="space-y-3">
                        {section.points.map((point) => (
                          <li key={point.es} className="flex gap-3 text-sm leading-7 text-white/64">
                            <span className="mt-3 h-1.5 w-1.5 shrink-0 rounded-full bg-[#E30613]" />
                            <span>{point[language]}</span>
                          </li>
                        ))}
                      </ul>
                    </div>

                    <div className="dric-info-panel rounded-3xl border border-white/10 bg-[#020617]/36 p-5">
                      <div className="mb-4 flex items-center gap-2 text-sm font-bold text-white">
                        <PublicRoundedIcon sx={{ color: "#c59dff", fontSize: 20 }} />
                        {t.resources}
                      </div>

                      <div className="grid gap-3">
                        {section.links.map((resource) => (
                          <a
                            key={resource.href}
                            href={resource.href}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="dric-info-resource group/link flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-3 text-sm font-semibold text-white/74 transition hover:border-cyan-200/35 hover:bg-white/[0.07] hover:text-white"
                            aria-label={`${t.open}: ${resource.label[language]}`}
                          >
                            <span className="flex min-w-0 items-center gap-3">
                              <LinkRoundedIcon className="shrink-0 text-[#E30613]" fontSize="small" />
                              <span className="min-w-0">{resource.label[language]}</span>
                            </span>
                            <ArrowForwardRoundedIcon className="shrink-0 text-cyan-200 transition group-hover/link:translate-x-1" fontSize="small" />
                          </a>
                        ))}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          ))}
        </div>
      </section>

      <Footer />
    </main>
  );
}
