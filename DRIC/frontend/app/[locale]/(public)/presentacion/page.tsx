import Image from "next/image";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Chip from "@mui/material/Chip";
import EmailRoundedIcon from "@mui/icons-material/EmailRounded";
import AccountBalanceRoundedIcon from "@mui/icons-material/AccountBalanceRounded";
import GroupsRoundedIcon from "@mui/icons-material/GroupsRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function PresentacionPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";

  return (
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.50),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />

        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="max-w-6xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {isEnglish ? "About DRIC" : "Presentación"}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {isEnglish
              ? "The Directorate of International Relations and Agreements promotes cooperation, mobility, projects and international academic opportunities for Universidad Mayor de San Simón."
              : "La Dirección de Relaciones Internacionales y Convenios promueve la cooperación, movilidad, proyectos y oportunidades académicas internacionales de la Universidad Mayor de San Simón."}
          </p>
        </div>
      </section>

      <section className="bg-[#f8fafc] px-5 py-20 text-slate-950 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <Card
              sx={{
                borderRadius: "36px",
                overflow: "hidden",
                boxShadow: "0 30px 90px rgba(15,23,42,0.14)",
              }}
            >
              <div className="relative h-[420px] bg-slate-200">
                <Image
                  src="/images/presentation/dric-team.jpg"
                  alt="Equipo DRIC UMSS"
                  fill
                  className="object-cover"
                />
              </div>
            </Card>

            <div>
              <Chip
                label={isEnglish ? "Institutional history" : "Historia institucional"}
                sx={{
                  borderRadius: "999px",
                  backgroundColor: "rgba(181,18,27,0.08)",
                  color: "#b5121b",
                  fontWeight: 800,
                }}
              />

              <h2 className="mt-6 text-4xl font-semibold tracking-[-0.05em] md:text-5xl">
                {isEnglish ? "International vision from UMSS" : "Una visión internacional desde la UMSS"}
              </h2>

              <p className="mt-6 text-base leading-8 text-slate-600">
                La Dirección de Relaciones Internacionales y Convenios fue creada el 7 de enero de 1988, con el rango de Secretaría. El año 1995 se instituye como Departamento y en noviembre de 1997 se crea la actual Dirección.
              </p>

              <div className="mt-8 grid gap-4 sm:grid-cols-3">
                <MiniStat icon={<PublicRoundedIcon />} title="1988" text="Creación" />
                <MiniStat icon={<AccountBalanceRoundedIcon />} title="1997" text="Dirección actual" />
                <MiniStat icon={<GroupsRoundedIcon />} title="UMSS" text="Cooperación" />
              </div>
            </div>
          </div>

          <div className="mt-24 grid gap-7 md:grid-cols-2">
            <InfoCard
              title={isEnglish ? "Mission" : "Misión"}
              text="Promover, coordinar y canalizar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS, en beneficio de los procesos de enseñanza-aprendizaje, investigación científica y tecnológica, interacción social y fortalecimiento institucional."
              color="#b5121b"
            />

            <InfoCard
              title={isEnglish ? "Purpose" : "Propósito"}
              text="Es propósito fundamental de la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón explorar de manera organizada y sistemática las oportunidades de cooperación internacional y de coordinación interinstitucional."
              color="#164194"
            />
          </div>

          <div className="mt-24 grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <Card
              sx={{
                borderRadius: "36px",
                overflow: "hidden",
                boxShadow: "0 30px 90px rgba(15,23,42,0.12)",
              }}
            >
              <div className="relative h-[821px] bg-slate-200">
                <Image
                  src="/images/presentation/director.jpg"
                  alt="Director DRIC"
                  fill
                  className="object-cover"
                />
              </div>
            </Card>

            <Card
              sx={{
                borderRadius: "36px",
                background: "#d4d6d7",
                boxShadow: "0 30px 90px rgba(15,23,42,0.10)",
                overflow: "hidden",
              }}
            >
              <div className="p-8 md:p-12">
                <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
                  {isEnglish ? "Organizational structure" : "Estructura"}
                </p>

                <h2 className="mt-5 text-4xl font-semibold tracking-[-0.05em] md:text-5xl">
                  Dirección DRIC
                </h2>

                <p className="mt-6 text-sm leading-7 text-slate-700">
                  La DRIC depende directamente del Rectorado. Para el cumplimiento de sus funciones, se estructura de la siguiente manera:
                </p>

                <ul className="mt-6 space-y-3 text-sm leading-7 text-slate-700">
                  <li>• Dirección Ejecutiva</li>
                  <li>• Departamento de Convenios, Movilidad y Becas</li>
                  <li>• Departamento de Internacionalización y Proyectos</li>
                </ul>

                <div className="mt-8 rounded-3xl bg-white/70 p-6">
                  <h3 className="text-2xl font-bold tracking-[-0.04em]">
                    Director: Omar Morales Delgadillo
                  </h3>

                  <div className="mt-5 space-y-3 text-sm text-slate-700">
                    <p className="flex gap-2">
                      <EmailRoundedIcon sx={{ color: "#b5121b", fontSize: 20 }} />
                      director-dric@umss.edu.bo
                    </p>
                    <p className="flex gap-2">
                      <EmailRoundedIcon sx={{ color: "#b5121b", fontSize: 20 }} />
                      rrii@umss.edu.bo
                    </p>
                  </div>
                </div>

                <div className="mt-8 grid gap-5 md:grid-cols-2">
                  <StaffBlock
                    title="Convenios, Movilidad y Becas"
                    people={[
                      "Mgr. Asunta Giovanna Magdalena Maldonado Moscoso",
                      "Mgr. Silvia del Pilar Arze",
                    ]}
                  />
                  <StaffBlock
                    title="Internacionalización y Proyectos"
                    people={["Lic. Jimena Salinas", "Ing. John Medina", "Mgr. Roxana Zambrana"]}
                  />
                </div>
              </div>
            </Card>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function MiniStat({ icon, title, text }: { icon: React.ReactNode; title: string; text: string }) {
  return (
    <div className="rounded-3xl bg-white p-5 shadow-xl shadow-slate-200/70">
      <div className="text-[#164194]">{icon}</div>
      <p className="mt-4 text-2xl font-black tracking-[-0.05em]">{title}</p>
      <p className="mt-1 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{text}</p>
    </div>
  );
}

function InfoCard({ title, text, color }: { title: string; text: string; color: string }) {
  return (
    <Card
      sx={{
        borderRadius: "34px",
        border: "1px solid rgba(15,23,42,0.08)",
        boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
      }}
    >
      <div className="relative min-h-[310px] bg-white p-8 md:p-10">
        <div className="absolute inset-x-0 top-0 h-1.5" style={{ backgroundColor: color }} />
        <h3 className="text-4xl font-semibold tracking-[-0.05em]">{title}</h3>
        <p className="mt-6 text-sm leading-8 text-slate-600">{text}</p>
      </div>
    </Card>
  );
}

function StaffBlock({ title, people }: { title: string; people: string[] }) {
  return (
    <div className="rounded-3xl bg-white/70 p-6">
      <p className="text-sm font-black uppercase tracking-[0.18em] text-[#164194]">{title}</p>
      <ul className="mt-4 space-y-2 text-sm leading-6 text-slate-700">
        {people.map((person) => (
          <li key={person}>• {person}</li>
        ))}
      </ul>
    </div>
  );
}