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
  contentSections?: ScholarshipOpportunitySection[];
};

export type ScholarshipOpportunitySection = {
  heading?: {
    es: string;
    en: string;
  };
  paragraphs?: {
    es: string;
    en: string;
  }[];
  bullets?: {
    label: {
      es: string;
      en: string;
    };
    text: {
      es: string;
      en: string;
    };
  }[];
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
          es: "DAAD - Servicio Alemán de Intercambio Académico (Alemania)",
          en: "DAAD - German Academic Exchange Service (Germany)",
        },
        body: {
          es: "El DAAD es una de las principales instituciones alemanas de cooperación académica internacional. Sus programas reúnen becas, estancias de investigación, estudios de posgrado, cursos especializados y oportunidades de movilidad para estudiantes, graduados, docentes e investigadores interesados en fortalecer su formación en Alemania.",
          en: "DAAD is one of Germany's leading institutions for international academic cooperation. Its programs bring together scholarships, research stays, postgraduate studies, specialized courses and mobility opportunities for students, graduates, faculty and researchers interested in strengthening their academic path in Germany.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Desde 2013, el DAAD cuenta con representación en Bolivia para promover oportunidades de estudio, investigación y cooperación académica con Alemania. Además de brindar orientación sobre universidades alemanas, ofrece información sobre programas de becas para estudiantes, profesionales, docentes e investigadores.",
                en: "Since 2013, DAAD has had representation in Bolivia to promote study, research and academic cooperation opportunities with Germany. In addition to providing guidance on German universities, it offers information about scholarship programs for students, professionals, faculty and researchers.",
              },
            ],
          },
          {
            heading: {
              es: "Estudiar en Alemania",
              en: "Studying in Germany",
            },
            paragraphs: [
              {
                es: "Alemania destaca por su sistema de educación superior de alta calidad y universidades públicas con costos de matrícula muy reducidos. Es posible acceder a programas de pregrado, maestría, doctorado e investigación, con acceso a bibliotecas, servicios universitarios, transporte público y residencias estudiantiles.",
                en: "Germany stands out for its high-quality higher education system and public universities with very low tuition costs. It is possible to access undergraduate, master's, doctoral and research programs, with access to libraries, university services, public transportation and student residences.",
              },
            ],
          },
          {
            heading: {
              es: "Costo de vida",
              en: "Cost of living",
            },
            paragraphs: [
              {
                es: "El costo promedio de manutención es de aproximadamente 750 euros mensuales. Los estudiantes internacionales pueden trabajar hasta 120 días al año, lo que les permite adquirir experiencia profesional y contribuir a sus gastos.",
                en: "The average cost of living is approximately 750 euros per month. International students may work up to 120 days per year, allowing them to gain professional experience and contribute to their expenses.",
              },
            ],
          },
          {
            heading: {
              es: "Becas del DAAD",
              en: "DAAD scholarships",
            },
            paragraphs: [
              {
                es: "El DAAD ofrece diversas becas, principalmente para estudios de posgrado e investigación, entre las que destacan:",
                en: "DAAD offers several scholarships, mainly for postgraduate studies and research, including:",
              },
            ],
            bullets: [
              {
                label: { es: "EPOS", en: "EPOS" },
                text: {
                  es: "Maestrías Interdisciplinarias para el Desarrollo.",
                  en: "Interdisciplinary Master's programs for development.",
                },
              },
              {
                label: { es: "PPGG", en: "PPGG" },
                text: {
                  es: "Maestrías en Políticas Públicas y Buen Gobierno.",
                  en: "Master's programs in Public Policy and Good Governance.",
                },
              },
              {
                label: { es: "Programa de Artes", en: "Arts Program" },
                text: {
                  es: "Maestrías y proyectos en artes escénicas, música, artes visuales, cine y arquitectura.",
                  en: "Master's programs and projects in performing arts, music, visual arts, film and architecture.",
                },
              },
              {
                label: { es: "Programas de Investigación", en: "Research Programs" },
                text: {
                  es: "Apoyo para proyectos científicos y académicos.",
                  en: "Support for scientific and academic projects.",
                },
              },
            ],
          },
        ],
        href: "https://www.daad.de/en/studying-in-germany/scholarships/",
        linkLabel: {
          es: "Ver sitio oficial DAAD",
          en: "Open DAAD official site",
        },
      },
      {
        slug: "kaad",
        title: {
          es: "KAAD - Servicio Católico Alemán de Intercambio Académico",
          en: "KAAD - German Catholic Academic Exchange Service",
        },
        body: {
          es: "El KAAD ofrece programas de becas orientados principalmente a estudios de posgrado, doctorado, investigación y formación académica en Alemania. Sus convocatorias valoran el rendimiento académico, la experiencia profesional, el compromiso social y la vinculación del proyecto de estudios con el desarrollo de la región de origen.",
          en: "KAAD offers scholarship programmes mainly focused on postgraduate studies, doctoral studies, research and academic training in Germany. Its calls value academic performance, professional experience, social commitment and the connection between the study project and the development of the applicant's home region.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El KAAD coopera con comités asociados conformados por representantes de la Iglesia Católica y de las universidades de los respectivos países de origen. Su programa está dirigido a posgraduados y profesionales con experiencia laboral, quienes pueden realizar estudios de posgrado o estancias de investigación en Alemania. Asimismo, contempla el apoyo a candidatos que cursan programas de maestría en su país de origen o en otros países.",
                en: "KAAD works in cooperation with partner committees composed of representatives from the Catholic Church and universities in the applicants’ respective countries of origin. Its scholarship programme is intended for postgraduate candidates and experienced professionals seeking to pursue advanced studies or research stays in Germany. It may also support candidates undertaking master’s degree programmes in their home countries or in third countries.",
              },
            ],
          },
          {
            heading: {
              es: "Programas disponibles",
              en: "Available programs",
            },
            bullets: [
              {
                label: { es: "Maestrías y posgrado", en: "Master's and postgraduate studies" },
                text: {
                  es: "Programas de maestría y estudios de posgrado en universidades alemanas.",
                  en: "Master's and postgraduate study programs at German universities.",
                },
              },
              {
                label: { es: "Doctorados y posdoctorados", en: "Doctoral and postdoctoral studies" },
                text: {
                  es: "Apoyo para formación doctoral y posdoctoral.",
                  en: "Support for doctoral and postdoctoral training.",
                },
              },
              {
                label: { es: "Estancias de investigación", en: "Research stays" },
                text: {
                  es: "Estancias de investigación de corta duración, de 2 a 6 meses.",
                  en: "Short-term research stays lasting 2 to 6 months.",
                },
              },
              {
                label: { es: "Cursos de alemán", en: "German courses" },
                text: {
                  es: "Posibilidad de acceder a cursos de alemán previos al inicio del programa.",
                  en: "Possibility of accessing German language courses before the program begins.",
                },
              },
            ],
          },
          {
            heading: {
              es: "Requisitos generales",
              en: "General requirements",
            },
            bullets: [
              {
                label: { es: "Residencia", en: "Residence" },
                text: {
                  es: "Ser ciudadano y residir en un país en desarrollo o emergente de América Latina, África, Asia o Medio Oriente.",
                  en: "Be a citizen and resident of a developing or emerging country in Latin America, Africa, Asia or the Middle East.",
                },
              },
              {
                label: { es: "Formación", en: "Academic background" },
                text: {
                  es: "Contar con título universitario y experiencia profesional.",
                  en: "Hold a university degree and have professional experience.",
                },
              },
              {
                label: { es: "Perfil académico y social", en: "Academic and social profile" },
                text: {
                  es: "Demostrar un buen desempeño académico y compromiso social.",
                  en: "Demonstrate strong academic performance and social commitment.",
                },
              },
              {
                label: { es: "Idioma alemán", en: "German language" },
                text: {
                  es: "Tener conocimientos del idioma alemán, generalmente nivel B1 o A2 para programas impartidos en inglés.",
                  en: "Have knowledge of German, generally level B1 or A2 for programs taught in English.",
                },
              },
              {
                label: { es: "Retorno", en: "Return commitment" },
                text: {
                  es: "Comprometerse a retornar al país de origen tras finalizar los estudios.",
                  en: "Commit to returning to the country of origin after completing the studies.",
                },
              },
            ],
          },
        ],
        href: "https://www.kaad.de/es/becas",
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
    opportunities: [
      {
        slug: "iwc-water-leadership-program-scholarships",
        title: {
          es: "IWC Water Leadership Program Scholarships",
          en: "IWC Water Leadership Program Scholarships",
        },
        body: {
          es: "Las IWC Water Leadership Program Scholarships son becas otorgadas por el International WaterCentre para apoyar el desarrollo de líderes del sector del agua mediante el Water Leadership Program, un programa de formación profesional impartido por Griffith University en Australia.",
          en: "The IWC Water Leadership Program Scholarships are awarded by the International WaterCentre to support the development of leaders in the water sector through the Water Leadership Program, a professional training program delivered by Griffith University in Australia.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las IWC Water Leadership Program Scholarships son becas otorgadas por el International WaterCentre (IWC) para apoyar el desarrollo de líderes del sector del agua mediante el Water Leadership Program, un programa de formación profesional impartido por Griffith University (Australia).",
                en: "The IWC Water Leadership Program Scholarships are awarded by the International WaterCentre (IWC) to support the development of leaders in the water sector through the Water Leadership Program, a professional training program delivered by Griffith University (Australia).",
              },
            ],
          },
          {
            heading: {
              es: "¿Qué ofrece?",
              en: "What does it offer?",
            },
            bullets: [
              {
                label: {
                  es: "Becas",
                  en: "Scholarships",
                },
                text: {
                  es: "Becas completas y parciales para participar en el Water Leadership Program.",
                  en: "Full and partial scholarships to participate in the Water Leadership Program.",
                },
              },
              {
                label: {
                  es: "Formación especializada",
                  en: "Specialized training",
                },
                text: {
                  es: "Formación especializada en liderazgo, gestión y desarrollo profesional en el sector del agua.",
                  en: "Specialized training in leadership, management and professional development in the water sector.",
                },
              },
              {
                label: {
                  es: "Duración",
                  en: "Duration",
                },
                text: {
                  es: "Programa de 10 meses que combina actividades virtuales con sesiones presenciales en Brisbane, Australia.",
                  en: "A 10-month program combining virtual activities with in-person sessions in Brisbane, Australia.",
                },
              },
              {
                label: {
                  es: "Acompañamiento",
                  en: "Support",
                },
                text: {
                  es: "Acceso a mentorías, coaching, estudios de caso y certificación otorgada por Griffith University.",
                  en: "Access to mentoring, coaching, case studies and certification awarded by Griffith University.",
                },
              },
            ],
          },
          {
            heading: {
              es: "Requisitos principales",
              en: "Main requirements",
            },
            bullets: [
              {
                label: {
                  es: "Experiencia laboral",
                  en: "Work experience",
                },
                text: {
                  es: "Contar con al menos tres años de experiencia laboral en el sector del agua.",
                  en: "Have at least three years of work experience in the water sector.",
                },
              },
              {
                label: {
                  es: "Idioma inglés",
                  en: "English language",
                },
                text: {
                  es: "Poseer un buen dominio del idioma inglés.",
                  en: "Have a good command of the English language.",
                },
              },
              {
                label: {
                  es: "Respaldo institucional",
                  en: "Institutional support",
                },
                text: {
                  es: "Contar con el respaldo del supervisor o empleador para participar en el programa.",
                  en: "Have the support of a supervisor or employer to participate in the program.",
                },
              },
              {
                label: {
                  es: "Compromiso",
                  en: "Commitment",
                },
                text: {
                  es: "Comprometerse a completar todas las actividades del programa, incluidas las sesiones presenciales en Australia.",
                  en: "Commit to completing all program activities, including the in-person sessions in Australia.",
                },
              },
            ],
          },
        ],
        href: "https://watercentre.org/professional-development/water-leadership-program/wlp-scholarships/",
        linkLabel: {
          es: "Ver sitio oficial IWC",
          en: "Open IWC official site",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "richard-plaschka-fellowship",
        title: {
          es: "Richard Plaschka Fellowship",
          en: "Richard Plaschka Fellowship",
        },
        body: {
          es: "La Richard Plaschka Fellowship es un programa de becas del OeAD que promueve la cooperación científica internacional mediante el financiamiento de estancias de investigación en Austria para especialistas en el área de Historia.",
          en: "The Richard Plaschka Fellowship is a scholarship program from OeAD that promotes international scientific cooperation by funding research stays in Austria for specialists in the field of History.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Richard Plaschka Fellowship es un programa de becas del OeAD (Agencia Austriaca para la Educación y la Internacionalización) que promueve la cooperación científica internacional mediante el financiamiento de estancias de investigación en Austria para especialistas en el área de Historia.",
                en: "The Richard Plaschka Fellowship is a scholarship program from OeAD (Austria's Agency for Education and Internationalisation) that promotes international scientific cooperation by funding research stays in Austria for specialists in the field of History.",
              },
            ],
          },
          {
            heading: {
              es: "¿Qué ofrece?",
              en: "What does it offer?",
            },
            bullets: [
              {
                label: {
                  es: "Estancias de investigación",
                  en: "Research stays",
                },
                text: {
                  es: "Becas para realizar estancias de investigación en universidades, archivos, bibliotecas e instituciones académicas de Austria.",
                  en: "Scholarships for research stays at universities, archives, libraries and academic institutions in Austria.",
                },
              },
              {
                label: {
                  es: "Proyectos históricos",
                  en: "Historical projects",
                },
                text: {
                  es: "Apoyo para el desarrollo de proyectos de investigación relacionados con la historia de Austria o temas históricos vinculados al país.",
                  en: "Support for research projects related to Austrian history or historical topics connected to the country.",
                },
              },
              {
                label: {
                  es: "Duración",
                  en: "Duration",
                },
                text: {
                  es: "Financiamiento con una duración de 4 a 12 meses, con posibilidad de extensión hasta 18 meses previa evaluación favorable.",
                  en: "Funding for 4 to 12 months, with the possibility of extension up to 18 months after a favorable evaluation.",
                },
              },
              {
                label: {
                  es: "Red académica",
                  en: "Academic network",
                },
                text: {
                  es: "Integración a una red internacional de investigadores y oportunidades de cooperación académica con instituciones austríacas.",
                  en: "Integration into an international network of researchers and academic cooperation opportunities with Austrian institutions.",
                },
              },
            ],
          },
          {
            heading: {
              es: "Requisitos principales",
              en: "Main requirements",
            },
            bullets: [
              {
                label: {
                  es: "Perfil académico",
                  en: "Academic profile",
                },
                text: {
                  es: "Ser estudiante de doctorado, investigador posdoctoral, docente universitario o investigador en el área de Historia o disciplinas afines.",
                  en: "Be a doctoral student, postdoctoral researcher, university lecturer or researcher in History or related disciplines.",
                },
              },
              {
                label: {
                  es: "Tema de investigación",
                  en: "Research topic",
                },
                text: {
                  es: "Desarrollar un proyecto de investigación con énfasis en la historia de Austria o en temas históricos relacionados con el país.",
                  en: "Develop a research project focused on Austrian history or historical topics related to the country.",
                },
              },
              {
                label: {
                  es: "Institución anfitriona",
                  en: "Host institution",
                },
                text: {
                  es: "Contar con una institución anfitriona o desarrollar la investigación en una universidad, archivo, biblioteca o centro de investigación en Austria.",
                  en: "Have a host institution or conduct the research at a university, archive, library or research center in Austria.",
                },
              },
              {
                label: {
                  es: "Postulación",
                  en: "Application",
                },
                text: {
                  es: "Presentar la solicitud a través de la plataforma oficial scholarships.at dentro de las fechas establecidas por el OeAD.",
                  en: "Submit the application through the official scholarships.at platform within the dates established by OeAD.",
                },
              },
            ],
          },
        ],
        href: "https://oead.at/en/study-research-teaching/overview-grants-and-scholarships/richard-plaschka-grant",
        linkLabel: {
          es: "Ver plataforma OeAD",
          en: "Open OeAD",
        },
      },
    ],
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
