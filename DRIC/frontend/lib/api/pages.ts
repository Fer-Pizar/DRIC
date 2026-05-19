import type { CmsPage } from "@/types/cms";

const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://127.0.0.1:8000/api";

export async function getPageBySlug(slug: string, locale: string): Promise<CmsPage> {
  const response = await fetch(`${API_BASE_URL}/pages/${slug}?locale=${locale}`, {
    headers: {
      Accept: "application/json",
    },
    cache: "no-store",
  });

  if (!response.ok) {
    throw new Error(`Failed to fetch page: ${slug}`);
  }

  const json = await response.json();

  return json.data;
}