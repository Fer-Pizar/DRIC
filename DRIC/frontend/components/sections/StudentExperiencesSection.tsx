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
    <section className="bg-[#020617] px-4 py-16 text-white sm:px-6 md:py-24">
      <div className="mx-auto max-w-7xl">
        <div className="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
          <div className="relative h-[240px] overflow-hidden rounded-2xl border border-white/10 bg-white/5 sm:h-[320px] md:h-[360px] md:rounded-3xl">
            <Image
              src="/images/home/student-experience.png"
              alt={t.title}
              fill
              className="object-cover"
            />
          </div>

          <div className="min-w-0">
            <h2 className="max-w-xl text-3xl font-light leading-tight tracking-wide sm:text-4xl md:text-5xl">
              {t.title}
            </h2>
            <p className="mt-4 max-w-xl text-base leading-relaxed text-white/60 sm:text-lg md:mt-6 md:text-xl">
              {t.text}
            </p>
            <a
              href={`/${locale}/becas-movilidad`}
              className="mt-6 inline-flex rounded-2xl border border-white/40 px-6 py-3 text-sm font-medium text-white shadow-[0_0_30px_rgba(255,255,255,0.25)] transition hover:bg-white hover:text-slate-950 md:mt-8 md:px-7 md:py-4"
            >
              {t.button}
            </a>
          </div>
        </div>

        <div className="mt-10 grid gap-5 md:mt-16 md:gap-8 lg:grid-cols-2">
          {t.comments.map((item) => (
            <article
              key={item.name}
              className="rounded-2xl border border-white/10 bg-white/[0.03] p-5 shadow-2xl sm:p-7 md:rounded-3xl md:p-10"
            >
              <div className="mb-6 h-14 w-14 rounded-full bg-gradient-to-br from-white/30 to-white/5 md:mb-8 md:h-20 md:w-20" />
              <h3 className="text-xl font-semibold leading-tight sm:text-2xl md:text-3xl">{item.name}</h3>
              <p className="mt-2 text-white/45">{item.role}</p>
              <div className="my-6 h-px bg-white/10" />
              <p className="text-base leading-relaxed text-white/65 md:text-lg">
                “{item.comment}”
              </p>
              <p className="mt-6 text-lg text-yellow-400 md:mt-8 md:text-xl">5.0 ★★★★★</p>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
