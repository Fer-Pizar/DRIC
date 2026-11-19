"use client";

import { useLayoutEffect, useRef, useState } from "react";

export default function ResponsiveInternationalizationTitle({
  title,
  variant = "page",
}: {
  title: string;
  variant?: "page" | "card";
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

  const fittedStyle = scale < 1 ? {
    width: `${100 / scale}%`,
    maxWidth: "none",
    transform: `scaleX(${scale})`,
    transformOrigin: "left top",
  } : undefined;

  if (variant === "card") {
    return (
      <h2
        ref={headingRef}
        className="mx-auto w-full max-w-full break-words text-center text-[1.375rem] font-light leading-tight tracking-[-0.025em] max-sm:break-normal max-sm:hyphens-none max-sm:whitespace-nowrap max-sm:[overflow-wrap:normal] sm:text-3xl md:text-5xl md:tracking-[-0.04em]"
        style={fittedStyle}
      >
        {title}
      </h2>
    );
  }

  return (
    <h1
      ref={headingRef}
      className="dric-internationalization-title mx-auto w-full max-w-full break-words text-[2.125rem] font-light uppercase leading-[1.04] tracking-[-0.025em] max-sm:break-normal max-sm:hyphens-none max-sm:whitespace-nowrap max-sm:[overflow-wrap:normal] sm:text-5xl md:mx-0 md:max-w-6xl md:text-7xl md:leading-[0.9] md:tracking-[-0.07em] lg:text-8xl"
      style={fittedStyle}
    >
      {title}
    </h1>
  );
}
