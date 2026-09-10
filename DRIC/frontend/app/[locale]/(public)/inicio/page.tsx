import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import SectionRenderer from "@/components/sections/SectionRenderer";
import StudentExperiencesSection from "@/components/sections/StudentExperiencesSection";
import { getPageBySlug } from "@/lib/api/pages";
import type { CmsSection } from "@/types/cms";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

export default async function InicioPage({ params }: Props) {
  const { locale } = await params;

  const page = await getPageBySlug("inicio", locale);
  const hasTestimonials = page.sections.some(
    (section: CmsSection) => section.section_key === "home.student_testimonials" || section.section_type === "student_testimonials"
  );
  const statsIndex = page.sections.findIndex(
    (section: CmsSection) => section.section_key === "home.stats" || section.section_type === "stats"
  );
  const sectionsBeforeFallback = !hasTestimonials && statsIndex >= 0 ? page.sections.slice(0, statsIndex + 1) : page.sections;
  const sectionsAfterFallback = !hasTestimonials && statsIndex >= 0 ? page.sections.slice(statsIndex + 1) : [];

  return (
    <main className="dric-theme-page dric-home-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />
      <SectionRenderer sections={sectionsBeforeFallback} locale={locale} />
      {!hasTestimonials ? <StudentExperiencesSection locale={locale as "es" | "en"} /> : null}
      <SectionRenderer sections={sectionsAfterFallback} locale={locale} />
      <Footer />
    </main>
  );
}
