import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function FaqSection({ section }: Props) {
  return (
    <section className="px-4 py-16 sm:px-6 md:py-24">
      <div className="mx-auto max-w-5xl">
        <h2 className="mb-8 text-center text-3xl font-bold leading-tight sm:text-4xl md:mb-12 md:text-left md:text-5xl">
          {section.title}
        </h2>

        <div className="space-y-4 md:space-y-6">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="rounded-2xl border border-slate-800 p-5 text-center md:p-6 md:text-left"
            >
              <h3 className="mb-3 text-xl font-semibold leading-tight md:mb-4 md:text-2xl">
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
