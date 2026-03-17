import Header from '@/components/layout/Header';
import HeroSection from '@/components/sections/HeroSection';
import StatsSection from '@/components/sections/StatsSection';
import PillarsSection from '@/components/sections/PillarsSection';
import NewsSection from '@/components/sections/NewsSection';

export default function InicioPage() {
  return (
    <main className="min-h-screen bg-[#050816] text-white">
      <Header />
      <HeroSection />
      <StatsSection />
      <NewsSection />
    </main>
  );
}
