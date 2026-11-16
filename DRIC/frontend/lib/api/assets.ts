const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://127.0.0.1:8000/api";

export function publicAssetUrl(path: string | null | undefined): string | undefined {
  if (!path) return undefined;
  if (path === "/images/administration/dric-team.jpg") {
    return "/images/presentation/dric-team.JPG";
  }
  if (/^https?:\/\//i.test(path)) {
    try {
      const backend = new URL(backendBaseUrl());
      const asset = new URL(path);

      if (asset.host === backend.host && asset.pathname.startsWith("/storage/")) {
        return `${backend.origin}${asset.pathname}${asset.search}${asset.hash}`;
      }
    } catch {
      return path;
    }

    return path;
  }
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
