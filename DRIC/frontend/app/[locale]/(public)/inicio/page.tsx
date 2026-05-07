import Header from "@/components/layout/Header";
import SectionRenderer from "@/components/sections/SectionRenderer";
import { getPageBySlug } from "@/lib/api/pages";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

export default async function InicioPage({ params }: Props) {
  const { locale } = await params;

  const page = await getPageBySlug("inicio", locale);

  return (
    <main className="min-h-screen bg-[#020617] text-white overflow-x-hidden">
      <Header />

      <SectionRenderer sections={page.sections} />
    </main>
  );
}