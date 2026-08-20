"use client";

import Image from "next/image";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";

type Props = {
  locale: "es" | "en";
};

const content = {
  es: {
    title: "Experiencias de los estudiantes",
    text: "Historias reales sobre movilidad académica, cooperación internacional y oportunidades que transforman la vida universitaria.",
    button: "Ver programas",
    comments: [
      {
        name: "Naïs Mampaey",
        role: "Estudiante de intercambio",
        country: "Bélgica",
        image: "/images/testimonials/mais.jpg",
        comment:
          "Realicé una pasantía médica en Bolivia durante dos meses: un mes en pediatría y un mes en ginecología. Durante la pasantía conocimos a muchos internos y médicos amables, apasionados por su trabajo. Fue interesante ver las diferencias entre la atención médica en Bolivia y Bélgica. Los fines de semana viajamos y vimos muchos lugares hermosos como el Salar de Uyuni, Sucre, Potosí, Toro Toro, La Paz y Trinidad. ¡Bolivia realmente lo tiene todo!",
      },
      {
        name: "Wannes Loobuyck",
        role: "Estudiante de intercambio",
        country: "Bélgica",
        image: "/images/testimonials/wannes.jpg",
        comment:
          "Llegué a Bolivia como estudiante de intercambio para realizar una pasantía en el hospital y realmente valió la pena. Las personas aquí son muy amables y siempre les gusta ayudarte. En el hospital vimos muchas patologías que no vemos en Bélgica. También nos gustó mucho la comida de aquí, ¡muy rico! ¡Gracias Bolivia!",
      },
      {
        name: "Kato Vandoorne",
        role: "Estudiante de intercambio",
        country: "Bélgica",
        image: "/images/testimonials/kato.jpg",
        comment:
          "Realicé una pasantía médica de dos meses en dos hospitales diferentes de Cochabamba. Fue muy interesante ver las diferencias con los hospitales de Bélgica. El intercambio también fue una experiencia muy bonita fuera del hospital. Conocimos a muchas personas amables, comimos buena comida local y pudimos viajar por la hermosa Bolivia. ¡Realmente recomiendo a todos hacer un intercambio internacional!",
      },
    ],
  },
  en: {
    title: "Student experiences",
    text: "Real stories about academic mobility, international cooperation, and opportunities that transform university life.",
    button: "View programs",
    comments: [
      {
        name: "Naïs Mampaey",
        role: "Exchange student",
        country: "Belgium",
        image: "/images/testimonials/mais.jpg",
        comment:
          "I did a medical internship in Bolivia for two months, one month pediatrics and one month gynecology. In the internship we met a lot of friendly interns and doctors who were passionate about their jobs. It was interesting to see the differences between the healthcare in Bolivia and Belgium. In the weekends we travelled, we saw a lot of beautiful places like Salar de Uyuni, Sucre, Potosí, Toro Toro, La Paz and Trinidad. Bolivia really has everything!",
      },
      {
        name: "Wannes Loobuyck",
        role: "Exchange student",
        country: "Belgium",
        image: "/images/testimonials/wannes.jpg",
        comment:
          "I came to Bolivia as an exchange student to do internship in the hospital and it was totally worth it! The people here are very friendly and they like to help you everytime. In the hospital we saw many pathologies we dont see in Belgium. We also really liked the food here, muy rico!!! Gracias Bolivia!",
      },
      {
        name: "Kato Vandoorne",
        role: "Exchange student",
        country: "Belgium",
        image: "/images/testimonials/kato.jpg",
        comment:
          "I did a two month medical internship in two different hospitals in Cochabamba. It was very interesting to see the differences with the hospitals in Belgium. The exchange was also a very nice experience outside of the hospital. We met a lot of friendly people, ate good local food and could travel in the beautiful Bolivia. I really recommend everyone to do an international exchange!",
      },
    ],
  },
};

export default function StudentExperiencesSection({ locale }: Props) {
  const t = content[locale] ?? content.es;
  const carouselRef = useRef<HTMLDivElement>(null);
  const [canScrollLeft, setCanScrollLeft] = useState(false);
  const [canScrollRight, setCanScrollRight] = useState(false);

  const updateScrollControls = useCallback(() => {
    const carousel = carouselRef.current;

    if (!carousel) {
      return;
    }

    const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;
    setCanScrollLeft(carousel.scrollLeft > 8);
    setCanScrollRight(carousel.scrollLeft < maxScrollLeft - 8);
  }, []);

  useEffect(() => {
    updateScrollControls();

    const carousel = carouselRef.current;

    if (!carousel) {
      return;
    }

    carousel.addEventListener("scroll", updateScrollControls, { passive: true });
    window.addEventListener("resize", updateScrollControls);

    return () => {
      carousel.removeEventListener("scroll", updateScrollControls);
      window.removeEventListener("resize", updateScrollControls);
    };
  }, [updateScrollControls]);

  const scrollTestimonials = (direction: "left" | "right") => {
    const carousel = carouselRef.current;

    if (!carousel) {
      return;
    }

    carousel.scrollBy({
      left: direction === "right" ? carousel.clientWidth * 0.82 : -carousel.clientWidth * 0.82,
      behavior: "smooth",
    });
  };

  return (
    <section className="bg-[#020617] px-4 py-16 text-white sm:px-6 md:py-24">
      <div className="mx-auto max-w-7xl">
        <div className="grid items-center gap-8 md:gap-12 lg:grid-cols-2">
          <div className="relative h-[240px] overflow-hidden rounded-2xl border border-white/10 bg-white/5 sm:h-[320px] md:h-[360px] md:rounded-3xl">
            <Image
              src="/images/home/student-experience.png"
              alt={t.title}
              fill
              className="object-cover"
            />
          </div>

          <div className="min-w-0">
            <h2 className="max-w-xl text-3xl font-light leading-tight tracking-wide sm:text-4xl md:text-5xl">
              {t.title}
            </h2>
            <p className="mt-4 max-w-xl text-base leading-relaxed text-white/60 sm:text-lg md:mt-6 md:text-xl">
              {t.text}
            </p>
            <a
              href={`/${locale}/becas-movilidad`}
              className="mt-6 inline-flex rounded-2xl border border-white/40 px-6 py-3 text-sm font-medium text-white shadow-[0_0_30px_rgba(255,255,255,0.25)] transition hover:bg-white hover:text-slate-950 md:mt-8 md:px-7 md:py-4"
            >
              {t.button}
            </a>
          </div>
        </div>

        <div className="relative mt-6 md:mt-12">
          {canScrollLeft ? (
            <button
              type="button"
              onClick={() => scrollTestimonials("left")}
              className="dric-testimonials-arrow dric-testimonials-arrow-left absolute top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/12 text-white shadow-2xl shadow-black/30 backdrop-blur-xl transition hover:scale-105 hover:border-cyan-200/70 hover:bg-cyan-200/18 md:h-11 md:w-11"
              aria-label={locale === "en" ? "Show previous testimonial" : "Ver testimonio anterior"}
            >
              <ChevronLeft className="h-6 w-6" />
            </button>
          ) : null}

          <div
            ref={carouselRef}
            className="dric-testimonials-carousel flex snap-x snap-mandatory gap-5 overflow-x-auto px-1 pb-4 pt-10 md:gap-8 md:px-2 md:pt-14"
          >
            {t.comments.map((item) => (
              <article
                key={item.name}
                className="flex min-w-[86%] snap-center flex-col rounded-2xl border border-white/10 bg-white/[0.03] p-5 shadow-2xl transition duration-300 hover:-translate-y-3 hover:border-cyan-200/35 hover:bg-white/[0.05] sm:min-w-[68%] sm:p-7 md:min-w-[560px] md:rounded-3xl md:p-10 lg:min-w-[620px]"
            >
              <div className="mb-6 h-14 w-14 overflow-hidden rounded-full bg-gradient-to-br from-white/30 to-white/5 md:mb-8 md:h-20 md:w-20">
                {"image" in item && item.image ? (
                  <Image
                    src={item.image}
                    alt={item.name}
                    width={80}
                    height={80}
                    className="h-full w-full object-cover"
                  />
                ) : null}
              </div>
              <h3 className="text-xl font-semibold leading-tight sm:text-2xl md:text-3xl">{item.name}</h3>
              <p className="mt-2 text-white/45">{item.role}</p>
              <span className="dric-testimonials-country mt-4 inline-flex self-start rounded-full border border-cyan-200/20 bg-cyan-200/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-cyan-100 shadow-[0_0_24px_rgba(103,232,249,0.08)] backdrop-blur">
                {item.country}
              </span>
              <div className="my-6 h-px bg-white/10" />
              <p className="dric-testimonials-quote text-justify text-sm leading-relaxed text-white/65 sm:text-base md:text-lg">
                “{item.comment}”
              </p>
              <p className="dric-testimonials-rating mt-auto pt-6 text-lg md:pt-8 md:text-xl">
                <span className="dric-testimonials-rating-score">5.0</span>{" "}
                <span className="dric-testimonials-rating-stars">★★★★★</span>
              </p>
            </article>
            ))}
          </div>

          {canScrollRight ? (
            <button
              type="button"
              onClick={() => scrollTestimonials("right")}
              className="dric-testimonials-arrow dric-testimonials-arrow-right absolute top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/12 text-white shadow-2xl shadow-black/30 backdrop-blur-xl transition hover:scale-105 hover:border-cyan-200/70 hover:bg-cyan-200/18 md:h-11 md:w-11"
              aria-label={locale === "en" ? "Show next testimonial" : "Ver siguiente testimonio"}
            >
              <ChevronRight className="h-6 w-6" />
            </button>
          ) : null}
        </div>
      </div>
    </section>
  );
}
