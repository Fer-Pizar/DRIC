export type ScholarshipCatalogItem = {
  slug: string;
  type: "country" | "organization";
  name: {
    es: string;
    en: string;
  };
  region: {
    es: string;
    en: string;
  };
  summary: {
    es: string;
    en: string;
  };
  accent: string;
  children?: ScholarshipCatalogItem[];
  opportunities?: ScholarshipOpportunity[];
};

export type ScholarshipOpportunity = {
  slug: string;
  title: {
    es: string;
    en: string;
  };
  body: {
    es: string;
    en: string;
  };
  href: string;
  linkLabel: {
    es: string;
    en: string;
  };
};

export const scholarshipCountries: ScholarshipCatalogItem[] = [
  {
    slug: "alemania",
    type: "country",
    name: { es: "Alemania", en: "Germany" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas, movilidad y oportunidades académicas con instituciones alemanas.",
      en: "Scholarships, mobility and academic opportunities with German institutions.",
    },
    accent: "#003770",
    opportunities: [
      {
        slug: "daad",
        title: {
          es: "Servicio Alemán de Intercambio Académico (DAAD).",
          en: "German Academic Exchange Service (DAAD).",
        },
        body: {
          es: "El DAAD es una de las principales instituciones alemanas de cooperación académica internacional. Sus programas reúnen becas, estancias de investigación, estudios de posgrado, cursos especializados y oportunidades de movilidad para estudiantes, graduados, docentes e investigadores interesados en fortalecer su formación en Alemania.",
          en: "DAAD is one of Germany's leading institutions for international academic cooperation. Its programs bring together scholarships, research stays, postgraduate studies, specialized courses and mobility opportunities for students, graduates, faculty and researchers interested in strengthening their academic path in Germany.",
        },
        href: "https://www.daad.de/en/studying-in-germany/scholarships/",
        linkLabel: {
          es: "Ver sitio oficial DAAD",
          en: "Open DAAD official site",
        },
      },
      {
        slug: "kaad",
        title: {
          es: "Programa de becas KAAD",
          en: "KAAD scholarship programme",
        },
        body: {
          es: "El KAAD ofrece programas de becas orientados principalmente a estudios de posgrado, doctorado, investigación y formación académica en Alemania. Sus convocatorias valoran el rendimiento académico, la experiencia profesional, el compromiso social y la vinculación del proyecto de estudios con el desarrollo de la región de origen.",
          en: "KAAD offers scholarship programmes mainly focused on postgraduate studies, doctoral studies, research and academic training in Germany. Its calls value academic performance, professional experience, social commitment and the connection between the study project and the development of the applicant's home region.",
        },
        href: "https://www.kaad.de/en/stipendien/seite",
        linkLabel: {
          es: "Ver sitio oficial KAAD",
          en: "Open KAAD official site",
        },
      },
    ],
  },
  {
    slug: "australia",
    type: "country",
    name: { es: "Australia", en: "Australia" },
    region: { es: "Oceanía", en: "Oceanía" },
    summary: {
      es: "Programas académicos, investigación y convocatorias internacionales.",
      en: "Academic programs, research and international calls.",
    },
    accent: "#E30613",
  },
  {
    slug: "austria",
    type: "country",
    name: { es: "Austria", en: "Austria" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Oportunidades de formación, intercambio y cooperación académica.",
      en: "Training, exchange and academic cooperation opportunities.",
    },
    accent: "#003770",
  },
  {
    slug: "belgica",
    type: "country",
    name: { es: "Bélgica", en: "Belgium" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Convocatorias europeas, cooperación universitaria y movilidad.",
      en: "European calls, university cooperation and mobility.",
    },
    accent: "#E30613",
  },
  {
    slug: "brasil",
    type: "country",
    name: { es: "Brasil", en: "Brazil" },
    region: { es: "América Latina", en: "Latin America" },
    summary: {
      es: "Programas regionales, redes académicas y cooperación sur-sur.",
      en: "Regional programs, academic networks and south-south cooperation.",
    },
    accent: "#003770",
  },
  {
    slug: "chile",
    type: "country",
    name: { es: "Chile", en: "Chile" },
    region: { es: "América Latina", en: "Latin America" },
    summary: {
      es: "Movilidad regional, investigación conjunta y becas universitarias.",
      en: "Regional mobility, joint research and university scholarships.",
    },
    accent: "#E30613",
  },
  {
    slug: "china",
    type: "country",
    name: { es: "China", en: "China" },
    region: { es: "Asia", en: "Asia" },
    summary: {
      es: "Becas gubernamentales, movilidad y oportunidades académicas en Asia.",
      en: "Government scholarships, mobility and academic opportunities in Asia.",
    },
    accent: "#003770",
    children: [
      {
        slug: "hong-kong",
        type: "country",
        name: { es: "Hong Kong", en: "Hong Kong" },
        region: { es: "Asia", en: "Asia" },
        summary: {
          es: "Convocatorias y oportunidades específicas para Hong Kong.",
          en: "Specific calls and opportunities for Hong Kong.",
        },
        accent: "#E30613",
      },
    ],
  },
  {
    slug: "colombia",
    type: "country",
    name: { es: "Colombia", en: "Colombia" },
    region: { es: "América Latina", en: "Latin America" },
    summary: {
      es: "Intercambio académico, redes universitarias y programas regionales.",
      en: "Academic exchange, university networks and regional programs.",
    },
    accent: "#E30613",
  },
  {
    slug: "corea-del-sur",
    type: "country",
    name: { es: "Corea del Sur", en: "South Korea" },
    region: { es: "Asia", en: "Asia" },
    summary: {
      es: "Becas, posgrados y movilidad académica con instituciones coreanas.",
      en: "Scholarships, graduate studies and mobility with Korean institutions.",
    },
    accent: "#003770",
  },
  {
    slug: "ecuador",
    type: "country",
    name: { es: "Ecuador", en: "Ecuador" },
    region: { es: "América Latina", en: "Latin America" },
    summary: {
      es: "Cooperacion regional, intercambio y oportunidades académicas.",
      en: "Regional cooperation, exchange and academic opportunities.",
    },
    accent: "#E30613",
  },
  {
    slug: "espana",
    type: "country",
    name: { es: "España", en: "Spain" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas de grado, posgrado, movilidad y cooperación universitaria.",
      en: "Undergraduate, graduate, mobility and university cooperation scholarships.",
    },
    accent: "#003770",
  },
  {
    slug: "estados-unidos",
    type: "country",
    name: { es: "Estados Unidos", en: "United States" },
    region: { es: "Norteamérica", en: "North America" },
    summary: {
      es: "Convocatorias, investigación, intercambio y programas de liderazgo.",
      en: "Calls, research, exchange and leadership programs.",
    },
    accent: "#E30613",
  },
  {
    slug: "francia",
    type: "country",
    name: { es: "Francia", en: "France" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas, redes académicas y oportunidades de formación internacional.",
      en: "Scholarships, academic networks and international training opportunities.",
    },
    accent: "#003770",
  },
  {
    slug: "holanda",
    type: "country",
    name: { es: "Holanda", en: "Netherlands" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Programas de intercambio, becas y cooperación cientifica.",
      en: "Exchange programs, scholarships and scientific cooperation.",
    },
    accent: "#E30613",
  },
  {
    slug: "irlanda",
    type: "country",
    name: { es: "Irlanda", en: "Ireland" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Oportunidades académicas, posgrados y programas internacionales.",
      en: "Academic opportunities, graduate studies and international programs.",
    },
    accent: "#003770",
  },
  {
    slug: "italia",
    type: "country",
    name: { es: "Italia", en: "Italy" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas, intercambio cultural y cooperación académica internacional.",
      en: "Scholarships, cultural exchange and international academic cooperation.",
    },
    accent: "#E30613",
  },
  {
    slug: "japon",
    type: "country",
    name: { es: "Japón", en: "Japan" },
    region: { es: "Asia", en: "Asia" },
    summary: {
      es: "Becas, investigación, tecnología y movilidad académica.",
      en: "Scholarships, research, technology and academic mobility.",
    },
    accent: "#003770",
  },
  {
    slug: "mexico",
    type: "country",
    name: { es: "México", en: "Mexico" },
    region: { es: "América Latina", en: "Latin America" },
    summary: {
      es: "Programas regionales, posgrados y redes de cooperación académica.",
      en: "Regional programs, graduate studies and academic cooperation networks.",
    },
    accent: "#E30613",
  },
  {
    slug: "reino-unido",
    type: "country",
    name: { es: "Reino Unido", en: "United Kingdom" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas de excelencia, posgrados y oportunidades internacionales.",
      en: "Excellence scholarships, graduate studies and international opportunities.",
    },
    accent: "#003770",
  },
  {
    slug: "suecia",
    type: "country",
    name: { es: "Suecia", en: "Sweden" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Becas, sostenibilidad, investigación y movilidad académica.",
      en: "Scholarships, sustainability, research and academic mobility.",
    },
    accent: "#E30613",
  },
  {
    slug: "suiza",
    type: "country",
    name: { es: "Suiza", en: "Switzerland" },
    region: { es: "Europa", en: "Europe" },
    summary: {
      es: "Programas de investigación, movilidad y excelencia académica.",
      en: "Research programs, mobility and academic excellence.",
    },
    accent: "#003770",
  },
  {
    slug: "taiwan",
    type: "country",
    name: { es: "Taiwán", en: "Taiwan" },
    region: { es: "Asia", en: "Asia" },
    summary: {
      es: "Becas, tecnología, idiomas y programas académicos.",
      en: "Scholarships, technology, languages and academic programs.",
    },
    accent: "#E30613",
  },
  {
    slug: "turquia",
    type: "country",
    name: { es: "Turquía", en: "Turkey" },
    region: { es: "Europa / Asia", en: "Europe / Asia" },
    summary: {
      es: "Becas internacionales, movilidad y cooperación académica.",
      en: "International scholarships, mobility and academic cooperation.",
    },
    accent: "#003770",
  },
];

export const scholarshipOrganizations: ScholarshipCatalogItem[] = [
  {
    slug: "abe",
    type: "organization",
    name: { es: "ABE", en: "ABE" },
    region: { es: "Programa internacional", en: "International program" },
    summary: {
      es: "Convocatorias y programas especiales vinculados a ABE.",
      en: "Calls and special programs linked to ABE.",
    },
    accent: "#E30613",
  },
  {
    slug: "banco-mundial",
    type: "organization",
    name: { es: "Banco Mundial", en: "World Bank" },
    region: { es: "Organismo internacional", en: "International organization" },
    summary: {
      es: "Becas, investigación y oportunidades de desarrollo global.",
      en: "Scholarships, research and global development opportunities.",
    },
    accent: "#003770",
  },
  {
    slug: "egpp",
    type: "organization",
    name: { es: "EGPP", en: "EGPP" },
    region: { es: "Programa académico", en: "Academic program" },
    summary: {
      es: "Información y convocatorias administradas por programa.",
      en: "Program-managed information and calls.",
    },
    accent: "#E30613",
  },
  {
    slug: "union-europea",
    type: "organization",
    name: { es: "Unión Europea", en: "European Union" },
    region: { es: "Cooperacion europea", en: "European cooperation" },
    summary: {
      es: "Becas, movilidad, proyectos y cooperación internacional europea.",
      en: "Scholarships, mobility, projects and European international cooperation.",
    },
    accent: "#003770",
  },
  {
    slug: "otros",
    type: "organization",
    name: { es: "Otros", en: "Others" },
    region: { es: "Más oportunidades", en: "More opportunities" },
    summary: {
      es: "Otras convocatorias internacionales que no pertenecen a un pais especifico.",
      en: "Other international calls that do not belong to a specific country.",
    },
    accent: "#E30613",
  },
];

export const scholarshipCatalog = [
  ...scholarshipCountries,
  ...scholarshipCountries.flatMap((country) => country.children ?? []),
  ...scholarshipOrganizations,
];

export function findScholarshipCatalogItem(slug: string) {
  return scholarshipCatalog.find((item) => item.slug === slug);
}
