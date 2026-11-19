"use client";

import { useLayoutEffect, useRef, useState } from "react";

export default function ResponsiveRegulationsTitle({ title }: { title: string }) {
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
      className="mt-6 w-full text-6xl font-light tracking-wide max-sm:hyphens-none max-sm:whitespace-nowrap md:text-8xl"
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
