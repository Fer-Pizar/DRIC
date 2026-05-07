import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function RecentAgreementsSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-7xl">
        <h2 className="text-4xl font-bold mb-6">
          {section.title}
        </h2>

        <div className="grid md:grid-cols-3 gap-8">
          {section.blocks.map((block) => (
            <div
              key={block.id}
              className="rounded-3xl overflow-hidden border border-slate-800"
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