"use client";

import { useMemo, useState } from "react";
import Link from "next/link";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import Chip from "@mui/material/Chip";
import SearchRoundedIcon from "@mui/icons-material/SearchRounded";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";

type NewsItem = {
  title: string;
  date: string;
  category: string;
  excerpt: string;
};

type Props = {
  locale: string;
  news: NewsItem[];
};

export default function NewsExplorer({ locale, news }: Props) {
  const [query, setQuery] = useState("");

  const filteredNews = useMemo(() => {
    return news.filter((item) =>
      `${item.title} ${item.category} ${item.excerpt}`
        .toLowerCase()
        .includes(query.toLowerCase())
    );
  }, [query, news]);

  return (
    <section className="relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
      <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.22),transparent_34%),radial-gradient(circle_at_center_right,rgba(22,65,148,0.30),transparent_38%),linear-gradient(145deg,#020617_0%,#07111f_50%,#12070a_100%)]" />
      <div className="absolute right-[-9rem] top-16 -z-10 h-[430px] w-[430px] rounded-full bg-cyan-300/10 blur-[135px]" />

      <div className="mx-auto max-w-7xl">
        <div className="mb-12 grid gap-8 lg:grid-cols-[1fr_0.75fr] lg:items-end">
          <div>
            <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#b5121b]">
              {locale === "en" ? "Explore" : "Explorar"}
            </p>
            <h2 className="mt-4 text-4xl font-semibold tracking-[-0.04em] md:text-5xl">
              {locale === "en" ? "Latest institutional updates" : "Últimas noticias institucionales"}
            </h2>
          </div>

          <div className="flex items-center rounded-full border border-white/10 bg-white/[0.06] px-5 py-3 shadow-2xl shadow-black/20 backdrop-blur-xl">
            <SearchRoundedIcon sx={{ color: "#164194", mr: 1.5 }} />
            <input
              value={query}
              onChange={(event) => setQuery(event.target.value)}
              placeholder={locale === "en" ? "Search news..." : "Buscar noticias..."}
              className="w-full bg-transparent text-sm text-white outline-none placeholder:text-white/42"
            />
          </div>
        </div>

        <div className="grid gap-7 lg:grid-cols-3">
          {filteredNews.map((item, index) => (
            <Card
              key={item.title}
              sx={{
                borderRadius: "32px",
                overflow: "hidden",
                background: "rgba(255,255,255,0.06)",
                border: "1px solid rgba(255,255,255,0.10)",
                boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                color: "white",
              }}
            >
              <div className="relative flex min-h-[420px] flex-col bg-white/[0.06] p-8">
                <div className="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-[#b5121b] via-[#164194] to-[#b5121b]" />

                <Chip
                  label={item.category}
                  sx={{
                    borderRadius: "999px",
                    backgroundColor: "rgba(22,65,148,0.08)",
                    color: "#164194",
                    fontWeight: 800,
                  }}
                />

                <h3 className="mt-8 text-2xl font-bold leading-tight tracking-[-0.04em]">
                  {item.title}
                </h3>

                <div className="mt-5 flex items-center gap-2 text-sm font-semibold text-[#b5121b]">
                  <CalendarMonthRoundedIcon sx={{ fontSize: 18 }} />
                  {item.date}
                </div>

                <p className="mt-6 text-sm leading-7 text-white/62">
                  {item.excerpt}
                </p>

                <div className="mt-8 pt-2">
                  <Link href={`/${locale}/noticias/${index + 1}`} className="inline-flex">
                    <Button
                      variant="outlined"
                      endIcon={<ArrowForwardRoundedIcon />}
                      sx={{
                        borderRadius: "999px",
                        px: 3,
                        py: 1.1,
                        color: "#b5121b",
                        borderColor: "rgba(181,18,27,0.35)",
                        textTransform: "none",
                        fontWeight: 800,
                      }}
                    >
                      {locale === "en" ? "Read more" : "Leer más"}
                    </Button>
                  </Link>
                </div>
              </div>
            </Card>
          ))}
        </div>
      </div>
    </section>
  );
}
