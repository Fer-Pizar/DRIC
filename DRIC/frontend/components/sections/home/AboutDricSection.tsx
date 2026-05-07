import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function AboutDricSection({ section }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-6xl grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <h2 className="text-5xl font-bold mb-6">
            {section.title}
          </h2>

          <p className="text-slate-300 text-lg leading-relaxed">
            {section.summary}
          </p>
        </div>

        <div>
          <img
            src={String(section.settings?.image ?? "")}
            alt={section.title ?? ""}
            className="rounded-3xl object-cover"
          />
        </div>
      </div>
    </section>
  );
}