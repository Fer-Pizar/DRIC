"use client";

import { useMemo, useState } from "react";
import Link from "next/link";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import { Search, X } from "lucide-react";

type Locale = "es" | "en";

type Agreement = {
  es: string;
  en: string;
  href: string;
};

type Props = {
  agreements: Agreement[];
  locale: Locale;
  noResults: string;
  searchLabel: string;
  searchPlaceholder: string;
};

export default function OtherAgreementsList({
  agreements,
  locale,
  noResults,
  searchLabel,
  searchPlaceholder,
}: Props) {
  const [query, setQuery] = useState("");
  const normalizedQuery = query.trim().toLocaleLowerCase();

  const filteredAgreements = useMemo(() => {
    if (!normalizedQuery) {
      return agreements.map((agreement, index) => ({ agreement, index }));
    }

    return agreements
      .map((agreement, index) => ({ agreement, index }))
      .filter(({ agreement }) => agreement[locale].toLocaleLowerCase().includes(normalizedQuery));
  }, [agreements, locale, normalizedQuery]);

  return (
    <>
      <div className="dric-other-agreements-search mt-12 flex items-center gap-4 rounded-[28px] px-5 py-4 backdrop-blur-2xl md:mt-16 md:px-6">
        <Search className="h-5 w-5 shrink-0" aria-hidden="true" />
        <label className="sr-only" htmlFor="agreement-search">
          {searchLabel}
        </label>
        <input
          id="agreement-search"
          type="search"
          value={query}
          onChange={(event) => setQuery(event.target.value)}
          placeholder={searchPlaceholder}
          className="dric-other-agreements-search-input min-w-0 flex-1 bg-transparent text-base font-semibold outline-none md:text-lg"
        />
        {query ? (
          <button
            type="button"
            onClick={() => setQuery("")}
            className="dric-other-agreements-search-clear inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full transition"
            aria-label={locale === "es" ? "Limpiar búsqueda" : "Clear search"}
          >
            <X className="h-4 w-4" aria-hidden="true" />
          </button>
        ) : null}
      </div>

      <div className="dric-other-agreements-list mt-6 overflow-hidden rounded-[30px] backdrop-blur-2xl">
        {filteredAgreements.length ? (
          filteredAgreements.map(({ agreement, index }) => (
            <Link
              key={agreement.href}
              href={agreement.href}
              className="dric-other-agreement-row group relative block px-5 py-6 transition duration-300 sm:px-7 md:px-8"
            >
              <div className="flex items-start gap-4 md:gap-6">
                <div className="dric-other-agreement-icon mt-1 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl transition duration-300">
                  <DescriptionRoundedIcon sx={{ fontSize: 23 }} />
                </div>

                <div className="min-w-0 flex-1">
                  <div className="flex items-center gap-3">
                    <span className="dric-other-agreement-number text-xs font-black uppercase tracking-[0.18em] transition duration-300">
                      {String(index + 1).padStart(2, "0")}
                    </span>
                    <span className="dric-other-agreement-rule h-px flex-1 transition duration-300" />
                  </div>

                  <div className="mt-3 flex min-w-0 items-start">
                    <h2 className="dric-other-agreement-title text-base font-semibold leading-7 transition duration-300 md:text-lg md:leading-8">
                      {agreement[locale]}
                    </h2>
                  </div>
                </div>
              </div>
            </Link>
          ))
        ) : (
          <div className="px-5 py-10 text-center sm:px-7 md:px-8">
            <p className="dric-other-agreements-muted text-base font-semibold">{noResults}</p>
          </div>
        )}
      </div>
    </>
  );
}
