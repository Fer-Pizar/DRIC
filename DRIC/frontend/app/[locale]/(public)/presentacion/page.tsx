import Image from "next/image";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Chip from "@mui/material/Chip";
import EmailRoundedIcon from "@mui/icons-material/EmailRounded";
import AccountBalanceRoundedIcon from "@mui/icons-material/AccountBalanceRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function PresentacionPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";
  const fallbackCopy = isEnglish
    ? {
        heroTitle: "About DRIC",
        heroSummary:
          "The Directorate of International Relations and Agreements promotes cooperation, mobility, projects and international academic opportunities for Universidad Mayor de San Simón.",
        imageAltTeam: "DRIC UMSS team",
        imageAltDirector: "DRIC Director",
        historyBadge: "Institutional history",
        historyTitle: "International vision from UMSS",
        historyText:
          "The Directorate of International Relations and Agreements was created on January 7, 1988, with the rank of Secretariat. In 1995 it was established as a Department, and in November 1997 the current Directorate was created.",
        created: "Created",
        currentDirectorate: "Current Directorate",
        cooperation: "Cooperation",
        missionTitle: "Mission",
        mission:
          "To promote, coordinate and channel international and national cooperation, as well as UMSS interinstitutional coordination, in support of teaching and learning processes, scientific and technological research, social engagement and institutional strengthening.",
        purposeTitle: "Purpose",
        purpose:
          "The main purpose of the Directorate of International Relations and Agreements of Universidad Mayor de San Simón is to explore international cooperation and interinstitutional coordination opportunities in an organized and systematic way.",
        structureBadge: "Organizational structure",
        structureTitle: "DRIC Directorate",
        structureDescription:
          "DRIC reports directly to the Rector's Office. To fulfill its functions, it is structured as follows:",
        structureItems: [
          "Executive Directorate",
          "Department of Agreements, Mobility and Scholarships",
          "Department of Internationalization and Projects",
        ],
        director: "Director: Mgr. Omar Morales Delgadillo",
        directorEmails: ["director-dric@umss.edu.bo", "rrii@umss.edu.bo"],
        agreementsTeamTitle: "Agreements, Mobility and Scholarships",
        agreementsTeamPeople: [
          "Head of Department: Mgr. Giovanna Maldonado Moscoso",
          "Mgr. Silvia del Pilar Arze",
        ],
        projectsTeamTitle: "Internationalization and Projects",
        projectsTeamPeople: ["Head of Department: Mgr. Daniel Vasquez Torrez", "Eng. John Medina"],
        teamImage: "/images/presentation/dric-team.JPG",
        directorImage: "/images/presentation/director.JPG",
      }
    : {
        heroTitle: "Presentación",
        heroSummary:
          "La Dirección de Relaciones Internacionales y Convenios promueve la cooperación, movilidad, proyectos y oportunidades académicas internacionales de la Universidad Mayor de San Simón.",
        imageAltTeam: "Equipo DRIC UMSS",
        imageAltDirector: "Director DRIC",
        historyBadge: "Historia institucional",
        historyTitle: "Una visión internacional desde la UMSS",
        historyText:
          "La Dirección de Relaciones Internacionales y Convenios fue creada el 7 de enero de 1988, con el rango de Secretaría. El año 1995 se instituye como Departamento y en noviembre de 1997 se crea la actual Dirección.",
        created: "Creación",
        currentDirectorate: "Dirección actual",
        cooperation: "Cooperación",
        missionTitle: "Misión",
        mission:
          "Promover, coordinar y canalizar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS, en beneficio de los procesos de enseñanza-aprendizaje, investigación científica y tecnológica, interacción social y fortalecimiento institucional.",
        purposeTitle: "Propósito",
        purpose:
          "Es propósito fundamental de la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón explorar de manera organizada y sistemática las oportunidades de cooperación internacional y de coordinación interinstitucional.",
        structureBadge: "Estructura",
        structureTitle: "Dirección DRIC",
        structureDescription:
          "La DRIC depende directamente del Rectorado. Para el cumplimiento de sus funciones, se estructura de la siguiente manera:",
        structureItems: [
          "Dirección Ejecutiva",
          "Departamento de Convenios, Movilidad y Becas",
          "Departamento de Internacionalización y Proyectos",
        ],
        director: "Director: Mgr. Omar Morales Delgadillo",
        directorEmails: ["director-dric@umss.edu.bo", "rrii@umss.edu.bo"],
        agreementsTeamTitle: "Convenios, Movilidad y Becas",
        agreementsTeamPeople: [
          "Jefe del departamento: Mgr. Giovanna Maldonado Moscoso",
          "Mgr. Silvia del Pilar Arze",
        ],
        projectsTeamTitle: "Internacionalización y Proyectos",
        projectsTeamPeople: ["Jefe del Departamento: Mgr. Daniel Vasquez Torrez", "Ing. John Medina"],
        teamImage: "/images/presentation/dric-team.JPG",
        directorImage: "/images/presentation/director.JPG",
      };
  const cmsPage = await getOptionalPageBySlug("presentacion", locale);
  const copy = mergePresentationContent(fallbackCopy, cmsPage, locale);

  return (
    <main className="dric-presentation-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-presentation-content relative isolate px-4 pb-16 pt-32 sm:px-5 md:px-10 md:pb-20 md:pt-36 lg:px-12">
        <div className="mx-auto max-w-7xl text-center md:text-left">
          <p className="mb-5 inline-flex max-w-full rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white/80 backdrop-blur sm:px-5 sm:tracking-[0.28em]">
            DRIC · UMSS
          </p>

          <h1 className="mx-auto max-w-full break-words text-[2.25rem] font-light uppercase leading-[1.05] tracking-[-0.015em] sm:text-5xl md:mx-0 md:max-w-6xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-8xl">
            {copy.heroTitle}
          </h1>

          <p className="mx-auto mt-6 max-w-3xl text-base leading-7 text-white/70 md:mx-0 md:mt-8 md:text-lg md:leading-8">
            {copy.heroSummary}
          </p>
        </div>
      </section>

      <section className="dric-presentation-content relative isolate overflow-hidden px-4 py-14 text-white sm:px-5 md:px-10 md:py-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <Card
              sx={{
                borderRadius: "36px",
                overflow: "hidden",
                background: "rgba(255,255,255,0.06)",
                border: "1px solid rgba(255,255,255,0.12)",
                boxShadow: "0 30px 90px rgba(0,0,0,0.34)",
              }}
            >
              <div className="relative h-[260px] bg-slate-200 sm:h-[340px] md:h-[420px]">
                <Image
                  src={copy.teamImage}
                  alt={copy.imageAltTeam}
                  fill
                  className="object-cover"
                />
              </div>
            </Card>

            <div className="min-w-0 text-center lg:text-left">
              <Chip
                label={copy.historyBadge}
                sx={{
                  borderRadius: "999px",
                  backgroundColor: "rgba(227,6,19,0.08)",
                  color: "#E30613",
                  fontWeight: 800,
                }}
              />

              <h2 className="mt-5 text-3xl font-semibold leading-tight tracking-[-0.025em] sm:text-4xl md:mt-6 md:text-5xl md:tracking-[-0.05em]">
                {copy.historyTitle}
              </h2>

              <p className="mx-auto mt-5 max-w-3xl text-sm leading-7 text-white/68 sm:text-base md:mt-6 md:leading-8 lg:mx-0">
                {copy.historyText}
              </p>

              <div className="mt-8 grid gap-4 sm:grid-cols-3">
                <MiniStat icon={<PublicRoundedIcon />} title="1988" text={copy.created} />
                <MiniStat icon={<AccountBalanceRoundedIcon />} title="1997" text={copy.currentDirectorate} />
                <MiniStat icon={<GroupsRoundedIcon />} title="UMSS" text={copy.cooperation} />
              </div>
            </div>
          </div>

          <div className="mt-14 grid gap-5 md:mt-24 md:grid-cols-2 md:gap-7">
            <InfoCard
              title={copy.missionTitle}
              text={copy.mission}
              color="#E30613"
            />

            <InfoCard
              title={copy.purposeTitle}
              text={copy.purpose}
              color="#003770"
            />
          </div>

          <div className="mt-14 grid gap-8 md:mt-24 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <Card
              sx={{
                borderRadius: "36px",
                overflow: "hidden",
                background: "rgba(255,255,255,0.06)",
                border: "1px solid rgba(255,255,255,0.12)",
                boxShadow: "0 30px 90px rgba(0,0,0,0.34)",
              }}
            >
              <div className="relative h-[360px] bg-slate-200 sm:h-[560px] lg:h-[821px]">
                <Image
                  src={copy.directorImage}
                  alt={copy.imageAltDirector}
                  fill
                  className="object-cover"
                />
              </div>
            </Card>

            <Card
              sx={{
                borderRadius: "36px",
                background: "linear-gradient(135deg,rgba(255,255,255,0.11),rgba(255,255,255,0.045))",
                color: "white",
                border: "1px solid rgba(255,255,255,0.12)",
                boxShadow: "0 30px 90px rgba(0,0,0,0.34)",
                overflow: "hidden",
              }}
            >
              <div className="p-5 sm:p-8 md:p-12">
                <p className="text-xs font-bold uppercase tracking-[0.18em] text-[#E30613] sm:text-sm sm:tracking-[0.25em]">
                  {copy.structureBadge}
                </p>

                <h2 className="mt-4 text-3xl font-semibold leading-tight tracking-[-0.025em] sm:text-4xl md:mt-5 md:text-5xl md:tracking-[-0.05em]">
                  {copy.structureTitle}
                </h2>

                <p className="mt-5 text-sm leading-7 text-white/68 md:mt-6">
                  {copy.structureDescription}
                </p>

                <ul className="mt-6 space-y-3 text-sm leading-7 text-white/68">
                  {copy.structureItems.map((item) => (
                    <li key={item}>• {item}</li>
                  ))}
                </ul>

                <div className="mt-8 rounded-2xl border border-white/10 bg-white/[0.06] p-5 md:rounded-3xl md:p-6">
                  <h3 className="break-words text-xl font-bold leading-tight tracking-[-0.02em] sm:text-2xl md:tracking-[-0.04em]">
                    {copy.director}
                  </h3>

                  <div className="mt-5 space-y-3 text-sm text-white/70">
                    {copy.directorEmails.map((email) => (
                      <p key={email} className="flex min-w-0 items-start gap-2">
                        <EmailRoundedIcon sx={{ color: "#E30613", fontSize: 20, flexShrink: 0 }} />
                        <span className="min-w-0 break-words">{email}</span>
                      </p>
                    ))}
                  </div>
                </div>

                <div className="mt-8 grid gap-5 md:grid-cols-2">
                  <StaffBlock
                    title={copy.agreementsTeamTitle}
                    people={copy.agreementsTeamPeople}
                  />
                  <StaffBlock
                    title={copy.projectsTeamTitle}
                    people={copy.projectsTeamPeople}
                  />
                </div>
              </div>
            </Card>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

type PresentationCopy = {
  heroTitle: string;
  heroSummary: string;
  imageAltTeam: string;
  imageAltDirector: string;
  historyBadge: string;
  historyTitle: string;
  historyText: string;
  created: string;
  currentDirectorate: string;
  cooperation: string;
  missionTitle: string;
  mission: string;
  purposeTitle: string;
  purpose: string;
  structureBadge: string;
  structureTitle: string;
  structureDescription: string;
  structureItems: string[];
  director: string;
  directorEmails: string[];
  agreementsTeamTitle: string;
  agreementsTeamPeople: string[];
  projectsTeamTitle: string;
  projectsTeamPeople: string[];
  teamImage: string;
  directorImage: string;
};

function mergePresentationContent(fallback: PresentationCopy, page: CmsPage | null, locale: string): PresentationCopy {
  if (!page) {
    return fallback;
  }

  const history = findSection(page, "presentation.history");
  const structure = findSection(page, "presentation.structure");
  const mission = findBlock(page, "presentation.mission");
  const purpose = findBlock(page, "presentation.purpose");
  const structureItems = findBlock(page, "presentation.structure-items");
  const director = findBlock(page, "presentation.director");
  const agreementsTeam = findBlock(page, "presentation.agreements-team");
  const projectsTeam = findBlock(page, "presentation.projects-team");
  const historyImage = findBlock(page, "presentation.history-image");
  const directorImage = findBlock(page, "presentation.director-image");
  const suffix = locale === "en" ? "en" : "es";

  return {
    ...fallback,
    heroTitle: page.title || fallback.heroTitle,
    heroSummary: page.summary || fallback.heroSummary,
    historyBadge: history?.subtitle || fallback.historyBadge,
    historyTitle: history?.title || fallback.historyTitle,
    historyText: history?.summary || fallback.historyText,
    missionTitle: mission?.title || fallback.missionTitle,
    mission: mission?.summary || fallback.mission,
    purposeTitle: purpose?.title || fallback.purposeTitle,
    purpose: purpose?.summary || fallback.purpose,
    structureBadge: structure?.subtitle || fallback.structureBadge,
    structureTitle: structure?.title || fallback.structureTitle,
    structureDescription: structure?.summary || fallback.structureDescription,
    structureItems: arrayData(structureItems, `items_${suffix}`, fallback.structureItems),
    director: director?.title || fallback.director,
    directorEmails: arrayData(director, "emails", fallback.directorEmails),
    agreementsTeamTitle: agreementsTeam?.title || fallback.agreementsTeamTitle,
    agreementsTeamPeople: arrayData(agreementsTeam, `people_${suffix}`, fallback.agreementsTeamPeople),
    projectsTeamTitle: projectsTeam?.title || fallback.projectsTeamTitle,
    projectsTeamPeople: arrayData(projectsTeam, `people_${suffix}`, fallback.projectsTeamPeople),
    teamImage: historyImage?.media?.url || fallback.teamImage,
    directorImage: directorImage?.media?.url || fallback.directorImage,
  };
}

function findSection(page: CmsPage, key: string): CmsSection | undefined {
  return page.sections.find((section) => section.section_key === key);
}

function findBlock(page: CmsPage, key: string): CmsBlock | undefined {
  return page.sections
    .flatMap((section) => section.blocks ?? [])
    .find((block) => block.link_url === key);
}

function arrayData(block: CmsBlock | undefined, key: string, fallback: string[]): string[] {
  const value = block?.data?.[key];

  return Array.isArray(value) && value.every((item) => typeof item === "string")
    ? value
    : fallback;
}

function MiniStat({ icon, title, text }: { icon: React.ReactNode; title: string; text: string }) {
  return (
    <div className="rounded-2xl border border-white/10 bg-white/[0.06] p-5 shadow-xl shadow-black/20 md:rounded-3xl">
      <div className="text-cyan-300">{icon}</div>
      <p className="mt-4 text-xl font-black tracking-[-0.03em] md:text-2xl md:tracking-[-0.05em]">{title}</p>
      <p className="mt-1 break-words text-xs font-bold uppercase tracking-[0.14em] text-white/50 sm:tracking-[0.18em]">{text}</p>
    </div>
  );
}

function InfoCard({ title, text, color }: { title: string; text: string; color: string }) {
  return (
    <Card
      sx={{
        borderRadius: "34px",
        background: "linear-gradient(135deg,rgba(255,255,255,0.105),rgba(255,255,255,0.04))",
        color: "white",
        border: "1px solid rgba(255,255,255,0.12)",
        boxShadow: "0 24px 70px rgba(0,0,0,0.28)",
      }}
    >
      <div className="relative min-h-[260px] p-5 sm:p-8 md:min-h-[310px] md:p-10">
        <div className="absolute inset-x-0 top-0 h-1.5" style={{ backgroundColor: color }} />
        <h3 className="text-3xl font-semibold leading-tight tracking-[-0.025em] md:text-4xl md:tracking-[-0.05em]">{title}</h3>
        <p className="mt-5 text-sm leading-7 text-white/68 md:mt-6 md:leading-8">{text}</p>
      </div>
    </Card>
  );
}

function StaffBlock({ title, people }: { title: string; people: string[] }) {
  return (
    <div className="rounded-2xl border border-white/10 bg-white/[0.055] p-5 md:rounded-3xl md:p-6">
      <p className="break-words text-xs font-black uppercase leading-relaxed tracking-[0.14em] text-cyan-300 sm:text-sm sm:tracking-[0.18em]">{title}</p>
      <ul className="mt-4 space-y-2 text-sm leading-7 text-white/68">
        {people.map((person) => (
          <li key={person} className="break-words">• {person}</li>
        ))}
      </ul>
    </div>
  );
}
