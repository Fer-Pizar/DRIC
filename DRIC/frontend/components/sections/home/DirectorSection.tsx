import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function DirectorSection({ section }: Props) {
  return (
    <section className="px-4 py-16 sm:px-6 md:py-24">
      <div className="mx-auto max-w-6xl">
        <h2 className="mb-4 text-left text-3xl font-bold leading-tight sm:text-4xl md:mb-6 md:text-left md:text-5xl">
          {section.title}
        </h2>

        <p className="mx-auto mb-8 max-w-2xl text-left text-base leading-relaxed text-slate-300 md:mx-0 md:mb-12 md:text-left">
          {section.summary}
        </p>

        <div className="grid gap-5 md:grid-cols-2 md:gap-8">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="rounded-2xl border border-slate-800 p-5 text-left md:rounded-3xl md:p-8 md:text-center"
            >
              <h3 className="mb-3 text-xl font-semibold leading-tight sm:text-2xl md:mb-4 md:text-3xl">
                {block.title}
              </h3>

              <p className="text-sm leading-relaxed text-slate-300 sm:text-base">
                {block.summary}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
