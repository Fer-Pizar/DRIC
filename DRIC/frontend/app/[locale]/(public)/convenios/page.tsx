import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import SectionRenderer from "@/components/sections/SectionRenderer";
import { getPageBySlug } from "@/lib/api/pages";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

export default async function ConveniosPage({ params }: Props) {
  const { locale } = await params;

  const page = await getPageBySlug("convenios", locale);

  return (
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />
      <SectionRenderer sections={page.sections} locale={locale} />
      <Footer />
    </main>
  );
}