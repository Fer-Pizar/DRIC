"use client";

import Image from "next/image";
import Link from "next/link";
import { useLocale, useTranslations } from "next-intl";
import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
};

const socialLinks = [
  {
    name: "Facebook",
    href: "https://www.facebook.com/UMSS.DRIC/",
    icon: "/images/social/facebook.png",
  },
  {
    name: "X",
    href: "https://x.com/UmssBolOficial",
    icon: "/images/social/x.png",
  },
  {
    name: "Instagram",
    href: "https://www.instagram.com/umss.dric/",
    icon: "/images/social/instagram.png",
  },
  {
    name: "LinkedIn",
    href: "https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-name",
    icon: "/images/social/linkedin.png",
  },
  {
    name: "YouTube",
    href: "https://www.youtube.com/@universidadmayordesansimon9737",
    icon: "/images/social/youtube.png",
  },
];

export default function HeroSection({ section }: Props) {
  const heroBlock = section.blocks[0];
  const locale = useLocale();
  const tNav = useTranslations("nav");

  const badge = tNav("presentation");
  const badgeHref = `/${locale}${heroBlock?.link_url ?? "/presentacion"}`;
  const primaryHref = `/${locale}/convenios`;
  const secondaryHref = `/${locale}${String(heroBlock?.data?.secondaryLink ?? "/becas-movilidad")}`;

  const primaryLabel = heroBlock?.cta_label ?? tNav("agreements");
  const secondaryLabel = heroBlock?.secondary_cta_label ?? tNav("mobility");

  return (
    <section className="dric-home-hero relative isolate min-h-[92vh] overflow-hidden bg-[#020617] px-4 pb-16 pt-28 text-white md:px-8 md:pb-32 md:pt-36 lg:px-12">
      <Image
        src="/images/hero/university.png"
        alt="UMSS university view"
        fill
        priority
        className="absolute inset-0 -z-30 object-cover"
      />

      <div className="absolute inset-0 -z-20 bg-gradient-to-b from-[#020617]/82 via-[#020617]/62 to-[#020617]" />
      <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(227,6,19,0.38),transparent_35%),radial-gradient(circle_at_top_right,rgba(0,55,112,0.42),transparent_38%)]" />

      <div className="dric-home-hero-content mx-auto flex min-h-[68vh] w-full max-w-6xl flex-col items-center justify-center text-center md:min-h-[72vh]">
        <Link
          href={badgeHref}
          className="dric-home-hero-badge mb-6 inline-flex max-w-full items-center justify-center gap-2 rounded-full border border-white/15 bg-black/35 px-4 py-2 text-center text-[0.68rem] font-semibold uppercase tracking-[0.14em] text-white/90 shadow-[0_0_30px_rgba(255,255,255,0.12)] backdrop-blur-md sm:text-xs sm:tracking-[0.22em] md:mb-7 md:px-5"
        >
          <span className="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_12px_rgba(103,232,249,0.9)]" />
          {badge}
        </Link>

        <h1 className="dric-home-hero-title mx-auto max-w-[18rem] break-words text-center text-[2.15rem] font-light uppercase leading-[1.08] tracking-[-0.015em] text-white sm:max-w-xl sm:text-5xl md:max-w-5xl md:text-7xl md:leading-[0.92] md:tracking-[-0.08em] lg:text-8xl">
          {section.title}
        </h1>

        <p className="dric-home-hero-summary mx-auto mt-5 max-w-[18rem] text-center text-sm leading-relaxed text-white/75 sm:max-w-xl md:mt-8 md:max-w-3xl md:text-base lg:text-lg">
          {heroBlock?.summary ?? section.summary}
        </p>

        <div className="mt-8 flex w-full max-w-sm flex-col items-stretch justify-center gap-4 sm:max-w-none sm:flex-row sm:items-center md:mt-10">
          <Link
            href={primaryHref}
            className="dric-glow-button dric-home-hero-primary rounded-xl px-6 py-3 text-center text-sm font-semibold text-white sm:px-8"
          >
            {primaryLabel}
          </Link>

          <Link
            href={secondaryHref}
            className="dric-home-hero-secondary rounded-xl border border-white/15 bg-black/35 px-6 py-3 text-center text-sm font-semibold text-white shadow-[0_0_24px_rgba(255,255,255,0.10)] backdrop-blur-md transition hover:-translate-y-0.5 hover:bg-white/10 sm:px-8"
          >
            {secondaryLabel}
          </Link>
        </div>

        <div className="mx-auto mt-10 w-full max-w-[18rem] overflow-hidden sm:max-w-md md:mt-16 md:w-[52vw] md:max-w-none">
          <div className="dric-social-track">
            {[...socialLinks, ...socialLinks].map((social, index) => (
              <a
                key={`${social.name}-${index}`}
                href={social.href}
                target="_blank"
                rel="noopener noreferrer"
                aria-label={social.name}
                className="dric-social-icon"
              >
                <Image
                  src={social.icon}
                  alt={social.name}
                  width={34}
                  height={34}
                  className="h-8 w-8 object-contain opacity-70 transition duration-300 hover:opacity-100"
                />
              </a>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
