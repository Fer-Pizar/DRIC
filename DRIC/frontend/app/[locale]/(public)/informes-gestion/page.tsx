import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import DownloadRoundedIcon from "@mui/icons-material/DownloadRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import SearchRoundedIcon from "@mui/icons-material/SearchRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "Transparencia institucional",
    title: "Informes de Gestión",
    intro:
      "Consulta los informes institucionales de la Dirección de Relaciones Internacionales y Convenios, organizados por gestión para fortalecer la transparencia y el acceso público a la información.",
    archiveLabel: "Archivo DRIC",
    archiveDescription:
      "Los documentos estarán conectados al CMS para descarga directa en PDF.",
    exploreLabel: "Explorar documentos",
    archiveTitle: "Archivo de informes",
    searchPlaceholder: "Buscar informe...",
    coverEyebrow: "Dirección de",
    coverTitle: "Relaciones Internacionales y Convenios",
    yearLabel: "Gestión",
    downloadLabel: "Descargar PDF",
    reports: [
      { title: "Informe de Gestión 2023", date: "Oct 15, 2024", year: "2023" },
      { title: "Informe de Gestión 2022", date: "Nov 29, 2023", year: "2022" },
      { title: "Informe DRIC 2021", date: "Mar 3, 2022", year: "2021" },
      { title: "Informe DRIC 2020", date: "Dic 28, 2020", year: "2020" },
      { title: "Informe DRIC 2019", date: "Dic 27, 2019", year: "2019" },
      { title: "Informe DRIC 2018", date: "Dic 27, 2018", year: "2018" },
      { title: "Informe DRIC 2017", date: "Dic 29, 2017", year: "2017" },
    ],
  },
  en: {
    eyebrow: "Institutional transparency",
    title: "Management Reports",
    intro:
      "Review the institutional reports of the Directorate of International Relations and Agreements, organized by year to strengthen transparency and public access to information.",
    archiveLabel: "DRIC Archive",
    archiveDescription:
      "The documents will be connected to the CMS for direct PDF downloads.",
    exploreLabel: "Explore documents",
    archiveTitle: "Reports archive",
    searchPlaceholder: "Search report...",
    coverEyebrow: "Directorate of",
    coverTitle: "International Relations and Agreements",
    yearLabel: "Year",
    downloadLabel: "Download PDF",
    reports: [
      { title: "Management Report 2023", date: "Oct 15, 2024", year: "2023" },
      { title: "Management Report 2022", date: "Nov 29, 2023", year: "2022" },
      { title: "DRIC Report 2021", date: "Mar 3, 2022", year: "2021" },
      { title: "DRIC Report 2020", date: "Dec 28, 2020", year: "2020" },
      { title: "DRIC Report 2019", date: "Dec 27, 2019", year: "2019" },
      { title: "DRIC Report 2018", date: "Dec 27, 2018", year: "2018" },
      { title: "DRIC Report 2017", date: "Dec 29, 2017", year: "2017" },
    ],
  },
};

export default async function InformesGestionPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";
  const t = content[locale as "es" | "en"] ?? content.es;

  return (
    <main className="dric-theme-page dric-reports-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-reports-hero relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
          <div>
            <p
              className={`mb-5 inline-flex max-w-full rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase text-white/80 backdrop-blur sm:px-5 ${
                isEnglish ? "tracking-[0.16em] sm:tracking-[0.28em]" : "tracking-[0.28em]"
              }`}
            >
              {t.eyebrow}
            </p>

            <h1
              className={`max-w-5xl break-words font-light uppercase ${
                isEnglish
                  ? "text-[2.4rem] leading-[1.04] tracking-[-0.025em] sm:text-5xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-8xl"
                  : "text-5xl leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl"
              }`}
            >
              {t.title}
            </h1>

            <p
              className={`max-w-3xl text-white/70 ${
                isEnglish
                  ? "mt-6 text-sm leading-7 sm:text-base md:mt-8 md:text-lg md:leading-8"
                  : "mt-8 text-base leading-8 md:text-lg"
              }`}
            >
              {t.intro}
            </p>
          </div>

          <div className="dric-reports-summary rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl sm:p-7 md:rounded-[2rem]">
            <p
              className={`text-sm font-bold uppercase text-white/55 ${
                isEnglish ? "tracking-[0.16em] sm:tracking-[0.24em]" : "tracking-[0.24em]"
              }`}
            >
              {t.archiveLabel}
            </p>

            <p
              className={`mt-5 font-light ${
                isEnglish
                  ? "text-[2.65rem] leading-none tracking-[-0.035em] sm:text-5xl sm:tracking-[-0.06em]"
                  : "text-5xl tracking-[-0.06em]"
              }`}
            >
              2017—2023
            </p>

            <p className="mt-4 text-sm leading-7 text-white/65">
              {t.archiveDescription}
            </p>
          </div>
        </div>
      </section>

      <section className="dric-reports-section relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-12 grid gap-6 lg:grid-cols-[1fr_0.8fr] lg:items-end">
            <div>
              <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#E30613]">
                {t.exploreLabel}
              </p>

              <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                {t.archiveTitle}
              </h2>
            </div>

            <div className="dric-reports-search rounded-full border border-white/10 bg-white/[0.06] p-2 shadow-2xl shadow-black/20 backdrop-blur-xl">
              <TextField
                fullWidth
                placeholder={t.searchPlaceholder}
                variant="outlined"
                slotProps={{
                  input: {
                    startAdornment: (
                      <SearchRoundedIcon sx={{ mr: 1.5, color: "#003770" }} />
                    ),
                  },
                }}
                sx={{
                  "& .MuiOutlinedInput-root": {
                    borderRadius: "999px",
                    backgroundColor: "#ffffff",
                    "& fieldset": { borderColor: "transparent" },
                    "&:hover fieldset": { borderColor: "transparent" },
                    "&.Mui-focused fieldset": { borderColor: "#003770" },
                  },
                }}
              />
            </div>
          </div>

          <div className="grid gap-7 sm:grid-cols-2 xl:grid-cols-3">
            {t.reports.map((report) => (
              <Card
                className="dric-reports-card"
                key={report.year}
                sx={{
                  borderRadius: "30px",
                  overflow: "hidden",
                  background: "rgba(255,255,255,0.06)",
                  border: "1px solid rgba(255,255,255,0.10)",
                  boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                  color: "white",
                }}
              >
                <div className="relative h-48 overflow-hidden bg-[#020617] p-7 text-white">
                  <div className="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.6),transparent_36%),radial-gradient(circle_at_bottom_right,rgba(0,55,112,0.7),transparent_40%)]" />
                  <div className="dric-reports-cover-accent absolute left-0 top-0 h-full w-24 bg-[#E30613]" />

                  <div className="relative">
                    <p className="text-xs font-bold uppercase tracking-[0.24em] text-white/65">
                      {t.coverEyebrow}
                    </p>

                    <h3 className="mt-3 max-w-xs text-2xl font-black leading-tight tracking-[-0.04em]">
                      {t.coverTitle}
                    </h3>
                  </div>
                </div>

                <div className="dric-reports-card-body p-7">
                  <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#003770]">
                    {t.yearLabel} {report.year}
                  </p>

                  <h3 className="mt-3 text-2xl font-bold tracking-[-0.04em] text-white">
                    {report.title}
                  </h3>

                  <div className="mt-5 flex items-center gap-2 text-sm font-semibold text-white/58">
                    <CalendarMonthRoundedIcon sx={{ fontSize: 19, color: "#E30613" }} />
                    {report.date}
                  </div>

                  <Link href={`/${locale}/normativas`} className="mt-7 inline-flex">
                    <Button
                      variant="contained"
                      endIcon={<DownloadRoundedIcon />}
                      sx={{
                        borderRadius: "999px",
                        px: 3,
                        py: 1.1,
                        background: "linear-gradient(135deg,#E30613,#E30613)",
                        textTransform: "none",
                        fontWeight: 800,
                        boxShadow: "0 14px 34px rgba(227,6,19,0.22)",
                      }}
                    >
                      {t.downloadLabel}
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
