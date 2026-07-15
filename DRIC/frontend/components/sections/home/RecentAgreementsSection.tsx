"use client";

import Link from "next/link";
import Image from "next/image";
import { motion } from "framer-motion";
import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
  locale?: string;
};

export default function RecentAgreementsSection({
  section,
  locale = "es",
}: Props) {
  return (
    <section className="relative overflow-hidden px-6 py-24 md:px-10 lg:px-16">
      {/* Background cinematic blur */}
      <div className="absolute left-0 top-32 h-72 w-72 rounded-full bg-cyan-400/10 blur-[120px]" />

      <div className="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-red-500/10 blur-[140px]" />

      <div className="relative mx-auto max-w-7xl">
        {/* Section Heading */}
        <motion.div
          initial={{ opacity: 0, y: 36 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="mb-16"
        >
          <p className="mb-4 text-sm uppercase tracking-[0.3em] text-cyan-300">
            International Cooperation
          </p>

          <h2 className="max-w-3xl text-4xl font-bold leading-tight text-white md:text-6xl">
            {section.title}
          </h2>

          {section.summary && (
            <p className="mt-6 max-w-2xl text-lg leading-8 text-white/60">
              {section.summary}
            </p>
          )}
        </motion.div>

        {/* Agreements Grid */}
        <div className="grid gap-10 md:grid-cols-2 xl:grid-cols-3">
          {section.blocks.map((block, index) => {
            const image =
              block.media?.url ??
              String(block.data?.image ?? "");

            const slug = String(
              block.data?.slug ??
                block.title
                  ?.toLowerCase()
                  .replaceAll(" ", "-")
                  .normalize("NFD")
                  .replace(/[\u0300-\u036f]/g, "") ??
                "agreement"
            );
            const normalizedSlug = slug
              .toLowerCase()
              .normalize("NFD")
              .replace(/[\u0300-\u036f]/g, "");
            const href =
              normalizedSlug === "alianzas-estrategicas" ||
              normalizedSlug === "strategic-partnerships"
                ? `/${locale}/membresias`
                : `/${locale}/convenios/${slug}`;

            return (
              <motion.div
                key={block.id}
                initial={{ opacity: 0, y: 40 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{
                  duration: 0.7,
                  delay: index * 0.12,
                }}
              >
                <Link
                  href={href}
                  className="group relative block overflow-hidden rounded-[34px] border border-white/10 bg-white/[0.03] backdrop-blur-xl"
                >
                  {/* Image */}
                  <div className="relative h-[460px] overflow-hidden">
                    <Image
                      src={image}
                      alt={block.title ?? ""}
                      fill
                      className="
                        object-cover
                        grayscale
                        transition-all
                        duration-700
                        group-hover:scale-110
                        group-hover:grayscale-0
                      "
                    />

                    {/* Overlay */}
                    <div
                      className="
                        absolute inset-0
                        bg-gradient-to-t
                        from-black
                        via-black/20
                        to-transparent
                      "
                    />

                    {/* Glow */}
                    <div
                      className="
                        absolute inset-0
                        opacity-0
                        transition-opacity
                        duration-700
                        group-hover:opacity-100
                        bg-cyan-400/10
                      "
                    />
                  </div>

                  {/* Content */}
                  <div className="absolute bottom-0 left-0 z-10 p-8">
                    <p className="mb-3 text-xs uppercase tracking-[0.25em] text-cyan-300">
                      DRIC UMSS
                    </p>

                    <h3
                      className="
                        max-w-xs
                        text-3xl
                        font-semibold
                        leading-tight
                        text-white
                        transition-all
                        duration-500
                        group-hover:translate-x-2
                      "
                    >
                      {block.title}
                    </h3>
                  </div>

                  {/* Border glow */}
                  <div
                    className="
                      pointer-events-none
                      absolute inset-0
                      rounded-[34px]
                      ring-1
                      ring-white/10
                      transition-all
                      duration-700
                      group-hover:ring-cyan-300/40
                    "
                  />
                </Link>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
