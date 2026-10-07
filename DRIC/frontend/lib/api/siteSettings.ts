export type SiteSettings = {
  topbar_logo_url: string | null;
  footer: FooterSettings;
  mobile_menu: MobileMenuSettings;
};

export type MobileMenuLocale = {
  kicker: string;
  title: string;
  copy: string;
  footer: string;
  items: MobileMenuItem[];
};

export type MobileMenuItem = {
  label: string;
  description: string;
  href: string;
};

export type MobileMenuSettings = {
  es: MobileMenuLocale;
  en: MobileMenuLocale;
};

export type FooterSettings = {
  title: string;
  title_en?: string;
  address_line_1: string;
  address_line_1_en?: string;
  address_line_2: string;
  address_line_2_en?: string;
  umss_url: string;
  social_links: {
    linkedin: string;
    facebook: string;
    x: string;
    instagram: string;
    youtube: string;
  };
};

export const fallbackSiteSettings: SiteSettings = {
  topbar_logo_url: null,
  mobile_menu: {
    es: {
      kicker: "Explora DRIC",
      title: "UMSS Global",
      copy: "Navega por información institucional, convenios, proyectos, becas, informes, vida universitaria, verificación de certificados y canales de contacto.",
      footer: "Universidad Mayor de San Simón · DRIC",
      items: [
        { label: "Inicio", href: "inicio", description: "Página principal" },
        { label: "Presentación", href: "presentacion", description: "Historia, misión y estructura" },
        { label: "Convenios", href: "convenios", description: "Relaciones institucionales" },
        { label: "Proyectos", href: "proyectos", description: "Cooperación y financiamiento" },
        { label: "Becas y Movilidad", href: "becas-movilidad", description: "Oportunidades internacionales" },
        { label: "Membresías", href: "membresias", description: "Redes académicas globales" },
        { label: "Noticias", href: "noticias", description: "Actualidad institucional" },
        { label: "Normativas", href: "normativas", description: "Documentos y normativa" },
        { label: "Informes de Gestión", href: "informes-gestion", description: "Archivo institucional" },
        { label: "Campus Life", href: "campus-life", description: "Vida universitaria UMSS" },
        { label: "Verificar Certificado", href: "validar-certificado", description: "Validación institucional" },
        { label: "Contacto", href: "contacto", description: "Ubicación y canales" },
      ],
    },
    en: {
      kicker: "Explore DRIC",
      title: "Global UMSS",
      copy: "Navigate through institutional information, agreements, projects, scholarships, reports, campus life, certificate verification and contact channels.",
      footer: "Universidad Mayor de San Simón · DRIC",
      items: [
        { label: "Home", href: "inicio", description: "Main page" },
        { label: "Presentation", href: "presentacion", description: "History, mission and structure" },
        { label: "Agreements", href: "convenios", description: "Institutional relations" },
        { label: "Projects", href: "proyectos", description: "Cooperation and funding" },
        { label: "Scholarships and Mobility", href: "becas-movilidad", description: "International opportunities" },
        { label: "Memberships", href: "membresias", description: "Global academic networks" },
        { label: "News", href: "noticias", description: "Institutional updates" },
        { label: "Regulations", href: "normativas", description: "Documents and regulations" },
        { label: "Management Reports", href: "informes-gestion", description: "Institutional archive" },
        { label: "Campus Life", href: "campus-life", description: "UMSS university life" },
        { label: "Verify Certificate", href: "validar-certificado", description: "Institutional validation" },
        { label: "Contact", href: "contacto", description: "Location and channels" },
      ],
    },
  },
  footer: {
    title: "Dirección de Relaciones Internacionales y Convenios",
    title_en: "Office of International Relations and Agreements",
    address_line_1: "Av. Ballivián N. 591 esq. Reza, Cochabamba, Bolivia",
    address_line_1_en: "Ballivián Ave. No. 591 at Reza, Cochabamba, Bolivia",
    address_line_2: "Edif. Mariscal Andrés de Santa Cruz",
    address_line_2_en: "Mariscal Andrés de Santa Cruz Building",
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
