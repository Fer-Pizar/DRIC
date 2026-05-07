import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function DirectorSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-6xl">
        <h2 className="text-5xl font-bold mb-6">
          {section.title}
        </h2>

        <p className="text-slate-300 mb-12">
          {section.summary}
        </p>

        <div className="grid md:grid-cols-2 gap-8">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="rounded-3xl border border-slate-800 p-8"
            >
              <h3 className="text-3xl font-semibold mb-4">
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