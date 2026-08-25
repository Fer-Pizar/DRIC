import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import SectionRenderer from "@/components/sections/SectionRenderer";
import { getPageBySlug } from "@/lib/api/pages";
import StudentExperiencesSection from "@/components/sections/StudentExperiencesSection";
import type { CmsBlock, CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

const extraFaqBlocks: Record<"es" | "en", CmsBlock[]> = {
  es: [
    {
      id: -101,
      type: "faq_item",
      sort_order: 101,
      block_type: "faq_item",
      link_url: null,
      settings: {},
      data: {},
      title: "¿Las becas cubren todos los gastos?",
      subtitle: null,
      summary:
        "La cobertura depende de cada convocatoria y puede ser total o parcial, incluyendo beneficios como matrícula, alojamiento, manutención, pasajes o seguro médico. Se recomienda revisar los requisitos y beneficios específicos de cada programa.",
      body: null,
      cta_label: null,
      secondary_cta_label: null,
      media: null,
    },
    {
      id: -102,
      type: "faq_item",
      sort_order: 102,
      block_type: "faq_item",
      link_url: null,
      settings: {},
      data: {},
      title: "¿También existen oportunidades para docentes e investigadores?",
      subtitle: null,
      summary:
        "Sí. La DRIC también difunde programas de movilidad, investigación, capacitación y cooperación internacional para docentes, investigadores y personal administrativo. Los requisitos y beneficios varían según cada convocatoria.",
      body: null,
      cta_label: null,
      secondary_cta_label: null,
      media: null,
    },
  ],
  en: [
    {
      id: -101,
      type: "faq_item",
      sort_order: 101,
      block_type: "faq_item",
      link_url: null,
      settings: {},
      data: {},
      title: "Do scholarships cover all expenses?",
      subtitle: null,
      summary:
        "Not always. Coverage depends on each call and may be full or partial, including benefits such as tuition, housing, living expenses, travel or health insurance. We recommend reviewing the specific requirements and benefits of each program.",
      body: null,
      cta_label: null,
      secondary_cta_label: null,
      media: null,
    },
    {
      id: -102,
      type: "faq_item",
      sort_order: 102,
      block_type: "faq_item",
      link_url: null,
      settings: {},
      data: {},
      title: "Are there also opportunities for faculty and researchers?",
      subtitle: null,
      summary:
        "Yes. DRIC also shares mobility, research, training and international cooperation programs for faculty, researchers and administrative staff. Requirements and benefits vary depending on each call.",
      body: null,
      cta_label: null,
      secondary_cta_label: null,
      media: null,
    },
  ],
};

function withExtraFaqBlocks(section: CmsSection, locale: string): CmsSection {
  const language = locale === "en" ? "en" : "es";
  const additions = extraFaqBlocks[language].filter(
    (extraBlock) =>
      !section.blocks.some((block) => block.title === extraBlock.title)
  );

  if (additions.length === 0) {
    return section;
  }

  return {
    ...section,
    blocks: [...section.blocks, ...additions],
  };
}

export default async function InicioPage({ params }: Props) {
  const { locale } = await params;

  const page = await getPageBySlug("inicio", locale);

  const faqIndex = page.sections.findIndex(
    (section: CmsSection) =>
      section.section_key === "faq" ||
      section.type === "faq" ||
      section.section_type === "faq"
  );

  const sectionsBeforeFaq =
    faqIndex >= 0 ? page.sections.slice(0, faqIndex) : page.sections;

  const faqAndAfter =
    faqIndex >= 0
      ? page.sections
          .slice(faqIndex)
          .map((section, index) =>
            index === 0 ? withExtraFaqBlocks(section, locale) : section
          )
      : [];

  return (
    <main className="dric-theme-page dric-home-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />
      <SectionRenderer sections={sectionsBeforeFaq} locale={locale} />
      <StudentExperiencesSection locale={locale as "es" | "en"} />
      <SectionRenderer sections={faqAndAfter} locale={locale} />
      <Footer />
    </main>
  );
}
