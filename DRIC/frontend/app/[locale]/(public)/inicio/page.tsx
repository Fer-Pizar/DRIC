import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import SectionRenderer from "@/components/sections/SectionRenderer";
import { getPageBySlug } from "@/lib/api/pages";
import StudentExperiencesSection from "@/components/sections/StudentExperiencesSection";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

export default async function InicioPage({ params }: Props) {
  const { locale } = await params;

  const page = await getPageBySlug("inicio", locale);

  const faqIndex = page.sections.findIndex(
    (section: any) =>
      section.section_key === "faq" ||
      section.type === "faq" ||
      section.section_type === "faq"
  );

  const sectionsBeforeFaq =
    faqIndex >= 0 ? page.sections.slice(0, faqIndex) : page.sections;

  const faqAndAfter =
    faqIndex >= 0 ? page.sections.slice(faqIndex) : [];

  return (
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />
      <SectionRenderer sections={sectionsBeforeFaq} locale={locale} />
      <StudentExperiencesSection locale={locale as "es" | "en"} />
      <SectionRenderer sections={faqAndAfter} locale={locale} />
      <Footer />
    </main>
  );
}