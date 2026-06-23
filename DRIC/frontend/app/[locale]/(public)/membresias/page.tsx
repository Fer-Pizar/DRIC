import Link from "next/link";
import Image from "next/image";
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
  { name: "AUF", full: "Agencia Universitaria de la Francofonía", url: "https://www.auf.org/", logo: "/images/memberships/auf.png" },
  { name: "AUGM", full: "Asociación de Universidades Grupo Montevideo", url: "https://grupomontevideo.org/", logo: "/images/memberships/augm.png" },
  { name: "UNAI", full: "United Nations Academic Impact", url: "https://www.un.org/es/academicimpact", logo: "/images/memberships/unai.png" },
  { name: "AUIP", full: "Asociación Universitaria Iberoamericana de Posgrado", url: "https://auip.org/", logo: "/images/memberships/auip.png" },
  { name: "CRISCOS", full: "Consejo de Rectores por la Integración de la Subregión Centro Oeste de Sudamérica", url: "https://criscos.unju.edu.ar/", logo: "/images/memberships/criscos.png" },
  { name: "CLACSO", full: "Consejo Latinoamericano de Ciencias Sociales", url: "https://www.clacso.org/", logo: "/images/memberships/clacso.png" },
  { name: "UNAMAZ", full: "Asociación de Universidades Amazónicas", url: "https://www.unamaz.org/es", logo: "/images/memberships/unamaz.png" },
  { name: "PADOR", full: "European Aid Online Registration Services", url: "#", logo: "/images/memberships/pador.png" },
  { name: "Comisión Europea", full: "Programas y cooperación internacional de la Unión Europea", url: "https://commission.europa.eu/index_es", logo: "/images/memberships/comision-europea.png" },
  { name: "Universia", full: "Plataforma iberoamericana que conecta universidades, estudiantes, instituciones y oportunidades académicas internacionales.", url: "https://www.universia.net/", logo: "/images/memberships/universia.png" },
];

export default async function MembresiasPage({ params }: Props) {
  await params;

  return (
    <main className="dric-theme-page dric-memberships-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-memberships-hero relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.48),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="dric-memberships-hero-glow absolute left-1/2 top-24 -z-10 h-[430px] w-[430px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

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

      <section className="dric-memberships-section relative isolate overflow-hidden px-5 py-24 text-white md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.22),transparent_34%),radial-gradient(circle_at_center_right,rgba(22,65,148,0.30),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />
        <div className="absolute right-[-9rem] top-16 -z-10 h-[430px] w-[430px] rounded-full bg-cyan-300/10 blur-[135px]" />

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

            <p className="max-w-md text-sm leading-7 text-white/68">
              Cada membresía puede redirigir a su sitio oficial y ser administrada posteriormente desde el CMS.
            </p>
          </div>

          <div className="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            {memberships.map((item) => (
              <Card
                className="dric-memberships-card"
                key={item.name}
                sx={{
                  borderRadius: "30px",
                  background: "rgba(255,255,255,0.06)",
                  border: "1px solid rgba(255,255,255,0.10)",
                  boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                  color: "white",
                  overflow: "hidden",
                }}
              >
                <div className="dric-memberships-card-inner group relative min-h-[290px] bg-white/[0.06] p-8 transition duration-500 hover:-translate-y-1">
                  <div className="absolute right-6 top-6 h-20 w-20 rounded-full bg-[#164194]/10 blur-2xl" />
                  <div
                    className={`absolute left-0 h-1 w-full bg-gradient-to-r from-[#b5121b] via-[#164194] to-[#ffffff] ${
                      item.name === "PADOR" ? "bottom-2" : "bottom-0"
                    }`}
                  />

                  <div className="flex h-32 w-full items-center justify-center">
                    <Image
                      src={item.logo}
                      alt={`${item.name} logo`}
                      width={220}
                      height={96}
                      className="h-auto max-h-24 w-auto max-w-[220px] object-contain"
                    />
                  </div>

                  <h3 className="mt-6 text-2xl font-bold tracking-[-0.04em] text-white">
                    {item.name}
                  </h3>

                  <p
                    className={`mt-3 text-sm leading-7 text-white/62 ${
                      item.name === "PADOR" ? "min-h-[42px]" : "min-h-[72px]"
                    }`}
                  >
                    {item.full}
                  </p>

                  {item.name === "PADOR" ? (
                    <div className="dric-memberships-note mt-2 rounded-2xl border border-amber-200/30 bg-amber-50/10 px-4 py-3">
                      <p className="text-xs font-medium leading-6 text-white/62">
                        Para mayor información sobre el registro PADOR, contactar a:
                      </p>

                      <a
                        href="mailto:dric@umss.edu"
                        className="mt-1 block font-semibold text-cyan-300 hover:underline"
                      >
                        dric@umss.edu
                      </a>
                    </div>
                  ) : (
                  <Link href={item.url} target="_blank" className="mt-6 inline-flex">
                    <Button
                      className="dric-memberships-card-button"
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
                      {item.name === "Universia" ? "Visitar Universia" : "Visitar sitio"}
                    </Button>
                  </Link>
                )}
                </div>
              </Card>
            ))}
          </div>

          <div className="dric-memberships-info-panel mt-16 rounded-[2rem] border border-white/10 bg-white/[0.06] p-8 text-white shadow-2xl shadow-black/25 backdrop-blur-xl md:p-12">
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
