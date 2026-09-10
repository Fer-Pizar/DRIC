import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage, CmsSection } from "@/types/cms";
import Card from "@mui/material/Card";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "DRIC · UMSS",
    title: "Internacionalización",
    intro:
      "La internacionalización fortalece la formación académica, la cooperación científica y la vinculación institucional de la Universidad Mayor de San Simón con redes, universidades y organismos del mundo.",
    detailTitle: "Internacionalización",
    detailParagraphs: [
      "La Internacionalización de la Educación Superior tiene como propósito mejorar los procesos de formación, investigación e interacción social en las universidades, contribuyendo de esta manera a la sociedad con profesionales/ciudadanos preparados para enfrentar los cambios y desafíos, a escala no solo Local sino también Regional y Mundial.",
      "Se cuenta con una propuesta de un Plan de Internacionalización que tiene como objetivo: Fortalecer los procesos y acciones de internacionalización que se desarrollan en la UMSS, desde una perspectiva endógena, colaborativa, integral e interregional, propiciando su incorporación institucional, transversal y contextualizada en las funciones formativas, investigativas y de interrelación y servicio a la comunidad; con políticas, estrategias y acciones sistematizadas en un Plan de Internacionalización Universitario concertado y amplio y, que responda a la nueva realidad generada como efecto de la pandemia en nuestro país y en el planeta.",
      "Actualmente la Dirección de Relaciones Internacionales y Convenios, tiene el objetivo de generar un proceso de apropiación del indicado Plan de parte de la comunidad sansimoniana, de manera que se consiga su fortalecimiento a través de la definición de políticas y estrategias institucionales.",
      "En el contexto generado por la pandemia del covid-19, las instituciones de Educación Superior debemos trabajar en transformaciones y cambios reales que mejoren la calidad de la formación para responder a nuestro encargo social. La Internacionalización es un instrumento que posibilita encaminarnos hacia la calidad en la formación de competencias para el desempeño de los profesionales en todos los ámbitos del planeta.",
      "Se plantea como una necesidad el implementar programas y estrategias apoyadas en el uso de la conectividad digital, para el desarrollo de la internacionalización en casa, la movilidad virtual, la investigación conjunta con socios de la Región y del mundo, el desarrollo de proyectos conjuntos, el intercambio de conocimientos y experiencias en redes, eventos colaborativos entre universidades y países, entre otras acciones.",
    ],
    sectionEyebrow: "Ejes de trabajo",
    sectionTitle: "Una universidad conectada con oportunidades globales",
    sectionText:
      "Este espacio reúne las líneas de acción que impulsan la presencia internacional de la UMSS y facilitan nuevas oportunidades para estudiantes, docentes, investigadores y unidades académicas.",
    cards: [
      {
        title: "Cooperación académica",
        text: "Promovemos vínculos con instituciones nacionales e internacionales para fortalecer proyectos, redes y programas conjuntos.",
      },
      {
        title: "Movilidad y formación",
        text: "Impulsamos oportunidades de intercambio, becas, pasantías y experiencias internacionales para la comunidad universitaria.",
      },
      {
        title: "Proyección institucional",
        text: "Acompañamos la participación de la UMSS en espacios globales de colaboración, innovación y desarrollo académico.",
      },
    ],
  },
  en: {
    eyebrow: "DRIC · UMSS",
    title: "Internationalization",
    intro:
      "Internationalization strengthens academic training, scientific cooperation and institutional engagement between Universidad Mayor de San Simón and global networks, universities and organizations.",
    detailTitle: "Internationalization",
    detailParagraphs: [
      "The internationalization of higher education aims to improve training, research, and social interaction processes in universities, contributing to society with professionals and citizens prepared to face changes and challenges at local, regional, and global scales.",
      "There is a proposal for an Internationalization Plan whose objective is to strengthen the internationalization processes and actions developed at UMSS from an endogenous, collaborative, comprehensive, and interregional perspective, promoting their institutional, cross-cutting, and contextualized incorporation into training, research, interrelation, and community service functions.",
      "Currently, the Directorate of International Relations and Agreements seeks to generate a process through which the San Simon community takes ownership of this Plan, so it can be strengthened through the definition of institutional policies and strategies.",
      "In the context generated by the covid-19 pandemic, higher education institutions must work on real transformations and changes that improve the quality of education in response to our social mission. Internationalization is an instrument that allows us to move toward quality in the development of competencies for professional performance in every sphere of the world.",
      "It is necessary to implement programs and strategies supported by digital connectivity for the development of internationalization at home, virtual mobility, joint research with partners in the region and around the world, joint projects, knowledge and experience exchange through networks, and collaborative events between universities and countries, among other actions.",
    ],
    sectionEyebrow: "Work areas",
    sectionTitle: "A university connected to global opportunities",
    sectionText:
      "This space brings together the lines of action that expand UMSS international presence and create new opportunities for students, faculty, researchers and academic units.",
    cards: [
      {
        title: "Academic cooperation",
        text: "We promote relationships with national and international institutions to strengthen projects, networks and joint programs.",
      },
      {
        title: "Mobility and training",
        text: "We support exchange opportunities, scholarships, internships and international experiences for the university community.",
      },
      {
        title: "Institutional projection",
        text: "We accompany UMSS participation in global spaces for collaboration, innovation and academic development.",
      },
    ],
  },
};

const icons = [
  <PublicRoundedIcon key="cooperation" />,
  <SchoolRoundedIcon key="mobility" />,
  <GroupsRoundedIcon key="projection" />,
];

function sectionByKey(page: CmsPage | null, key: string): CmsSection | null {
  return page?.sections.find((section) => section.section_key === key) ?? null;
}

function blockByKey(section: CmsSection | null, key: string): CmsBlock | null {
  return section?.blocks.find((block) => block.link_url === key) ?? null;
}

function textParagraphs(value: string | null | undefined, fallback: string[]): string[] {
  if (!value || value.trim() === "") {
    return fallback;
  }

  return value
    .split(/\n{2,}/)
    .map((paragraph) => paragraph.trim())
    .filter(Boolean);
}

function pageContent(page: CmsPage | null, locale: "es" | "en") {
  const fallback = content[locale] ?? content.es;
  const hero = sectionByKey(page, "internationalization.hero");
  const detail = sectionByKey(page, "internationalization.detail");
  const workAreas = sectionByKey(page, "internationalization.work_areas");

  return {
    eyebrow: hero?.subtitle || page?.subtitle || fallback.eyebrow,
    title: page?.title || hero?.title || fallback.title,
    intro: hero?.summary || page?.summary || fallback.intro,
    detailTitle: detail?.title || fallback.detailTitle,
    detailParagraphs: textParagraphs(detail?.body, fallback.detailParagraphs),
    sectionEyebrow: workAreas?.subtitle || fallback.sectionEyebrow,
    sectionTitle: workAreas?.title || fallback.sectionTitle,
    sectionText: workAreas?.summary || fallback.sectionText,
    cards: fallback.cards.map((card, index) => {
      const block = blockByKey(workAreas, `internationalization.card.${index + 1}`);

      return {
        title: block?.title || card.title,
        text: block?.summary || card.text,
      };
    }),
  };
}

export default async function InternacionalizacionPage({ params }: Props) {
  const { locale } = await params;
  const currentLocale = locale === "en" ? "en" : "es";
  const page = await getOptionalPageBySlug("internacionalizacion", currentLocale);
  const t = pageContent(page, currentLocale);

  return (
    <main className="dric-theme-page dric-internationalization-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-internationalization-section relative isolate px-4 pb-16 pt-32 sm:px-5 md:px-10 md:pb-20 md:pt-36 lg:px-12">
        <div className="absolute left-1/2 top-28 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-cyan-300/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl text-center md:text-left">
          <p className="mb-5 inline-flex max-w-full rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white/80 backdrop-blur sm:px-5 sm:tracking-[0.28em]">
            {t.eyebrow}
          </p>

          <h1 className="mx-auto max-w-full break-words text-[2.45rem] font-light uppercase leading-[1.04] tracking-[-0.025em] sm:text-5xl md:mx-0 md:max-w-6xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-8xl">
            {t.title}
          </h1>

          <p className="mx-auto mt-6 max-w-3xl text-base leading-7 text-white/70 md:mx-0 md:mt-8 md:text-lg md:leading-8">
            {t.intro}
          </p>
        </div>
      </section>

      <section className="dric-internationalization-section relative isolate px-4 py-16 text-white sm:px-5 md:px-10 md:py-20 lg:px-12">
        <div className="group mx-auto max-w-5xl rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl transition-all duration-500 hover:-translate-y-1 hover:border-cyan-300/45 hover:bg-white/[0.085] hover:shadow-[0_28px_80px_rgba(0,55,112,0.25)] sm:p-8 md:rounded-[2.5rem] md:p-10">
          <h2 className="mx-auto max-w-full break-words text-center text-2xl font-semibold leading-tight tracking-[-0.025em] sm:text-3xl md:text-5xl md:tracking-[-0.04em]">
            {t.detailTitle}
          </h2>

          <div className="mt-8 space-y-6 text-justify text-base leading-8 text-white/72 md:text-lg md:leading-9">
            {t.detailParagraphs.map((paragraph) => (
              <p key={paragraph}>{paragraph}</p>
            ))}
          </div>
        </div>
      </section>

      <section className="dric-internationalization-section relative isolate overflow-hidden px-4 py-16 text-white sm:px-5 md:px-10 md:py-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-12 max-w-3xl text-center md:text-left">
            <p className="text-xs font-bold uppercase tracking-[0.22em] text-[#E30613] sm:text-sm sm:tracking-[0.25em]">
              {t.sectionEyebrow}
            </p>

            <h2 className="mt-4 text-3xl font-semibold leading-tight tracking-[-0.025em] sm:text-4xl md:text-5xl md:tracking-[-0.04em]">
              {t.sectionTitle}
            </h2>

            <p className="mt-5 text-sm leading-7 text-white/68 md:text-base">
              {t.sectionText}
            </p>
          </div>

          <div className="grid gap-6 md:grid-cols-3">
            {t.cards.map((card, index) => (
              <Card
                key={card.title}
                sx={{
                  borderRadius: "30px",
                  background: "rgba(255,255,255,0.06)",
                  border: "1px solid rgba(255,255,255,0.10)",
                  boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                  color: "white",
                  overflow: "hidden",
                }}
              >
                <div className="min-h-[260px] p-6 md:p-8">
                  <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#003770] text-white shadow-xl shadow-black/20">
                    {icons[index]}
                  </div>

                  <h3 className="mt-7 text-2xl font-semibold leading-tight tracking-[-0.03em]">
                    {card.title}
                  </h3>

                  <p className="mt-4 text-sm leading-7 text-white/65">
                    {card.text}
                  </p>
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
