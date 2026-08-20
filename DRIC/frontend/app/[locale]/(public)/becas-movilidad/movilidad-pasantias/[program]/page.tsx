import Link from "next/link";
import { notFound } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Button from "@mui/material/Button";
import AdminPanelSettingsRoundedIcon from "@mui/icons-material/AdminPanelSettingsRounded";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import WorkRoundedIcon from "@mui/icons-material/WorkRounded";
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
    conditions: "Condiciones",
    audience: "Ruta",
    related: "Más programas de esta ruta",
    cms: "Contenido listo para conectar al CMS administrativo",
    contact: "Contactar DRIC",
    callsTitle: "Convocatorias por Convenios Interinstitucionales",
    benefits: "Beneficio",
    documents: "Documentos",
    deadline: "Plazo de postulación",
    source: "Ver fuente original",
  },
  en: {
    back: "Back to mobility",
    overview: "Program overview",
    conditions: "Conditions",
    audience: "Pathway",
    related: "More programs in this pathway",
    cms: "Content ready to connect to the admin CMS",
    contact: "Contact DRIC",
    callsTitle: "Calls through Interinstitutional Agreements",
    benefits: "Benefit",
    documents: "Documents",
    deadline: "Application deadline",
    source: "View original source",
  },
};

export default async function MobilityProgramDetailPage({ params }: Props) {
  const { locale, program } = await params;
  const isEnglish = locale === "en";
  const text = isEnglish ? mobilityData.en : mobilityData.es;
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
        slug: slugifyProgramTitle(item.title, track.id),
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
    <main className="dric-theme-page dric-mobility-page dric-mobility-programs-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-mobility-hero relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.34),transparent_34%),radial-gradient(circle_at_top_right,rgba(34,211,238,0.22),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="dric-mobility-hero-glow absolute left-1/2 top-24 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl">
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

          <div className="mt-14 grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-end">
            <div>
              <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
                DRIC · UMSS
              </p>

              <p className="mb-5 text-xs font-bold uppercase tracking-[0.25em] text-cyan-200">
                {match.program.tag}
              </p>

              <h1 className="max-w-5xl text-4xl font-light uppercase leading-[0.95] tracking-[-0.06em] text-white md:text-6xl lg:text-7xl">
                {match.program.title}
              </h1>
            </div>

            <aside className="dric-mobility-track-panel rounded-[2rem] border border-white/12 bg-white/[0.07] p-7 shadow-2xl shadow-black/25 backdrop-blur-xl">
              <div className="flex items-center gap-4">
                <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E30613] text-white shadow-xl shadow-[#E30613]/20">
                  {match.track.icon === "student" ? (
                    <SchoolRoundedIcon sx={{ fontSize: 30 }} />
                  ) : (
                    <AdminPanelSettingsRoundedIcon sx={{ fontSize: 30 }} />
                  )}
                </div>

                <div>
                  <p className="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">
                    {copy.audience}
                  </p>
                  <h2 className="mt-1 text-2xl font-semibold tracking-[-0.03em]">
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
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.18),transparent_34%),radial-gradient(circle_at_center_right,rgba(0,55,112,0.30),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />

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

            <div className="dric-mobility-cyan-note mt-8 rounded-3xl border border-cyan-200/20 bg-cyan-200/10 px-5 py-4 text-sm font-semibold leading-7 text-cyan-50">
              {copy.cms}
            </div>

            {match.program.reference ? (
              <Link href={match.program.reference.href} className="mt-7 inline-flex">
                <Button
                  variant="contained"
                  endIcon={<OpenInNewRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 4,
                    py: 1.25,
                    background: "linear-gradient(135deg,#67e8f9,#0e7490)",
                    color: "#020617",
                    textTransform: "none",
                    fontWeight: 900,
                    boxShadow: "0 18px 45px rgba(103,232,249,0.22)",
                  }}
                >
                  {match.program.reference.label}
                </Button>
              </Link>
            ) : null}
          </article>

          <aside className="space-y-7">
            <div className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl">
              <div className="mb-5 flex items-center gap-3 text-lg font-semibold">
                {match.program.conditions.length > 1 ? (
                  <GroupsRoundedIcon sx={{ color: "#E30613" }} />
                ) : (
                  <WorkRoundedIcon sx={{ color: "#E30613" }} />
                )}
                {copy.conditions}
              </div>

              <ul className="space-y-4">
                {match.program.conditions.map((condition) => (
                  <li key={condition} className="flex gap-3 text-sm leading-7 text-white/66">
                    <span className="mt-2 h-2 w-2 shrink-0 rounded-full bg-cyan-200 shadow-[0_0_18px_rgba(103,232,249,0.5)]" />
                    <span>{condition}</span>
                  </li>
                ))}
              </ul>
            </div>

            <Link href={`/${locale}/contacto`} className="block">
              <div className="dric-mobility-program-card rounded-[2rem] border border-white/10 bg-white/[0.055] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/40">
                <p className="text-xs font-bold uppercase tracking-[0.22em] text-cyan-200">
                  DRIC · UMSS
                </p>
                <div className="mt-5 flex items-center justify-between gap-4">
                  <h2 className="text-2xl font-semibold tracking-[-0.03em]">{copy.contact}</h2>
                  <OpenInNewRoundedIcon sx={{ color: "#67e8f9" }} />
                </div>
              </div>
            </Link>
          </aside>
        </div>

        {match.program.calls?.length ? (
          <div className="mx-auto mt-12 max-w-7xl">
            <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
              <div>
                <p className="text-xs font-bold uppercase tracking-[0.25em] text-cyan-200">
                  {match.program.reference?.label ?? match.program.tag}
                </p>
                <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-4xl">
                  {copy.callsTitle}
                </h2>
              </div>

              {match.program.reference ? (
                <Link href={match.program.reference.href} className="inline-flex">
                  <Button
                    className="dric-mobility-card-button"
                    variant="outlined"
                    endIcon={<OpenInNewRoundedIcon />}
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
                    {copy.source}
                  </Button>
                </Link>
              ) : null}
            </div>

            <div className="grid gap-5 lg:grid-cols-2">
              {match.program.calls.map((call, index) => (
                <article
                  key={`${call.title}-${index}`}
                  className="dric-mobility-call-card group rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/45 hover:bg-white/[0.075] md:p-7"
                >
                  <div className="flex flex-wrap items-center gap-3">
                    <span className="dric-mobility-program-number text-xs font-bold uppercase tracking-[0.25em] text-cyan-200">
                      {String(index + 1).padStart(2, "0")}
                    </span>
                    <span className="rounded-full border border-cyan-200/20 bg-cyan-200/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] text-cyan-100">
                      {match.program.tag}
                    </span>
                  </div>

                  <h3 className="mt-6 text-2xl font-semibold leading-tight tracking-[-0.04em] text-white">
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
                  href={`/${locale}/becas-movilidad/movilidad-pasantias/${slugifyProgramTitle(item.title, match.track.id)}`}
                  className="dric-mobility-program-card rounded-3xl border border-white/10 bg-white/[0.055] p-5 shadow-xl shadow-black/15 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-cyan-200/40"
                >
                  <span className="text-xs font-bold uppercase tracking-[0.16em] text-cyan-200">
                    {item.tag}
                  </span>
                  <h3 className="mt-3 text-lg font-semibold leading-snug tracking-[-0.03em]">
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
