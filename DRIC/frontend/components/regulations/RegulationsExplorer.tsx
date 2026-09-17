"use client";

import { useMemo, useState } from "react";
import ArticleRoundedIcon from "@mui/icons-material/ArticleRounded";
import DownloadRoundedIcon from "@mui/icons-material/DownloadRounded";
import KeyboardArrowDownRoundedIcon from "@mui/icons-material/KeyboardArrowDownRounded";
import SearchRoundedIcon from "@mui/icons-material/SearchRounded";
import TuneRoundedIcon from "@mui/icons-material/TuneRounded";
import type { RegulationItem } from "@/lib/regulations/regulationsCatalog";

type Props = {
  locale: string;
  regulations: RegulationItem[];
};

const labels = {
  es: {
    search: "Buscar por código, título o categoría...",
    all: "Todas",
    category: "Categoría",
    download: "Descargar PDF",
    empty: "No se encontraron normativas con esos filtros.",
    count: "documentos disponibles",
    groups: {
      primero: "Primero",
      segundo: "Segundo",
      tercero: "Tercero",
    },
  },
  en: {
    search: "Search by code, title, or category...",
    all: "All",
    category: "Category",
    download: "Download PDF",
    empty: "No regulations were found with those filters.",
    count: "available documents",
    groups: {
      primero: "First",
      segundo: "Second",
      tercero: "Third",
    },
  },
};

const categoryOrder = ["primero", "segundo", "tercero"] as const;

export default function RegulationsExplorer({ locale, regulations }: Props) {
  const language = locale === "en" ? "en" : "es";
  const t = labels[language];
  const [query, setQuery] = useState("");
  const [category, setCategory] = useState<"all" | RegulationItem["categoryKey"]>("all");

  const filteredRegulations = useMemo(() => {
    const normalizedQuery = query.trim().toLowerCase();

    return regulations.filter((item) => {
      const matchesCategory = category === "all" || item.categoryKey === category;
      const matchesQuery =
        normalizedQuery.length === 0 ||
        `${item.code} ${item.title} ${item.category}`.toLowerCase().includes(normalizedQuery);

      return matchesCategory && matchesQuery;
    });
  }, [category, query, regulations]);

  return (
    <div className="dric-regulations-panel mt-16 rounded-[2rem] border border-white/10 bg-white/[0.04] p-5 shadow-2xl backdrop-blur-xl md:p-7">
      <div className="dric-regulations-toolbar grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
        <label className="dric-regulations-input flex items-center rounded-full border border-white/10 bg-white/[0.04] px-5 py-4">
          <SearchRoundedIcon sx={{ color: "#67e8f9", mr: 1.5, fontSize: 22 }} />
          <input
            value={query}
            onChange={(event) => setQuery(event.target.value)}
            placeholder={t.search}
            className="dric-regulations-search-field w-full bg-transparent text-sm text-white outline-none placeholder:text-white/35"
          />
        </label>

        <label className="dric-regulations-filter-menu flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.04] px-4 py-3">
          <span className="flex items-center text-white/55">
            <TuneRoundedIcon sx={{ fontSize: 16 }} />
          </span>
          <span className="relative inline-flex min-w-[170px] items-center">
            <select
              value={category}
              onChange={(event) =>
                setCategory(event.target.value as "all" | RegulationItem["categoryKey"])
              }
              aria-label={t.category}
              className="dric-regulations-category-select w-full appearance-none bg-transparent pr-8 text-xs font-bold uppercase tracking-[0.18em] text-white outline-none"
            >
              <option value="all">{t.all}</option>
              {categoryOrder.map((key) => (
                <option key={key} value={key}>
                  {t.groups[key]}
                </option>
              ))}
            </select>
            <KeyboardArrowDownRoundedIcon
              className="pointer-events-none absolute right-0"
              sx={{ fontSize: 20 }}
            />
          </span>
        </label>
      </div>

      <div className="mt-7 flex items-center justify-between gap-4 border-y border-white/10 py-4">
        <p className="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-200">
          {filteredRegulations.length} {t.count}
        </p>
      </div>

      <div className="mt-7 grid gap-4">
        {filteredRegulations.map((item) => (
          <article
            key={item.id}
            className="dric-regulations-card group relative overflow-hidden rounded-[1.5rem] border border-white/10 bg-white/[0.035] p-5 transition duration-300 hover:-translate-y-1 hover:border-cyan-200/45 hover:bg-white/[0.06] md:p-6"
          >
            <div className="absolute inset-x-6 top-0 h-px bg-gradient-to-r from-transparent via-cyan-200/70 to-transparent" />

            <div className="grid gap-5 lg:grid-cols-[170px_1fr_auto] lg:items-center">
              <div>
                <p className="text-xs font-bold uppercase tracking-[0.24em] text-cyan-200">
                  {item.code}
                </p>
                <a
                  href={item.categoryUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="dric-regulations-category mt-4 inline-flex rounded-full border border-[#E30613]/25 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-[#E30613] transition hover:border-[#E30613]/55"
                >
                  {item.category}
                </a>
              </div>

              <div className="flex gap-4">
                <div className="dric-regulations-icon mt-1 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.05] text-cyan-200">
                  <ArticleRoundedIcon sx={{ fontSize: 23 }} />
                </div>
                <h2 className="text-lg font-semibold leading-snug text-white/88 md:text-xl">
                  {item.title}
                </h2>
              </div>

              <div className="flex flex-wrap gap-3 lg:justify-end">
                <a
                  href={item.downloadUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="dric-regulations-download"
                >
                  <DownloadRoundedIcon sx={{ fontSize: 18 }} />
                  {t.download}
                </a>
              </div>
            </div>
          </article>
        ))}
      </div>

      {filteredRegulations.length === 0 ? (
        <p className="mt-8 rounded-3xl border border-white/10 bg-white/[0.04] p-6 text-center text-white/60">
          {t.empty}
        </p>
      ) : null}
    </div>
  );
}
