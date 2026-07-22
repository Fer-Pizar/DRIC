"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import type { MouseEvent } from "react";
import { useEffect, useState } from "react";
import { Menu, Moon, Sun, Languages } from "lucide-react";
import { useLocale } from "next-intl";
import MobileMenu from "./MobileMenu";

export default function Header() {
  const [open, setOpen] = useState(false);
  const [theme, setTheme] = useState<"dark" | "light">("dark");

  const locale = useLocale();
  const pathname = usePathname();
  const router = useRouter();
  const homePath = `/${locale}/inicio`;

  useEffect(() => {
    const savedTheme = localStorage.getItem("dric-theme") as "dark" | "light" | null;
    const initialTheme = savedTheme ?? "dark";

    queueMicrotask(() => setTheme(initialTheme));
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

  const handleLogoClick = (event: MouseEvent<HTMLAnchorElement>) => {
    if (pathname === homePath) {
      event.preventDefault();
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };

  return (
    <>
      <header className="dric-site-header fixed inset-x-0 top-0 z-50 px-4 md:px-6">
        <div className="dric-site-header-shell mx-auto mt-4 flex w-full max-w-7xl items-center justify-between rounded-full border border-white/10 bg-[#001935]/75 px-4 py-2.5 shadow-2xl shadow-black/25 backdrop-blur-xl sm:px-5 sm:py-3 md:px-7">
          <Link href={homePath} onClick={handleLogoClick} className="flex items-center">
            <Image
              src="/images/brand/DRIC_logo.png"
              alt="DRIC"
              width={70}
              height={70}
              priority
              className="h-auto w-[48px] object-contain sm:w-[58px] md:w-[62px]"
            />
          </Link>

          <div className="flex items-center gap-1.5 sm:gap-2">
            <button
              type="button"
              onClick={toggleLanguage}
              className="dric-site-header-button inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20 sm:h-10 sm:w-10"
              aria-label={locale === "es" ? "Change to English" : "Cambiar a español"}
              title={locale === "es" ? "Change to English" : "Cambiar a español"}
            >
              <Languages className="h-5 w-5" />
            </button>

            <button
              type="button"
              onClick={toggleTheme}
              className="dric-site-header-button inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20 sm:h-10 sm:w-10"
              aria-label={theme === "dark" ? "Change to light mode" : "Change to dark mode"}
              title={theme === "dark" ? "Change to light mode" : "Change to dark mode"}
            >
              {theme === "dark" ? <Sun className="h-5 w-5" /> : <Moon className="h-5 w-5" />}
            </button>

            <button
              type="button"
              onClick={() => setOpen(true)}
              className="dric-site-header-button inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/10 text-white transition hover:bg-white/20 sm:h-10 sm:w-10"
              aria-label="Open menu"
              title="Open menu"
            >
              <Menu className="h-6 w-6" />
            </button>
          </div>
        </div>
      </header>

      <MobileMenu open={open} onClose={() => setOpen(false)} />
    </>
  );
}
