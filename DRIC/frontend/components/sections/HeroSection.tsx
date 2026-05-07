import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function HeroSection({ section }: Props) {
  const heroBlock = section.blocks[0];

  const badge = String(heroBlock?.data?.badge ?? "Presentación");
  const primaryHref = heroBlock?.link_url ?? "/presentacion";
  const secondaryHref = String(heroBlock?.data?.secondaryLink ?? "/becas-movilidad");

  const primaryLabel = heroBlock?.cta_label ?? "Convenios";
  const secondaryLabel = heroBlock?.secondary_cta_label ?? "Becas y movilidad";

  return (
    <section className="relative isolate min-h-[92vh] overflow-hidden bg-[#020617] px-4 pb-24 pt-28 text-white md:px-8 md:pb-32 md:pt-36 lg:px-12">
      <div className="absolute inset-0 -z-20 dric-blur-bg" />

      <div className="absolute left-1/2 top-24 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-blue-500/20 blur-[110px]" />
      <div className="absolute right-[-120px] top-36 -z-10 h-[360px] w-[360px] rounded-full bg-red-500/20 blur-[120px]" />
      <div className="absolute bottom-[-160px] left-[-100px] -z-10 h-[420px] w-[420px] rounded-full bg-indigo-500/20 blur-[130px]" />

      <div className="mx-auto flex min-h-[72vh] max-w-6xl flex-col items-center justify-center text-center">
        <a
          href="/presentacion"
          className="mb-7 inline-flex items-center gap-2 rounded-full border border-white/15 bg-black/40 px-5 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-white/90 shadow-[0_0_30px_rgba(255,255,255,0.12)] backdrop-blur-md"
        >
          <span className="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_12px_rgba(103,232,249,0.9)]" />
          {badge}
        </a>

        <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.92] tracking-[-0.08em] text-white md:text-7xl lg:text-8xl">
          {section.title}
        </h1>

        <p className="mt-8 max-w-3xl text-sm leading-relaxed text-white/70 md:text-base lg:text-lg">
          {heroBlock?.summary ?? section.summary}
        </p>

        <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
          <a
            href={primaryHref}
            className="dric-glow-button rounded-xl px-8 py-3 text-sm font-semibold text-white"
          >
            {primaryLabel}
          </a>

          <a
            href={secondaryHref}
            className="rounded-xl border border-white/15 bg-black/40 px-8 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(255,255,255,0.10)] backdrop-blur-md transition hover:-translate-y-0.5 hover:bg-white/10"
          >
            {secondaryLabel}
          </a>
        </div>

        <div className="mt-16 grid w-full max-w-3xl grid-cols-5 gap-4 text-white/35">
          <span className="text-center text-lg">f</span>
          <span className="text-center text-lg">×</span>
          <span className="text-center text-lg">◎</span>
          <span className="text-center text-lg">in</span>
          <span className="text-center text-lg">▶</span>
        </div>
      </div>
    </section>
  );
}