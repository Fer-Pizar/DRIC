'use client';

const news = [
  {
    type: 'Convocatoria',
    date: '15 Enero 2024',
    title: 'Becas de Movilidad Internacional 2024',
    description:
      'Abierta la convocatoria para estudiantes de pregrado y posgrado interesados en realizar...',
    gradient: 'from-indigo-500 to-violet-500',
  },
  {
    type: 'Evento',
    date: '22 Febrero 2024',
    title: 'Conferencia Internacional de Investigación',
    description:
      'Expertos de 20 países se reunirán para discutir avances en ciencia y tecnología.',
    gradient: 'from-cyan-400 to-blue-500',
  },
];

export default function NewsSection() {
  return (
    <section className="px-4 py-20 md:px-8 lg:px-12">
      <div className="mx-auto max-w-7xl">
        {/* Header */}
        <div className="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 className="text-4xl font-extrabold md:text-5xl">
              Últimas Noticias
            </h2>
            <p className="mt-2 text-white/60">
              Mantente al día con nuestras actividades
            </p>
          </div>

          <button className="self-start text-cyan-300 transition hover:underline md:self-auto">
            Ver todas las noticias →
          </button>
        </div>

        {/* Cards */}
        <div className="mt-12 grid gap-8 md:grid-cols-2">
          {news.map((item) => (
            <div
              key={item.title}
              className="overflow-hidden rounded-3xl border border-white/10"
            >
              {/* Top gradient block */}
              <div
                className={`h-40 bg-gradient-to-br ${item.gradient} p-6`}
              >
                <span className="rounded-full bg-white/20 px-4 py-1 text-sm">
                  {item.type}
                </span>
              </div>

              {/* Content */}
              <div className="bg-[#040611] p-6">
                <p className="text-sm text-cyan-300">{item.date}</p>

                <h3 className="mt-2 text-xl font-bold md:text-2xl">
                  {item.title}
                </h3>

                <p className="mt-3 text-white/60">
                  {item.description}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}