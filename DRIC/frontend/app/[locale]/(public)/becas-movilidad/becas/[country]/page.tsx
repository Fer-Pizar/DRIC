import Link from "next/link";
import { notFound } from "next/navigation";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import LinkRoundedIcon from "@mui/icons-material/LinkRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import WorkspacePremiumRoundedIcon from "@mui/icons-material/WorkspacePremiumRounded";
import { findScholarshipCatalogItem } from "@/lib/scholarships/becasCatalog";

type Props = {
  params: Promise<{
    locale: string;
    country: string;
  }>;
};

const cmsReadyItems = [
  {
    icon: <CalendarMonthRoundedIcon />,
    es: "Fechas de convocatoria",
    en: "Call dates",
  },
  {
    icon: <DescriptionRoundedIcon />,
    es: "Requisitos y documentos",
    en: "Requirements and documents",
  },
  {
    icon: <LinkRoundedIcon />,
    es: "Enlaces oficiales y PDFs",
    en: "Official links and PDFs",
  },
];

export default async function ScholarshipDestinationPage({ params }: Props) {
  const { locale, country } = await params;
  const language = locale === "en" ? "en" : "es";
  const item = findScholarshipCatalogItem(country);

  if (!item) {
    notFound();
  }

  const opportunities = item.opportunities ?? [];

  return (
    <main className="dric-theme-page dric-scholarship-detail-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.34),transparent_34%),radial-gradient(circle_at_top_right,rgba(0,55,112,0.46),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_48%,#12070a_100%)]" />
        <div
          className="absolute right-[-8rem] top-24 -z-10 h-[420px] w-[420px] rounded-full blur-[140px]"
          style={{ backgroundColor: `${item.accent}24` }}
        />

        <div className="mx-auto max-w-7xl">
          <Link
            href={`/${locale}/becas-movilidad/becas`}
            className="mb-8 inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white/72 backdrop-blur transition hover:border-white/25 hover:bg-white/15 hover:text-white"
          >
            <ArrowBackRoundedIcon fontSize="small" />
            {language === "en" ? "Back to scholarships" : "Volver a becas"}
          </Link>

          <div className="grid gap-10 lg:grid-cols-[1fr_0.72fr] lg:items-end">
            <div>
              <h1 className="dric-neon-country-title max-w-5xl">
                {item.name[language]}
              </h1>

              <p className="mt-7 max-w-3xl text-base leading-8 text-white/68 md:text-lg">
                {item.summary[language]}
              </p>
            </div>

            <aside className="rounded-[2rem] border border-white/10 bg-white/[0.06] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl md:p-8">
              <div
                className="flex h-16 w-16 items-center justify-center rounded-3xl text-white shadow-xl shadow-black/20"
                style={{ backgroundColor: item.accent }}
              >
                {item.type === "country" ? <PublicRoundedIcon /> : <WorkspacePremiumRoundedIcon />}
              </div>

              <p className="mt-6 text-xs font-bold uppercase tracking-[0.22em] text-white/45">
                {item.region[language]}
              </p>

              <h2 className="mt-3 text-2xl font-semibold tracking-[-0.03em]">
                {language === "en" ? "CMS-ready section" : "Sección lista para CMS"}
              </h2>

              <p className="mt-4 text-sm leading-7 text-white/60">
                {language === "en"
                  ? "This view is prepared so the admin can later publish active calls, files, dates and official links."
                  : "Esta vista queda preparada para que el administrador publique convocatorias activas, archivos, fechas y enlaces oficiales."}
              </p>
            </aside>
          </div>
        </div>
      </section>

      <section className="relative isolate overflow-hidden px-5 py-16 text-white md:px-10 md:py-20 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[linear-gradient(180deg,#020617_0%,#07111f_48%,#020617_100%)]" />

        <div className="mx-auto max-w-7xl">
          {opportunities.length > 0 ? (
            <>
              <div className="mb-10 max-w-3xl">
                <p className="text-xs font-bold uppercase tracking-[0.24em] text-[#E30613]">
                  {language === "en" ? "Available programmes" : "Programas disponibles"}
                </p>
                <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
                  {language === "en"
                    ? `Scholarship channels for ${item.name.en}`
                    : `Canales de becas para ${item.name.es}`}
                </h2>
              </div>

              <div className="mx-auto flex max-w-6xl flex-col gap-8">
                {opportunities.map((opportunity) => (
                  <article
                    key={opportunity.slug}
                    className="dric-scholarship-program-card group relative overflow-hidden rounded-[2rem] p-[1px] shadow-2xl shadow-black/25 transition duration-500 hover:-translate-y-1"
                  >
                    <div className="dric-scholarship-program-card-inner relative flex min-h-[430px] flex-col rounded-[calc(2rem-1px)] px-7 py-8 md:min-h-[470px] md:px-12 md:py-11 lg:px-14">
                      <h3 className="max-w-5xl text-3xl font-normal leading-tight tracking-[-0.035em] text-white md:text-4xl lg:text-[2.65rem]">
                        {opportunity.title[language]}
                      </h3>

                      <div className="mt-9 flex-1 space-y-7 text-justify text-base leading-8 text-white/72 md:text-lg md:leading-9">
                        {opportunity.contentSections ? (
                          opportunity.contentSections.map((section, sectionIndex) => (
                            <section key={`${opportunity.slug}-section-${sectionIndex}`} className="space-y-3">
                              {section.heading ? (
                                <h4 className="text-left text-xl font-semibold text-white md:text-2xl">
                                  {section.heading[language]}
                                </h4>
                              ) : null}

                              {section.paragraphs?.map((paragraph, paragraphIndex) => (
                                <p key={`${opportunity.slug}-paragraph-${paragraphIndex}`}>
                                  {paragraph[language]}
                                </p>
                              ))}

                              {section.bullets ? (
                                <ul className="space-y-2 pl-5 text-left">
                                  {section.bullets.map((bullet) => (
                                    <li key={bullet.label.es} className="list-disc">
                                      <span className="font-semibold text-white">
                                        {bullet.label[language]}:
                                      </span>{" "}
                                      <span>{bullet.text[language]}</span>
                                    </li>
                                  ))}
                                </ul>
                              ) : null}
                            </section>
                          ))
                        ) : (
                          <p>{opportunity.body[language]}</p>
                        )}
                      </div>

                      <div className="dric-scholarship-program-divider mt-10" />

                      <div className="mt-7 flex justify-center">
                        <a
                          href={opportunity.href}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="dric-scholarship-program-link inline-flex items-center gap-4 rounded-full p-[1px] text-lg font-normal text-white transition hover:scale-[1.02] md:text-2xl"
                        >
                          <span className="inline-flex items-center gap-4 rounded-full px-7 py-3 backdrop-blur-xl">
                            {opportunity.linkLabel[language]}
                            <OpenInNewRoundedIcon className="text-[1.6em]" />
                          </span>
                        </a>
                      </div>
                    </div>
                  </article>
                ))}
              </div>
            </>
          ) : (
            <>
              <div className="grid gap-5 md:grid-cols-3">
                {cmsReadyItems.map((readyItem) => (
                  <div
                    key={readyItem.es}
                    className="rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 shadow-2xl shadow-black/20 backdrop-blur-xl"
                  >
                    <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                      {readyItem.icon}
                    </div>
                    <h2 className="mt-6 text-2xl font-semibold tracking-[-0.035em]">
                      {readyItem[language]}
                    </h2>
                    <p className="mt-4 text-sm leading-7 text-white/58">
                      {language === "en"
                        ? "The content for this area will come from the administrative database."
                        : "El contenido de esta area vendra desde la base de datos administrativa."}
                    </p>
                  </div>
                ))}
              </div>

              <div className="mt-8 rounded-[2rem] border border-dashed border-white/18 bg-white/[0.035] p-8 text-center backdrop-blur-xl md:p-10">
                <p className="text-sm font-bold uppercase tracking-[0.24em] text-[#E30613]">
                  {language === "en" ? "No active calls yet" : "Sin convocatorias activas aún"}
                </p>
                <p className="mx-auto mt-4 max-w-2xl text-sm leading-7 text-white/60 md:text-base">
                  {language === "en"
                    ? "When the admin module is connected, published opportunities for this destination will appear here automatically."
                    : "Cuando se conecte el módulo administrativo, las oportunidades publicadas para este destino apareceran aqui automaticamente."}
                </p>
              </div>
            </>
          )}
        </div>
      </section>

      <Footer />
    </main>
  );
}
