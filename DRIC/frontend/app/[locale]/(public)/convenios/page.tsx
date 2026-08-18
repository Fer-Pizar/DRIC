import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Link from "next/link";

type Props = {
  params: Promise<{
    locale: string;
  }>;
};

const content = {
  es: {
    eyebrow: "Convenios institucionales",
    title: "Convenios suscritos por la UMSS",
    intro1:
      "La DRIC fortalece el vínculo de la UMSS con instituciones de educación superior e investigación, sectores público, privado y social, organismos internacionales, fundaciones y agencias de apoyo a la educación.",
    intro2:
      "Los convenios suscritos favorecen el intercambio académico, la cooperación interinstitucional y el desarrollo de mecanismos de investigación con mayor impacto, eficiencia y resultados funcionales.",
    mainButton: "Ver convenios",
    procedure: "Procedimiento para suscribir un convenio con la UMSS",
    cards: [
      {
        title: "Convenios UMSS",
        description:
          "Acuerdos institucionales supervisados por la DRIC para fortalecer la cooperación académica, científica y administrativa.",
        href: "https://conveniosdric.umss.edu.bo/convenios",
        image: "/images/agreements/convenios-umss.png",
      },
      {
        title: "Otros convenios suscritos",
        description:
          "Convenios suscritos con instituciones que no han sido revisados directamente por la DRIC.",
        href: "/convenios/otros",
        image: "/images/agreements/convenios.png",
      },
      {
        title: "Convenios CEUB y Gobierno de Bolivia",
        description:
          "Acuerdos suscritos por el Gobierno de Bolivia y el Comité Ejecutivo de la Universidad Boliviana.",
        href: "/convenios/ceub-gobierno",
        image: "/images/agreements/ceub.jpg",
      },
    ],
  },
  en: {
    eyebrow: "Institutional agreements",
    title: "Agreements signed by UMSS",
    intro1:
      "DRIC strengthens UMSS relationships with higher education and research institutions, public, private and social sectors, international organizations, foundations, and education support agencies.",
    intro2:
      "Signed agreements promote academic exchange, interinstitutional cooperation, and research mechanisms with greater impact, efficiency, and functional results.",
    mainButton: "View agreements",
    procedure: "Procedure to sign an agreement with UMSS",
    cards: [
      {
        title: "UMSS Agreements",
        description:
          "Institutional agreements supervised by DRIC to strengthen academic, scientific, and administrative cooperation.",
        href: "https://conveniosdric.umss.edu.bo/convenios",
        image: "/images/agreements/convenios-umss.png",
      },
      {
        title: "Other signed agreements",
        description:
          "Agreements signed with institutions that have not been directly reviewed by DRIC.",
        href: "/convenios/otros",
        image: "/images/agreements/convenios.png",
      },
      {
        title: "CEUB and Government of Bolivia Agreements",
        description:
          "Agreements signed by the Government of Bolivia and the Executive Committee of the Bolivian University.",
        href: "/convenios/ceub-gobierno",
        image: "/images/agreements/ceub.jpg",
      },
    ],
  },
};

export default async function ConveniosPage({ params }: Props) {
  const { locale } = await params;
  const t = content[locale as "es" | "en"] ?? content.es;

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative px-6 pb-28 pt-44">
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,rgba(0,55,112,0.16),transparent_38%),radial-gradient(circle_at_bottom_right,rgba(0,55,112,0.18),transparent_36%)]" />

        <div className="mx-auto max-w-7xl">
          <div className="grid items-center gap-14 lg:grid-cols-[1.1fr_0.9fr]">
            <div>
              <p className="mb-5 text-sm uppercase tracking-[0.35em] text-cyan-300">
                {t.eyebrow}
              </p>

              <h1 className="max-w-4xl text-5xl font-light leading-tight tracking-wide md:text-7xl">
                {t.title}
              </h1>

              <div className="mt-8 max-w-3xl space-y-5 text-lg leading-relaxed text-white/60">
                <p>{t.intro1}</p>
                <p>{t.intro2}</p>
              </div>

              <div className="mt-14 flex justify-center">
                <Link
                  href="https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf"
                  className="inline-flex items-center gap-3 rounded-full border border-cyan-300/30 bg-white/[0.03] px-8 py-4 text-sm font-medium tracking-wide text-cyan-200 backdrop-blur-xl transition-all duration-300 hover:scale-[1.02] hover:border-cyan-300 hover:bg-cyan-300/10 hover:text-white hover:shadow-[0_0_40px_rgba(0,55,112,0.20)]"
                >
                  <span>{t.procedure}</span>

                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth={2}
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </Link>
              </div>
            </div>

            <div className="rounded-[2rem] border border-white/10 bg-white/[0.04] p-4 shadow-2xl backdrop-blur">
              <img
                src="/images/agreements/international-flags.jpg"
                alt={t.title}
                className="h-[430px] w-full rounded-[1.5rem] object-cover"
              />
            </div>
          </div>

          <div className="mt-24 grid gap-8 lg:grid-cols-3">
            {t.cards.map((card) => {
              const href = card.href.startsWith("http") ? card.href : `/${locale}${card.href}`;

              return (
                <Link
                  key={card.title}
                  href={href}
                  className="group flex h-full flex-col overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04] shadow-2xl backdrop-blur transition duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:border-cyan-300/60 hover:shadow-[0_0_55px_rgba(0,55,112,0.18)]"
                >
                  <div className="relative h-64 overflow-hidden">
                    <img
                      src={card.image}
                      alt={card.title}
                      className="h-full w-full object-cover transition duration-700 group-hover:scale-110 group-hover:brightness-110"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent" />
                  </div>

                  <div className="flex flex-1 flex-col p-8">
                    <h2 className="text-3xl font-light leading-tight transition group-hover:text-cyan-300">
                      {card.title}
                    </h2>

                    <p className="mt-5 text-base leading-relaxed text-white/55">
                      {card.description}
                    </p>

                    <span className="mt-auto inline-flex self-center pt-8 text-center text-sm font-semibold uppercase tracking-[0.25em] text-red-300 transition group-hover:text-cyan-300">
                      {t.mainButton}
                    </span>
                  </div>
                </Link>
              );
            })}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
