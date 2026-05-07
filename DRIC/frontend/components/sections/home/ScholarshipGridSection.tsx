import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function ScholarshipGridSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-7xl">
        <h2 className="text-4xl font-bold mb-4">
          {section.title}
        </h2>

        <p className="text-slate-300 mb-12">
          {section.summary}
        </p>

        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="overflow-hidden rounded-3xl bg-slate-900 border border-slate-800"
            >
              <img
                src={String(block.data?.image ?? "")}
                alt={block.title ?? ""}
                className="h-72 w-full object-cover"
              />

              <div className="p-6">
                <h3 className="text-2xl font-semibold">
                  {block.title}
                </h3>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}