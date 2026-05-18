import Link from "next/link";

export default function Footer() {
  return (
    <footer className="relative overflow-hidden bg-[#020617] px-6 pb-10 pt-16 text-white md:px-10 lg:px-16">
      <div className="absolute left-1/2 top-0 -z-10 h-72 w-72 -translate-x-1/2 rounded-full bg-cyan-400/10 blur-[100px]" />
      <div className="absolute bottom-0 right-0 -z-10 h-80 w-80 rounded-full bg-red-500/10 blur-[120px]" />

      <div className="mx-auto grid max-w-7xl gap-10 border-t border-white/10 pt-10 md:grid-cols-[1.3fr_1fr_1fr]">
        <div>
          <p className="text-xs uppercase tracking-[0.22em] text-cyan-300/80">
            DRIC UMSS
          </p>

          <p className="mt-5 max-w-md text-sm leading-7 text-white/55">
            Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.
          </p>
        </div>

        <div>
          <h3 className="text-xs font-semibold uppercase tracking-[0.22em] text-white/65">
            Navigation
          </h3>

          <nav className="mt-5 grid gap-3 text-sm text-white/50">
            <Link className="transition hover:text-cyan-300" href="/es/inicio">Inicio</Link>
            <Link className="transition hover:text-cyan-300" href="/es/convenios">Convenios</Link>
            <Link className="transition hover:text-cyan-300" href="/es/proyectos">Proyectos</Link>
            <Link className="transition hover:text-cyan-300" href="/es/becas-movilidad">Becas y Movilidad</Link>
          </nav>
        </div>

        <div>
          <h3 className="text-xs font-semibold uppercase tracking-[0.22em] text-white/65">
            Contact
          </h3>

          <div className="mt-5 space-y-3 text-sm text-white/50">
            <p>dric@umss.edu</p>
            <p>Cochabamba, Bolivia</p>
            <p>Universidad Mayor de San Simón</p>
          </div>
        </div>
      </div>

      <div className="mx-auto mt-12 flex max-w-7xl flex-col gap-4 border-t border-white/10 pt-6 text-xs text-white/40 md:flex-row md:items-center md:justify-between">
        <p>© 2026 Dirección de Relaciones Internacionales y Convenios.</p>
        <p>Español / English</p>
      </div>
    </footer>
  );
}