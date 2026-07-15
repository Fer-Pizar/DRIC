import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

const content = {
  es: {
    eyebrow: "DRIC · UMSS",
    title: "Internacionalización",
    intro:
      "La internacionalización fortalece la formación académica, la cooperación científica y la vinculación institucional de la Universidad Mayor de San Simón con redes, universidades y organismos del mundo.",
    sectionEyebrow: "Ejes de trabajo",
    sectionTitle: "Una universidad conectada con oportunidades globales",
    sectionText:
      "Este espacio reúne las líneas de acción que impulsan la presencia internacional de la UMSS y facilitan nuevas oportunidades para estudiantes, docentes, investigadores y unidades académicas.",
    cards: [
      {
        title: "Cooperación académica",
        text: "Promovemos vínculos con instituciones nacionales e internacionales para fortalecer proyectos, redes y programas conjuntos.",
      },
      {
        title: "Movilidad y formación",
        text: "Impulsamos oportunidades de intercambio, becas, pasantías y experiencias internacionales para la comunidad universitaria.",
      },
      {
        title: "Proyección institucional",
        text: "Acompañamos la participación de la UMSS en espacios globales de colaboración, innovación y desarrollo académico.",
      },
    ],
  },
  en: {
    eyebrow: "DRIC · UMSS",
    title: "Internationalization",
    intro:
      "Internationalization strengthens academic training, scientific cooperation and institutional engagement between Universidad Mayor de San Simón and global networks, universities and organizations.",
    sectionEyebrow: "Work areas",
    sectionTitle: "A university connected to global opportunities",
    sectionText:
      "This space brings together the lines of action that expand UMSS international presence and create new opportunities for students, faculty, researchers and academic units.",
    cards: [
      {
        title: "Academic cooperation",
        text: "We promote relationships with national and international institutions to strengthen projects, networks and joint programs.",
      },
      {
        title: "Mobility and training",
        text: "We support exchange opportunities, scholarships, internships and international experiences for the university community.",
      },
      {
        title: "Institutional projection",
        text: "We accompany UMSS participation in global spaces for collaboration, innovation and academic development.",
      },
    ],
  },
};

const icons = [
  <PublicRoundedIcon key="cooperation" />,
  <SchoolRoundedIcon key="mobility" />,
  <GroupsRoundedIcon key="projection" />,
];

export default async function InternacionalizacionPage({ params }: Props) {
  const { locale } = await params;
  const t = content[locale === "en" ? "en" : "es"];

  return (
    <main className="dric-theme-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-4 pb-16 pt-32 sm:px-5 md:px-10 md:pb-20 md:pt-36 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(0,55,112,0.50),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_46%,#12070a_100%)]" />
        <div className="absolute left-1/2 top-28 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-cyan-300/10 blur-[140px]" />

        <div className="mx-auto max-w-7xl text-center md:text-left">
          <p className="mb-5 inline-flex max-w-full rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white/80 backdrop-blur sm:px-5 sm:tracking-[0.28em]">
            {t.eyebrow}
          </p>

          <h1 className="mx-auto max-w-full break-words text-[2.45rem] font-light uppercase leading-[1.04] tracking-[-0.025em] sm:text-5xl md:mx-0 md:max-w-6xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-8xl">
            {t.title}
          </h1>

          <p className="mx-auto mt-6 max-w-3xl text-base leading-7 text-white/70 md:mx-0 md:mt-8 md:text-lg md:leading-8">
            {t.intro}
          </p>
        </div>
      </section>

      <section className="relative isolate overflow-hidden px-4 py-16 text-white sm:px-5 md:px-10 md:py-20 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.20),transparent_34%),radial-gradient(circle_at_center_right,rgba(0,55,112,0.30),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />

        <div className="mx-auto max-w-7xl">
          <div className="mb-12 max-w-3xl text-center md:text-left">
            <p className="text-xs font-bold uppercase tracking-[0.22em] text-[#E30613] sm:text-sm sm:tracking-[0.25em]">
              {t.sectionEyebrow}
            </p>

            <h2 className="mt-4 text-3xl font-semibold leading-tight tracking-[-0.025em] sm:text-4xl md:text-5xl md:tracking-[-0.04em]">
              {t.sectionTitle}
            </h2>

            <p className="mt-5 text-sm leading-7 text-white/68 md:text-base">
              {t.sectionText}
            </p>
          </div>

          <div className="grid gap-6 md:grid-cols-3">
            {t.cards.map((card, index) => (
              <Card
                key={card.title}
                sx={{
                  borderRadius: "30px",
                  background: "rgba(255,255,255,0.06)",
                  border: "1px solid rgba(255,255,255,0.10)",
                  boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                  color: "white",
                  overflow: "hidden",
                }}
              >
                <div className="min-h-[260px] p-6 md:p-8">
                  <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#003770] text-white shadow-xl shadow-black/20">
                    {icons[index]}
                  </div>

                  <h3 className="mt-7 text-2xl font-semibold leading-tight tracking-[-0.03em]">
                    {card.title}
                  </h3>

                  <p className="mt-4 text-sm leading-7 text-white/65">
                    {card.text}
                  </p>
                </div>
              </Card>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}
