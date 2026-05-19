export type CmsMedia = {
  id: number;
  file_name: string | null;
  file_path: string | null;
  mime_type: string | null;
  file_size: number | null;
  disk: string | null;
  url: string | null;
  alt_text?: string | null;
  caption?: string | null;
};

export type CmsBlock = {
  id: number;
  type: string;
  sort_order: number;
  block_type?: string;
  link_url: string | null;
  settings: Record<string, unknown>;
  data: Record<string, unknown>;
  title: string | null;
  subtitle: string | null;
  summary: string | null;
  body: string | null;
  cta_label: string | null;
  secondary_cta_label: string | null;
  media: CmsMedia | null;
  media_asset?: CmsMedia | null;
};

export type CmsSection = {
  id: number;
  type?: string;
  section_type?: string;
  section_key?: string | null;
  layout?: string | null;
  sort_order: number;
  settings?: Record<string, unknown> | null;
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

export type CmsMediaAsset = {
  id: number;
  file_path: string | null;
  url: string | null;
};