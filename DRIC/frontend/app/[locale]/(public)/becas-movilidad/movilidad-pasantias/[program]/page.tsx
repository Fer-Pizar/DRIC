import Link from "next/link";
import { notFound } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Button from "@mui/material/Button";
import AdminPanelSettingsRoundedIcon from "@mui/icons-material/AdminPanelSettingsRounded";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import ChecklistRoundedIcon from "@mui/icons-material/ChecklistRounded";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import LinkRoundedIcon from "@mui/icons-material/LinkRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import TravelExploreRoundedIcon from "@mui/icons-material/TravelExploreRounded";
import WorkRoundedIcon from "@mui/icons-material/WorkRounded";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";
import { mobilityData, slugifyProgramTitle, type Program } from "../data";

type Props = {
  params: Promise<{
    locale: string;
    program: string;
  }>;
};

type TrackRecord = {
  id: string;
  title: string;
  intro: string;
  icon: "student" | "staff";
  programs: Program[];
};

const detailCopy = {
  es: {
    back: "Volver a movilidad",
    overview: "Resumen del programa",
    related: "Más programas relacionados",
    callsTitle: "Convocatorias vigentes y fenecidas",
    benefits: "Beneficio",
    documents: "Documentos",
    links: "Enlaces",
    deadline: "Plazo de postulación",
    conditions: "Condiciones de participación",
    details: "Guía del programa",
    officialLink: "Enlace oficial",
  },
  en: {
    back: "Back to mobility",
    overview: "Program overview",
    related: "More related programs",
    callsTitle: "Current and past calls",
    benefits: "Benefit",
    documents: "Documents",
    links: "Links",
    deadline: "Application deadline",
    conditions: "Participation conditions",
    details: "Program guide",
    officialLink: "Official link",
  },
};

export default async function MobilityProgramDetailPage({ params }: Props) {
  const { locale, program } = await params;
  const isEnglish = locale === "en";
  const fallbackText = isEnglish ? mobilityData.en : mobilityData.es;
  const cmsPage = await getOptionalPageBySlug("movilidad-pasantias", locale);
  const text = withCanonicalProgramSlugs(
    mergeMobilityCmsContent(fallbackText, cmsPage, locale),
    mobilityData.es,
  );
  const copy = isEnglish ? detailCopy.en : detailCopy.es;

  const tracks: TrackRecord[] = [
    {
      id: "estudiantes",
      title: text.students,
      intro: text.studentsIntro,
      icon: "student",
      programs: text.studentPrograms,
    },
    {
      id: "docentes-administrativos",
      title: text.staff,
      intro: text.staffIntro,
      icon: "staff",
      programs: text.staffPrograms,
    },
  ];

  const match = tracks
    .flatMap((track) =>
      track.programs.map((item) => ({
        program: item,
        track,
        slug: programSlug(item, track.id),
      })),
    )
    .find((item) => item.slug === program);

  if (!match) {
    notFound();
  }

  const relatedPrograms = match.track.programs
    .filter((item) => item.title !== match.program.title)
    .slice(0, 3);

  return (
    <main className="dric-theme-page dric-mobility-page dric-mobility-detail-page dric-mobility-programs-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-mobility-hero relative isolate px-5 pb-16 pt-44 sm:pt-36 md:px-10 md:pb-20 lg:px-12">
        <div className="mx-auto max-w-7xl min-w-0">
          <Link href={`/${locale}/becas-movilidad/movilidad-pasantias`} className="inline-flex">
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
              {copy.back}
            </Button>
          </Link>

          <div className="mt-10 grid min-w-0 gap-8 sm:mt-14 lg:grid-cols-[0.95fr_1.05fr] lg:items-end lg:gap-10">
            <div className="min-w-0">
              <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
                DRIC · UMSS
              </p>

              <h1 className="max-w-5xl break-words text-[2.35rem] font-light uppercase leading-[1.02] tracking-normal text-white [overflow-wrap:anywhere] sm:text-4xl sm:leading-[0.95] sm:tracking-[-0.06em] md:text-6xl lg:text-7xl">
                {match.program.title}
              </h1>
            </div>

            <aside className="dric-mobility-track-panel min-w-0 rounded-[2rem] border border-white/12 bg-white/[0.07] p-6 shadow-2xl shadow-black/25 backdrop-blur-xl sm:p-7">
              <div className="flex min-w-0 items-center gap-4">
                <div className="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#E30613] text-white shadow-xl shadow-[#E30613]/20">
                  {match.track.icon === "student" ? (
                    <SchoolRoundedIcon sx={{ fontSize: 30 }} />
                  ) : (
                    <AdminPanelSettingsRoundedIcon sx={{ fontSize: 30 }} />
                  )}
                </div>

                <div className="min-w-0">
                  <h2 className="break-words text-2xl font-semibold tracking-[-0.03em] [overflow-wrap:anywhere]">
                    {match.track.title}
                  </h2>
                </div>
              </div>

              <p className="mt-5 text-sm leading-7 text-white/66">{match.track.intro}</p>
            </aside>
          </div>
        </div>
      </section>

      <section className="dric-mobility-section relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
        <div className="mx-auto grid max-w-7xl gap-7 lg:grid-cols-[1fr_0.72fr]">
          <article className="dric-mobility-track-heading rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-10">
            <div className="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10">
              <PublicRoundedIcon sx={{ color: "#67e8f9", fontSize: 30 }} />
            </div>

            <h2 className="text-3xl font-semibold tracking-[-0.04em] md:text-4xl">
              {copy.overview}
            </h2>

            <p className="mt-6 text-base leading-8 text-white/68 md:text-lg">
              {match.program.summary}
            </p>
          </article>

          <aside className="space-y-7">
            {match.program.highlights?.length ? (
              <div className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <div className="mb-5 flex items-center gap-3">
                  <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-cyan-200">
                    <TravelExploreRoundedIcon />
                  </div>
                  <h2 className="text-xl font-semibold tracking-[-0.03em]">
                    {isEnglish ? "At a glance" : "Datos clave"}
                  </h2>
                </div>

                <dl className="grid gap-3">
                  {match.program.highlights.map((item) => (
                    <div
                      key={item.label}
                      className="rounded-3xl border border-white/10 bg-[#020617]/40 p-4"
                    >
                      <dt className="text-xs font-bold uppercase tracking-[0.18em] text-cyan-200">
                        {item.label}
                      </dt>
                      <dd className="mt-2 text-sm leading-6 text-white/72">{item.value}</dd>
                    </div>
                  ))}
                </dl>
              </div>
            ) : null}

            {match.program.conditions.length ? (
              <div className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <div className="mb-5 flex items-center gap-3">
                  <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-[#E30613]">
                    <ChecklistRoundedIcon />
                  </div>
                  <h2 className="text-xl font-semibold tracking-[-0.03em]">{copy.conditions}</h2>
                </div>

                <ul className="space-y-3">
                  {match.program.conditions.map((condition) => (
                    <li key={condition} className="flex gap-3 text-sm leading-7 text-white/66">
                      <span className="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#E30613]" />
                      <span>{condition}</span>
                    </li>
                  ))}
                </ul>
              </div>
            ) : null}

            {match.program.reference ? (
              <a
                href={match.program.reference.href}
                target="_blank"
                rel="noopener noreferrer"
                className="block"
              >
                <div className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/40">
                  <p className="text-xs font-bold uppercase tracking-[0.22em] text-cyan-200">
                    {copy.officialLink}
                  </p>
                  <div className="mt-5 flex items-center justify-between gap-4">
                    <h2 className="text-2xl font-semibold tracking-[-0.03em]">
                      {match.program.reference.label}
                    </h2>
                    <OpenInNewRoundedIcon sx={{ color: "#67e8f9" }} />
                  </div>
                </div>
              </a>
            ) : null}

          </aside>
        </div>

        {match.program.sections?.length ? (
          <div className="mx-auto mt-12 max-w-7xl">
            <div className="mb-6 max-w-3xl">
              <p className="text-xs font-bold uppercase tracking-[0.24em] text-[#E30613]">
                {match.program.tag}
              </p>
              <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-4xl">
                {copy.details}
              </h2>
            </div>

            <div className="grid gap-5 lg:grid-cols-3">
              {match.program.sections.map((section) => (
                <article
                  key={section.title}
                  className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-7"
                >
                  <h3 className="text-2xl font-semibold tracking-[-0.04em]">{section.title}</h3>

                  {section.body ? (
                    <p className="mt-5 text-sm leading-7 text-white/66">{section.body}</p>
                  ) : null}

                  {section.items?.length ? (
                    <ul className="mt-5 space-y-3">
                      {section.items.map((item) => (
                        <li key={item} className="flex gap-3 text-sm leading-7 text-white/66">
                          <span className="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-200" />
                          <span>{item}</span>
                        </li>
                      ))}
                    </ul>
                  ) : null}
                </article>
              ))}
            </div>
          </div>
        ) : null}

        {match.program.calls?.length ? (
          <div className="mx-auto mt-12 max-w-7xl">
            <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
              <div>
                <h2 className="text-3xl font-semibold tracking-[-0.04em] md:text-4xl">
                  {copy.callsTitle}
                </h2>
              </div>
            </div>

            <div className="grid gap-5 lg:grid-cols-2">
              {match.program.calls.map((call, index) => (
                <article
                  key={`${call.title}-${index}`}
                  className="dric-mobility-call-card group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/45 hover:bg-white/[0.075] md:p-7"
                >
                  <span className="absolute inset-x-7 top-0 h-1 rounded-b-full bg-gradient-to-r from-[#b1040f] via-cyan-200 to-transparent opacity-90" />

                  <h3 className="pt-4 text-2xl font-semibold leading-tight tracking-[-0.04em] text-white">
                    {call.title}
                  </h3>

                  <p className="mt-4 text-sm leading-7 text-white/66">{call.description}</p>

                  <div className="mt-7 grid gap-4">
                    {call.benefits?.length ? (
                      <InfoBlock title={copy.benefits} items={call.benefits} />
                    ) : null}

                    {call.documents?.length ? (
                      <InfoBlock title={copy.documents} items={call.documents} icon="document" />
                    ) : null}

                    {call.links?.length ? (
                      <LinkBlock title={copy.links} links={call.links} />
                    ) : null}

                    {call.deadline ? (
                      <div className="rounded-3xl border border-white/10 bg-[#020617]/40 p-5">
                        <div className="mb-3 flex items-center gap-2 text-sm font-bold text-white">
                          <CalendarMonthRoundedIcon sx={{ color: "#67e8f9", fontSize: 20 }} />
                          {copy.deadline}
                        </div>
                        <p className="text-sm leading-7 text-white/66">{call.deadline}</p>
                      </div>
                    ) : null}

                    {call.note ? (
                      <div className="dric-mobility-cyan-note rounded-3xl border border-cyan-200/20 bg-cyan-200/10 p-5 text-sm leading-7 text-cyan-50">
                        {call.note}
                      </div>
                    ) : null}
                  </div>
                </article>
              ))}
            </div>
          </div>
        ) : null}

        {relatedPrograms.length > 0 ? (
          <div className="mx-auto mt-10 max-w-7xl">
            <h2 className="text-2xl font-semibold tracking-[-0.03em]">{copy.related}</h2>

            <div className="mt-5 grid gap-4 md:grid-cols-3">
              {relatedPrograms.map((item) => (
                <Link
                  key={item.title}
                  href={programHref(locale, item, match.track.id)}
                  className="dric-mobility-program-card group relative overflow-hidden rounded-3xl border border-white/10 bg-white/[0.055] p-5 shadow-xl shadow-black/15 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/40"
                >
                  <span className="absolute inset-y-5 left-0 w-1 rounded-r-full bg-gradient-to-b from-[#E30613] to-cyan-200 opacity-80 transition duration-300 group-hover:opacity-100" />
                  <h3 className="pl-3 text-lg font-semibold leading-snug tracking-[-0.03em]">
                    {item.title}
                  </h3>
                </Link>
              ))}
            </div>
          </div>
        ) : null}
      </section>

      <Footer />
    </main>
  );
}

function LinkBlock({
  title,
  links,
}: {
  title: string;
  links: Array<{
    label: string;
    href: string;
  }>;
}) {
  return (
    <div className="rounded-3xl border border-white/10 bg-[#020617]/40 p-5">
      <div className="mb-3 flex items-center gap-2 text-sm font-bold text-white">
        <LinkRoundedIcon sx={{ color: "#67e8f9", fontSize: 20 }} />
        {title}
      </div>

      <div className="flex flex-wrap gap-2">
        {links.map((link) => (
          <a
            key={`${link.label}-${link.href}`}
            href={link.href}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex max-w-full items-center gap-2 rounded-full border border-cyan-200/20 bg-cyan-200/10 px-4 py-2 text-sm font-semibold leading-6 text-cyan-50 transition hover:border-cyan-200/45 hover:bg-cyan-200/15"
          >
            <span className="min-w-0 break-words [overflow-wrap:anywhere]">{link.label}</span>
            <OpenInNewRoundedIcon className="shrink-0" sx={{ fontSize: 17 }} />
          </a>
        ))}
      </div>
    </div>
  );
}

function InfoBlock({
  title,
  items,
  icon = "benefit",
}: {
  title: string;
  items: string[];
  icon?: "benefit" | "document";
}) {
  const Icon = icon === "document" ? DescriptionRoundedIcon : WorkRoundedIcon;

  return (
    <div className="rounded-3xl border border-white/10 bg-[#020617]/40 p-5">
      <div className="mb-3 flex items-center gap-2 text-sm font-bold text-white">
        <Icon sx={{ color: icon === "document" ? "#67e8f9" : "#E30613", fontSize: 20 }} />
        {title}
      </div>

      <ul className="space-y-2">
        {items.map((item) => (
          <li key={item} className="flex gap-3 text-sm leading-7 text-white/66">
            <span className="mt-2.5 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-200" />
            <span>{item}</span>
          </li>
        ))}
      </ul>
    </div>
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
    const sectionTrackId = stringValue(section.settings?.track_id);
    return sectionTrackId === trackId || section.section_key === `mobility.${trackId}`;
  });
}

function withCanonicalProgramSlugs(text: MobilityLandingText, canonicalText: MobilityLandingText): MobilityLandingText {
  return {
    ...text,
    studentPrograms: withTrackCanonicalSlugs(text.studentPrograms, canonicalText.studentPrograms, "estudiantes"),
    staffPrograms: withTrackCanonicalSlugs(text.staffPrograms, canonicalText.staffPrograms, "docentes-administrativos"),
  };
}

function withTrackCanonicalSlugs(programs: Program[], canonicalPrograms: Program[], trackId: string): Program[] {
  return programs.map((program, index) => ({
    ...program,
    slug: program.slug || canonicalPrograms[index]?.slug || slugifyProgramTitle(canonicalPrograms[index]?.title || program.title, trackId),
  }));
}

function programsFromCmsBlocks(section: CmsSection | undefined, fallbackPrograms: Program[], trackId: string, locale: string): Program[] {
  const blocks = section?.blocks?.filter((block) => block.type === "mobility_program" || block.block_type === "mobility_program") ?? [];

  if (blocks.length === 0) {
    return fallbackPrograms;
  }

  return blocks.map((block, index) => {
    const slug = stringValue(block.data?.slug) || block.link_url?.split("/").filter(Boolean).pop() || "";
    const fallback =
      fallbackPrograms.find((program) => programSlugCandidates(program, trackId).includes(slug)) ??
      fallbackPrograms[index];
    const detailWasEdited = block.data?.detail_edited === true;
    const localizedConditions = stringArray(block.data?.[`conditions_${locale}`]);
    const defaultConditions = stringArray(block.data?.conditions);
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
      tag: block.subtitle || stringValue(block.data?.tag) || fallback?.tag || "",
      slug: slug || fallback?.slug || slugifyProgramTitle(block.title || fallback?.title || "", trackId),
      href: block.link_url || stringValue(block.data?.href) || fallback?.href,
      conditions: conditions.length > 0 ? conditions : fallback?.conditions ?? [],
      highlights: detailWasEdited ? cmsHighlights(block, locale) : fallback?.highlights,
      sections: detailWasEdited ? cmsSections(block, locale) : fallback?.sections,
      reference: detailWasEdited ? cmsReference(block, locale) : fallback?.reference,
      calls: detailWasEdited ? cmsCalls(block, locale) : fallback?.calls,
    };
  });
}

function cmsHighlights(block: CmsBlock, locale: string): Program["highlights"] {
  const value = block.data?.highlights;
  if (!Array.isArray(value)) return undefined;

  const items = value
    .map((item) => {
      if (!isRecord(item)) return null;
      const label = localizedString(item.label, locale);
      const value = localizedString(item.value, locale);
      return label && value ? { label, value } : null;
    })
    .filter((item): item is { label: string; value: string } => item !== null);

  return items.length ? items : undefined;
}

function cmsSections(block: CmsBlock, locale: string): Program["sections"] {
  const value = block.data?.sections;
  if (!Array.isArray(value)) return undefined;

  const sections = value
    .map((item): NonNullable<Program["sections"]>[number] | null => {
      if (!isRecord(item)) return null;
      const title = localizedString(item.title, locale);
      const body = localizedString(item.body, locale);
      const items = localizedArray(item.items, locale);
      return title ? { title, body: body || undefined, items: items.length ? items : undefined } : null;
    })
    .filter((item): item is NonNullable<Program["sections"]>[number] => item !== null);

  return sections.length ? sections : undefined;
}

function cmsReference(block: CmsBlock, locale: string): Program["reference"] {
  const reference = block.data?.reference;
  if (!isRecord(reference)) return undefined;

  const href = stringValue(reference.href);
  const label = localizedString(reference.label, locale);

  return href && label ? { href, label } : undefined;
}

function cmsCalls(block: CmsBlock, locale: string): Program["calls"] {
  const value = block.data?.calls;
  if (!Array.isArray(value)) return undefined;

  const calls = value
    .map((item): NonNullable<Program["calls"]>[number] | null => {
      if (!isRecord(item)) return null;
      const title = localizedString(item.title, locale);
      const description = localizedString(item.description, locale);
      const links = cmsLinks(item.links, locale);

      return title && description
        ? {
            title,
            description,
            benefits: localizedArray(item.benefits, locale),
            documents: localizedArray(item.documents, locale),
            deadline: localizedString(item.deadline, locale),
            note: localizedString(item.note, locale),
            links: links.length ? links : undefined,
          }
        : null;
    })
    .filter((item): item is NonNullable<Program["calls"]>[number] => item !== null);

  return calls.length ? calls : undefined;
}

function cmsLinks(value: unknown, locale: string): NonNullable<NonNullable<Program["calls"]>[number]["links"]> {
  if (!Array.isArray(value)) return [];

  return value
    .map((item) => {
      if (!isRecord(item)) return null;
      const href = stringValue(item.href);
      const label = localizedString(item.label, locale);
      return href && label ? { href, label } : null;
    })
    .filter((item): item is { label: string; href: string } => item !== null);
}

function localizedString(value: unknown, locale: string): string {
  if (isRecord(value)) {
    return stringValue(value[locale]) || stringValue(value.es) || stringValue(value.en);
  }

  return stringValue(value);
}

function localizedArray(value: unknown, locale: string): string[] {
  if (isRecord(value)) {
    const localized = stringArray(value[locale]);
    return localized.length ? localized : stringArray(value.es).length ? stringArray(value.es) : stringArray(value.en);
  }

  return stringArray(value);
}

function stringArray(value: unknown): string[] {
  return Array.isArray(value) ? value.filter((item): item is string => typeof item === "string" && item.trim().length > 0) : [];
}

function programHref(locale: string, program: Program, trackId: string): string {
  const href = program.href || `/becas-movilidad/movilidad-pasantias/${programSlug(program, trackId)}`;

  if (href.startsWith("http://") || href.startsWith("https://")) {
    return href;
  }

  const cleanHref = href.startsWith("/") ? href : `/${href}`;
  return `/${locale}${cleanHref}`;
}

function programSlug(program: Program, trackId: string): string {
  return program.slug || slugifyProgramTitle(program.title, trackId);
}

function programSlugCandidates(program: Program, trackId: string): string[] {
  return [
    program.slug,
    program.href?.split("/").filter(Boolean).pop(),
    slugifyProgramTitle(program.title, trackId),
  ].filter((value): value is string => typeof value === "string" && value.length > 0);
}

function stringValue(value: unknown): string {
  return typeof value === "string" && value.trim() ? value : "";
}

function isRecord(value: unknown): value is Record<string, unknown> {
  return Boolean(value && typeof value === "object" && !Array.isArray(value));
}
