"use client";

import Image from "next/image";
import Link from "next/link";
import { useEffect, useState } from "react";
import { Menu, Moon, Sun, Languages } from "lucide-react";
import { useLocale, useTranslations } from "next-intl";
import { usePathname, useRouter } from "next/navigation";
import MobileMenu from "./MobileMenu";

export default function Header() {
  const [open, setOpen] = useState(false);
  const [theme, setTheme] = useState<"dark" | "light">("dark");

  const t = useTranslations("nav");
  const locale = useLocale();
  const pathname = usePathname();
  const router = useRouter();

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

  useEffect(() => {
    const savedTheme = localStorage.getItem("dric-theme") as "dark" | "light" | null;
    const initialTheme = savedTheme ?? "dark";

    setTheme(initialTheme);
    document.documentElement.dataset.theme = initialTheme;
  }, []);

  const toggleTheme = () => {
    const nextTheme = theme === "dark" ? "light" : "dark";

    setTheme(nextTheme);
    localStorage.setItem("dric-theme", nextTheme);
    document.documentElement.dataset.theme = nextTheme;
  };

  const toggleLanguage = () => {
    const nextLocale = locale === "es" ? "en" : "es";

    const nextPath = pathname.startsWith(`/${locale}`)
      ? pathname.replace(`/${locale}`, `/${nextLocale}`)
      : `/${nextLocale}/inicio`;

    router.push(nextPath);
  };

  return (
    <>
      <header className="fixed inset-x-0 top-0 z-50">
        <div className="mx-auto mt-4 flex max-w-7xl items-center justify-between rounded-full border border-white/10 bg-[#020617]/75 px-5 py-3 shadow-2xl shadow-black/25 backdrop-blur-xl md:px-7">
          <Link href={`/${locale}/inicio`} className="flex items-center">
            <Image
              src="/images/brand/DRIC_logo.png"
              alt="DRIC"
              width={70}
              height={70}
              priority
              className="h-auto w-[58px] object-contain md:w-[62px]"
            />
          </Link>

          <div className="flex items-center gap-2">
            <button
              type="button"
              onClick={toggleLanguage}
              className="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20"
              aria-label="Change language"
              title={locale === "es" ? "Change to English" : "Cambiar a español"}
            >
              <Languages className="h-5 w-5" />
            </button>

            <button
              type="button"
              onClick={toggleTheme}
              className="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20"
              aria-label="Change theme"
              title={theme === "dark" ? "Change to light mode" : "Change to dark mode"}
            >
              {theme === "dark" ? <Sun className="h-5 w-5" /> : <Moon className="h-5 w-5" />}
            </button>

            <button
              type="button"
              onClick={() => setOpen(true)}
              className="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20"
              aria-label="Open menu"
            >
              <Menu className="h-6 w-6" />
            </button>
          </div>
        </div>
      </header>

      <MobileMenu open={open} onClose={() => setOpen(false)} items={items} />
    </>
  );
}