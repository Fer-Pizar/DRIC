"use client";

import { useMemo, useState } from "react";
import Link from "next/link";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import { Search, X } from "lucide-react";

type Locale = "es" | "en";

export type GovernmentAgreement = {
  title: string;
  href: string;
};

export type GovernmentAgreementSection = {
  title: string;
  agreements: GovernmentAgreement[];
};

type Props = {
  locale: Locale;
  noResults: string;
  searchLabel: string;
  searchPlaceholder: string;
  sections: GovernmentAgreementSection[];
};

const countryNames: Record<string, string> = {
  Alemania: "Germany",
  Argentina: "Argentina",
  Austria: "Austria",
  Bélgica: "Belgium",
  Brasil: "Brazil",
  Chile: "Chile",
  China: "China",
  Colombia: "Colombia",
  Corea: "South Korea",
  Cuba: "Cuba",
  Dinamarca: "Denmark",
  Ecuador: "Ecuador",
  EEUU: "United States",
  Egipto: "Egypt",
  España: "Spain",
  Francia: "France",
  Holanda: "Netherlands",
  Hungría: "Hungary",
  India: "India",
  Inglaterra: "United Kingdom",
  Israel: "Israel",
  Italia: "Italy",
  Japón: "Japan",
  México: "Mexico",
  OEA: "OAS",
  Panamá: "Panama",
  Paraguay: "Paraguay",
  Perú: "Peru",
  Rusia: "Russia",
  Suecia: "Sweden",
  Suiza: "Switzerland",
  Uruguay: "Uruguay",
  Venezuela: "Venezuela",
};

const phraseTranslations: Array<[RegExp, string]> = [
  [/Convenios suscritos por el CEUB con otras instituciones/gi, "Agreements signed by CEUB with other institutions"],
  [/Convenio Marco Interinstitucional de cooperación académica, científica y administrativa/gi, "Interinstitutional Framework Agreement for academic, scientific, and administrative cooperation"],
  [/Convenio Marco de Cooperación Interinstitucional/gi, "Framework Agreement for Interinstitutional Cooperation"],
  [/Convenio marco de cooperación interinstitucional/gi, "Framework Agreement for Interinstitutional Cooperation"],
  [/Convenio marco cooperación insterinstitucional/gi, "Framework Agreement for Interinstitutional Cooperation"],
  [/Convenio Marco de Colaboración Interinstitucional/gi, "Framework Agreement for Interinstitutional Collaboration"],
  [/Convenio marco de colaboración interinstitucional/gi, "Framework Agreement for Interinstitutional Collaboration"],
  [/Convenio marco de colaboración académica, científica y cultural/gi, "Framework Agreement for academic, scientific, and cultural collaboration"],
  [/Convenio marco de colaboración académica/gi, "Framework Agreement for academic collaboration"],
  [/Convenio de Cooperación Interinstitucional/gi, "Interinstitutional Cooperation Agreement"],
  [/Convenio de cooperación interinstitucional/gi, "Interinstitutional Cooperation Agreement"],
  [/Convenio de cooperación Interinstitucional/gi, "Interinstitutional Cooperation Agreement"],
  [/Convenio básico de cooperación técnica y científica/gi, "Basic Agreement on technical and scientific cooperation"],
  [/Convenio de cooperación cultural, científica y técnica/gi, "Agreement on cultural, scientific, and technical cooperation"],
  [/Convenio de cooperación Técnica y Científica/gi, "Agreement on technical and scientific cooperation"],
  [/Convenio de Cooperación Técnica y Científica/gi, "Agreement on technical and scientific cooperation"],
  [/Convenio de Cooperación Cultural/gi, "Cultural Cooperation Agreement"],
  [/Convenio de cooperación cultural/gi, "Cultural Cooperation Agreement"],
  [/Convenio Cultural/gi, "Cultural Agreement"],
  [/Convenio de cooperación turística/gi, "Tourism Cooperation Agreement"],
  [/Acuerdo de Cooperación Turística/gi, "Tourism Cooperation Agreement"],
  [/Acuerdo de cooperación turística/gi, "Tourism Cooperation Agreement"],
  [/Acuerdo de Cooperación Cultural/gi, "Cultural Cooperation Agreement"],
  [/Acuerdo de cooperación en materia de turismo/gi, "Agreement on tourism cooperation"],
  [/Acuerdo de Cooperación Técnica, Científica y de Asistencia Humanitaria/gi, "Agreement on technical, scientific, and humanitarian assistance cooperation"],
  [/Acuerdo de Cooperación en Ciencia y Tecnología/gi, "Agreement on Science and Technology Cooperation"],
  [/Acuerdo básico de Cooperación Técnica y Científica/gi, "Basic Agreement on Technical and Scientific Cooperation"],
  [/Acuerdo básico de cooperación técnica, científica y tecnológica/gi, "Basic Agreement on technical, scientific, and technological cooperation"],
  [/Acuerdo de Cooperación Científica y Tecnológica/gi, "Agreement on Scientific and Technological Cooperation"],
  [/Acuerdo de Cooperación Científico-Tecnica y Tecnológica/gi, "Agreement on Scientific, Technical, and Technological Cooperation"],
  [/Acuerdo Cultural/gi, "Cultural Agreement"],
  [/Acuerdo Básico de Cooperación/gi, "Basic Cooperation Agreement"],
  [/Acuerdo de Asistencia Técnica/gi, "Technical Assistance Agreement"],
  [/Acuerdo de cooperación/gi, "Cooperation Agreement"],
  [/Memorándum de entendimiento/gi, "Memorandum of Understanding"],
  [/Memorandum de Entendimiento/gi, "Memorandum of Understanding"],
  [/Memorandum de entendimiento/gi, "Memorandum of Understanding"],
  [/Memorandúm de Entendimiento/gi, "Memorandum of Understanding"],
  [/Protocolo de Intenciones/gi, "Protocol of Intentions"],
  [/Acta de canje de instrumentos de ratificación/gi, "Exchange of instruments of ratification record"],
  [/Acta de Canje/gi, "Exchange record"],
  [/Ley Nº/gi, "Law No."],
  [/Ley /gi, "Law "],
  [/D\.S\./gi, "Supreme Decree"],
  [/República de Bolivia/gi, "Republic of Bolivia"],
  [/Estado Plurinacional de Bolivia/gi, "Plurinational State of Bolivia"],
  [/Gobierno de Bolivia/gi, "Government of Bolivia"],
  [/Gobierno de la República de Bolivia/gi, "Government of the Republic of Bolivia"],
  [/Gobierno dela República de Bolivia/gi, "Government of the Republic of Bolivia"],
  [/Gobierno del Estado Plurinacional de Bolivia/gi, "Government of the Plurinational State of Bolivia"],
  [/Gobierno Autónomo/gi, "Autonomous Government"],
  [/Comité Ejecutivo de la Universidad Boliviana/gi, "Executive Committee of the Bolivian University"],
  [/Universidad Boliviana/gi, "Bolivian University"],
  [/Universidad Nacional/gi, "National University"],
  [/Universidades Españolas/gi, "Spanish Universities"],
  [/Ministerio de Desarrollo Productivo y Economía Plural/gi, "Ministry of Productive Development and Plural Economy"],
  [/Ministerio de Justicia y Transparencia Institucional/gi, "Ministry of Justice and Institutional Transparency"],
  [/Ministerio de Economía y Finanzas Públicas/gi, "Ministry of Economy and Public Finance"],
  [/Ministerio de la Presidencia/gi, "Ministry of the Presidency"],
  [/Ministerio de Obras Públicas Servicios y Vivienda/gi, "Ministry of Public Works, Services, and Housing"],
  [/Ministerio de Obras Públicas, Servicios y Vivienda/gi, "Ministry of Public Works, Services, and Housing"],
  [/Ministerio de Educación/gi, "Ministry of Education"],
  [/Ministerio de Culturas/gi, "Ministry of Cultures"],
  [/Tribunal Supremo de Justicia/gi, "Supreme Court of Justice"],
  [/Tribunal Constitucional Plurinacional/gi, "Plurinational Constitutional Court"],
  [/Tribunal Agroambiental/gi, "Agro-Environmental Court"],
  [/Consejo de la Magistratura/gi, "Council of the Magistracy"],
  [/Dirección del Notariado Plurinacional/gi, "Plurinational Notary Directorate"],
  [/Dirección Administrativa y Financiera del Órgano Judicial/gi, "Administrative and Financial Directorate of the Judicial Branch"],
  [/Escuela de Jueces del Estado/gi, "State Judges School"],
  [/Agencia Nacional de Hidrocarburos/gi, "National Hydrocarbons Agency"],
  [/Agencia Boliviana Espacial/gi, "Bolivian Space Agency"],
  [/Fondo de Desarrollo Indígena/gi, "Indigenous Development Fund"],
  [/Yacimientos Petrolíferos Fiscales Bolivianos/gi, "Bolivian Fiscal Oilfields"],
  [/Conferencia de Presidentes de Universidad/gi, "Conference of University Presidents"],
  [/Conferencia de Directores de las Escuelas Francesas de Ingenieros/gi, "Conference of Directors of French Engineering Schools"],
  [/conferencia de rectores/gi, "conference of rectors"],
  [/Cooperativa de Ahorro y Crédito de Vinculo Laboral/gi, "Employment-Based Savings and Credit Cooperative"],
  [/Universidad de Tecnología de Graz/gi, "Graz University of Technology"],
  [/Universidad Federal del Acre/gi, "Federal University of Acre"],
  [/Instituto Federal de Educación, Ciencia e Tecnología do ACRE/gi, "Federal Institute of Education, Science and Technology of Acre"],
  [/Universidad Nacional Amazónica de Madre de Dios/gi, "National Amazonian University of Madre de Dios"],
  [/República Federal de Alemania/gi, "Federal Republic of Germany"],
  [/República Argentina/gi, "Argentine Republic"],
  [/República Federativa del Brasil/gi, "Federative Republic of Brazil"],
  [/República Popular China/gi, "People's Republic of China"],
  [/República de Colombia/gi, "Republic of Colombia"],
  [/República de Corea/gi, "Republic of Korea"],
  [/República de Cuba/gi, "Republic of Cuba"],
  [/Reino de Dinamarca/gi, "Kingdom of Denmark"],
  [/República del Ecuador/gi, "Republic of Ecuador"],
  [/Estados Unidos de América/gi, "United States of America"],
  [/República Árabe de Egipto/gi, "Arab Republic of Egypt"],
  [/República de Francia/gi, "French Republic"],
  [/República Popular de Hungría/gi, "People's Republic of Hungary"],
  [/República de la India/gi, "Republic of India"],
  [/Consejo Británico/gi, "British Council"],
  [/Estado de Israel/gi, "State of Israel"],
  [/República Italiana/gi, "Italian Republic"],
  [/Estados Unidos Mexicanos/gi, "United Mexican States"],
  [/República de Panamá/gi, "Republic of Panama"],
  [/República de Paraguay/gi, "Republic of Paraguay"],
  [/República del Paraguay/gi, "Republic of Paraguay"],
  [/República del Perú/gi, "Republic of Peru"],
  [/Federación de Rusia/gi, "Russian Federation"],
  [/Confederación Suiza/gi, "Swiss Confederation"],
  [/República Oriental del Uruguay/gi, "Oriental Republic of Uruguay"],
  [/República Bolivariana de Venezuela/gi, "Bolivarian Republic of Venezuela"],
  [/aprobado y ratificado/gi, "approved and ratified"],
  [/Aprobado y ratificado/gi, "Approved and ratified"],
  [/Aprobado/gi, "Approved"],
  [/Ratificado/gi, "Ratified"],
  [/ratificando/gi, "ratifying"],
  [/aprueba y ratifica/gi, "approves and ratifies"],
  [/aprueba/gi, "approves"],
  [/suscrito entre/gi, "signed between"],
  [/celebrado entre/gi, "entered into between"],
  [/entre/gi, "between"],
  [/ y /gi, " and "],
  [/para/gi, "for"],
  [/sobre/gi, "on"],
  [/en materia de/gi, "in the area of"],
  [/en el área de/gi, "in the area of"],
  [/en las áreas de/gi, "in the areas of"],
  [/en apoyo a/gi, "in support of"],
  [/la cooperación/gi, "cooperation"],
  [/cooperación/gi, "cooperation"],
  [/colaboración/gi, "collaboration"],
  [/interinstitucional/gi, "interinstitutional"],
  [/académica/gi, "academic"],
  [/científica/gi, "scientific"],
  [/técnica/gi, "technical"],
  [/tecnológica/gi, "technological"],
  [/cultural/gi, "cultural"],
  [/educativa/gi, "educational"],
  [/turismo/gi, "tourism"],
  [/educación superior/gi, "higher education"],
  [/reconocimiento/gi, "recognition"],
  [/títulos/gi, "degrees"],
  [/diplomas/gi, "diplomas"],
  [/certificados académicos/gi, "academic certificates"],
  [/estudios parciales/gi, "partial studies"],
  [/recuperación de bienes culturales/gi, "recovery of cultural property"],
  [/robados, importados o exportados ilícitamente/gi, "stolen, imported, or exported illicitly"],
  [/intercambio/gi, "exchange"],
  [/profesores/gi, "professors"],
  [/estudiantes/gi, "students"],
  [/viajes/gi, "travel"],
  [/deporte/gi, "sports"],
  [/salud/gi, "health"],
  [/ciencia/gi, "science"],
  [/Propiedad Intelectual/gi, "Intellectual Property"],
];

function translateGovernmentText(text: string, locale: Locale) {
  if (locale === "es") {
    return text;
  }

  if (countryNames[text]) {
    return countryNames[text];
  }

  return phraseTranslations.reduce(
    (translated, [pattern, replacement]) => translated.replace(pattern, replacement),
    text,
  );
}

export default function GovernmentAgreementsList({
  locale,
  noResults,
  searchLabel,
  searchPlaceholder,
  sections,
}: Props) {
  const [query, setQuery] = useState("");
  const normalizedQuery = query.trim().toLocaleLowerCase();

  const filteredSections = useMemo(() => {
    if (!normalizedQuery) {
      return sections;
    }

    return sections
      .map((section) => ({
        ...section,
        agreements: section.agreements.filter((agreement) =>
          `${section.title} ${agreement.title} ${translateGovernmentText(section.title, locale)} ${translateGovernmentText(agreement.title, locale)}`
            .toLocaleLowerCase()
            .includes(normalizedQuery),
        ),
      }))
      .filter((section) => section.agreements.length > 0);
  }, [locale, normalizedQuery, sections]);

  return (
    <>
      <div className="dric-other-agreements-search mt-12 flex items-center gap-4 rounded-[28px] px-5 py-4 backdrop-blur-2xl md:mt-16 md:px-6">
        <Search className="h-5 w-5 shrink-0" aria-hidden="true" />
        <label className="sr-only" htmlFor="government-agreement-search">
          {searchLabel}
        </label>
        <input
          id="government-agreement-search"
          type="search"
          value={query}
          onChange={(event) => setQuery(event.target.value)}
          placeholder={searchPlaceholder}
          className="dric-other-agreements-search-input min-w-0 flex-1 bg-transparent text-base font-semibold outline-none md:text-lg"
        />
        {query ? (
          <button
            type="button"
            onClick={() => setQuery("")}
            className="dric-other-agreements-search-clear inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full transition"
            aria-label={locale === "es" ? "Limpiar búsqueda" : "Clear search"}
          >
            <X className="h-4 w-4" aria-hidden="true" />
          </button>
        ) : null}
      </div>

      <div className="mt-8 grid gap-8">
        {filteredSections.length ? (
          filteredSections.map((section) => {
            const sectionTitle = translateGovernmentText(section.title, locale);

            return (
              <section key={section.title} className="dric-government-agreement-section overflow-hidden rounded-[30px] backdrop-blur-2xl">
                <div className="dric-government-agreement-heading px-5 py-5 sm:px-7 md:px-8">
                  <div className="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <h2 className="dric-government-agreement-section-title text-2xl font-light uppercase leading-tight tracking-wide">
                      {sectionTitle}
                    </h2>
                    <span className="dric-other-agreements-count inline-flex w-fit rounded-full px-4 py-1.5 text-xs font-bold">
                      {section.agreements.length}
                    </span>
                  </div>
                </div>

                <div>
                  {section.agreements.map((agreement, index) => (
                    <Link
                      key={`${section.title}-${agreement.href}-${index}`}
                      href={agreement.href}
                      className="dric-other-agreement-row group relative block px-5 py-5 transition duration-300 sm:px-7 md:px-8"
                    >
                      <div className="flex items-start gap-4 md:gap-6">
                        <div className="dric-other-agreement-icon mt-1 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl transition duration-300">
                          <DescriptionRoundedIcon sx={{ fontSize: 23 }} />
                        </div>

                        <div className="min-w-0 flex-1">
                          <div className="flex items-center gap-3">
                            <span className="dric-other-agreement-number text-xs font-black uppercase tracking-[0.18em] transition duration-300">
                              {String(index + 1).padStart(2, "0")}
                            </span>
                            <span className="dric-other-agreement-rule h-px flex-1 transition duration-300" />
                          </div>

                          <h3 className="dric-other-agreement-title mt-3 text-base font-semibold leading-7 transition duration-300 md:text-lg md:leading-8">
                            {translateGovernmentText(agreement.title, locale)}
                          </h3>
                        </div>
                      </div>
                    </Link>
                  ))}
                </div>
              </section>
            );
          })
        ) : (
          <div className="dric-other-agreements-list rounded-[30px] px-5 py-10 text-center backdrop-blur-2xl sm:px-7 md:px-8">
            <p className="dric-other-agreements-muted text-base font-semibold">{noResults}</p>
          </div>
        )}
      </div>
    </>
  );
}
