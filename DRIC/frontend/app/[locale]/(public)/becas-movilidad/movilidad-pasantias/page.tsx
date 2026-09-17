import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Button from "@mui/material/Button";
import AdminPanelSettingsRoundedIcon from "@mui/icons-material/AdminPanelSettingsRounded";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import WorkRoundedIcon from "@mui/icons-material/WorkRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsPage, CmsSection } from "@/types/cms";
import type { Program } from "./data";
import { mobilityData, slugifyProgramTitle } from "./data";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function MovilidadPasantiasPage({ params }: Props) {
  const { locale } = await params;
  const fallbackText = locale === "en" ? mobilityData.en : mobilityData.es;
  const cmsPage = await getOptionalPageBySlug("movilidad-pasantias", locale);
  const text = mergeMobilityCmsContent(fallbackText, cmsPage, locale);

  return (
    <main className="dric-theme-page dric-mobility-page dric-mobility-landing-page dric-mobility-programs-page dric-mobility-programs-index-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-mobility-hero relative isolate px-5 pb-20 pt-28 md:px-10 md:pt-30 lg:px-12 lg:pt-32">
        <div className="mx-auto max-w-7xl">
          <Link href={`/${locale}/becas-movilidad`} className="inline-flex">
            <Button
              className="dric-mobility-card-button"
              variant="outlined"
              startIcon={<ArrowBackRoundedIcon />}
              sx={{
                borderRadius: "999px",
                px: 3,
                py: 1.1,
                color: "white",
                borderColor: "rgba(255,255,255,0.24)",
                textTransform: "none",
                fontWeight: 800,
              }}
            >
              {text.back}
            </Button>
          </Link>

          <div className="mt-14 max-w-5xl min-w-0">
            <p className="mb-5 inline-flex max-w-full rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              DRIC · UMSS
            </p>

            <p className="mb-5 text-xs font-bold uppercase tracking-[0.25em] text-cyan-200 [overflow-wrap:anywhere]">
              {text.eyebrow}
            </p>

            <h1 className="max-w-5xl text-[2.65rem] font-light uppercase leading-[0.95] text-white [overflow-wrap:anywhere] sm:text-5xl md:text-7xl lg:text-8xl">
              {text.title}
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 [overflow-wrap:anywhere] md:text-lg">
              {text.intro}
            </p>
          </div>
        </div>
      </section>

      <MobilityTrack
        id="estudiantes"
        title={text.students}
        intro={text.studentsIntro}
        programs={text.studentPrograms}
        icon="student"
        locale={locale}
        trackId="estudiantes"
        conditions={text.conditions}
      />

      <MobilityTrack
        id="docentes-administrativos"
        title={text.staff}
        intro={text.staffIntro}
        programs={text.staffPrograms}
        icon="staff"
        locale={locale}
        trackId="docentes-administrativos"
        conditions={text.conditions}
      />

      <Footer />
    </main>
  );
}

function MobilityTrack({
  id,
  title,
  intro,
  programs,
  icon,
  locale,
  trackId,
  conditions,
}: {
  id: string;
  title: string;
  intro: string;
  programs: Program[];
  icon: "student" | "staff";
  locale: string;
  trackId: string;
  conditions: string;
}) {
  return (
    <section id={id} className="dric-mobility-section relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
      <div className="mx-auto max-w-7xl">
        <div className="dric-mobility-track-heading mb-12 grid min-w-0 gap-8 sm:grid-cols-[auto_1fr] sm:items-center">
          <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-[1.35rem] bg-[#E30613] text-white shadow-2xl shadow-[#E30613]/20 sm:h-20 sm:w-20 sm:rounded-[1.7rem]">
            {icon === "student" ? (
              <SchoolRoundedIcon sx={{ fontSize: { xs: 32, sm: 38 } }} />
            ) : (
              <AdminPanelSettingsRoundedIcon sx={{ fontSize: { xs: 32, sm: 38 } }} />
            )}
          </div>

          <div className="min-w-0">
            <h2 className="text-3xl font-semibold [overflow-wrap:anywhere] sm:text-4xl md:text-5xl">
              {title}
            </h2>
            <p className="mt-4 max-w-4xl text-sm leading-7 text-white/66 [overflow-wrap:anywhere] md:text-base">
              {intro}
            </p>
          </div>
        </div>

        <div className="grid gap-5 lg:grid-cols-2">
          {programs.map((program) => (
            <Link
              key={`${trackId}-${program.title}`}
              href={programHref(locale, program, trackId)}
              className="block h-full min-w-0"
            >
              <article className="dric-mobility-program-card group h-full min-w-0 rounded-[1.5rem] border border-white/10 bg-white/[0.055] p-5 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-[#E30613]/45 hover:bg-white/[0.075] sm:rounded-[2rem] sm:p-6 md:p-7">
                <div className="flex min-w-0 flex-wrap items-center gap-3">
                  <span className="dric-mobility-program-tag max-w-full rounded-full border border-cyan-200/20 bg-cyan-200/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] text-cyan-100 [overflow-wrap:anywhere]">
                    {program.tag}
                  </span>
                </div>

                <h3 className="mt-6 text-xl font-semibold leading-tight text-white [overflow-wrap:anywhere] sm:text-2xl">
                  {program.title}
                </h3>

                <p className="mt-4 text-sm leading-7 text-white/66 [overflow-wrap:anywhere]">{program.summary}</p>

                <div className="dric-mobility-condition-panel mt-7 rounded-3xl border border-white/10 bg-[#020617]/40 p-5">
                  <div className="mb-4 flex items-center gap-2 text-sm font-bold text-white">
                    {program.conditions.length > 1 ? (
                      <GroupsRoundedIcon sx={{ color: "#E30613", fontSize: 20 }} />
                    ) : (
                      <PublicRoundedIcon sx={{ color: "#E30613", fontSize: 20 }} />
                    )}
                    {conditions}
                  </div>

                  <ul className="space-y-3">
                    {program.conditions.map((condition) => (
                      <li key={condition} className="flex gap-3 text-sm leading-6 text-white/64 [overflow-wrap:anywhere]">
                        <WorkRoundedIcon sx={{ color: "#E30613", fontSize: 17, mt: "2px", flexShrink: 0 }} />
                        <span>{condition}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              </article>
            </Link>
          ))}
        </div>

      </div>
    </section>
  );
}

type MobilityLandingText = {
  back: string;
  eyebrow: string;
  title: string;
  intro: string;
  students: string;
  studentsIntro: string;
  staff: string;
  staffIntro: string;
  conditions: string;
  studentPrograms: Program[];
  staffPrograms: Program[];
};

function mergeMobilityCmsContent(fallbackText: MobilityLandingText, cmsPage: CmsPage | null, locale: string): MobilityLandingText {
  if (!cmsPage) {
    return fallbackText;
  }

  const studentSection = findTrackSection(cmsPage, "estudiantes");
  const staffSection = findTrackSection(cmsPage, "docentes-administrativos");

  return {
    ...fallbackText,
    eyebrow: cmsPage.subtitle || fallbackText.eyebrow,
    title: cmsPage.title || fallbackText.title,
    intro: cmsPage.summary || fallbackText.intro,
    students: studentSection?.title || fallbackText.students,
    studentsIntro: studentSection?.summary || fallbackText.studentsIntro,
    staff: staffSection?.title || fallbackText.staff,
    staffIntro: staffSection?.summary || fallbackText.staffIntro,
    studentPrograms: programsFromCmsBlocks(studentSection, fallbackText.studentPrograms, "estudiantes", locale),
    staffPrograms: programsFromCmsBlocks(staffSection, fallbackText.staffPrograms, "docentes-administrativos", locale),
  };
}

function findTrackSection(cmsPage: CmsPage, trackId: string): CmsSection | undefined {
  return cmsPage.sections?.find((section) => {
    const sectionTrackId = asString(section.settings?.track_id);
    return sectionTrackId === trackId || section.section_key === `mobility.${trackId}`;
  });
}

function programsFromCmsBlocks(section: CmsSection | undefined, fallbackPrograms: Program[], trackId: string, locale: string): Program[] {
  const blocks = section?.blocks?.filter((block) => block.type === "mobility_program" || block.block_type === "mobility_program") ?? [];

  if (blocks.length === 0) {
    return fallbackPrograms;
  }

  return blocks.map((block) => {
    const slug = asString(block.data?.slug);
    const fallback = fallbackPrograms.find((program) => slugifyProgramTitle(program.title, trackId) === slug);
    const localizedConditions = asStringArray(block.data?.[`conditions_${locale}`]);
    const defaultConditions = asStringArray(block.data?.conditions);
    const conditions = localizedConditions.length > 0 ? localizedConditions : defaultConditions;

    return {
      ...(fallback ?? {
        title: "",
        summary: "",
        conditions: [],
        tag: "",
      }),
      title: block.title || fallback?.title || slug || "",
      summary: block.summary || fallback?.summary || "",
      tag: block.subtitle || asString(block.data?.tag) || fallback?.tag || "",
      slug: slug || fallback?.slug || slugifyProgramTitle(block.title || fallback?.title || "", trackId),
      href: asString(block.link_url) || asString(block.data?.href) || fallback?.href,
      conditions: conditions.length > 0 ? conditions : fallback?.conditions ?? [],
    };
  });
}

function programHref(locale: string, program: Program, trackId: string): string {
  const href = program.href || `/becas-movilidad/movilidad-pasantias/${program.slug || slugifyProgramTitle(program.title, trackId)}`;

  if (href.startsWith("http://") || href.startsWith("https://")) {
    return href;
  }

  const cleanHref = href.startsWith("/") ? href : `/${href}`;
  return `/${locale}${cleanHref}`;
}

function asString(value: unknown): string | undefined {
  return typeof value === "string" && value.trim() ? value : undefined;
}

function asStringArray(value: unknown): string[] {
  return Array.isArray(value) ? value.filter((item): item is string => typeof item === "string" && item.trim().length > 0) : [];
}
