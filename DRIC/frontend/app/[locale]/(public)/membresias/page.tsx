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
  { name: "AUF", full: { es: "Agencia Universitaria de la Francofonía", en: "University Agency of La Francophonie" }, url: "https://www.auf.org/", logo: "/images/memberships/auf.png" },
  { name: "AUGM", full: { es: "Asociación de Universidades Grupo Montevideo", en: "Association of Universities of the Montevideo Group" }, url: "https://grupomontevideo.org/", logo: "/images/memberships/augm.png" },
  { name: "UNAI", full: { es: "Impacto Académico de las Naciones Unidas", en: "United Nations Academic Impact" }, url: "https://www.un.org/es/academicimpact", logo: "/images/memberships/unai.png" },
  { name: "AUIP", full: { es: "Asociación Universitaria Iberoamericana de Posgrado", en: "Ibero-American Postgraduate University Association" }, url: "https://auip.org/", logo: "/images/memberships/auip.png" },
  { name: "CRISCOS", full: { es: "Consejo de Rectores por la Integración de la Subregión Centro Oeste de Sudamérica", en: "Council of Rectors for the Integration of the Central-Western South American Subregion" }, url: "https://criscos.unju.edu.ar/", logo: "/images/memberships/criscos.png" },
  { name: "CLACSO", full: { es: "Consejo Latinoamericano de Ciencias Sociales", en: "Latin American Council of Social Sciences" }, url: "https://www.clacso.org/", logo: "/images/memberships/clacso.png" },
  { name: "UNAMAZ", full: { es: "Asociación de Universidades Amazónicas", en: "Association of Amazonian Universities" }, url: "https://www.unamaz.org/es", logo: "/images/memberships/unamaz.png" },
  { name: "PADOR", full: { es: "Servicios de Registro en Línea de Ayuda Europea", en: "European Aid Online Registration Services" }, url: "#", logo: "/images/memberships/pador.png" },
  { name: "Comisión Europea", nameEn: "European Commission", full: { es: "Programas y cooperación internacional de la Unión Europea", en: "European Union international cooperation and programs" }, url: "https://commission.europa.eu/index_es", logo: "/images/memberships/comision-europea.png" },
  { name: "Universia", full: { es: "Plataforma iberoamericana que conecta universidades, estudiantes, instituciones y oportunidades académicas internacionales.", en: "Ibero-American platform connecting universities, students, institutions and international academic opportunities." }, url: "https://www.universia.net/", logo: "/images/memberships/universia.png" },
];

export default async function MembresiasPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";

  const copy = {
    title: isEnglish ? "Memberships" : "Membresías",
    summary: isEnglish
      ? "Universidad Mayor de San Simón participates in international networks, associations and programs that strengthen academic, scientific and institutional cooperation."
      : "La Universidad Mayor de San Simón participa en redes, asociaciones y programas internacionales que fortalecen la cooperación académica, científica e institucional.",
    kicker: isEnglish ? "International networks" : "Redes internacionales",
    sectionTitle: isEnglish
      ? "Partnerships connecting UMSS with the world"
      : "Alianzas que conectan a la UMSS con el mundo",
    sectionText: isEnglish
      ? "Each membership can redirect to its official website and later be managed from the CMS."
      : "Cada membresía puede redirigir a su sitio oficial y ser administrada posteriormente desde el CMS.",
    padorText: isEnglish
      ? "For more information about PADOR registration, contact:"
      : "Para mayor información sobre el registro PADOR, contactar a:",
    visitSite: isEnglish ? "Visit site" : "Visitar sitio",
    visitUniversia: isEnglish ? "Visit Universia" : "Visitar Universia",
    infoTitle: isEnglish ? "Institutional information" : "Información institucional",
    infoText: isEnglish
      ? "For more information about institutional records, memberships or participation in international networks, contact the Directorate of International Relations and Agreements."
      : "Para mayor información sobre registros, membresías institucionales o participación en redes internacionales, contactar con la Dirección de Relaciones Internacionales y Convenios.",
  };

  return (
    <main className="dric-theme-page dric-memberships-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-memberships-hero relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1
            className={`max-w-5xl break-words font-light uppercase ${
              isEnglish
                ? "text-[2.40rem] sm:text-[2.8rem] md:text-7xl lg:text-8xl leading-[1.05]"
                : "text-[2.55rem] sm:text-[4rem] md:text-7xl lg:text-8xl leading-[0.95]"
            }`}
          >
            {copy.title}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {copy.summary}
          </p>
        </div>
      </section>

      <section className="dric-memberships-section relative isolate overflow-hidden px-5 py-24 text-white md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-14 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
              <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#E30613]">
                {copy.kicker}
              </p>

              <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
                {copy.sectionTitle}
              </h2>
            </div>

            <p className="max-w-md text-sm leading-7 text-white/68">
              {copy.sectionText}
            </p>
          </div>

          <div className="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
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
                <div className="dric-memberships-card-inner group relative flex min-h-[430px] flex-col bg-white/[0.06] p-8 transition duration-500 hover:-translate-y-1">
                  <div className="absolute right-6 top-6 h-20 w-20 rounded-full bg-[#003770]/10 blur-2xl" />
                  <div className="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-[#E30613] via-[#003770] to-[#ffffff]" />

                  <div className="flex h-32 w-full items-center justify-center">
                    <Image
                      src={item.logo}
                      alt={`${isEnglish ? item.nameEn ?? item.name : item.name} logo`}
                      width={220}
                      height={96}
                      className="h-auto max-h-24 w-auto max-w-[220px] object-contain"
                    />
                  </div>

                  <h3 className="mt-6 text-2xl font-bold tracking-[-0.04em] text-white">
                    {isEnglish ? item.nameEn ?? item.name : item.name}
                  </h3>

                  <p
                    className={`mt-3 text-sm leading-7 text-white/62 ${
                      item.name === "PADOR" ? "min-h-[42px]" : "min-h-[72px]"
                    }`}
                  >
                    {item.full[isEnglish ? "en" : "es"]}
                  </p>

                  {item.name === "PADOR" ? (
                    <div className="dric-memberships-note mt-auto rounded-2xl border border-amber-200/30 bg-amber-50/10 px-4 py-3">
                      <p className="text-xs font-medium leading-6 text-white/62">
                        {copy.padorText}
                      </p>

                      <a
                        href="mailto:dric@umss.edu"
                        className="mt-1 block font-semibold text-cyan-300 hover:underline"
                      >
                        dric@umss.edu
                      </a>
                    </div>
                  ) : (
                    <Link href={item.url} target="_blank" className="mx-auto mt-auto inline-flex">
                      <Button
                        className="dric-memberships-card-button"
                        variant="outlined"
                        endIcon={<ArrowOutwardRoundedIcon />}
                        sx={{
                          borderRadius: "999px",
                          px: 3,
                          py: 1.1,
                          color: "#E30613",
                          borderColor: "rgba(227,6,19,0.35)",
                          textTransform: "none",
                          fontWeight: 800,
                          "&:hover": {
                            borderColor: "#E30613",
                            backgroundColor: "rgba(227,6,19,0.06)",
                          },
                        }}
                      >
                        {item.name === "Universia" ? copy.visitUniversia : copy.visitSite}
                      </Button>
                    </Link>
                  )}
                </div>
              </Card>
            ))}
          </div>

          <div className="dric-memberships-info-panel mt-16 rounded-[2rem] border border-white/10 bg-white/[0.06] p-8 text-white shadow-2xl shadow-black/25 backdrop-blur-xl md:p-12">
            <PublicRoundedIcon sx={{ color: "#E30613", fontSize: 42 }} />

            <h2 className="mt-5 text-3xl font-semibold tracking-[-0.04em]">
              {copy.infoTitle}
            </h2>

            <p className="mt-4 max-w-3xl text-sm leading-7 text-white/65">
              {copy.infoText}
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
