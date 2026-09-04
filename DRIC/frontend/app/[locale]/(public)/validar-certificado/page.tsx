import ValidateCertificateClient from "./ValidateCertificateClient";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsPage } from "@/types/cms";

type Props = {
  params: Promise<{ locale: string }>;
};

const fallback = {
  es: {
    eyebrow: "Verificación institucional",
    title: "Verificar Certificado",
    description:
      "Consulta la validez de certificados emitidos por la Dirección de Relaciones Internacionales y Convenios mediante un código único de verificación.",
  },
  en: {
    eyebrow: "Institutional verification",
    title: "Verify Certificate",
    description:
      "Check the validity of certificates issued by the Directorate of International Relations and Agreements using a unique verification code.",
  },
};

export default async function ValidateCertificatePage({ params }: Props) {
  const { locale } = await params;
  const language = locale === "en" ? "en" : "es";
  const cmsPage = await getOptionalPageBySlug("validar-certificado", language);

  return <ValidateCertificateClient editableText={editableText(cmsPage, language)} />;
}

function editableText(page: CmsPage | null, locale: "es" | "en") {
  const hero = page?.sections.find((section) => section.section_key === "certificates.hero");

  return {
    eyebrow: hero?.subtitle || page?.seo?.meta_title || fallback[locale].eyebrow,
    title: page?.title || hero?.title || fallback[locale].title,
    description: hero?.summary || page?.summary || fallback[locale].description,
  };
}
