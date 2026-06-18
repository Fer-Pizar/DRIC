import Link from "next/link";
import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
  locale?: string;
};

function getLocalizedHref(linkUrl: string | null, locale: string) {
  const target = linkUrl === "/contacto" ? "/agendar-cita" : linkUrl ?? "/agendar-cita";

  if (target.startsWith("http")) {
    return target;
  }

  return `/${locale}${target.startsWith("/") ? target : `/${target}`}`;
}

export default function FinalCtaSection({ section, locale = "es" }: Props) {
  return (
    <section className="px-6 py-32">
      <div className="mx-auto max-w-5xl text-center rounded-[40px] border border-slate-800 p-16">
        <h2 className="text-5xl font-bold mb-6">
          {section.title}
        </h2>

        <p className="text-slate-300 text-xl mb-10">
          {section.summary}
        </p>

        {section.blocks.map((block) => (
          <Link
            key={block.id}
            href={getLocalizedHref(block.link_url, locale)}
            className="inline-flex rounded-full bg-blue-600 px-8 py-4 text-lg font-semibold"
          >
            {block.cta_label}
          </Link>
        ))}
      </div>
    </section>
  );
}
