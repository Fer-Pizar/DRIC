import Link from "next/link";
import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function ScholarshipGridSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-7xl">
        <h2 className="mb-4 text-4xl font-bold">{section.title}</h2>

        <p className="mb-12 text-slate-300">{section.summary}</p>

        <div className="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900"
            >
              <img
                src={block.media?.url ?? String(block.data?.image ?? "")}
                alt={block.title ?? ""}
                className="h-72 w-full object-cover"
              />

              <div className="p-6">
                <h3 className="text-2xl font-semibold">{block.title}</h3>
              </div>
            </div>
          ))}
        </div>

        <div className="mt-16 flex justify-center">
          <Link
            href="/es/becas-movilidad"
            className="group relative inline-flex overflow-hidden rounded-full border border-white/10 bg-gradient-to-r from-[#7A0015] via-[#B5121B] to-[#163E8C] px-10 py-5 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-[0_15px_40px_rgba(0,0,0,0.35)] transition-all duration-500 hover:scale-105 hover:shadow-[0_25px_60px_rgba(181,18,27,0.4)]"
          >
            <span className="relative z-10">Ver todas las convocatorias</span>
            <span className="relative z-10 ml-3 transition-transform duration-300 group-hover:translate-x-1">
              →
            </span>
            <span className="absolute inset-0 -translate-x-full bg-white/10 transition-transform duration-700 group-hover:translate-x-0" />
          </Link>
        </div>
      </div>
    </section>
  );
}