import type { CmsSection } from "@/types/cms";
import { publicAssetUrl } from "@/lib/api/assets";

type Props = {
  section: CmsSection;
};

export default function AboutDricSection({ section }: Props) {
  const image = section.settings?.image_hidden ? "" : publicAssetUrl(String(section.settings?.image ?? "")) ?? "";

  return (
    <section className="px-6 py-16 md:px-10 md:py-24 lg:px-16">
      <div className={`mx-auto grid max-w-7xl items-center gap-10 lg:gap-16 ${image ? "lg:grid-cols-2" : ""}`}>
        <div className={`w-full min-w-0 ${image ? "" : "mx-auto max-w-3xl"}`}>
          <h2 className="mb-5 text-3xl font-normal leading-tight text-balance sm:text-4xl md:mb-7 md:text-5xl">
            {section.title}
          </h2>

          <p className="text-left text-base leading-relaxed text-slate-300 md:text-justify md:text-lg">
            {section.summary}
          </p>
        </div>

        {image ? (
          <div className="w-full overflow-hidden rounded-2xl md:rounded-3xl">
            <img
              src={image}
              alt={section.title ?? ""}
              className="aspect-[3/2] w-full object-cover"
            />
          </div>
        ) : null}
      </div>
    </section>
  );
}
