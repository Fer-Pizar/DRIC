"use client";

import Image from "next/image";
import Link from "next/link";
import { X } from "lucide-react";
import { useLocale } from "next-intl";
import { useEffect } from "react";

type MobileMenuProps = {
  open: boolean;
  onClose: () => void;
};

const menuItems = [
  { label: { es: "Inicio", en: "Home" }, href: "inicio", description: { es: "Página principal", en: "Main page" } },
  { label: { es: "Presentación", en: "Presentation" }, href: "presentacion", description: { es: "Historia, misión y estructura", en: "History, mission and structure" } },
  { label: { es: "Convenios", en: "Agreements" }, href: "convenios", description: { es: "Relaciones institucionales", en: "Institutional relations" } },
  { label: { es: "Proyectos", en: "Projects" }, href: "proyectos", description: { es: "Cooperación y financiamiento", en: "Cooperation and funding" } },
  { label: { es: "Becas y Movilidad", en: "Scholarships and Mobility" }, href: "becas-movilidad", description: { es: "Oportunidades internacionales", en: "International opportunities" } },
  { label: { es: "Membresías", en: "Memberships" }, href: "membresias", description: { es: "Redes académicas globales", en: "Global academic networks" } },
  { label: { es: "Noticias", en: "News" }, href: "noticias", description: { es: "Actualidad institucional", en: "Institutional updates" } },
  { label: { es: "Normativas", en: "Regulations" }, href: "normativas", description: { es: "Documentos y normativa", en: "Documents and regulations" } },
  { label: { es: "Informes de Gestión", en: "Management Reports" }, href: "informes-gestion", description: { es: "Archivo institucional", en: "Institutional archive" } },
  { label: { es: "Campus Life", en: "Campus Life" }, href: "campus-life", description: { es: "Vida universitaria UMSS", en: "UMSS university life" } },
  { label: { es: "Verificar Certificado", en: "Verify Certificate" }, href: "validar-certificado", description: { es: "Validación institucional", en: "Institutional validation" } },
  { label: { es: "Contacto", en: "Contact" }, href: "contacto", description: { es: "Ubicación y canales", en: "Location and channels" } },
];

export default function MobileMenu({ open, onClose }: MobileMenuProps) {
  const locale = useLocale() as "es" | "en";

  useEffect(() => {
    if (!open) {
      return;
    }

    const previousOverflow = document.body.style.overflow;
    document.body.style.overflow = "hidden";

    return () => {
      document.body.style.overflow = previousOverflow;
    };
  }, [open]);

  if (!open) return null;

  return (
    <div className="dric-mobile-menu fixed inset-0 z-[999] h-dvh overflow-y-auto text-white backdrop-blur-2xl xl:overflow-hidden">

      <div className="relative mx-auto flex min-h-dvh w-full max-w-6xl flex-col px-5 py-5 sm:px-7 md:px-10 xl:h-dvh xl:min-h-0">
        <div className="dric-mobile-menu-header flex items-center justify-between gap-4 pb-5">
          <Link href={`/${locale}/inicio`} onClick={onClose} className="flex min-w-0 items-center gap-3 no-underline sm:gap-4">
            <div className="dric-mobile-menu-logo relative h-12 w-12 shrink-0 overflow-hidden rounded-full bg-gray p-0.5 shadow-2xl shadow-cyan-400/10 sm:h-14 sm:w-14">
              <Image src="/images/brand/DRIC_logo.png" alt="DRIC" fill className="object-contain p-1" />
            </div>

            <div className="min-w-0">
              <p className="dric-mobile-menu-brand text-[0.65rem] font-bold uppercase tracking-[0.28em] text-cyan-300 sm:text-xs sm:tracking-[0.35em]">
                DRIC · UMSS
              </p>
              <p className="dric-mobile-menu-subtitle mt-1 truncate text-[0.72rem] text-white/55 sm:text-sm">
                {locale === "en" ? "International Relations and Agreements" : "Dirección de Relaciones Internacionales y Convenios"}
              </p>
            </div>
          </Link>

          <button
            type="button"
            onClick={onClose}
            className="dric-mobile-menu-close flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20 sm:h-11 sm:w-11"
            aria-label="Close menu"
          >
            <X className="h-6 w-6" />
          </button>
        </div>

        <div className="grid flex-1 items-start gap-5 pt-10 pb-6 lg:grid-cols-[0.88fr_1.12fr] lg:gap-8">
          <div className="dric-mobile-menu-feature rounded-[1.7rem] border border-white/10 bg-white/10 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl lg:block xl:p-7">
            <p className="dric-mobile-menu-kicker text-xs font-bold uppercase tracking-[0.28em] text-[#E30613]">
              {locale === "en" ? "Explore DRIC" : "Explora DRIC"}
            </p>

            <h2 className="dric-mobile-menu-title mt-4 text-4xl font-light uppercase leading-[0.95] tracking-[-0.07em] sm:text-5xl lg:text-4xl xl:text-5xl">
              {locale === "en" ? "Global UMSS" : "UMSS Global"}
            </h2>

            <p className="dric-mobile-menu-copy mt-4 text-sm leading-7 text-white/62">
              {locale === "en"
                ? "Navigate through institutional information, agreements, projects, scholarships, reports, campus life, certificate verification and contact channels."
                : "Navega por información institucional, convenios, proyectos, becas, informes, vida universitaria, verificación de certificados y canales de contacto."}
            </p>
          </div>

          <nav className="grid grid-cols-1 gap-2.5 sm:grid-cols-2 xl:auto-rows-[5.7rem]">
            {menuItems.map((item) => (
              <Link
                key={item.href}
                href={`/${locale}/${item.href}`}
                onClick={onClose}
                className="dric-mobile-menu-link group flex min-h-[5.7rem] flex-col justify-center overflow-hidden rounded-[1.35rem] border border-white/10 bg-white/[0.055] px-5 py-3 no-underline transition hover:-translate-y-0.5 hover:border-white/25 hover:bg-white/[0.09] xl:min-h-[5.5rem]"
              >
                <p className="dric-mobile-menu-link-title text-xl font-light uppercase leading-[0.95] tracking-[-0.035em] text-white sm:text-2xl xl:text-[1.55rem]">  
                  {item.label[locale]}
                </p>

                <span className="dric-mobile-menu-link-description mt-2 block truncate text-[0.67rem] font-semibold uppercase leading-none tracking-[0.18em] text-white/38 no-underline decoration-transparent group-hover:text-cyan-300">
                  {item.description[locale]}
                </span>
              </Link>
            ))}
          </nav>
        </div>

        <div className="dric-mobile-menu-footer pb-1 text-[0.65rem] uppercase tracking-[0.2em] text-white/35 sm:text-xs xl:absolute xl:bottom-5 xl:left-10 xl:z-10 xl:pb-0">
          Universidad Mayor de San Simón · DRIC
        </div>
      </div>
    </div>
  );
}
