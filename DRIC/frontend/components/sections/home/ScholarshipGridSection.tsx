import Link from "next/link";
import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
  locale?: string;
};

const imageSlugMap: Record<string, string> = {
  germany: "alemania",
  france: "francia",
  "south-korea": "corea-del-sur",
  italy: "italia",
  japan: "japon",
  netherlands: "holanda",
  sweden: "suecia",
  switzerland: "suiza",
  china: "china",
};

function getCountrySlug(block: CmsSection["blocks"][number]) {
  const explicitSlug = block.data?.slug;

  if (typeof explicitSlug === "string" && explicitSlug.length > 0) {
    return explicitSlug;
  }

  const image = String(block.data?.image ?? "");
  const imageSlug = image.split("/").pop()?.replace(/\.[^.]+$/, "");

  return imageSlug ? imageSlugMap[imageSlug] ?? imageSlug : "";
}

export default function ScholarshipGridSection({ section, locale = "es" }: Props) {
  return (
    <section className="px-6 py-24">
      <div className="mx-auto max-w-7xl">
        <h2 className="mb-4 text-4xl font-bold">{section.title}</h2>

        <p className="mb-12 text-slate-300">{section.summary}</p>

        <div className="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
          {section.blocks.map((block) => {
            const countrySlug = getCountrySlug(block);

            return (
              <Link
                key={block.id}
                href={`/${locale}/becas-movilidad/${countrySlug}`}
                className="dric-scholarship-card group block overflow-hidden rounded-3xl border border-white/10 bg-slate-900 transition duration-500 hover:-translate-y-3 hover:scale-[1.03] hover:border-cyan-300/70 hover:shadow-[0_0_45px_rgba(0,55,112,0.25)]"
              >
                <div className="relative overflow-hidden">
                  <img
                    src={block.media?.url ?? String(block.data?.image ?? "")}
                    alt={block.title ?? ""}
                    className="h-64 w-full object-cover transition duration-700 group-hover:scale-110 group-hover:brightness-110"
                  />

                  <div className="absolute inset-0 bg-cyan-300/0 transition duration-500 group-hover:bg-cyan-300/10" />
                </div>

                <div className="dric-scholarship-card-strip p-6">
                  <h3 className="dric-scholarship-card-title text-2xl font-light transition duration-300 group-hover:text-cyan-300">
                    {block.title}
                  </h3>
                </div>
              </Link>
            );
          })}
        </div>

        <div className="mt-16 flex justify-center">
          <Link
            href={`/${locale}/becas-movilidad`}
            className="group relative inline-flex overflow-hidden rounded-full border border-white/10 bg-gradient-to-r from-[#E30613] via-[#E30613] to-[#003770] px-10 py-5 text-sm font-semibold uppercase tracking-[0.18em] text-white shadow-[0_15px_40px_rgba(0,0,0,0.35)] transition-all duration-500 hover:scale-105 hover:shadow-[0_25px_60px_rgba(227,6,19,0.4)]"
          >
            <span className="relative z-10">Ver todas las convocatorias</span>
            <span className="relative z-10 ml-3 transition-transform duration-300 group-hover:translate-x-1">
              →
            </span>
            <span className="absolute inset-0 -translate-x-full bg-white/10 transition-transform duration-700 group-hover:translate-x-0" />
          </Link>
        </div>
      </div>
    </section>
  );
}
