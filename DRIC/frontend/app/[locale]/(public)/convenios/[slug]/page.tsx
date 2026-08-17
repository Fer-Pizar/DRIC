import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import OtherAgreementsList from "./OtherAgreementsList";

type Props = {
  params: Promise<{
    locale: string;
    slug: string;
  }>;
};

type Locale = "es" | "en";

const otherAgreements = [
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
    fallback: "Agreement detail",
    fallbackText:
      "This view will later connect to the corresponding administrative content.",
  },
};

export default async function AgreementDetailPage({ params }: Props) {
  const { locale, slug } = await params;
  const activeLocale: Locale = locale === "en" ? "en" : "es";
  const t = labels[activeLocale];

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
                {otherAgreements.length} {t.count}
              </div>
            </div>
          </div>

          <OtherAgreementsList
            agreements={otherAgreements}
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
