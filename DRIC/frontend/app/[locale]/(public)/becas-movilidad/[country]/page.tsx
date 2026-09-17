import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";

type Props = {
  params: Promise<{
    locale: string;
    country: string;
  }>;
};

const countryNames: Record<string, { es: string; en: string }> = {
  alemania: { es: "Alemania", en: "Germany" },
  francia: { es: "Francia", en: "France" },
  "corea-del-sur": { es: "Corea del Sur", en: "South Korea" },
  italia: { es: "Italia", en: "Italy" },
  japon: { es: "Japón", en: "Japan" },
  holanda: { es: "Holanda", en: "Netherlands" },
  suecia: { es: "Suecia", en: "Sweden" },
  suiza: { es: "Suiza", en: "Switzerland" },
  china: { es: "China", en: "China" },
};

export default async function CountryScholarshipPage({ params }: Props) {
  const { locale, country } = await params;

  const countryData = countryNames[country];
  const countryTitle = countryData?.[locale as "es" | "en"] ?? country;

  return (
    <main className="min-h-screen bg-[#020617] text-white">
      <Header />

      <section className="mx-auto max-w-6xl px-6 pb-24 pt-44">
        <p className="mb-4 text-sm uppercase tracking-[0.35em] text-cyan-300">
          {locale === "es" ? "Becas y movilidad" : "Scholarships and mobility"}
        </p>

        <h1 className="text-5xl font-light tracking-wide md:text-7xl">
          {countryTitle}
        </h1>

        <p className="mt-6 max-w-3xl text-lg leading-relaxed text-white/60">
          {locale === "es"
            ? `Aquí se mostrarán las convocatorias, becas, requisitos, fechas y oportunidades disponibles para ${countryTitle}.`
            : `This page will display calls, scholarships, requirements, dates, and available opportunities for ${countryTitle}.`}
        </p>

        <div className="mt-14 rounded-3xl border border-white/10 bg-white/[0.04] p-8">
          <h2 className="text-3xl font-light">
            {locale === "es" ? "Convocatorias disponibles" : "Available calls"}
          </h2>

          <p className="mt-4 text-white/55">
            {locale === "es"
              ? "Por ahora este espacio queda preparado para conectarse al CMS administrativo."
              : "For now, this area is ready to be connected to the admin CMS."}
          </p>
        </div>
      </section>

      <Footer />
    </main>
  );
}
