"use client";

import { useLayoutEffect, useRef, useState } from "react";

export default function ResponsiveMembershipsTitle({
  title,
  isEnglish,
}: {
  title: string;
  isEnglish: boolean;
}) {
  const headingRef = useRef<HTMLHeadingElement>(null);
  const [scale, setScale] = useState(1);

  useLayoutEffect(() => {
    const heading = headingRef.current;
    const container = heading?.parentElement;
    if (!heading || !container) return;

    let active = true;
    let frame = 0;

    const update = () => {
      if (!active) return;
      if (!window.matchMedia("(max-width: 639px)").matches) {
        setScale(1);
        return;
      }

      const availableWidth = container.clientWidth;
      if (!availableWidth) return;

      const computed = window.getComputedStyle(heading);
      const probe = document.createElement("span");
      probe.textContent = title;
      probe.style.position = "fixed";
      probe.style.visibility = "hidden";
      probe.style.whiteSpace = "nowrap";
      probe.style.fontFamily = computed.fontFamily;
      probe.style.fontSize = computed.fontSize;
      probe.style.fontWeight = computed.fontWeight;
      probe.style.fontStyle = computed.fontStyle;
      probe.style.letterSpacing = computed.letterSpacing;
      probe.style.textTransform = computed.textTransform;
      document.body.appendChild(probe);
      const titleWidth = probe.getBoundingClientRect().width;
      probe.remove();

      const nextScale = titleWidth > availableWidth - 2
        ? (availableWidth - 2) / titleWidth
        : 1;
      setScale((current) => Math.abs(current - nextScale) < 0.001 ? current : nextScale);
    };

    const schedule = () => {
      if (!active) return;
      cancelAnimationFrame(frame);
      frame = requestAnimationFrame(update);
    };

    const observer = new ResizeObserver(schedule);
    observer.observe(container);
    window.addEventListener("resize", schedule);
    void document.fonts.ready.then(schedule);
    schedule();

    return () => {
      active = false;
      cancelAnimationFrame(frame);
      observer.disconnect();
      window.removeEventListener("resize", schedule);
    };
  }, [title]);

  return (
    <h1
      ref={headingRef}
      className={`max-w-5xl break-words font-light uppercase max-sm:hyphens-none max-sm:whitespace-nowrap ${
        isEnglish
          ? "text-[2.40rem] sm:text-[2.8rem] md:text-7xl lg:text-8xl leading-[1.05]"
          : "text-[2.55rem] sm:text-[4rem] md:text-7xl lg:text-8xl leading-[0.95]"
      }`}
      style={scale < 1 ? {
        width: `${100 / scale}%`,
        transform: `scaleX(${scale})`,
        transformOrigin: "left top",
      } : undefined}
    >
      {title}
    </h1>
  );
}
