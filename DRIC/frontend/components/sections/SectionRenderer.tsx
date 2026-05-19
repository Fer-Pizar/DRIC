import HeroSection from "@/components/sections/HeroSection";
import StatsSection from "@/components/sections/StatsSection";

import ScholarshipGridSection from "@/components/sections/home/ScholarshipGridSection";
import AboutDricSection from "@/components/sections/home/AboutDricSection";
import RecentAgreementsSection from "@/components/sections/home/RecentAgreementsSection";
import DirectorSection from "@/components/sections/home/DirectorSection";
import FaqSection from "@/components/sections/home/FaqSection";
import FinalCtaSection from "@/components/sections/home/FinalCtaSection";

import type { CmsSection } from "@/types/cms";

type Props = {
  sections: CmsSection[];
  locale?: string;
};

export default function SectionRenderer({ sections, locale = "es" }: Props) {
  return (
    <>
      {sections.map((section) => {
        const sectionType = section.type ?? section.section_type;

        switch (sectionType) {
          case "hero":
            return <HeroSection key={section.id} section={section} />;

          case "scholarship_country_grid":
            return <ScholarshipGridSection key={section.id} section={section} />;

          case "about_dric":
            return <AboutDricSection key={section.id} section={section} />;

          case "recent_agreements":
            return (
              <RecentAgreementsSection
                key={section.id}
                section={section}
                locale={locale}
              />
            );

          case "director_mission_purpose":
            return <DirectorSection key={section.id} section={section} />;

          case "stats":
            return <StatsSection key={section.id} section={section} />;

          case "faq":
            return <FaqSection key={section.id} section={section} />;

          case "final_cta":
            return <FinalCtaSection key={section.id} section={section} />;

          default:
            return null;
        }
      })}
    </>
  );
}