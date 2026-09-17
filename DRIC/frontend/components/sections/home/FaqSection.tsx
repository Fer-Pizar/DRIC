"use client";

import { useMemo, useState } from "react";
import clsx from "clsx";

import type { CmsSection } from "@/types/cms";

type Props = {
  section: CmsSection;
  locale?: string;
};

const copy = {
  es: {
    showAll: "Mostrar todo",
    hideAll: "Ocultar todo",
  },
  en: {
    showAll: "Show all",
    hideAll: "Hide all",
  },
};

export default function FaqSection({ section, locale = "es" }: Props) {
  const [openItems, setOpenItems] = useState<Set<number>>(new Set());
  const labels = locale === "en" ? copy.en : copy.es;
  const allOpen = section.blocks.length > 0 && openItems.size === section.blocks.length;

  const answerIds = useMemo(
    () => section.blocks.map((block) => `faq-answer-${section.id}-${block.id}`),
    [section.blocks, section.id]
  );

  const toggleItem = (blockId: number) => {
    setOpenItems((current) => {
      const next = new Set(current);

      if (next.has(blockId)) {
        next.delete(blockId);
      } else {
        next.add(blockId);
      }

      return next;
    });
  };

  const toggleAll = () => {
    setOpenItems(() => {
      if (allOpen) {
        return new Set();
      }

      return new Set(section.blocks.map((block) => block.id));
    });
  };

  return (
    <section className="dric-faq-section px-4 py-16 sm:px-6 md:py-24">
      <div className="mx-auto max-w-5xl">
        <div className="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between md:mb-12">
          <h2 className="text-center text-3xl font-bold leading-tight sm:text-left sm:text-4xl md:text-5xl">
            {section.title}
          </h2>

          {section.blocks.length > 0 ? (
            <button
              type="button"
              onClick={toggleAll}
              className="dric-faq-toggle-all mx-auto inline-flex min-h-11 items-center justify-center gap-2 border px-5 py-2 text-sm font-semibold transition sm:mx-0 sm:text-base"
              aria-expanded={allOpen}
            >
              <span>{allOpen ? labels.hideAll : labels.showAll}</span>
              <span aria-hidden="true" className="text-lg leading-none">
                {allOpen ? "-" : "+"}
              </span>
            </button>
          ) : null}
        </div>

        <div className="dric-faq-list">
          {section.blocks.map((block, index) => {
            const isOpen = openItems.has(block.id);

            return (
              <div
                key={block.id}
                className={clsx("dric-faq-item", isOpen && "is-open")}
              >
                <button
                  type="button"
                  onClick={() => toggleItem(block.id)}
                  className="dric-faq-question grid w-full grid-cols-[1fr_auto] items-center gap-4 py-5 text-left transition sm:gap-6 md:py-6"
                  aria-expanded={isOpen}
                  aria-controls={answerIds[index]}
                >
                  <span className="text-lg font-semibold leading-snug sm:text-xl md:text-2xl">
                    {block.title}
                  </span>

                  <span
                    className="dric-faq-plus flex h-10 w-10 shrink-0 items-center justify-center text-3xl font-light leading-none transition"
                    aria-hidden="true"
                  >
                    +
                  </span>
                </button>

                <div
                  id={answerIds[index]}
                  className="dric-faq-answer-grid grid transition-all duration-300 ease-out"
                >
                  <div className="overflow-hidden">
                    <p className="dric-faq-answer pb-5 text-sm leading-relaxed sm:text-base md:pb-6">
                      {block.summary}
                    </p>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
