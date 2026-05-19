import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function FaqSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-5xl">
        <h2 className="text-5xl font-bold mb-12">
          {section.title}
        </h2>

        <div className="space-y-6">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="rounded-2xl border border-slate-800 p-6"
            >
              <h3 className="text-2xl font-semibold mb-4">
                {block.title}
              </h3>

              <p className="text-slate-300">
                {block.summary}
              </p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}