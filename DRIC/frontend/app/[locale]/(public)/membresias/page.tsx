import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import ArrowOutwardRoundedIcon from "@mui/icons-material/ArrowOutwardRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

const memberships = [
  { name: "AUF", full: "Agencia Universitaria de la Francofonía", url: "https://www.auf.org/" },
  { name: "AUGM", full: "Asociación de Universidades Grupo Montevideo", url: "https://grupomontevideo.org/" },
  { name: "UNAI", full: "United Nations Academic Impact", url: "https://www.un.org/en/academic-impact" },
  { name: "AUIP", full: "Asociación Universitaria Iberoamericana de Posgrado", url: "https://auip.org/" },
  { name: "CRISCOS", full: "Consejo de Rectores por la Integración de la Subregión Centro Oeste de Sudamérica", url: "#" },
  { name: "CLACSO", full: "Consejo Latinoamericano de Ciencias Sociales", url: "https://www.clacso.org/" },
  { name: "UNAMAZ", full: "Asociación de Universidades Amazónicas", url: "#" },
  { name: "PADOR", full: "Potential Applicant Data Online Registration", url: "#" },
  { name: "Comisión Europea", full: "Programas y cooperación internacional de la Unión Europea", url: "https://commission.europa.eu/" },
];

export default async function MembresiasPage({ params }: Props) {
  const { locale } = await params;

  return (
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.48),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="absolute left-1/2 top-24 -z-10 h-[430px] w-[430px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            Membresías
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            La Universidad Mayor de San Simón participa en redes, asociaciones y programas internacionales que fortalecen la cooperación académica, científica e institucional.
          </p>
        </div>
      </section>

      <section className="bg-[#f8fafc] px-5 py-24 text-[#111827] md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-14 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
              <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
                Redes internacionales
              </p>

              <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                Alianzas que conectan a la UMSS con el mundo
              </h2>
            </div>

            <p className="max-w-md text-sm leading-7 text-slate-600">
              Cada membresía puede redirigir a su sitio oficial y ser administrada posteriormente desde el CMS.
            </p>
          </div>

          <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            {memberships.map((item) => (
              <Card
                key={item.name}
                sx={{
                  borderRadius: "30px",
                  border: "1px solid rgba(15,23,42,0.08)",
                  boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
                  overflow: "hidden",
                }}
              >
                <div className="group relative min-h-[290px] bg-white p-8 transition duration-500 hover:-translate-y-1">
                  <div className="absolute right-6 top-6 h-20 w-20 rounded-full bg-[#164194]/10 blur-2xl" />
                  <div className="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-[#b5121b] via-[#164194] to-[#ffffff]" />

                  <div className="flex h-24 w-24 items-center justify-center rounded-[2rem] bg-[#020617] text-white shadow-xl shadow-slate-300/60">
                    <span className="text-2xl font-black tracking-[-0.06em]">{item.name}</span>
                  </div>

                  <h3 className="mt-8 text-2xl font-bold tracking-[-0.04em] text-slate-950">
                    {item.name}
                  </h3>

                  <p className="mt-3 min-h-[72px] text-sm leading-7 text-slate-600">
                    {item.full}
                  </p>

                  <Link href={item.url} target="_blank" className="mt-6 inline-flex">
                    <Button
                      variant="outlined"
                      endIcon={<ArrowOutwardRoundedIcon />}
                      sx={{
                        borderRadius: "999px",
                        px: 3,
                        py: 1.1,
                        color: "#b5121b",
                        borderColor: "rgba(181,18,27,0.35)",
                        textTransform: "none",
                        fontWeight: 800,
                        "&:hover": {
                          borderColor: "#b5121b",
                          backgroundColor: "rgba(181,18,27,0.06)",
                        },
                      }}
                    >
                      Visitar sitio
                    </Button>
                  </Link>
                </div>
              </Card>
            ))}
          </div>

          <div className="mt-12 flex justify-center">
            <Card
              sx={{
                width: "100%",
                maxWidth: "620px",
                borderRadius: "34px",
                border: "1px solid rgba(15,23,42,0.08)",
                boxShadow: "0 28px 80px rgba(15,23,42,0.10)",
                overflow: "hidden",
                background:
                  "linear-gradient(135deg, rgba(255,255,255,1), rgba(248,250,252,1))",
              }}
            >
              <div className="relative p-8 text-center md:p-10">
                <div className="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-[#b5121b] via-[#164194] to-[#b5121b]" />

                <p className="text-xs font-bold uppercase tracking-[0.28em] text-[#164194]">
                  Red académica destacada
                </p>

                <div className="mx-auto mt-7 flex h-24 w-56 items-center justify-center rounded-3xl bg-[#e30613] shadow-xl shadow-red-200/70">
                  <span className="text-3xl font-black tracking-[-0.06em] text-white">
                    universia
                  </span>
                </div>

                <h3 className="mt-8 text-3xl font-bold tracking-[-0.05em] text-slate-950">
                  Universia
                </h3>

                <p className="mx-auto mt-4 max-w-md text-sm leading-7 text-slate-600">
                  Plataforma iberoamericana que conecta universidades, estudiantes,
                  instituciones y oportunidades académicas internacionales.
                </p>

                <Link href="https://www.universia.net/" target="_blank" className="mt-7 inline-flex">
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
                      boxShadow: "0 16px 38px rgba(181,18,27,0.25)",
                    }}
                  >
                    Visitar Universia
                  </Button>
                </Link>
              </div>
            </Card>
          </div>

          <div className="mt-16 rounded-[2rem] bg-[#020617] p-8 text-white md:p-12">
            <PublicRoundedIcon sx={{ color: "#ef4444", fontSize: 42 }} />

            <h2 className="mt-5 text-3xl font-semibold tracking-[-0.04em]">
              Información institucional
            </h2>

            <p className="mt-4 max-w-3xl text-sm leading-7 text-white/65">
              Para mayor información sobre registros, membresías institucionales o participación en redes internacionales, contactar con la Dirección de Relaciones Internacionales y Convenios.
            </p>

            <a href="mailto:dric@umss.edu" className="mt-6 inline-flex font-bold text-white underline underline-offset-4">
              dric@umss.edu
            </a>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}