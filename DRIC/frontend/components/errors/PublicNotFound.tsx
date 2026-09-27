"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { ArrowLeft, Home } from "lucide-react";

export default function PublicNotFound() {
  const pathname = usePathname();
  const isEnglish = pathname?.startsWith("/en") ?? false;
  const homeHref = isEnglish ? "/en/inicio" : "/es/inicio";
  const copy = isEnglish
    ? {
        imageAlt: "DRIC robot with low battery",
        title: "Oops, that page was not found.",
        description:
          "The address may be incomplete, the link may have changed, or the page may no longer be available. You can return to the homepage and continue browsing the DRIC website.",
        back: "Go back",
        home: "Go to homepage",
      }
    : {
        imageAlt: "Robotcito DRIC sin batería",
        title: "Oops, no se encontró esa página.",
        description:
          "La dirección puede estar incompleta, el enlace pudo cambiar o la página ya no está disponible. Puedes volver al inicio y continuar navegando por el sitio DRIC.",
        back: "Volver atrás",
        home: "Ir al inicio",
      };

  return (
    <main className="relative min-h-screen overflow-hidden bg-[#f5f8fd] text-slate-950">
      <div className="absolute inset-0 bg-[radial-gradient(circle_at_18%_16%,rgba(0,55,112,0.14),transparent_32rem),radial-gradient(circle_at_86%_80%,rgba(227,6,19,0.09),transparent_30rem),linear-gradient(180deg,#ffffff_0%,#edf3fa_100%)]" />

      <section className="relative mx-auto grid min-h-screen w-full max-w-7xl items-center gap-10 px-6 py-10 md:grid-cols-[0.96fr_1.04fr] md:px-10 lg:px-14">
        <div className="flex min-h-[360px] items-center justify-center p-8 md:min-h-[620px] lg:p-12">
          <div className="relative flex aspect-square w-full max-w-[470px] items-center justify-center">
            <div className="absolute inset-8 rounded-full bg-white/20 blur-3xl" aria-hidden="true" />
            <img
              className="relative z-10 h-full max-h-[430px] w-full object-contain drop-shadow-[0_30px_42px_rgba(15,23,42,0.22)]"
              src="/images/errors/robotcito-dric.png"
              alt={copy.imageAlt}
            />
          </div>
        </div>

        <div className="flex flex-col justify-center p-7 md:min-h-[620px] md:p-12 lg:p-16">
          <h1 className="max-w-2xl text-4xl font-black leading-[1.05] tracking-normal text-slate-950 sm:text-5xl lg:text-6xl">
            {copy.title}
          </h1>

          <p className="mt-7 max-w-2xl text-lg font-semibold leading-8 text-slate-600">
            {copy.description}
          </p>

          <div className="mt-10 grid gap-4 sm:grid-cols-2">
            <button
              type="button"
              onClick={() => history.back()}
              className="inline-flex min-h-14 items-center justify-center gap-3 rounded-2xl border border-[#d7e3f4] bg-[#eef3fb] px-5 text-base font-black text-[#003770] transition hover:-translate-y-0.5 hover:border-[#b9cbe4] hover:shadow-xl"
            >
              <ArrowLeft aria-hidden="true" className="h-5 w-5" strokeWidth={2.4} />
              {copy.back}
            </button>

            <Link
              href={homeHref}
              className="inline-flex min-h-14 items-center justify-center gap-3 rounded-2xl bg-[#003770] px-5 text-base font-black text-white shadow-[0_18px_34px_rgba(0,55,112,0.25)] transition hover:-translate-y-0.5 hover:bg-[#0a4d91] hover:shadow-[0_22px_42px_rgba(0,55,112,0.3)]"
            >
              <Home aria-hidden="true" className="h-5 w-5" strokeWidth={2.4} />
              {copy.home}
            </Link>
          </div>
        </div>
      </section>
    </main>
  );
}
