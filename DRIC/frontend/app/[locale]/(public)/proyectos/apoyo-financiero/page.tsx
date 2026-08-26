import Link from "next/link";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Button from "@mui/material/Button";
import AccountBalanceRoundedIcon from "@mui/icons-material/AccountBalanceRounded";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import PictureAsPdfRoundedIcon from "@mui/icons-material/PictureAsPdfRounded";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

const documentLinks = [
  {
    es: "Convocatoria completa (portugués)",
    en: "Full call for proposals (Portuguese)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQA31J1MFInGR4IYPtZGeRMnAVCVo8aVaAtsZDUskF4Ukbo?e=VycKEl",
  },
  {
    es: "Convocatoria completa (español)",
    en: "Full call for proposals (Spanish)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQApdgS7fwsFQot0es4VqMAmAQ1qqjSBKg04Df8QTsmbTfA?e=dnTpu4",
  },
  {
    es: "Preguntas frecuentes (portugués)",
    en: "Frequently asked questions (Portuguese)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQBCO_KLT2AbToIDcqJLBFH9AVQaCLfNpZDBzEZOgjC-7zo?e=HpfVp3",
  },
  {
    es: "Preguntas frecuentes (español)",
    en: "Frequently asked questions (Spanish)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQCXo57aZtlCT5cs4FLkRWP5AUnqFj-s1DH42KYiKfxjjio?e=KTwedo",
  },
];

const strategicAreas = {
  es: [
    "Medio ambiente y sostenibilidad",
    "Alimentación y agricultura",
    "Energía y minería",
    "Salud",
    "Tecnologías de la información",
    "Humanidades y ciencias sociales",
  ],
  en: [
    "Environment and sustainability",
    "Food and agriculture",
    "Energy and mining",
    "Health",
    "Information technologies",
    "Humanities and social sciences",
  ],
};

const copy = {
  es: {
    eyebrow: "Convocatorias",
    title: "PROSUL Pepe Mujica",
    subtitle:
      "Convocatoria MCTI/CNPq de Brasil para financiar investigación colaborativa entre instituciones de Brasil, América Latina y el Caribe.",
    back: "Volver a proyectos",
    total: "R$ 50.000.000",
    totalLabel: "financiamiento total",
    augm: "10%",
    augmLabel: "reservado para proyectos con universidades AUGM",
    openLabel: "Convocatoria abierta",
    sectionTitle: "Oportunidad de cooperación regional",
    paragraphs: [
      "Se encuentra abierta la Convocatoria PROSUL Pepe Mujica (MCTI/CNPq - Brasil), orientada a financiar proyectos de investigación colaborativa entre instituciones de Brasil y de América Latina y el Caribe.",
      "El Programa Pepe Mujica se centra en la formación de redes temáticas de investigación entre instituciones de América Latina y el Caribe, la movilidad de investigadores en diferentes niveles de formación y el desarrollo conjunto de proyectos estratégicos.",
      "También incluye acciones para fortalecer la infraestructura científica regional, estimular la innovación tecnológica y promover la educación y la difusión de la ciencia.",
      "Un aspecto especialmente relevante es que al menos el 10% del financiamiento total de la convocatoria está garantizado para proyectos que involucren a universidades miembro de la Asociación de Universidades Grupo Montevideo (AUGM), lo que representa una ventaja competitiva concreta para las instituciones que presenten propuestas en el marco de esta red.",
      "Se invita a las unidades académicas e investigadores interesados a considerar esta oportunidad y a articular propuestas con socios de la AUGM.",
    ],
    areasTitle: "Áreas estratégicas",
    docsTitle: "Documentos de la convocatoria",
    docsIntro: "Acceda a las bases completas y a las preguntas frecuentes en español y portugués.",
    moreInfo: "Más información oficial",
  },
  en: {
    eyebrow: "Calls for proposals",
    title: "PROSUL Pepe Mujica",
    subtitle:
      "MCTI/CNPq Brazil call to fund collaborative research among institutions in Brazil, Latin America, and the Caribbean.",
    back: "Back to projects",
    total: "R$ 50,000,000",
    totalLabel: "total funding",
    augm: "10%",
    augmLabel: "reserved for projects with AUGM universities",
    openLabel: "Open call",
    sectionTitle: "Regional cooperation opportunity",
    paragraphs: [
      "The PROSUL Pepe Mujica Call (MCTI/CNPq - Brazil) is open to finance collaborative research projects between institutions in Brazil, Latin America, and the Caribbean.",
      "The Pepe Mujica Program focuses on creating thematic research networks among institutions in Latin America and the Caribbean, researcher mobility at different levels of training, and the joint development of strategic projects.",
      "It also includes actions to strengthen regional scientific infrastructure, stimulate technological innovation, and promote education and science communication.",
      "A particularly relevant point is that at least 10% of the total call funding is guaranteed for projects involving member universities of the Association of Universities Grupo Montevideo (AUGM), offering a concrete competitive advantage to institutions submitting proposals through this network.",
      "Academic units and interested researchers are invited to consider this opportunity and coordinate proposals with AUGM partners.",
    ],
    areasTitle: "Strategic areas",
    docsTitle: "Call documents",
    docsIntro: "Access the complete guidelines and frequently asked questions in Spanish and Portuguese.",
    moreInfo: "Official information",
  },
};

export default async function ApoyoFinancieroPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";
  const text = isEnglish ? copy.en : copy.es;
  const areas = isEnglish ? strategicAreas.en : strategicAreas.es;

  return (
    <main className="dric-theme-page dric-projects-page dric-funding-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-projects-hero relative isolate overflow-hidden px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <Link href={`/${locale}/proyectos`} className="inline-flex">
            <Button
              className="dric-projects-outline-button"
              variant="outlined"
              startIcon={<ArrowBackRoundedIcon />}
              sx={{
                borderRadius: "999px",
                px: 3,
                py: 1.1,
                color: "white",
                borderColor: "rgba(255,255,255,0.24)",
                textTransform: "none",
                fontWeight: 700,
                backdropFilter: "blur(14px)",
              }}
            >
              {text.back}
            </Button>
          </Link>

          <div className="mt-14 grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-end">
            <div>
              <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
                {text.eyebrow}
              </p>

              <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
                {text.title}
              </h1>

              <p className="mt-8 max-w-3xl text-base leading-8 text-white/72 md:text-lg">
                {text.subtitle}
              </p>
            </div>

            <div className="dric-funding-summary rounded-[2rem] border border-white/12 bg-white/[0.07] p-6 shadow-2xl shadow-black/25 backdrop-blur-xl md:p-8">
              <span className="inline-flex rounded-full bg-[#E30613] px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-white">
                {text.openLabel}
              </span>

              <div className="mt-8 grid gap-4 sm:grid-cols-2">
                <Metric value={text.total} label={text.totalLabel} />
                <Metric value={text.augm} label={text.augmLabel} />
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="dric-projects-section relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
        <div className="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1fr_0.8fr]">
          <article className="dric-funding-panel flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/25 backdrop-blur-xl md:p-10">
            <h2 className="text-3xl font-semibold tracking-[-0.04em] md:text-4xl">
              {text.sectionTitle}
            </h2>

            <div className="mt-8 space-y-6 text-base leading-8 text-white/70">
              {text.paragraphs.map((paragraph) => (
                <p key={paragraph}>{paragraph}</p>
              ))}
            </div>

            <Link
              href="https://www.gov.br/cnpq/pt-br/assuntos/noticias/cnpq-em-acao/prosul-pepe-mujica-vai-financiar-projetos-para-fortalecer-a-infraestrutura-cientifica-da-america-latina"
              className="mt-auto flex justify-center pt-9"
            >
              <Button
                variant="contained"
                endIcon={<OpenInNewRoundedIcon />}
                sx={{
                  borderRadius: "999px",
                  px: 4,
                  py: 1.3,
                  background: "linear-gradient(135deg,#E30613,#b70510)",
                  textTransform: "none",
                  fontWeight: 800,
                  boxShadow: "0 18px 45px rgba(227,6,19,0.28)",
                }}
              >
                {text.moreInfo}
              </Button>
            </Link>
          </article>

          <aside className="space-y-6">
            <div className="dric-funding-panel rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-8">
              <div className="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                <AccountBalanceRoundedIcon sx={{ color: "#E30613" }} />
              </div>

              <h2 className="text-2xl font-semibold tracking-[-0.03em]">
                {text.areasTitle}
              </h2>

              <div className="mt-6 grid gap-3">
                {areas.map((area) => (
                  <span
                    key={area}
                    className="dric-funding-area rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm font-semibold text-white/76 backdrop-blur transition duration-300 hover:-translate-y-0.5 hover:border-cyan-200/50 hover:bg-cyan-200/10"
                  >
                    {area}
                  </span>
                ))}
              </div>
            </div>

            <div className="dric-funding-panel rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-8">
              <h2 className="text-2xl font-semibold tracking-[-0.03em]">
                {text.docsTitle}
              </h2>

              <p className="mt-3 text-sm leading-7 text-white/62">{text.docsIntro}</p>

              <div className="mt-6 grid gap-3">
                {documentLinks.map((document) => (
                  <Link
                    key={document.href}
                    href={document.href}
                    className="dric-funding-document group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-4 text-white backdrop-blur transition duration-300 hover:-translate-y-0.5 hover:border-[#E30613]/55 hover:bg-[#E30613]/10"
                  >
                    <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 transition duration-300 group-hover:bg-[#E30613]">
                      <PictureAsPdfRoundedIcon sx={{ fontSize: 24 }} />
                    </span>
                    <span className="min-w-0 flex-1 text-sm font-semibold leading-6">
                      {isEnglish ? document.en : document.es}
                    </span>
                    <OpenInNewRoundedIcon className="shrink-0 opacity-65 transition duration-300 group-hover:opacity-100" sx={{ fontSize: 20 }} />
                  </Link>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function Metric({ value, label }: { value: string; label: string }) {
  return (
    <div className="dric-funding-metric rounded-3xl border border-white/10 bg-white/[0.06] p-5">
      <p className="text-3xl font-semibold tracking-[-0.04em] text-white">{value}</p>
      <p className="mt-2 text-sm leading-6 text-white/62">{label}</p>
    </div>
  );
}
