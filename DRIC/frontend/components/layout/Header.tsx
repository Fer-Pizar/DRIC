"use client";

import Image from "next/image";
import { useState } from "react";
import { Menu } from "lucide-react";
import { useTranslations } from "next-intl";
import MobileMenu from "./MobileMenu";

export default function Header() {
  const [open, setOpen] = useState(false);
  const t = useTranslations("nav");

  const items = [
    t("home"),
    t("presentation"),
    t("agreements"),
    t("projects"),
    t("mobility"),
    t("memberships"),
    t("events"),
    t("regulations"),
    t("reports"),
    t("contact"),
  ];

  return (
    <>
      <header className="fixed inset-x-0 top-0 z-50">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 md:px-8 lg:px-12">
          <a href="/es/inicio" className="flex items-center">
            <Image
              src="/images/brand/DRIC_logo.png"
              alt="DRIC"
              width={70}
              height={70}
              priority
              className="h-auto w-[78px] object-contain md:w-[78px]"
            />
          </a>

          <button
            type="button"
            onClick={() => setOpen(true)}
            className="rounded-xl p-2 text-white/90 transition hover:bg-white/5"
            aria-label="Open menu"
          >
            <Menu className="h-8 w-8" />
          </button>
        </div>
      </header>

      <MobileMenu open={open} onClose={() => setOpen(false)} items={items} />
    </>
  );
}