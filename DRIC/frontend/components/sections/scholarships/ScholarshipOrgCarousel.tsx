"use client";

import { useCallback, useEffect, useRef, useState } from "react";
import Link from "next/link";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import WorkspacePremiumRoundedIcon from "@mui/icons-material/WorkspacePremiumRounded";

import type { ScholarshipCatalogItem } from "@/lib/scholarships/becasCatalog";

type Props = {
  items: ScholarshipCatalogItem[];
  locale: string;
};

function CatalogCard({
  item,
  locale,
}: {
  item: ScholarshipCatalogItem;
  locale: string;
}) {
  const language = locale === "en" ? "en" : "es";
  const href = localizedHref(item.href ?? `/becas-movilidad/becas/${item.slug}`, locale);

  return (
    <article className="dric-scholarship-option group relative min-h-[250px] overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.055] p-6 text-white shadow-2xl shadow-black/20 backdrop-blur-xl transition duration-500 hover:-translate-y-1 hover:border-white/25 hover:bg-white/[0.085] md:p-7">
      <div
        className="absolute right-[-56px] top-[-64px] h-40 w-40 rounded-full blur-3xl transition duration-500 group-hover:scale-125"
        style={{ backgroundColor: `${item.accent}33` }}
      />

      <div className="relative flex h-full flex-col">
        <div className="flex items-start">
          <div
            className="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl text-white shadow-xl shadow-black/20"
            style={{ backgroundColor: item.accent }}
          >
            {item.type === "country" ? <PublicRoundedIcon /> : <WorkspacePremiumRoundedIcon />}
          </div>
        </div>

        <p className="mt-7 text-xs font-bold uppercase tracking-[0.22em] text-white/45">
          {item.region[language]}
        </p>

        <h2 className="mt-3 text-3xl font-semibold leading-tight tracking-[-0.045em]">
          {item.name[language]}
        </h2>

        <p className="mt-4 flex-1 text-sm leading-7 text-white/62">
          {item.summary[language]}
        </p>

        <Link
          href={href}
          className="mt-7 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-cyan-200"
        >
          {language === "en" ? "Open opportunities" : "Ver oportunidades"}
          <ArrowForwardRoundedIcon fontSize="small" />
        </Link>
      </div>
    </article>
  );
}

function localizedHref(href: string, locale: string): string {
  if (href.startsWith("http://") || href.startsWith("https://") || href.startsWith("mailto:")) {
    return href;
  }

  return `/${locale}/${href.replace(/^\/+/, "")}`;
}

export default function ScholarshipOrgCarousel({ items, locale }: Props) {
  const trackRef = useRef<HTMLDivElement>(null);
  const [canScrollPrevious, setCanScrollPrevious] = useState(false);
  const [canScrollNext, setCanScrollNext] = useState(false);
  const language = locale === "en" ? "en" : "es";

  const updateScrollState = useCallback(() => {
    const track = trackRef.current;

    if (!track) {
      setCanScrollPrevious(false);
      setCanScrollNext(false);
      return;
    }

    const maxScrollLeft = track.scrollWidth - track.clientWidth;
    const threshold = 2;

    setCanScrollPrevious(track.scrollLeft > threshold);
    setCanScrollNext(track.scrollLeft < maxScrollLeft - threshold);
  }, []);

  useEffect(() => {
    const track = trackRef.current;

    if (!track) {
      return;
    }

    const animationFrame = requestAnimationFrame(updateScrollState);
    track.addEventListener("scroll", updateScrollState, { passive: true });
    window.addEventListener("resize", updateScrollState);

    return () => {
      cancelAnimationFrame(animationFrame);
      track.removeEventListener("scroll", updateScrollState);
      window.removeEventListener("resize", updateScrollState);
    };
  }, [items.length, updateScrollState]);

  const scrollNext = () => {
    const track = trackRef.current;

    if (!track) {
      return;
    }

    track.scrollBy({
      left: Math.max(track.clientWidth * 0.9, 280),
      behavior: "smooth",
    });
  };

  const scrollPrevious = () => {
    const track = trackRef.current;

    if (!track) {
      return;
    }

    track.scrollBy({
      left: -Math.max(track.clientWidth * 0.9, 280),
      behavior: "smooth",
    });
  };

  return (
    <div className="dric-scholarship-org-carousel relative">
      {canScrollPrevious ? (
        <button
          type="button"
          onClick={scrollPrevious}
          className="dric-scholarship-org-arrow dric-scholarship-org-arrow-left absolute left-0 top-1/2 z-10 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-white/10 text-white shadow-2xl shadow-black/30 backdrop-blur-xl transition hover:border-fuchsia-300/80 hover:bg-fuchsia-400/18 hover:text-fuchsia-100 xl:flex"
          aria-label={language === "en" ? "Show previous organizations" : "Ver organismos anteriores"}
        >
          <ArrowForwardRoundedIcon className="rotate-180" />
        </button>
      ) : null}

      {canScrollNext ? (
        <button
          type="button"
          onClick={scrollNext}
          className="dric-scholarship-org-arrow dric-scholarship-org-arrow-right absolute right-0 top-1/2 z-10 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-white/10 text-white shadow-2xl shadow-black/30 backdrop-blur-xl transition hover:border-fuchsia-300/80 hover:bg-fuchsia-400/18 hover:text-fuchsia-100 xl:flex"
          aria-label={language === "en" ? "Show more organizations" : "Ver más organismos"}
        >
          <ArrowForwardRoundedIcon />
        </button>
      ) : null}

      <div
        ref={trackRef}
        className="dric-scholarship-org-track overflow-x-auto scroll-smooth pb-3"
      >
        <div className="flex gap-5">
          {items.map((organization) => (
            <div
              key={organization.slug}
              className="dric-scholarship-org-slide shrink-0"
            >
              <CatalogCard
                item={organization}
                locale={locale}
              />
            </div>
          ))}
        </div>
      </div>

      <p className="dric-scholarship-org-hint text-center text-sm font-semibold text-white/70">
        {language === "en" ? "Swipe to see more" : "Desliza para ver más"}
      </p>
    </div>
  );
}
