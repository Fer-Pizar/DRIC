import { NextRequest, NextResponse } from "next/server";
import { getRegulations } from "@/lib/regulations/regulationsCatalog";

export async function GET(request: NextRequest) {
  const locale = request.nextUrl.searchParams.get("locale") ?? "es";

  return NextResponse.json({ items: getRegulations(locale) });
}
