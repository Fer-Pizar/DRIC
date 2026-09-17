const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://127.0.0.1:8000/api";

export function publicAssetUrl(path: string | null | undefined): string | undefined {
  if (!path) return undefined;
  if (/^https?:\/\//i.test(path)) return path;
  if (!path.startsWith("/storage/")) return path;

  return `${backendBaseUrl()}${path}`;
}

export function publicAssetHref(path: string | null | undefined, fallback = "#"): string {
  return publicAssetUrl(path) ?? fallback;
}

function backendBaseUrl(): string {
  const backendBase = process.env.NEXT_PUBLIC_BACKEND_URL ?? API_BASE_URL.replace(/\/api\/?$/, "");

  return backendBase.replace(/\/$/, "");
}
