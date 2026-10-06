import type { CmsSection } from "@/types/cms";
import { publicAssetUrl } from "@/lib/api/assets";

type Props = {
  section: CmsSection;
};

export default function AboutDricSection({ section }: Props) {
  const image = section.settings?.image_hidden ? "" : publicAssetUrl(String(section.settings?.image ?? "")) ?? "";

  return (
    <section className="px-4 py-16 sm:px-6 md:py-24">
      <div className={`mx-auto grid max-w-6xl items-left gap-8 lg:gap-16 ${image ? "lg:grid-cols-2" : ""}`}>
        <div className="text-left lg:text-left">
          <h2 className="mb-4 text-3xl font-bold leading-tight sm:text-4xl md:mb-6 md:text-5xl">
            {section.title}
          </h2>

          <p className="mx-auto max-w-2xl text-base leading-relaxed text-slate-300 md:text-lg lg:mx-0">
            {section.summary}
          </p>
        </div>

        {image ? (
          <div>
            <img
              src={image}
              alt={section.title ?? ""}
              className="w-full rounded-2xl object-cover md:rounded-3xl"
            />
          </div>
        ) : null}
      </div>
    </section>
  );
}
