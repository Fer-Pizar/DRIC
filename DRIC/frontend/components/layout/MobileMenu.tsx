"use client";

import Image from "next/image";
import Link from "next/link";
import { X } from "lucide-react";
import { useLocale } from "next-intl";

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
  { label: { es: "Contacto", en: "Contact" }, href: "contacto", description: { es: "Ubicación y canales", en: "Location and channels" } },
];

export default function MobileMenu({ open, onClose }: MobileMenuProps) {
  const locale = useLocale() as "es" | "en";

  if (!open) return null;

  return (
    <div className="fixed inset-0 z-[999] overflow-y-auto bg-[#020617]/96 text-white backdrop-blur-2xl">
      <div className="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.28),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(22,65,148,0.34),transparent_36%)]" />

      <div className="relative mx-auto flex min-h-screen max-w-7xl flex-col px-6 py-7 md:px-10 lg:px-12">
        <div className="flex items-center justify-between border-b border-white/10 pb-6">
          <Link href={`/${locale}/inicio`} onClick={onClose} className="flex items-center gap-4">
            <div className="relative h-16 w-16 overflow-hidden rounded-full bg-white p-1.5 shadow-2xl shadow-cyan-400/10">
              <Image
                src="/images/brand/DRIC_logo.png"
                alt="DRIC"
                fill
                className="object-contain p-1"
              />
            </div>

            <div>
              <p className="text-xs font-bold uppercase tracking-[0.35em] text-cyan-300">
                DRIC · UMSS
              </p>
              <p className="mt-1 text-sm text-white/55">
                {locale === "en" ? "International Relations and Agreements" : "Relaciones Internacionales y Convenios"}
              </p>
            </div>
          </Link>

          <button
            type="button"
            onClick={onClose}
            className="flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20"
            aria-label="Close menu"
          >
            <X className="h-7 w-7" />
          </button>
        </div>

        <div className="grid flex-1 gap-10 py-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
          <div className="hidden rounded-[2rem] border border-white/10 bg-white/10 p-8 shadow-2xl shadow-black/20 backdrop-blur-xl lg:block">
            <p className="text-sm font-bold uppercase tracking-[0.28em] text-[#ef4444]">
              {locale === "en" ? "Explore DRIC" : "Explora DRIC"}
            </p>

            <h2 className="mt-6 text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em]">
              {locale === "en" ? "Global UMSS" : "UMSS Global"}
            </h2>

            <p className="mt-6 text-sm leading-7 text-white/62">
              {locale === "en"
                ? "Navigate through institutional information, agreements, projects, scholarships, reports, campus life and contact channels."
                : "Navega por información institucional, convenios, proyectos, becas, informes, vida universitaria y canales de contacto."}
            </p>
          </div>

          <nav className="grid gap-3 md:grid-cols-2">
            {menuItems.map((item) => (
              <Link
                key={item.href}
                href={`/${locale}/${item.href}`}
                onClick={onClose}
                className="group rounded-[1.5rem] border border-white/10 bg-white/[0.055] p-5 transition hover:-translate-y-0.5 hover:border-white/25 hover:bg-white/[0.09]"
              >
                <p className="text-2xl font-light uppercase tracking-[-0.04em] text-white md:text-3xl">
                  {item.label[locale]}
                </p>
                <p className="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/38 group-hover:text-cyan-300">
                  {item.description[locale]}
                </p>
              </Link>
            ))}
          </nav>
        </div>

        <div className="border-t border-white/10 pt-5 text-xs uppercase tracking-[0.22em] text-white/35">
          Universidad Mayor de San Simón · DRIC
        </div>
      </div>
    </div>
  );
}