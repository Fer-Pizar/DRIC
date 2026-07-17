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
    <section className="px-4 py-17 text-center sm:px-6 md:py-32">
      <div className="mx-auto max-w-5xl rounded-3xl border border-slate-800 p-6 sm:p-10 md:rounded-[40px] md:p-16">
        <h2 className="mb-4 text-3xl font-bold leading-tight sm:text-4xl md:mb-6 md:text-5xl">
          {section.title}
        </h2>

        <p className="mx-auto mb-8 max-w-2xl text-base leading-relaxed text-slate-300 sm:text-lg md:mb-10 md:text-xl">
          {section.summary}
        </p>

        {section.blocks.map((block) => (
          <Link
            key={block.id}
            href={getLocalizedHref(block.link_url, locale)}
            className="dric-final-cta-button inline-flex max-w-full justify-center rounded-full bg-blue-600 px-6 py-3 text-center text-base font-semibold sm:px-8 sm:py-4 sm:text-lg"
          >
            {block.cta_label}
          </Link>
        ))}
      </div>
    </section>
  );
}
