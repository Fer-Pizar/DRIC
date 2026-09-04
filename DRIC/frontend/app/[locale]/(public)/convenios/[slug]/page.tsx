import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import { publicAssetHref } from "@/lib/api/assets";
import { getOptionalPageBySlug } from "@/lib/api/pages";
import type { CmsBlock, CmsPage } from "@/types/cms";
import GovernmentAgreementsList, { type GovernmentAgreementSection } from "./GovernmentAgreementsList";
import OtherAgreementsList from "./OtherAgreementsList";

type Props = {
  params: Promise<{
    locale: string;
    slug: string;
  }>;
};

type Locale = "es" | "en";

type OtherAgreement = {
  es: string;
  en: string;
  href: string;
};

const otherAgreements: OtherAgreement[] = [
  {
    es: "Convenio Interinstitucional entre el Gobierno Autónomo Departamental de Cochabamba y la Universidad Mayor de San Simón para el Programa de Becas Individuales - PBI 2022",
    en: "Interinstitutional Agreement between the Autonomous Departmental Government of Cochabamba and Universidad Mayor de San Simón for the Individual Scholarship Program - PBI 2022",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EdCs0oYQk8pJqxOos_vsmr0BdnPLih2hCC5aFXP6iZ0s-Q?e=5kFZ2U",
  },
  {
    es: "Memorándum de Entendimiento entre la Sharif University of Technology, Irán y la UMSS 11-04-22",
    en: "Memorandum of Understanding between Sharif University of Technology, Iran and UMSS 11-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebq661XWWkNCsZCQ0MGH1UQBFCQ_l_ft1vXXPjQvTxRVNA?e=WsiCDS",
  },
  {
    es: "Memorándum de Entendimiento entre la Yazd University, Yazd, República Islámica de Irán y la UMSS 11-04-22",
    en: "Memorandum of Understanding between Yazd University, Yazd, Islamic Republic of Iran and UMSS 11-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Eb9lMWg59OtDlYm59ADhw3gBAaiS9RnlVzIILYb3mOD1ug?e=D8ERkc",
  },
  {
    es: "Memorándum de Entendimiento entre la Universidad de Teherán y la UMSS 11-04-22",
    en: "Memorandum of Understanding between the University of Tehran and UMSS 11-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ET_zCRzsBGNCoAxQKycAgzABmLMNbIH3eH23n6CIUyynmA?e=NrDvl5",
  },
  {
    es: "Memorándum de Entendimiento entre Shahid Sadoughi Of Medical Sciences, Yazd, República Islámica de Irán y la UMSS 11-04-22",
    en: "Memorandum of Understanding between Shahid Sadoughi University of Medical Sciences, Yazd, Islamic Republic of Iran and UMSS 11-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfI0mfXz7Y1LuwTy6Ex2NS8BOwy8hxIGy22Xpc-RPCOumQ?e=yQKekA",
  },
  {
    es: "Acuerdo de Cooperación Académica entre la Universidad de Ankara, República de Turquía y la UMSS 04-04-22",
    en: "Academic Cooperation Agreement between Ankara University, Republic of Turkey and UMSS 04-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Efab_0DDX5JCtgaKS_21SZEBOo-alCEPKu0i5raEl4-Vyw?e=9aCVLX",
  },
  {
    es: "Memorándum de Entendimiento sobre Cooperación Científico-Investigativa entre Universidad Allamed Tabataba'i, República Islámica de Irán y la UMSS 09-04-22",
    en: "Memorandum of Understanding on Scientific and Research Cooperation between Allameh Tabataba'i University, Islamic Republic of Iran and UMSS 09-04-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ea5nnoiyAXFJg199_GGiRikBPvkBSmnPBF_B21tN15yfvQ?e=DW3uFr",
  },
  {
    es: "Convenio Marco de Cooperación Interinstitucional entre la Universidad Nacional Arturo Jauretche (UNAJ) y la Universidad Mayor de San Simón 14-03-22",
    en: "Framework Agreement for Interinstitutional Cooperation between Universidad Nacional Arturo Jauretche (UNAJ) and Universidad Mayor de San Simón 14-03-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWkwKQ8Uwb5PlVksZ6s3er8B19wLTpWzP6aoH8iNK-1pyQ?e=PCldhX",
  },
  {
    es: "Acta de intenciones entre la Agencia Nacional de Hidrocarburos y la Universidad Mayor de San Simón 28-03-22",
    en: "Letter of Intent between the National Hydrocarbons Agency and Universidad Mayor de San Simón 28-03-22",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EX9n5M0_anlBsMFbX8qwUPMBEgGsk_ws1qcYXQgTP8jXyg?e=qp2jrW",
  },
  {
    es: "Acuerdo entre la Facultad de Diseño y Comunicación de la Universidad de Palermo (Argentina) y la Facultad de Arquitectura y Ciencias del Habitat de la UMSS 08-03-2022",
    en: "Agreement between the Faculty of Design and Communication of the University of Palermo (Argentina) and the Faculty of Architecture and Habitat Sciences of UMSS 08-03-2022",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EcWlHPlak2BDrVSRfhgedPoBtBrzduRrzaW4bOlCbPhbmw?e=arKQlx",
  },
  {
    es: "Convenio Marco de Cooperación entre la Universidad Nacional de San Luis (Argentina) y la Universidad Mayor de San Simón 15-03-2022",
    en: "Framework Cooperation Agreement between the National University of San Luis (Argentina) and Universidad Mayor de San Simón 15-03-2022",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUk9tVY5HgxHq-CRAr2o6SIBax9pog6fjaxldu46nDBCcw?e=ZySaoe",
  },
  {
    es: "Convenio Marco de Cooperación Interinstitucional entre la Universidad Mayor de San Simón y la Universidad Favaloro (Argentina) 16-03-2022",
    en: "Framework Agreement for Interinstitutional Cooperation between Universidad Mayor de San Simón and Favaloro University (Argentina) 16-03-2022",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYndnNGrQQtIh6AGp8PaxUsBeD93A87grcmK-p5Ac89YgA?e=SMpdf9",
  },
  {
    es: "Convenio Marco de Cooperación Interinstitucional entre la Universidad Mayor de San Simón y la Universidad Nacional Guillermo Brown (Argentina) 15-03-2022",
    en: "Framework Agreement for Interinstitutional Cooperation between Universidad Mayor de San Simón and Universidad Nacional Guillermo Brown (Argentina) 15-03-2022",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYN_HoW24WlHrkkAyAAG-PsBY86ZfXFfbSSI9A78RtnQxQ?e=eEUZ1Z",
  },
  {
    es: "Convenio Interinstitucional entre el Gobierno Autónomo Departamental de Cochabamba y la Universidad Mayor de San Simón para el Programa de Becas Individuales - PBI 2021",
    en: "Interinstitutional Agreement between the Autonomous Departmental Government of Cochabamba and Universidad Mayor de San Simón for the Individual Scholarship Program - PBI 2021",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EU54yPhts_JMuk9sB3tmbbQBOaYktl1kqrOJifxHoBqxzQ?e=eq0rlz",
  },
  {
    es: "Convenio Marco de Cooperación Interinstitucional de Desarrollo Regional y Apoyo para la Reactivación Económica y la Contención de la Pandemia entre el Gobierno Autónomo Departamental de Cochabamba y la UMSS 12-8-21",
    en: "Framework Agreement for Regional Development, Economic Recovery Support and Pandemic Containment between the Autonomous Departmental Government of Cochabamba and UMSS 12-8-21",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZ41IK7EEmhIlh6CxCiltzQB0JSkq8WNKESSEvlr_K4L7w?e=LW1F4v",
  },
  {
    es: "Convenio de cooperación y coordinación interinstitucional entre el servicio nacional de áreas protegidas - Sernap y la Universidad Mayor de San Simón a través de la Facultad de Arquitectura y Ciencias del Hábitat",
    en: "Interinstitutional Cooperation and Coordination Agreement between the National Service of Protected Areas - SERNAP and Universidad Mayor de San Simón through the Faculty of Architecture and Habitat Sciences",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfX6BRSgyO5EksQ7Uy8TZGEBhKtYbpAr-emZcPMtorO_Ow?e=dwtB79",
  },
  {
    es: "Convenio Interinstitucional suscrito entre la Empresa Boliviana de Alimentos y Derivados (EBA) y el Centro de Tecnología Agroindustrial de la Facultad de Ciencias y Tecnología de la UMSS",
    en: "Interinstitutional Agreement between Empresa Boliviana de Alimentos y Derivados (EBA) and the Agroindustrial Technology Center of the UMSS Faculty of Science and Technology",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EV1P94S8fVlDiADHhJaFU4cBrGibNAN2mLTaRqFGkGmSZw?e=JRxCEd",
  },
  {
    es: "Convenio UMSS - Gobierno Autónomo Departamental de Cochabamba para el Programa de Becas individuales - PBI 2018 (12-11-18)",
    en: "UMSS - Autonomous Departmental Government of Cochabamba Agreement for the Individual Scholarship Program - PBI 2018 (12-11-18)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Edhe0bIjWyBDtksTpx5Oin0B7EqR_BM83bpZ6DNddrdUhQ?e=0UShJb",
  },
  {
    es: "Convenio de cooperación Interinstitucional entre la Mancomunidad de Municipios del Norte Amazónico de Bolivia (Mamunab) y el Centro de Levantamientos Aeroespaciales y Aplicaciones SIG para el Desarrollo Sostenible de los Recursos Naturales (CLAS) de la UMSS",
    en: "Interinstitutional Cooperation Agreement between the Association of Municipalities of Northern Amazonian Bolivia (MAMUNAB) and the UMSS Center for Aerospace Surveys and GIS Applications for Sustainable Natural Resource Development (CLAS)",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXmmDL0IZ39HnWFw-F64rkABC2EhncOmA2sCwZvTJEgo3Q?e=dMvlET",
  },
  {
    es: "Cuarta adenda al acuerdo entre ASDI y la UMSS en apoyo a la cooperación en el área de investigación desde el 1 de abril de 2013 hasta el 31 de diciembre de 2017",
    en: "Fourth addendum to the agreement between ASDI and UMSS supporting cooperation in research from April 1, 2013 to December 31, 2017",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVm4WzDNdrxFrhdpGRjeIUYBzOhTGZ0idTVY6oG67gl2uA?e=t3fv6c",
  },
  {
    es: "Memorándum de Entendimiento sobre Cooperación en Educación y Ciencia entre la Universidad Tecnológica de Graz, Austria y el Ministerio de Obras Públicas, Servicios y Vivienda Bolivia 13-12-17",
    en: "Memorandum of Understanding on Cooperation in Education and Science between Graz University of Technology, Austria and Bolivia's Ministry of Public Works, Services and Housing 13-12-17",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfPvZuj4DqBKmZIxvDi6t8UBSkzKExD-85Ca4axKJ1kb1Q?e=ELS4Or",
  },
  {
    es: "Convenio específico entre el posgrado de la FACE de la UMSS y el Gobierno Autónomo Municipal de Vinto",
    en: "Specific Agreement between the UMSS FACE Graduate Program and the Autonomous Municipal Government of Vinto",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfpaUklLQ9tMk7XdbZD2J5wBpfuRplUX0oYHpDfZVaMiqA?e=je1EF7",
  },
  {
    es: "Convenio FHYCE a través del Instituto Confucio y la UAGRM",
    en: "FHYCE Agreement through the Confucius Institute and UAGRM",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETtxFbj9qZ5KuW5VEZ6Ov3YBmVAcQMDWDVeEIdq7hNJBoA?e=qrxQjn",
  },
  {
    es: "Convenio FHYCE - UMSS - Escuelas Populares Don Bosco EPDB 18-08-2017",
    en: "FHYCE - UMSS - Escuelas Populares Don Bosco EPDB Agreement 18-08-2017",
    href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EX2ddW5pgXpAqo48fWVT_uwBhJvgnZ-HPt01fA7y-wMyxQ?e=f3mkKh",
  },
];

const ceubSections: GovernmentAgreementSection[] = [
  {
    title: "Convenios suscritos por el CEUB con otras instituciones",
    agreements: [
      {
        title: "Convenio de Cooperación Interinstitucional entre el Ministerio de Desarrollo Productivo y Economía Plural y el Comité Ejecutivo de la Universidad Boliviana",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EaFXQn9b5hRLmzmUucDgWbIBEgqL6LtRef39-edsojyA6A?e=NpOeWs",
      },
      {
        title: "Convenio marco de cooperación interinstitucional entre el Tribunal Supremo de Justicia, la Escuela de Jueces del Estado, la Dirección Administrativa y Financiera del Órgano Judicial y el Comité Ejecutivo de la Universidad Boliviana",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZk4ukhF8fNGvkeHB2iINxgBBGtOBFjhgFcpX-dq-NvJrw?e=XOn9iY",
      },
      {
        title: "Convenio de cooperación interinstitucional entre la Dirección del Notariado Plurinacional y el CEUB",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXZ9UA5_es1CnTdBgnS2AAwBvTriIhiEKkIBCP_W6YAWgw?e=aDchOV",
      },
      {
        title: "Convenio Marco de Colaboración Interinstitucional suscrito entre el Comité Ejecitivo de la Universidad Boliviana y la Universidad Nacional de COMAHUE",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EeOiWkrrNk5DhqezrnMu9WIBrerR-dplovO6qyBdOHwFTA?e=oHyOYY",
      },
      {
        title: "Convenio marco de colaboración interinstitucional suscrito entre el Comité Ejecutivo de la Universidad Boliviana y el Tribunal Agroambiental del Órgano Judicial de Bolivia. 12/04/18",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EdfcFYDDiBpOtLQBW6POH7gBRGQ1b4rzBtn8Bv0ajsCNEg?e=3uIfm2",
      },
      {
        title: "Convenio marco de colaboración académica celebrado entre el Tribunal Constitucional Plurinacional de Bolivia y el Comité Ejecutivo de la Universidad Boliviana. 11.04.18",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EV-a0NIzSiVIgzILBpWBDe0B3LUw8av7dp7EW4Kzbn_cfw?e=rBTtes",
      },
      {
        title: "Convenio de cooperación Interinstitucional entre el Consejo de la Magistratura y el Comité Ejecutivo de la Universidad Boliviana. 12/04/18",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZ4WfKJbKT1OlXsRBVjw8PsBzz-Zh80-IwAbZQ_jMI0UVg?e=RjfYoE",
      },
      {
        title: "Memorandum de Entendimiento sobre Cooperación en Educación y Ciencia entre la Universidad de Tecnología de Graz, Austria y el Ministerio de Obras Públicas Servicios y Vivienda, Bolivia",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfUxqrKGHe1HsVhQ_w3gPY4BElSK7S7MXUGtYBQjgMNMOQ?e=XhEcEk",
      },
      {
        title: "Convenio entre el CEUB y la Conferencia de Presidentes de Universidad (CPU), la Conferencia de Directores de las Escuelas Francesas de Ingenieros (CDEFI). 26-4-18",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWuh6WxYIkdAmmWTDw06G0oB2L7GpowlZ52nG4G0-Yitig?e=7cfkwa",
      },
      {
        title: "Convenio marco de cooperación interinstitucional entre el Tribunal Agroambiental y el Comité Ejecutivo de la Universidad Boliviana 12-02-2021",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfYmctqX971Emy3NtP0iKHgB-BlTO1sHkIYGHNRldp5Q4Q?e=OpXbhY",
      },
      {
        title: "Convenio marco de cooperación interinstitucional entre el Ministerio de Justicia y Transparencia Institucional y el Comité Ejecutivo de la Universidad Boliviana 12-03-2021",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVa_FOzHsUpKh6m-cY6bu_sBH8S8ZxquCuOUKflV5fPobw?e=a5WDOm",
      },
      {
        title: "Convenio de cooperación interinstitucional entre la Agencia Nacional de Hidrocarburos y el Comité Ejecutivo de la Universidad Boliviana 31/03/21",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EaRxcmeT6g9JhtIRAhE3G5MBWvPDy5ITArQlIs697XAD1Q?e=3m0SXc",
      },
      {
        title: "Convenio marco de colaboración académica, científica y cultural entre la conferencia de rectores de las Universidades Españolas y el Comité Ejectivo de la Universidad Boliviana - CRUE y CEUB",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EcUe8ZIA5O9Els_zHMtJqgoB6duxzzb0_UJjjuQpGpLOxg?e=EJsZbd",
      },
      {
        title: "Convenio marco de cooperación interinstitucional entre el Comité Ejecutivo de la Universidad Boliviana y el Fondo de Desarrollo Indígena 17/05/21",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EbHzww4kkVVKlqxItfZfiagB26UVQJy026OvGe00J5-avg?e=7Tjp5y",
      },
      {
        title: "Convenio marco de cooperación interinstitucional entre Yacimientos Petrolíferos Fiscales Bolivianos y el Comité Ejecutivo de la Universidad Boliviana 15/07/21",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfYmctqX971Emy3NtP0iKHgB-BlTO1sHkIYGHNRldp5Q4Q?e=OpXbhY",
      },
      {
        title: "Convenio Marco de Colaboración entre la Universidad de Alicante y el CEUB. 21/04/2017",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUDc_jLOJcRJs6Y_B5PlPo8B4ECPS_UyUpp0HWBEj8Wg9A?e=Y05OmC",
      },
      {
        title: "Convenio de cooperación interinstitucional entre el Ministerio de la Presidencia y el Comité Ejecutivo de la Universidad Boliviana. 29/10/2021",
        href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebei38o0Jt5GlXiXMlI5hY0BSTRvvzekIP1HvqKekDCrdQ?e=TZThKS",
      },
      {
        title: "Convenio de cooperación interinstitucional entre el Ministerio de Justicia y Transparencia Institucional y el Comité Ejecutivo de la Universidad Boliviana. 19/04/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-2350.pdf",
      },
      {
        title: "Convenio marco cooperación insterinstitucional entre la Cooperativa de Ahorro y Crédito de Vinculo Laboral «COOMUPOL» R.L. y el Comité Ejecutivo de la Universidad Boliviana (CEUB). 03/07/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-COOMUPOL-2414.pdf",
      },
      {
        title: "Protocolo de Intenciones entre la Universidad Federal del Acre (UFAC) y el Comité Ejecutivo de la Universidad Boliviana (CEUB). 11/08/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/ceub-ufac-2408.pdf",
      },
      {
        title: "Convenio Marco de Cooperación Interinstitucional entre el Comité Ejecutivo de la Universidad Boliviana y la Agencia Boliviana Espacial. 12/09/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-ABE-2420.pdf",
      },
      {
        title: "Memorándum de entendimiento que celebran el Comité Ejecutivo de la Universidad Boliviana (CEUB) y el Instituto Federal de Educación, Ciencia e Tecnología do ACRE (IFAC). 24/07/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-IFAC-2418.pdf",
      },
      {
        title: "Convenio de Cooperación Interinstitucional entre el Ministerio de Economía y Finanzas Públicas y el Comité Ejecutivo de la Universidad Boliviana. 08/08/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-MEFP-2415.pdf",
      },
      {
        title: "Convenio Marco Interinstitucional de cooperación académica, científica y administrativa entre el Comité Ejecutivo de la Universidad Boliviana (CEUB) y la Universidad Nacional Amazónica de Madre de Dios (UNAMAD). 08/09/2023",
        href: "https://dric.umss.edu.bo/wp-content/uploads/2024/05/CEUB-UNAMAD-2455.pdf",
      },
    ],
  },
];

const bilateralSections: GovernmentAgreementSection[] = [
  {
    title: "Alemania",
    agreements: [
      { title: "Convenio Cultural entre la República de Bolivia y la República Federal de Alemania. 04/08/1966", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESHqB_PeaVxMhLNVW03H5NEBhp72GLJTg-QhLRtlGrNKyg?e=1kqvQh" },
      { title: "D.S. 07785 ratificando el convenio de 04/08/1966", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXqosQWBCRpAgoQPGV7fkVcBdW5MNylJomyWDhauXOvm0Q?e=fmyaee" },
    ],
  },
  {
    title: "Argentina",
    agreements: [
      { title: "Convenio de cooperación cultural, científica y técnica entre el Gobierno de la República de Bolivia y el Gobierno de la República Argentina. 17/11/1971", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESdcX_Wqc9FOkeRTcJXKtZMBio_Gf0ZDcXoPag0J_UtTJA?e=Ud3bOy" },
      { title: "Acta de Canje. 17/02/1972", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZMeZB-wMYpOrbrzS8cpXYcBiUNVNT_ELpCQ_faBjiBSbQ?e=GTBEbk" },
      { title: "Convenio de cooperación y facilitación en materia de turismo entre el Gobierno de la República de Bolivia y el Gobierno de la República Argentina. 13/12/1989. Aprobado 04/07/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EdFLsMUjBU9Mg1qlMggusIIB1BjODENH5R6QfU7QiO1NWQ?e=tghb6j" },
      { title: "Acta de canje de instrumentos de ratificación. 28/01/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EexEgW9jgEFIi1b9PpfkCe0BNM6bLfZBhkZchmnSLZSUJA?e=phdcRR" },
      { title: "Convenio de integración cultural entre el Gobierno de la República de Bolivia y el Gobierno de la República Argentina. 19/11/1996. Aprobado y ratificado 16/12/1997", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EbohA1gPUwFAjlFSFrz0x4IB_X8bShq7r2Hg80Gx7p-JpA?e=F7bQ4o" },
    ],
  },
  {
    title: "Austria",
    agreements: [
      { title: "Memorandum de entendimiento sobre Cooperación en Educación y Ciencia entre la Universidad de Tecnología de Graz, Austria y el Ministerio de Obras Públicas Servicios y Vivienda, Bolivia", href: "http://dric.umss.edu.bo/wp-content/uploads/2021/12/MEMORAMDUM-DE-ENTENDIMIENTO-MOPSV-y-TU-Graz-12-12-17.pdf" },
    ],
  },
  {
    title: "Bélgica",
    agreements: [
      { title: "Acuerdo de Cooperación Cultural y Educativa entre el Gobierno de la República de Bolivia y el Gobierno de la Comunidad Francesa de Bélgica. 11/10/1995", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EaTy_r5sNH9Go7aJz-VAgGEBagcFvC_Eoy4cfu9QTJ-_vQ?e=jVSFiI" },
      { title: "Acuerdo entre el Gobierno de Bolivia y APEFE. 09/12/2002", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EccdOuOczydBvPRBgW_-zS0BIUxrZ2nC3rSnbt0O6PJIVQ?e=fyuYzg" },
    ],
  },
  {
    title: "Brasil",
    agreements: [
      { title: "Acuerdo básico de Cooperación Técnica y Científica entre el Gobierno de la República de Bolivia y el Gobierno de la República Federativa del Brasil. 10/07/1973", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWgNCq0djdBDp9PphVeAO5gBsQu36I1dL5ghNBC0T_w1PQ?e=y6OdDW" },
      { title: "Acuerdo básico de cooperación técnica, científica y tecnológica entre el Gobierno de la República Federativa del Brasil y el Gobierno de la República Bolivia. 17/12/1996. Aprobado y ratificado 15/06/1998", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebumf9zmoadGtVW7zc2BjC0BC13SkasqBFVjkpf9JMSvBQ?e=mgD5oM" },
      { title: "Acuerdo de cooperación turística entre el Gobierno de la República de Bolivia y el Gobierno de la República Federativa del Brasil. 30/03/1998. Aprobado y ratificado 30/04/1999", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVtVNH5OA99JhOtWbeCpVcUBbEgxkWhHs_t0Tg2u7pJtxA?e=KXyd2a" },
      { title: "Acuerdo de cooperación cultural entre el Gobierno de la República de Bolivia y el Gobierno de la República Federativa del Brasil. 26/07/1999. Aprobado y ratificado 08/06/2000", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ET91bStMexNJtXI9aN0oc_ABLa1c8lA1l6AalooCtVQvzA?e=pFAMXR" },
      { title: "Acuerdo entre el Gobierno de la República de Bolivia y el Gobierno de la República Federativa del Brasil sobre la recuperación de bienes culturales, patrimoniales y otros específicos robados, importados o exportados ilícitamente. 26/07/1999. Aprobado y ratificado 08/06/2000", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETx4NAJ-Hc5DjTQ-8p6kxPkBi3-7wemOcGgt0xBkE_TEuA?e=z0AyvM" },
      { title: "Ajuste complementario al acuerdo básico de cooperación técnica, científica y tecnológica entre el Gobierno de la República Bolivia y el Gobierno de la República Federativa del Brasil para la implementación del proyecto “Intercambio de experiencias y conocimientos para la gestión de las culturas”. 27/05/2008", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ERDn-5ikm2NFmwKYHxPSUsUBmW6io_ABHJMGyma0Xfd7cQ?e=GqiAYW" },
      { title: "Acuerdo de Cooperación Educativa entre Bolivia y Brasil 1999", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZwrkavvhVJCtJ6TjP_BvpMBJkcI3RNZ3Et4KdyLSQeApA?e=CuiBB6" },
      { title: "Acuerdo de Cooperación Educativa entre Bolivia y Brasil 2001", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EeOXt8NYQrlBuWsoSYdcwI8BM6pJDlwrEy3fDzFJkJTYBg?e=jsv6yR" },
    ],
  },
  {
    title: "Chile",
    agreements: [
      { title: "Convenio sobre viajes y Turismo. 10/08/1942", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfJKBUdbS9VNqcjH3VaBT90B-AAV5ASi4EPiTNsZNySdbw?e=AWtWT3" },
      { title: "Convenio sobre intercambio intelectual y cultural y de profesores y estudiantes. 18/09/1937", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ef4D9rxXUZxJqEHgfz-H0m0BunVl_ojiuPGMRs0cB1Ck4w?e=2eC8ZK" },
      { title: "Acta de reunión del programa de trabajo para la profundización del ACE 22: promoción comercial, económica, de inversiones y turismo. Mesa de trabajo: turismo y transportes. 18/08/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVflH41tQIRGoNtFj0Gsx_kBX74xC0VTFI0AQaYTd2MfPw?e=jDTahm" },
      { title: "Memorándum de entendimiento para un programa de intercambio cultural entre el ministerio de culturas del Estado plurinacional de Bolivia y el Consejo Nacional de la Cultura y las Artes de la República de Chile para los años 2009, 2010, 2011, 2012. 14/05/2009", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETZf2SnoAnJIp8yp1XivBBEBh0D2V4-_etIVK6xqVNjfSQ?e=tRncBM" },
    ],
  },
  {
    title: "China",
    agreements: [
      { title: "Acuerdo de Cooperación en Ciencia y Tecnología entre el Ministerio de Educación del Estado Plurinacional de Bolivia y la Academia de Ciencias de China", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWzZgW3aASVHgefiDqC5ojQB9Oolbu0b-gBzKni6QkF0TA?e=hGLTef" },
      { title: "Convenio de Cooperación Cultural entre el Gobierno de la República de Bolivia y el Gobierno de la República Popular China. 05/05/1986", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EcIDSvaiSfBKq8jvVqgPI84BNkx-KQvFTZ8nAF9yrG3akQ?e=6Z9Iyd" },
      { title: "Ley Nº 892 que ratifica el convenio de 05/05/1986. 29/10/1986", href: "https://miumssedu-my.sharepoint.com/:w:/g/personal/dric_mi_umss_edu/Eaked-0Qg9ZEqdJSGSIZCZ0BmvTe27sIe5zo-PRKjud-FA?e=m1RoWm" },
      { title: "Convenio de Cooperación Técnica y Científica entre el Gobierno de la República de Bolivia y el Gobierno de la República Popular China. 08/05/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EecBKzA9mD5Cqt5tWCeADhMB1kwYAWRQQyPZJPlnzCIAPA?e=hE7lhU" },
      { title: "Ley Nº1400 que aprueba el convenio de 08/05/1992. 03/12/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWYNj42Wv_dFtotTFXwr_awBaqy3awPG55doPI9e3aGbbA?e=Fu6osh" },
      { title: "Programa de Cooperación Cultural y Educativa entre el Gobierno de la República de Bolivia y el Gobierno de la República Popular China 2007-2009. 05/11/2007", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EY4ZryxCfYFDlmAHrhtBh2gB33xZLiT7i2cBq3_Q44-D_A?e=mxJiEj" },
    ],
  },
  {
    title: "Colombia",
    agreements: [
      { title: "Convenio Cultural entre la República de Colombia y la República de Bolivia. 24/06/1972. Aprobado 19/05/1986", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZztUshfUB5AoTidWKebH6wBqL7ujM2MKetJHE8IjPbnHA?e=kvUMHD" },
      { title: "Acuerdo de Cooperación Científico-Tecnica y Tecnológica entre el Gobierno de la República de Bolivia y el Gobierno de la República de Colombia. 10/11/1998", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETEFXW49MuRCnBn6gdDW-VgBNsgIqGsEQgOZWHDavA1scw?e=7gopcu" },
      { title: "Convenio entre Gobierno de la República de Bolivia y el Gobierno de la República de Colombia para la recuperación de bienes culturales y otros específicos robados, importados o exportados ilícitamente. 20/08/2001", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ea33J60a5uBGi62k2UOcRE0B6BXUPrIaPn-jYX4qaXjbpA?e=d3hb3b" },
      { title: "Convenio de reconocimiento y validez de títulos, diplomas y certificados académicos de estudios parciales de Educación Superior entre el Gobierno de la República de Bolivia y el Gobierno de la República de Colombia. 20/08/2001. Aprobado y ratificado 03/05/2006", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ERh5t53coLZLlGP-Up7D-tYBVX5St1W0y_iH0kiR30sD9A?e=fOFO4f" },
      { title: "Convenio de cooperación turística entre el Gobierno de la República de Bolivia y el Gobierno de la República de Colombia. 20/08/2001", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYAphiq1APlNtQzlbmP5h3MBYwkHdlo9XZqdGz0Lz3No5Q?e=JhX7nk" },
      { title: "Memorándum de entendimiento entre el Instituto Boliviano de la pequeña industria y artesanía de Bolivia y artesanías de Colombia para el fomento de la cooperación en materia de artesanías. 29/11/2004", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EWjpgUpv6TNMlZy_1gIGYWABu3GgUZYNaedbKF7jenlx7w?e=nfr0QZ" },
    ],
  },
  {
    title: "Corea",
    agreements: [
      { title: "Convenio Cultural entre el Gobierno de la República de Bolivia y el Gobierno de la República de Corea. 07/09/1971", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVhdRINkgpVFjNJd7yaUJysBRp910-zEQPUsi9YDw1rs4w?e=Yf2IQ2" },
    ],
  },
  {
    title: "Cuba",
    agreements: [
      { title: "Convenio de Cooperación Científico-Técnica en el área de salud entre el Gobierno de la República de Bolivia y el Gobierno de la República de Cuba. 17/07/1985. Acta de canje de los instrumentos de ratificación. 08/06/1990", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVzyltj76cNCqkgG9EYy6kcBkncOUcCErKENB_RAEQam6A?e=dItvuZ" },
      { title: "Ley que aprueba el Convenio de Cooperación Científico-Técnica en el área de salud suscrito en La Habana el 17/07/1985. 16/11/1988", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfOVkWFU-hJGty2nlLmU6owB-7qZhcPJM50RklVyOmJmWg?e=KweLJM" },
      { title: "Convenio de cooperación cultural entre la República de Bolivia y la República de Cuba. 06/10/1986. Ratificado 15/06/1990", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUv4AoP_igdHsLSuxuUUdNEB7eBclZk-8JxDpPQO_whYpA?e=lDQQg0" },
      { title: "Ley que aprueba el Convenio Cultural suscrito entre los Gobiernos de la República de Bolivia y la República de Cuba firmado en La Habana el 06/06/1986", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EV4RJsK1q7JKgwUyI9BZDYkB3uCnyBLMJ0RIKqslLwAMpQ?e=k7V2T5" },
      { title: "Convenio de Cooperación entre el Ministerio de Educación, Cultura y Deportes de la República de Bolivia y el Ministerio de Educación de la República de Cuba. 01/10/1999", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYtUt55XbYlPkQUOM5DKiuUBYi2G0WkzD1S-FaxiiPa1kg?e=lCbxDg" },
      { title: "Convenio de reconocimiento mutuo de estudios y títulos de Educación Superior entre el Gobierno de la República de Bolivia y el Gobierno de la República de Cuba. 02/12/2004", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVBDL3-b-AVBuiy9bp9Af5YBOlKnyhvuKNC2rJWaNvqQpA?e=H3PObT" },
    ],
  },
  {
    title: "Dinamarca",
    agreements: [
      { title: "Convenio Gubernamental entre la República de Bolivia y el Reino de Dinamarca, concerniente al Programa de Apoyo Sectorial a la Educación. 28/07/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EeBY6xsH7qZGpiUUlgBbZWYBaCJrS79Fw7kyLCIBGByZbQ?e=5eeiqw" },
      { title: "Memorandum de entendimiento entre el Gobierno de Bolivia y los Gobiernos y Agencias de Cooperación Internacional Signatarias en relación al Fondo de Apoyo al Sector Educativo (FASE). 28/07/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EQLAuUmEmv9OgVI1gBvAQTwBklTaebXi6DGoZgJ7GysDJA?e=U6Pgow" },
    ],
  },
  {
    title: "Ecuador",
    agreements: [
      { title: "Convenio de cooperación Técnica y Científica entre la República de Bolivia y la República del Ecuador. 28/10/1972", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESUnHU7OJnBNgumrbb2SENwBb_-TV2rMZocYnRYDLLNurg?e=Lqy6xd" },
      { title: "Convenio de Cooperación Cultural. 28/10/1972", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESUnHU7OJnBNgumrbb2SENwBb_-TV2rMZocYnRYDLLNurg?e=LHPBwW" },
      { title: "Convenio de Cooperación Cultural entre los Gobiernos de la a República de Bolivia y la República del Ecuador. 31/01/2002", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Eev60835B1FOgAgExk35elABcOZpt5R2KVkdYjOlgtepmw?e=QUMvkM" },
    ],
  },
  {
    title: "EEUU",
    agreements: [
      { title: "Acuerdo de Cooperación Técnica, Científica y de Asistencia Humanitaria entre el Gobierno de Bolivia y el Gobierno de los Estados Unidos de América. 13/02/1997", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETwTr0Laii1AoYMejLR8rx8BIpRjKkmCWoDg_GlsuXK_TQ?e=R3722s" },
    ],
  },
  {
    title: "Egipto",
    agreements: [
      { title: "Convenio Cultural entre la República de Bolivia y la República Árabe de Egipto. 06/09/1982", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXsHJYZFlfxOpxALTro981gBZhWbztwyo6VHKnOnEhRPhA?e=OZF8IQ" },
      { title: "Ley Nº 1318 que aprueba el Convenio de 06/09/1982. 08/04/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebmc-NItHndJnZeP__4qJWgBh2WVWu28aDyyWKh9eobeUA?e=vSKVDb" },
    ],
  },
  {
    title: "España",
    agreements: [
      { title: "Convenio Cultural entre la República de Bolivia y España. 15/02/1966", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfGlF_Dpj8NFhXbl1IeJEh8BEXqOufcF48rDmVfaX2MFSg?e=qyN8JQ" },
      { title: "Acuerdo de Cooperación en materia de turismo entre el Ministerio de Comercio y Turismo de España y la Secretaría Nacional de Turismo de Bolivia. 25/01/1996", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVn_XTrkC_9GtwFdlZxQPHEBpwwts--JYIFNnN_mB6m_0w?e=5CcVAY" },
      { title: "Acta de la Revisión intermedia de la Comisión Mixta Hispano-Boliviana de Cooperación 2006-2010 (Marzo 2009). 10/03/2009", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ET4VzMRHYhRItY6VmBw51y4B97LIKg3DJLQQ1rCXqKh2tw?e=wju4Bs" },
    ],
  },
  {
    title: "Francia",
    agreements: [
      { title: "Convenio de Cooperación Cultural, Científica y Técnica entre el Gobierno de Bolivia y el Gobierno de la República de Francia. 26/05/1966", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUkSOtzG2xJDgh4TPrg3lyABlWt4x6ahWy52lG8yKet_Ow?e=gcbAKC" },
      { title: "Ley 11/12/1967 que ratifica el convenio de 26/05/1966. 02/01/1968", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EQ-nVTd9k3JBgQCiy5ja5EEBkn1TLn2ZT10aZQki7_RB8A?e=VYUxek" },
      { title: "Protocolo Complementario al Acuerdo de Cooperación Cultural, Científica y Técnica entre Bolivia y Francia relativo al Estatuto de los Agentes e Instituciones de Investigación Franceses. 20/05/1994", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ET2Blu9LtQBEuySRWoGAFMsBCQlBHgHMjk9hnz8v6_nlag?e=1wXQLU" },
    ],
  },
  {
    title: "Holanda",
    agreements: [
      { title: "Memorandum de entendimiento entre el Gobierno de la República de Bolivia y los Gobiernos y Agencias de Cooperación Internacional Signatarias en relación al Fondo de Apoyo al Sector Educativo (FASE). 18/06/2004. Addendum 28/07/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ETS2E6P1-GZCtuUh1MHOOXYBA1rsFW9OkkCR05RTQ4kssw?e=PuEHcq" },
    ],
  },
  {
    title: "Hungría",
    agreements: [
      { title: "Convenio de Cooperación Económica, Técnica y Científica entre el Gobierno de la República de Bolivia y la República Popular de Hungría. 15/05/1970", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUwAqZ3ggpVOrl1ND2GzOJoBun-appA0zzYd-WzR8RfYow?e=0UDb3s" },
      { title: "Convenio de Cooperación Cultural y Científica entre la República de Bolivia y la República Popular de Hungría. 15/05/1970", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYUxoGyUWKlCoSAhQ_bk0o8BylNv0nMX3lMAaLXUwSTlEQ?e=1vM4Oo" },
    ],
  },
  {
    title: "India",
    agreements: [
      { title: "Convenio Cultural entre el Gobierno de la República de Bolivia y el Gobierno de la República de la India. 08/12/1997", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EfM_3xlKhttOmsi7QPZKvygBu6nU0jjS6ILFKt0KIE4OdQ?e=PeSyCa" },
      { title: "Ley Nº 1898 que aprueba y ratifica el convenio de 08/12/1997. 18/09/1998", href: "https://miumssedu-my.sharepoint.com/:w:/g/personal/dric_mi_umss_edu/EV9JBmJmhyZGvJPXCevMMP0B_dbm4nmRMS-R9_I0Ix6WkA?e=KGhXVc" },
    ],
  },
  {
    title: "Inglaterra",
    agreements: [
      { title: "Acuerdo entre el Gobierno la República de Bolivia y el Consejo Británico relacionado con las condiciones operativas del Consejo Británico en la República de Bolivia. 04/08/1997", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Eb1_bk5mjM5Pv1l6PqcoAYwBCn3taeAh_VHazubOFTNHBQ?e=H37QyJ" },
    ],
  },
  {
    title: "Israel",
    agreements: [
      { title: "Convenio de Intercambio Cultural entre la República de Bolivia y el Estado de Israel. 27/04/1961", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EdjjVRF4_-hOmaU2Bcg-uOcBE4Q6QueALRNk1-pzfZPUGg?e=rTSpFu" },
      { title: "Ley 28/11/1962 que aprueba el Convenio de 27/04/1961. 15/11/1962", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVjYKXkcsrNGqW8wPOn3--EBcDyUaTSV-IOSgthInSy8ZA?e=1IpdlB" },
    ],
  },
  {
    title: "Italia",
    agreements: [
      { title: "Acuerdo Cultural entre Bolivia e Italia. 31/01/1953", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESe2E4o1n85Orjcz87HpM20Bnppv5ivVO9jevWNnL-FHgg?e=EdJcDK" },
      { title: "Ley 12/03/1969 que aprueba el Acuerdo de 31/03/1953. 12/01/1969", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebdc04I6f65Bt2ar7x4sOuwB0cgl4tUol4WLbheW3u4Yxw?e=c5D6Fr" },
      { title: "Acuerdo de Cooperación Científica y Tecnológica entre Bolivia e Italia. 03/06/2002. Anexo en materia de Propiedad Intelectual. 03/06/2002", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUz2PrrFr7lJhYlAV97HQDcBMBEtkGK0zHv-gpM2Wlrj7A?e=iw8cRe" },
    ],
  },
  { title: "Japón", agreements: [{ title: "Entendimiento para promover la cooperación técnica entre los dos países. 19/12/1977", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZGriklvoQRGp71bNZYUsoUBkjRI4SLwq5blaiMR_lj0xQ?e=ez2C62" }] },
  {
    title: "México",
    agreements: [
      { title: "Convenio entre el Gobierno dela República de Bolivia y el Gobierno de los Estados Unidos Mexicanos. 12/04/1962", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ebyo9q2mukdPn42XZGRUZAQB7oHZYpKdzWnQYBx9NJQuLQ?e=9LOnW3" },
      { title: "Convenio básico de cooperación técnica y científica entre Bolivia y México. 06/10/1990. Ratificado 21/06/1992", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EQ2rmnpxY39Chd54nII2N8cBtSxN0qdO5W-HdV5gomd1xA?e=tjSSAz" },
      { title: "Convenio de cooperación en las áreas de la educación, la cultura y el deporte entre Bolivia y México. 11/12/1998", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EVPBpCo7Wk9LttScMnVHt-gBEwZ9Nki_GmVjCCHyZ1poXg?e=gKSblS" },
      { title: "Ley Nº 1995 que aprueba el convenio de 11/12/1998. 21/07/1999", href: "https://miumssedu-my.sharepoint.com/:w:/g/personal/dric_mi_umss_edu/EdkL-wZ0L1NFqSUx48uqY4YBF8XAGmaCDmTQ3VI9EllVYQ?e=M4HDgy" },
    ],
  },
  { title: "OEA", agreements: [{ title: "Acuerdo de Asistencia Técnica que celebran el Ministerio de Educación y Cultura de Bolivia y la Secretaría General de la Organización de los Estados Americanos. 30/10/1978", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ES5OvjM0hkZDvRu_n1AhjiwBy8mBRWCvRcIgTEQhhOSxcA?e=me8oo4" }] },
  { title: "Panamá", agreements: [{ title: "Acuerdo de cooperación en materia de turismo entre Bolivia y Panamá. 11/04/2005. Ratificado 07/12/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EbZs63ro_stNv5CPPqz7nWQBXFeswfTGEkFCd4DiJCDwbw?e=F4wyYD" }] },
  {
    title: "Paraguay",
    agreements: [
      { title: "Convenio de cooperación e intercambio cultural entre Bolivia y Paraguay. 17/09/1990", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZ_btCo-EeNNr9438_-tUkIBhmevLVNycmJYyoH9xCOJYA?e=ITxAnb" },
      { title: "Convenio de cooperación turística entre Bolivia y Paraguay. 15/03/1994. Ratificado el 21/08/1995", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EUDa7tdFraBGie5m_RPSuhgBumgScxoocEZJEHZEegNy9g?e=wWs7CP" },
      { title: "Convenio de cooperación de educación intercultural bilingüe entre Bolivia y Paraguay. 04/12/2002", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Eaxr3cYdMA5Kq5U16DKUH64ByoVS7ynHtwO5QHExMhrtgw?e=pfOkZ6" },
      { title: "Convenio entre Bolivia y Paraguay para la recuperación de bienes culturales y otros específicos robados, importados o exportados ilícitamente. 16/04/2004", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ee0FlVB5FDZHhE3uqW21LV0BatEsKylsZ9DJswVsyG31hw?e=bbgjTL" },
    ],
  },
  {
    title: "Perú",
    agreements: [
      { title: "Convenio básico de cooperación técnica y científica entre Bolivia y Perú. 27/07/1996", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EcsRzRSOsMpMr9gTqBCjOFgBn5Vvo8qBq34L-SsaGMDPUA?e=XA6nwG" },
      { title: "Convenio entre Bolivia y Perú para la recuperación de bienes culturales y otros robados, importados o exportados ilícitamente. 14/12/1998. Acta de canje 23/10/2001", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXcR7fv4JTFHoIBUtK_7eK4BGEgH4JRRp9mT3gPRwtovuQ?e=e2fT8u" },
    ],
  },
  {
    title: "Rusia",
    agreements: [
      { title: "Convenio de Cooperación Cultural y Científica entre Bolivia y Rusia. 11/04/1995", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EbAsr0zl6AVDvTae9BFMpu0BWU-47GdRZTM6Mav2QvTOCg?e=mb39Q7" },
      { title: "Acuerdo Básico de Cooperación entre Bolivia y la Federación de Rusia. 26/07/1996", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EditdDlyWsBJri-qJhg4HAUBQm4oR3CHMGoNvC02RuYeCQ?e=I9NUaI" },
      { title: "Memorandúm de Entendimiento para la Colaboración Científica y Cultural entre ILA ACR y la Embajada de Bolivia en Rusia. 30/06/2005", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYYpsRWY59xLgv3_lAq4BFIBgz_6BSOg0aG4wPT0PLn4PA?e=65QQlp" },
    ],
  },
  { title: "Suecia", agreements: [{ title: "Specific Agreement between the Government of Bolivia and the Government of Sweden on support of the Education Reform Programme", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXGM2yF4c2tFi1JgDscA-nMBmoUxj7zF1tg_zYZPTHGwCA?e=FB6VK8" }] },
  { title: "Suiza", agreements: [{ title: "Convenio de Cooperación Técnica y Científica entre Bolivia y la Confederación Suiza. 30/11/1973", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EYMG466iSCREnGMoENVCILABA6jUn0X1kdFFnmzHVCJ9WA?e=cTEY77" }] },
  {
    title: "Uruguay",
    agreements: [
      { title: "Convenio entre Uruguay y Bolivia para la cooperación en los campos de la Ciencia y de la Tecnología. 12/05/1976", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EThyu48m879LnKriY5sTq1cBTC46KP_hQKKT5jxdHj7l9w?e=AZGFwY" },
      { title: "Acuerdo de cooperación turística entre Bolivia y Uruguay. 17/07/2007", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ERBi-7gZ4GhOpXS8Iup5KIoBdnvE4RYUs1pjsC0ZvaQNvg?e=ncDus6" },
      { title: "Convenio de protección y restitución de bienes culturales y otros específicos entre Bolivia y Uruguay. 17/07/2007", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ed7Zogf43blChBdPPfJ1JkQBY5JC_ycmalgwkwLZ1M1O3g?e=svmqQB" },
    ],
  },
  {
    title: "Venezuela",
    agreements: [
      { title: "Acuerdo de cooperación en el área educativa y deportiva entre Bolivia y Venezuela. 23/01/2006. Ratificado 20/06/2006", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EXN6xXZAwCFIjaqAHbUHPjwBm7mhiM-cJPeFq0wK7cT_5w?e=DrSj7T" },
      { title: "Acuerdo de cooperación en materia de educación superior entre Bolivia y Venezuela. 23/01/2006. Ratificado 20/06/2006", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EULqomWBObVAkLmrsJi9T8EBR6KpEGg3ckElc-XgrPgQRQ?e=Ngxngr" },
      { title: "Acuerdo “Gran Mariscal de Ayacucho”, complementario al Convenio Básico de Cooperación Técnica entre Bolivia y Venezuela, en materia de cooperación educativa. 26/05/2006", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/ESYRLSoeSiRLkJB7RPPzHrUBJqE_wRqzG4V4sPx3boG8Kw?e=JUfzTc" },
      { title: "Convenio de cooperación para la capacitación de 250 estudiantes bolivianos en la Escuela de Polímeros de Pequiven en Venezuela. 26/05/2006", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EV8d_Seggz9MiUzdev9kptYBxsx7FW1oy0HGuWQHegufgA?e=sGRUL1" },
      { title: "Programa de intercambio Cultural entre el Ministerio de Culturas de Bolivia y el Ministerio del Poder Popular para la Cultura de Venezuela 2010-2011. 30/04/2010", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/Ee1WO4lDlK1Nmnj2BAKXPvkBl0E7mVC5f8bY_HXdhK5pYQ?e=6ZUdOo" },
      { title: "Acuerdo de Cooperación Turística entre Bolivia y Venezuela. 30/04/2010", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EV4LRbh2ku1Np0sC-O2T3I8BpzaH_SRfkeJtKHs5b3-s8A?e=XzFIRs" },
      { title: "Acuerdo de Cooperación Cultural entre Bolivia y Venezuela. 30/04/2010", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EcdxuQznrDhOk_VQrSBSHVQB_As6-G0yAm6XvsS1kudltQ?e=CdbRbG" },
      { title: "Carta plenos poderes. Programa de Intercambio Cultural entre Bolivia y Venezuela 2010-2011. 28/04/10", href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EY97k7aJ19FHnFJWeI3ArA0BSaDnkHBPJeAOS3yxEaGZuw?e=EhuYjN" },
    ],
  },
];

const governmentAgreementSections = [...ceubSections, ...bilateralSections];

const labels = {
  es: {
    eyebrow: "Repositorio institucional",
    title: "Otros convenios suscritos",
    intro:
      "Consulta los acuerdos suscritos con instituciones nacionales e internacionales que forman parte del archivo documental de la DRIC.",
    count: "convenios disponibles",
    noResults: "No se encontraron convenios con esa búsqueda.",
    searchLabel: "Buscar convenios",
    searchPlaceholder: "Buscar por institución, país, programa o fecha",
    governmentEyebrow: "Repositorio CEUB y Gobierno de Bolivia",
    governmentTitle: "Otros convenios suscritos por el CEUB y el Gobierno de Bolivia",
    governmentIntro:
      "Explora convenios suscritos por el CEUB con otras instituciones y acuerdos bilaterales organizados por país.",
    governmentCount: "documentos disponibles",
    fallback: "Detalle de convenio",
    fallbackText:
      "Esta vista se conectará posteriormente al contenido administrativo correspondiente.",
  },
  en: {
    eyebrow: "Institutional repository",
    title: "Other signed agreements",
    intro:
      "Review agreements signed with national and international institutions that are part of DRIC's documentary archive.",
    count: "available agreements",
    noResults: "No agreements matched that search.",
    searchLabel: "Search agreements",
    searchPlaceholder: "Search by institution, country, program, or date",
    governmentEyebrow: "CEUB and Government of Bolivia repository",
    governmentTitle: "Other agreements signed by CEUB and the Government of Bolivia",
    governmentIntro:
      "Explore CEUB agreements with other institutions and bilateral agreements organized by country.",
    governmentCount: "available documents",
    fallback: "Agreement detail",
    fallbackText:
      "This view will later connect to the corresponding administrative content.",
  },
};

function getDocumentBlocks(page: CmsPage | null, sectionKey: string): CmsBlock[] {
  return (
    page?.sections
      .find((section) => section.section_key === sectionKey)
      ?.blocks.filter((block) => block.type === "agreement_document") ?? []
  );
}

function cmsOtherAgreements(page: CmsPage | null): OtherAgreement[] {
  return getDocumentBlocks(page, "agreements.other.documents")
    .map((block) => ({
      es: block.title?.trim() ?? "",
      en: block.title?.trim() ?? "",
      href: publicAssetHref(typeof block.data?.href === "string" ? block.data.href : "", ""),
    }))
    .filter((agreement) => agreement.es && agreement.href);
}

function cmsGovernmentSections(
  page: CmsPage | null,
  fallbackTitle: string,
): GovernmentAgreementSection[] {
  const documents = getDocumentBlocks(page, "agreements.government.documents")
    .map((block) => ({
      title: block.title?.trim() ?? "",
      href: publicAssetHref(typeof block.data?.href === "string" ? block.data.href : "", ""),
    }))
    .filter((agreement) => agreement.title && agreement.href);

  if (!documents.length) {
    return [];
  }

  return [
    {
      title: page?.sections.find((section) => section.section_key === "agreements.government.documents")?.title
        ?? fallbackTitle,
      agreements: documents,
    },
  ];
}

function hasCmsSection(page: CmsPage | null, key: string): boolean {
  return Boolean(page?.sections.find((section) => section.section_key === key));
}

export default async function AgreementDetailPage({ params }: Props) {
  const { locale, slug } = await params;
  const activeLocale: Locale = locale === "en" ? "en" : "es";
  const t = labels[activeLocale];

  if (slug === "ceub-gobierno") {
    const cmsPage = await getOptionalPageBySlug("convenios-ceub-gobierno", activeLocale);
    const managedSections = cmsGovernmentSections(cmsPage, t.governmentTitle);
    const sections = hasCmsSection(cmsPage, "agreements.government.documents") ? managedSections : governmentAgreementSections;
    const totalGovernmentAgreements = sections.reduce(
      (total, section) => total + section.agreements.length,
      0,
    );

    return (
      <main className="dric-other-agreements-page min-h-screen overflow-x-hidden">
        <Header />

        <section className="dric-other-agreements-section relative px-4 pb-20 pt-36 sm:px-6 md:pb-28 md:pt-40 lg:px-12">
          <div className="mx-auto max-w-7xl">
            <div className="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
              <div>
                <p className="dric-other-agreements-eyebrow text-xs font-black uppercase tracking-[0.28em]">
                  {t.governmentEyebrow}
                </p>
                <h1 className="dric-other-agreements-title mt-5 max-w-4xl text-4xl font-light leading-tight tracking-wide sm:text-5xl md:text-6xl">
                  {t.governmentTitle}
                </h1>
              </div>

              <div className="dric-other-agreements-intro rounded-[28px] p-6 backdrop-blur-2xl md:p-8">
                <p className="dric-other-agreements-muted text-base leading-8 md:text-lg">
                  {t.governmentIntro}
                </p>
                <div className="dric-other-agreements-count mt-6 inline-flex rounded-full px-5 py-2 text-sm font-bold">
                  {totalGovernmentAgreements} {t.governmentCount}
                </div>
              </div>
            </div>

            <GovernmentAgreementsList
              locale={activeLocale}
              noResults={t.noResults}
              searchLabel={t.searchLabel}
              searchPlaceholder={t.searchPlaceholder}
              sections={sections}
            />
          </div>
        </section>

        <Footer />
      </main>
    );
  }

  if (slug !== "otros") {
    return (
      <main className="min-h-screen bg-[#020617] text-white">
        <Header />
        <section className="px-6 py-36">
          <div className="mx-auto max-w-5xl">
            <p className="mb-4 text-sm uppercase tracking-[0.3em] text-cyan-300">
              {t.fallback}
            </p>

            <h1 className="text-5xl font-bold capitalize leading-tight">
              {slug.replaceAll("-", " ")}
            </h1>

            <div className="mt-12 rounded-[32px] border border-white/10 bg-white/[0.03] p-10 backdrop-blur-xl">
              <p className="text-lg leading-8 text-white/70">{t.fallbackText}</p>
            </div>
          </div>
        </section>
        <Footer />
      </main>
    );
  }

  const cmsPage = await getOptionalPageBySlug("convenios-otros", activeLocale);
  const managedOtherAgreements = cmsOtherAgreements(cmsPage);
  const agreements = hasCmsSection(cmsPage, "agreements.other.documents") ? managedOtherAgreements : otherAgreements;

  return (
    <main className="dric-other-agreements-page min-h-screen overflow-x-hidden">
      <Header />

      <section className="dric-other-agreements-section relative px-4 pb-20 pt-36 sm:px-6 md:pb-28 md:pt-40 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
            <div>
              <p className="dric-other-agreements-eyebrow text-xs font-black uppercase tracking-[0.28em]">
                {t.eyebrow}
              </p>
              <h1 className="dric-other-agreements-title mt-5 max-w-3xl text-4xl font-light leading-tight tracking-wide sm:text-5xl md:text-6xl">
                {t.title}
              </h1>
            </div>

            <div className="dric-other-agreements-intro rounded-[28px] p-6 backdrop-blur-2xl md:p-8">
              <p className="dric-other-agreements-muted text-base leading-8 md:text-lg">{t.intro}</p>
              <div className="dric-other-agreements-count mt-6 inline-flex rounded-full px-5 py-2 text-sm font-bold">
                {agreements.length} {t.count}
              </div>
            </div>
          </div>

          <OtherAgreementsList
            agreements={agreements}
            locale={activeLocale}
            noResults={t.noResults}
            searchLabel={t.searchLabel}
            searchPlaceholder={t.searchPlaceholder}
          />
        </div>
      </section>

      <Footer />
    </main>
  );
}
