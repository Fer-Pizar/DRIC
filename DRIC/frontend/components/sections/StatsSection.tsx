import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function StatsSection({ section }: Props) {
  return (
    <section className="relative px-6 py-20 md:px-10 lg:px-16">
      <div className="dric-stats-panel mx-auto max-w-6xl rounded-[32px] border border-white/10 bg-blue-950/40 px-6 py-10 shadow-[0_0_80px_rgba(0,55,112,0.25)] backdrop-blur-xl md:px-10">
        <div className="grid grid-cols-1 gap-8 text-center sm:grid-cols-3">
          {section.blocks.map((block) => (
            <div key={block.id}>
              <p className="dric-stats-value text-4xl font-bold text-cyan-300 md:text-5xl">
                {String(block.data?.value ?? "")}
              </p>

              <p className="mt-3 text-sm text-white/70 md:text-base">
                {block.title}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
