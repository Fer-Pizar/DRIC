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
  const primaryHref = `/${locale}${heroBlock?.link_url ?? "/presentacion"}`;
  const secondaryHref = `/${locale}${String(heroBlock?.data?.secondaryLink ?? "/becas-movilidad")}`;

  const primaryLabel = heroBlock?.cta_label ?? tNav("agreements");
  const secondaryLabel = heroBlock?.secondary_cta_label ?? tNav("mobility");

  return (
    <section className="dric-home-hero relative isolate min-h-[92vh] overflow-hidden bg-[#020617] px-4 pb-24 pt-28 text-white md:px-8 md:pb-32 md:pt-36 lg:px-12">
      <Image
        src="/images/hero/university.png"
        alt="UMSS university view"
        fill
        priority
        className="absolute inset-0 -z-30 object-cover"
      />

      <div className="absolute inset-0 -z-20 bg-gradient-to-b from-[#020617]/82 via-[#020617]/62 to-[#020617]" />
      <div className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.38),transparent_35%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.42),transparent_38%)]" />

      <div className="dric-home-hero-content mx-auto flex min-h-[72vh] max-w-6xl flex-col items-center justify-center text-center">
        <Link
          href={primaryHref}
          className="dric-home-hero-badge mb-7 inline-flex items-center gap-2 rounded-full border border-white/15 bg-black/35 px-5 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-white/90 shadow-[0_0_30px_rgba(255,255,255,0.12)] backdrop-blur-md"
        >
          <span className="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_12px_rgba(103,232,249,0.9)]" />
          {badge}
        </Link>

        <h1 className="dric-home-hero-title max-w-5xl text-5xl font-light uppercase leading-[0.92] tracking-[-0.08em] text-white md:text-7xl lg:text-8xl">
          {section.title}
        </h1>

        <p className="dric-home-hero-summary mt-8 max-w-3xl text-sm leading-relaxed text-white/75 md:text-base lg:text-lg">
          {heroBlock?.summary ?? section.summary}
        </p>

        <div className="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
          <Link
            href={primaryHref}
            className="dric-glow-button dric-home-hero-primary rounded-xl px-8 py-3 text-sm font-semibold text-white"
          >
            {primaryLabel}
          </Link>

          <Link
            href={secondaryHref}
            className="dric-home-hero-secondary rounded-xl border border-white/15 bg-black/35 px-8 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(255,255,255,0.10)] backdrop-blur-md transition hover:-translate-y-0.5 hover:bg-white/10"
          >
            {secondaryLabel}
          </Link>
        </div>

        <div className="mx-auto mt-16 w-[52vw] overflow-hidden">
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
