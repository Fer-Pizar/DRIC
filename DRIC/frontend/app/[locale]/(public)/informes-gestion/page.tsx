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

const reports = [
  { title: "Informe de Gestión 2023", date: "Oct 15, 2024", year: "2023" },
  { title: "Informe de Gestión 2022", date: "Nov 29, 2023", year: "2022" },
  { title: "Informe DRIC 2021", date: "Mar 3, 2022", year: "2021" },
  { title: "Informe DRIC 2020", date: "Dic 28, 2020", year: "2020" },
  { title: "Informe DRIC 2019", date: "Dic 27, 2019", year: "2019" },
  { title: "Informe DRIC 2018", date: "Dic 27, 2018", year: "2018" },
  { title: "Informe DRIC 2017", date: "Dic 29, 2017", year: "2017" },
];

export default async function InformesGestionPage({ params }: Props) {
  const { locale } = await params;

  return (
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.40),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.48),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="absolute bottom-0 left-1/2 -z-10 h-[360px] w-[560px] -translate-x-1/2 rounded-full bg-white/10 blur-[150px]" />

        <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
          <div>
            <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
              Transparencia institucional
            </p>

            <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
              Informes de Gestión
            </h1>

            <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
              Consulta los informes institucionales de la Dirección de Relaciones Internacionales y Convenios, organizados por gestión para fortalecer la transparencia y el acceso público a la información.
            </p>
          </div>

          <div className="rounded-[2rem] border border-white/10 bg-white/10 p-7 backdrop-blur-xl">
            <p className="text-sm font-bold uppercase tracking-[0.24em] text-white/55">
              Archivo DRIC
            </p>

            <p className="mt-5 text-5xl font-light tracking-[-0.06em]">
              2017—2023
            </p>

            <p className="mt-4 text-sm leading-7 text-white/65">
              Los documentos estarán conectados al CMS para descarga directa en PDF.
            </p>
          </div>
        </div>
      </section>

      <section className="bg-[#f8fafc] px-5 py-20 text-[#111827] md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-12 grid gap-6 lg:grid-cols-[1fr_0.8fr] lg:items-end">
            <div>
              <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
                Explorar documentos
              </p>

              <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                Archivo de informes
              </h2>
            </div>

            <div className="rounded-full bg-white p-2 shadow-xl shadow-slate-200/70">
              <TextField
                fullWidth
                placeholder="Buscar informe..."
                variant="outlined"
                slotProps={{
                  input: {
                    startAdornment: (
                      <SearchRoundedIcon sx={{ mr: 1.5, color: "#164194" }} />
                    ),
                  },
                }}
                sx={{
                  "& .MuiOutlinedInput-root": {
                    borderRadius: "999px",
                    backgroundColor: "#ffffff",
                    "& fieldset": { borderColor: "transparent" },
                    "&:hover fieldset": { borderColor: "transparent" },
                    "&.Mui-focused fieldset": { borderColor: "#164194" },
                  },
                }}
              />
            </div>
          </div>

          <div className="grid gap-7 md:grid-cols-2 xl:grid-cols-3">
            {reports.map((report) => (
              <Card
                key={report.year}
                sx={{
                  borderRadius: "30px",
                  overflow: "hidden",
                  border: "1px solid rgba(15,23,42,0.08)",
                  boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
                }}
              >
                <div className="relative h-48 overflow-hidden bg-[#020617] p-7 text-white">
                  <div className="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.6),transparent_36%),radial-gradient(circle_at_bottom_right,rgba(22,65,148,0.7),transparent_40%)]" />
                  <div className="absolute left-0 top-0 h-full w-24 bg-[#b5121b]" />

                  <div className="relative">
                    <p className="text-xs font-bold uppercase tracking-[0.24em] text-white/65">
                      Dirección de
                    </p>

                    <h3 className="mt-3 max-w-xs text-2xl font-black leading-tight tracking-[-0.04em]">
                      Relaciones Internacionales y Convenios
                    </h3>
                  </div>
                </div>

                <div className="p-7">
                  <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#164194]">
                    Gestión {report.year}
                  </p>

                  <h3 className="mt-3 text-2xl font-bold tracking-[-0.04em] text-slate-950">
                    {report.title}
                  </h3>

                  <div className="mt-5 flex items-center gap-2 text-sm font-semibold text-slate-500">
                    <CalendarMonthRoundedIcon sx={{ fontSize: 19, color: "#b5121b" }} />
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
                        background: "linear-gradient(135deg,#b5121b,#e1242f)",
                        textTransform: "none",
                        fontWeight: 800,
                        boxShadow: "0 14px 34px rgba(181,18,27,0.22)",
                      }}
                    >
                      Descargar PDF
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