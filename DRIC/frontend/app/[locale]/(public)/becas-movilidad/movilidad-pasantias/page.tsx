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
import type { Program } from "./data";
import { mobilityData, slugifyProgramTitle } from "./data";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function MovilidadPasantiasPage({ params }: Props) {
  const { locale } = await params;
  const text = locale === "en" ? mobilityData.en : mobilityData.es;

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

          <div className="mt-14 max-w-5xl">
            <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              DRIC · UMSS
            </p>

            <p className="mb-5 text-xs font-bold uppercase tracking-[0.25em] text-cyan-200">
              {text.eyebrow}
            </p>

            <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
              {text.title}
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
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
        <div className="dric-mobility-track-heading mb-12 grid gap-8 rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-9 lg:grid-cols-[auto_1fr] lg:items-center">
          <div className="flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-[#E30613] text-white shadow-2xl shadow-[#E30613]/20">
            {icon === "student" ? (
              <SchoolRoundedIcon sx={{ fontSize: 38 }} />
            ) : (
              <AdminPanelSettingsRoundedIcon sx={{ fontSize: 38 }} />
            )}
          </div>

          <div>
            <h2 className="text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
              {title}
            </h2>
            <p className="mt-4 max-w-4xl text-sm leading-7 text-white/66 md:text-base">
              {intro}
            </p>
          </div>
        </div>

        <div className="grid gap-5 lg:grid-cols-2">
          {programs.map((program) => (
            <Link
              key={`${trackId}-${program.title}`}
              href={`/${locale}/becas-movilidad/movilidad-pasantias/${slugifyProgramTitle(program.title, trackId)}`}
              className="block h-full"
            >
              <article className="dric-mobility-program-card group h-full rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-[#E30613]/45 hover:bg-white/[0.075] md:p-7">
              <div className="flex flex-wrap items-center gap-3">
                <span className="rounded-full border border-cyan-200/20 bg-cyan-200/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] text-cyan-100">
                  {program.tag}
                </span>
              </div>

              <h3 className="mt-6 text-2xl font-semibold leading-tight tracking-[-0.04em] text-white">
                {program.title}
              </h3>

              <p className="mt-4 text-sm leading-7 text-white/66">{program.summary}</p>

              <div className="mt-7 rounded-3xl border border-white/10 bg-[#020617]/40 p-5">
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
                    <li key={condition} className="flex gap-3 text-sm leading-6 text-white/64">
                      <WorkRoundedIcon sx={{ color: "#E30613", fontSize: 17, mt: "2px" }} />
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
