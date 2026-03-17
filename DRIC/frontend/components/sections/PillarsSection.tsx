'use client';

const stats = [
  { value: '150+', label: 'Convenios Activos' },
  { value: '50+', label: 'Países Aliados' },
  { value: '500+', label: 'Becarios' },
  { value: '80+', label: 'Proyectos' },
];

export default function StatsSection() {
  return (
    <section className="px-4 py-16 md:px-8 lg:px-12">
      <div className="mx-auto max-w-6xl">
        <div className="grid grid-cols-2 gap-10 text-center md:grid-cols-4">
          {stats.map((stat) => (
            <div key={stat.label} className="flex flex-col items-center">
              <span className="text-4xl font-extrabold text-cyan-300 md:text-5xl lg:text-6xl">
                {stat.value}
              </span>
              <span className="mt-2 text-sm text-white/60 md:text-base">
                {stat.label}
              </span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}