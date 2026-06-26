import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

export default function AboutDricSection({ section }: Props) {
  return (
    <section className="px-4 py-16 sm:px-6 md:py-24">
      <div className="mx-auto grid max-w-6xl items-center gap-8 lg:grid-cols-2 lg:gap-16">
        <div className="text-center lg:text-left">
          <h2 className="mb-4 text-3xl font-bold leading-tight sm:text-4xl md:mb-6 md:text-5xl">
            {section.title}
          </h2>

          <p className="mx-auto max-w-2xl text-base leading-relaxed text-slate-300 md:text-lg lg:mx-0">
            {section.summary}
          </p>
        </div>

        <div>
          <img
            src={String(section.settings?.image ?? "")}
            alt={section.title ?? ""}
            className="w-full rounded-2xl object-cover md:rounded-3xl"
          />
        </div>
      </div>
    </section>
  );
}
