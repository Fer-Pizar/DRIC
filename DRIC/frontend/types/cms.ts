export type CmsMedia = {
  id: number;
  type: string | null;
  url: string | null;
  alt: string | null;
  caption: string | null;
};

export type CmsBlock = {
  id: number;
  type: string;
  sort_order: number;
  link_url?: string | null;
  settings: Record<string, unknown>;
  data: Record<string, unknown>;
  title?: string | null;
  subtitle?: string | null;
  summary?: string | null;
  body?: string | null;
  cta_label?: string | null;
  secondary_cta_label?: string | null;
  media?: CmsMedia | null;
};

export type CmsSection = {
  id: number;
  type: string;
  layout?: string | null;
  sort_order: number;
  settings: Record<string, unknown>;
  title?: string | null;
  subtitle?: string | null;
  summary?: string | null;
  body?: string | null;
  blocks: CmsBlock[];
};

export type CmsPage = {
  id: number;
  slug: string;
  page_type: string | null;
  status: string;
  title?: string | null;
  menu_label?: string | null;
  summary?: string | null;
  seo: {
    meta_title?: string | null;
    meta_description?: string | null;
    canonical_url?: string | null;
  };
  sections: CmsSection[];
};