import Image from "next/image";

type Props = {
  locale: "es" | "en";
};

const content = {
  es: {
    title: "Experiencias de los estudiantes",
    text: "Historias reales sobre movilidad académica, cooperación internacional y oportunidades que transforman la vida universitaria.",
    button: "Ver programas",
    comments: [
      {
        name: "Mariana Espinoza Rojas",
        role: "Estudiante de movilidad internacional",
        comment:
          "La experiencia me permitió conocer otra cultura académica, fortalecer mi formación profesional y representar con orgullo a la UMSS.",
      },
      {
        name: "Diego Alejandro Vargas",
        role: "Beneficiario de convenio académico",
        comment:
          "Gracias a los programas de cooperación pude ampliar mis conocimientos, crear redes internacionales y descubrir nuevas oportunidades.",
      },
    ],
  },
  en: {
    title: "Student experiences",
    text: "Real stories about academic mobility, international cooperation, and opportunities that transform university life.",
    button: "View programs",
    comments: [
      {
        name: "Mariana Espinoza Rojas",
        role: "International mobility student",
        comment:
          "This experience allowed me to discover another academic culture, strengthen my professional growth, and proudly represent UMSS.",
      },
      {
        name: "Diego Alejandro Vargas",
        role: "Academic agreement beneficiary",
        comment:
          "Through cooperation programs, I expanded my knowledge, built international networks, and discovered new opportunities.",
      },
    ],
  },
};

export default function StudentExperiencesSection({ locale }: Props) {
  const t = content[locale] ?? content.es;

  return (
    <section className="bg-[#020617] px-6 py-24 text-white">
      <div className="mx-auto max-w-7xl">
        <div className="grid items-center gap-12 lg:grid-cols-2">
          <div className="relative h-[360px] overflow-hidden rounded-3xl border border-white/10 bg-white/5">
            <Image
              src="/images/home/student-experience.png"
              alt={t.title}
              fill
              className="object-cover"
            />
          </div>

          <div>
            <h2 className="max-w-xl text-5xl font-light leading-tight tracking-wide">
              {t.title}
            </h2>
            <p className="mt-6 max-w-xl text-xl leading-relaxed text-white/60">
              {t.text}
            </p>
            <a
              href={`/${locale}/becas-movilidad`}
              className="mt-8 inline-flex rounded-2xl border border-white/40 px-7 py-4 text-sm font-medium text-white shadow-[0_0_30px_rgba(255,255,255,0.25)] transition hover:bg-white hover:text-slate-950"
            >
              {t.button}
            </a>
          </div>
        </div>

        <div className="mt-16 grid gap-8 lg:grid-cols-2">
          {t.comments.map((item) => (
            <article
              key={item.name}
              className="rounded-3xl border border-white/10 bg-white/[0.03] p-10 shadow-2xl"
            >
              <div className="mb-8 h-20 w-20 rounded-full bg-gradient-to-br from-white/30 to-white/5" />
              <h3 className="text-3xl font-semibold">{item.name}</h3>
              <p className="mt-2 text-white/45">{item.role}</p>
              <div className="my-6 h-px bg-white/10" />
              <p className="text-lg leading-relaxed text-white/65">
                “{item.comment}”
              </p>
              <p className="mt-8 text-xl text-yellow-400">5.0 ★★★★★</p>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}