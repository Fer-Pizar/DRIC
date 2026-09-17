import { NextResponse } from "next/server";
import { getNews } from "@/lib/news/newsCatalog";

export function GET(request: Request) {
  const { searchParams } = new URL(request.url);
  const locale = searchParams.get("locale") ?? "es";

  return NextResponse.json({
    items: getNews(locale),
  });
}
