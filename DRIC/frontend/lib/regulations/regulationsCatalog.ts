export type Locale = "es" | "en";

export type RegulationCategory = "primero" | "segundo" | "tercero";

export type LocalizedText = Record<Locale, string>;

export type RegulationRecord = {
  id: string;
  code: string;
  title: LocalizedText;
  category: RegulationCategory;
  categoryLabel: LocalizedText;
  categoryUrl: string;
  downloadUrl: string;
};

export type RegulationItem = {
  id: string;
  code: string;
  title: string;
  category: string;
  categoryKey: RegulationCategory;
  categoryUrl: string;
  downloadUrl: string;
};

export const regulationsSourceUrl = "https://dric.umss.edu.bo/normativas/";

export const regulationsCatalog: RegulationRecord[] = [
  {
    id: "red-int-augm-peepg",
    code: "RED-INT.-AUGM",
    title: {
      es: "PROGRAMA ESCALA DE ESTUDIANTES DE POSGRADO (PEEPg)-AUGM.",
      en: "AUGM Graduate Student Scale Program (PEEPg).",
    },
    category: "tercero",
    categoryLabel: { es: "Tercero", en: "Third" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/tercero/",
    downloadUrl: "https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento-AUGM.pdf",
  },
  {
    id: "red-int-criscos-movilidad-estudiantil",
    code: "RED-INT.-CRISCOS",
    title: {
      es: "PROGRAMA DE MOVILIDAD ESTUDIANTIL - CRISCOS",
      en: "CRISCOS Student Mobility Program.",
    },
    category: "tercero",
    categoryLabel: { es: "Tercero", en: "Third" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/tercero/",
    downloadUrl: "https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento-CRISCOS.pdf",
  },
  {
    id: "red-int-criscos-movilidad-docente",
    code: "RED-INT.-CRISCOS",
    title: {
      es: "REGLAMENTO DEL PROGRAMA DE MOVILIDAD DOCENTE-CRISCOS",
      en: "Regulations for the CRISCOS Faculty Mobility Program.",
    },
    category: "tercero",
    categoryLabel: { es: "Tercero", en: "Third" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/tercero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento_Programa_de_Movilidad_Docente_CRISCOS.pdf",
  },
  {
    id: "red-int-criscos-pmaa",
    code: "RED-INT.-CRISCOS",
    title: {
      es: "REGLAMENTO DEL PROGRAMA DE MOVILIDAD ACADEMICA ADMINISTRATIVA (PMAA)-CRISCOS.",
      en: "Regulations for the CRISCOS Administrative Academic Mobility Program (PMAA).",
    },
    category: "tercero",
    categoryLabel: { es: "Tercero", en: "Third" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/tercero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento_Programa_de_Movilidad_adminsitrativa_CRISCOS.pdf",
  },
  {
    id: "sub-mar-2024-politica-plan-internacionalizacion",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 100/2024 Ref.: Aprobación de la Política y Plan Estratégico de Internacionalización del SUB.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 100/2024: Approval of the SUB Internationalization Policy and Strategic Plan.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/Politica_y_Plan_Estrategico_de_Internacionalizacion_del_SUB-1.pdf",
  },
  {
    id: "sub-mar-2024-reglamento-convenios",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 29/2024 Aprobación del Reglamento para Elaboración y Suscripción de Convenios Locales, Nacionales e Internacionales del SUB.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 29/2024: Approval of the regulation for drafting and signing local, national, and international SUB agreements.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/Reglamento-para-Elaboracion-y-Suscripcion-de-Covenios-Locales-Nacionales-e-Internacionales-del-SUB.pdf",
  },
  {
    id: "sub-mar-2024-reglamento-internacionalizacion",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 30/2024 Ref.: Aprobación del Reglamento de Internacionalización para las Universidades del SUB.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 30/2024: Approval of the internationalization regulation for SUB universities.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-30-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf",
  },
  {
    id: "sub-mar-2024-relaciones-internacionales",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 31/2024 Ref.: Aprobación del reglamento General de Relaciones Internacionales.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 31/2024: Approval of the General Regulations on International Relations.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-31-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf",
  },
  {
    id: "sub-mar-2024-movilidad-academica",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 32/2024 Ref.: Aprobación del Reglamento para la Movilidad Académica.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 32/2024: Approval of the Academic Mobility Regulation.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-32-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf",
  },
  {
    id: "sub-mar-2024-acciones-internacionalizacion",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 33/2024 Ref.: Aprobar la implementación de acciones que fortalezcan la internacionalización.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 33/2024: Approval of actions to strengthen internationalization.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-33-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf",
  },
  {
    id: "sub-mar-2024-indicadores-internacionalizacion",
    code: "SUB-MAR/2024",
    title: {
      es: "IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 34/2024 Ref.: Aprobar la Incorporación de indicadores de internacionalización.",
      en: "4th Ordinary National Conference of Universities - Resolution No. 34/2024: Approval of the incorporation of internationalization indicators.",
    },
    category: "primero",
    categoryLabel: { es: "Primero", en: "First" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/primero/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-34-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf",
  },
  {
    id: "umss-rcu-ago-2025-cudie",
    code: "UMSS_RCU-AGO/2025",
    title: {
      es: "RCU N° 63/25 agosto, 2025. Ref.: Aprobar «REGLAMENTO COMISIÓN UNIVERSITARIA DE INTERNACIONALIZACIÓN EDUCATIVA (CUDIE) DE LA UMSS».",
      en: "RCU No. 63/25, August 2025: Approval of the UMSS University Commission for Educational Internationalization (CUDIE) Regulation.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/Reglamento-de-la-comision-CUDIE.pdf",
  },
  {
    id: "umss-rcu-feb-2022-decipre",
    code: "UMSS_RCU-FEB/2022",
    title: {
      es: "RCU N° 014/22 febrero, 2022. «DEPARTAMENTO DE COORDINACIÓN INTERINSTITUCIONAL PARA PROYECTOS REGIONALES (DECIPRE).»",
      en: "RCU No. 014/22, February 2022: Department of Interinstitutional Coordination for Regional Projects (DECIPRE).",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl: "https://dric.umss.edu.bo/wp-content/uploads/2025/10/DECIPRE.pdf",
  },
  {
    id: "umss-rr-abr-2008-manual-convenios",
    code: "UMSS_RR-ABR/2008",
    title: {
      es: "RR N° 115/08 abril, 2002. Ref.: Aprobar el «MANUAL DE PROCEDIMIENTOS PARA LA SUSCRIPCIÓN DE CONVENIOS».",
      en: "RR No. 115/08, April 2002: Approval of the Procedures Manual for Signing Agreements.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DE-PROCEDIMIENTOS-PARA-LA-SUSCRIPCION-DE-CONVENIOS.pdf",
  },
  {
    id: "umss-rr-feb-2022-actualizacion-conocimiento",
    code: "UMSS_RR-FEB/2022",
    title: {
      es: "RR N° 079/22 febrero, 2022. «DECIPRE CON DEPENDENCIA DIRECTA DE LA DRIC Y ACTUALIZACIÓN DEL CONOCIMIENTO».",
      en: "RR No. 079/22, February 2022: DECIPRE under direct DRIC authority and knowledge updating.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/10/Actualizacio%CC%81n-y-Conocimiento.pdf",
  },
  {
    id: "umss-rr-feb-2023-mof-dric",
    code: "UMSS_RR-FEB/2023",
    title: {
      es: "RR N° 161/23 febrero, 2023. MANUAL DE ORGANIZACIÓN Y FUNCIONES. Ref.: Aprobar el «MANUAL DE ORGANIZACIÓN Y FUNCIONES DRIC».",
      en: "RR No. 161/23, February 2023: Organization and Functions Manual. Approval of the DRIC Organization and Functions Manual.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DE-ORGANIZACION-Y-FUNCIONES-DRIC.pdf",
  },
  {
    id: "umss-rr-feb-2023-manual-cargos-dric",
    code: "UMSS_RR-FEB/2023",
    title: {
      es: "RR N° 161/23 febrero, 2023. MANUAL DE DESCRIPCIÓN DE CARGOS Ref.: Aprobar el «MANUAL DE DESCRIPCIÓN DE CARGOS DRIC».",
      en: "RR No. 161/23, February 2023: Position Description Manual. Approval of the DRIC Position Description Manual.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DESCRIPCION-DE-CARGOS-DRIC-1.pdf",
  },
  {
    id: "umss-rr-sep-2022-reglamento-especifico-dric",
    code: "UMSS_RR-SEP/2022",
    title: {
      es: "RR N° 1017/22 septiembre, 2022. «REGLAMENTO ESPECÍFICO DE LA DIRECCIÓN DE RELACIONES INTERNACIONALES Y CONVENIOS»",
      en: "RR No. 1017/22, September 2022: Specific Regulation of the Office of International Relations and Agreements.",
    },
    category: "segundo",
    categoryLabel: { es: "Segundo", en: "Second" },
    categoryUrl: "https://dric.umss.edu.bo/document-category/segundo/",
    downloadUrl:
      "https://dric.umss.edu.bo/wp-content/uploads/2025/10/Reglamento-Especifico-DRIC-sep.2022.pdf",
  },
];

export function getRegulations(locale: string): RegulationItem[] {
  const language: Locale = locale === "en" ? "en" : "es";

  return regulationsCatalog.map((item) => ({
    id: item.id,
    code: item.code,
    title: item.title[language],
    category: item.categoryLabel[language],
    categoryKey: item.category,
    categoryUrl: item.categoryUrl,
    downloadUrl: item.downloadUrl,
  }));
}
