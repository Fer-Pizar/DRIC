export type SiteSettings = {
  topbar_logo_url: string | null;
  footer: FooterSettings;
};

export type FooterSettings = {
  title: string;
  address_line_1: string;
  address_line_2: string;
  umss_url: string;
  social_links: {
    linkedin: string;
    facebook: string;
    x: string;
    instagram: string;
    youtube: string;
  };
};

const fallbackSiteSettings: SiteSettings = {
  topbar_logo_url: null,
  footer: {
    title: "Dirección de Relaciones Internacionales y Convenios",
    address_line_1: "Av. Ballivián N. 591 esq. Reza, Cochabamba, Bolivia",
    address_line_2: "Edif. Mariscal Andrés de Santa Cruz",
    umss_url: "https://www.umss.edu.bo/",
    social_links: {
      linkedin: "https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-image",
      facebook: "https://www.facebook.com/UMSS.DRIC",
      x: "https://x.com/UmssBolOficial",
      instagram: "https://www.instagram.com/umss.dric/",
      youtube: "https://www.youtube.com/c/UniversidadMayordeSanSimonOficial",
    },
  },
};

export async function fetchSiteSettings(): Promise<SiteSettings> {
  const apiBaseUrl = process.env.NEXT_PUBLIC_API_BASE_URL ?? "http://127.0.0.1:8000/api";

  try {
    const response = await fetch(`${apiBaseUrl}/site-settings`, {
      headers: {
        Accept: "application/json",
      },
    });

    if (!response.ok) {
      return fallbackSiteSettings;
    }

    return response.json() as Promise<SiteSettings>;
  } catch {
    return fallbackSiteSettings;
  }
}
