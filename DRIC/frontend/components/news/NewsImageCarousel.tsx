"use client";

import { useEffect, useState } from "react";

type Props = {
  images: string[];
  alt: string;
};

export default function NewsImageCarousel({ images, alt }: Props) {
  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    if (images.length <= 1) return;

    const timer = window.setInterval(() => {
      setActiveIndex((index) => (index + 1) % images.length);
    }, 4000);

    return () => window.clearInterval(timer);
  }, [images.length]);

  if (!images.length) return null;

  return (
    <figure className="dric-news-article-photo relative mt-10 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.04]">
      {images.map((image, index) => (
        <img
          key={image}
          src={image}
          alt={alt}
          className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-700 ${
            index === activeIndex ? "opacity-100" : "opacity-0"
          }`}
        />
      ))}

      {images.length > 1 ? (
        <div className="absolute bottom-5 left-1/2 z-10 flex -translate-x-1/2 gap-2 rounded-full border border-white/12 bg-[#020617]/45 px-3 py-2 backdrop-blur">
          {images.map((image, index) => (
            <button
              key={`${image}-dot`}
              type="button"
              aria-label={`Imagen ${index + 1}`}
              onClick={() => setActiveIndex(index)}
              className={`h-2.5 w-2.5 rounded-full border border-white/60 transition ${
                index === activeIndex ? "bg-white" : "bg-white/20"
              }`}
            />
          ))}
        </div>
      ) : null}
    </figure>
  );
}
