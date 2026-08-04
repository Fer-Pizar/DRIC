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
  links?: ScholarshipOpportunityLink[];
  contentSections?: ScholarshipOpportunitySection[];
};

export type ScholarshipOpportunityLink = {
  href: string;
  label: {
    es: string;
    en: string;
  };
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
  bullets?: ScholarshipOpportunityBullet[];
};

export type ScholarshipOpportunityBullet = {
  label?: {
    es: string;
    en: string;
  };
  text: {
    es: string;
    en: string;
  };
  children?: ScholarshipOpportunityBullet[];
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
    opportunities: [
      {
        slug: "becas-internacionales-ares",
        title: {
          es: "Becas Internacionales ARES",
          en: "ARES International Scholarships",
        },
        body: {
          es: "Las Becas Internacionales ARES son un programa financiado por la Académie de Recherche et d'Enseignement Supérieur de Bélgica, destinado a fortalecer la formación de profesionales de países socios mediante becas para programas de maestría especializada y cursos internacionales en instituciones de educación superior belgas.",
          en: "The ARES International Scholarships are funded by Belgium's Académie de Recherche et d'Enseignement Supérieur and are designed to strengthen the training of professionals from partner countries through scholarships for specialized master's programs and international courses at Belgian higher education institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas Internacionales ARES son un programa financiado por la Académie de Recherche et d'Enseignement Supérieur (ARES) de Bélgica, destinado a fortalecer la formación de profesionales de países socios mediante becas para programas de maestría especializada y cursos internacionales en instituciones de educación superior belgas.",
                en: "The ARES International Scholarships are funded by Belgium's Académie de Recherche et d'Enseignement Supérieur (ARES) and are designed to strengthen the training of professionals from partner countries through scholarships for specialized master's programs and international courses at Belgian higher education institutions.",
              },
            ],
          },
          { 
            bullets: [
              {
                text: {
                  es: "Becas completas para cursar maestrías especializadas y programas internacionales de formación en Bélgica.",
                  en: "Full scholarships to pursue specialized master's degrees and international training programs in Belgium.",
                },
              },
              {
                text: {
                  es: "Cobertura de matrícula, pasajes aéreos, manutención, seguro médico, gastos de instalación y visa, según las condiciones de la convocatoria.",
                  en: "Coverage of tuition, airfare, living expenses, health insurance, installation costs and visa expenses, according to the conditions of the call.",
                },
              },
              {
                text: {
                  es: "Formación en áreas prioritarias para el desarrollo sostenible.",
                  en: "Training in priority areas for sustainable development.",
                },
              },
            ],
          },
          {
            heading: {
              es: "Áreas de formación",
              en: "Training areas",
            },
            bullets: [
              {
                text: { es: "Derechos humanos.", en: "Human rights." },
              },
              {
                text: { es: "Gestión de riesgos y desastres.", en: "Risk and disaster management." },
              },
              {
                text: { es: "Gestión integrada de riesgos sanitarios.", en: "Integrated health risk management." },
              },
              {
                text: { es: "Economía internacional y del desarrollo.", en: "International and development economics." },
              },
              {
                text: { es: "Microfinanzas.", en: "Microfinance." },
              },
              {
                text: { es: "Salud pública.", en: "Public health." },
              },
              {
                text: { es: "Políticas y sistemas internacionales de salud.", en: "International health policies and systems." },
              },
              {
                text: { es: "Transporte y logística.", en: "Transport and logistics." },
              },
              {
                text: { es: "Innovación social.", en: "Social innovation." },
              },
              {
                text: { es: "Nexus agua, energía y alimentación.", en: "Water, energy and food nexus." },
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
                text: {
                  es: "Contar con el título académico requerido para el programa de interés.",
                  en: "Hold the academic degree required for the program of interest.",
                },
              },
              {
                text: {
                  es: "Poseer experiencia profesional relevante, según los requisitos específicos de cada programa.",
                  en: "Have relevant professional experience, according to the specific requirements of each program.",
                },
              },
              {
                text: {
                  es: "Presentar la postulación exclusivamente a través de la plataforma oficial GIRAF dentro de los plazos establecidos en la convocatoria.",
                  en: "Submit the application exclusively through the official GIRAF platform within the deadlines established in the call.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos particulares del programa académico seleccionado.",
                  en: "Meet the specific requirements of the selected academic program.",
                },
              },
            ],
          },
        ],
        href: "https://www.ares-ac.be/en/scholarships",
        linkLabel: {
          es: "Ver sitio oficial ARES",
          en: "Open ARES official site",
        },
      },
      {
        slug: "becas-internacionales-vlir-uos",
        title: {
          es: "Becas Internacionales VLIR-UOS",
          en: "VLIR-UOS International Scholarships",
        },
        body: {
          es: "Las Becas Internacionales VLIR-UOS son un programa financiado por VLIR-UOS que promueve la formación académica y el desarrollo sostenible mediante becas para estudios superiores en universidades e instituciones de educación superior de Flandes, Bélgica.",
          en: "The VLIR-UOS International Scholarships are funded by VLIR-UOS and promote academic training and sustainable development through scholarships for higher education studies at universities and higher education institutions in Flanders, Belgium.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas Internacionales VLIR-UOS son un programa financiado por VLIR-UOS (Flemish Interuniversity Council for University Development Cooperation) que promueve la formación académica y el desarrollo sostenible mediante becas para estudios superiores en universidades e instituciones de educación superior de Flandes, Bélgica.",
                en: "The VLIR-UOS International Scholarships are funded by VLIR-UOS (Flemish Interuniversity Council for University Development Cooperation) and promote academic training and sustainable development through scholarships for higher education studies at universities and higher education institutions in Flanders, Belgium.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas completas para cursar programas de licenciatura profesional, maestrías iniciales y maestrías de especialización impartidos en inglés.",
                  en: "Full scholarships to pursue professional bachelor's programs, initial master's programs and advanced master's programs taught in English.",
                },
              },
              {
                text: {
                  es: "Cobertura de matrícula, pasajes aéreos, seguro médico, alojamiento y manutención durante toda la duración del programa.",
                  en: "Coverage of tuition, airfare, health insurance, accommodation and living expenses throughout the full duration of the program.",
                },
              },
              {
                text: {
                  es: "Formación en diversas áreas del conocimiento orientadas al desarrollo sostenible, entre ellas:",
                  en: "Training in various fields of knowledge oriented toward sustainable development, including:",
                },
                children: [
                  {
                    text: { es: "Desarrollo Sostenible.", en: "Sustainable Development." },
                  },
                  {
                    text: { es: "Antropología y Desarrollo.", en: "Anthropology and Development." },
                  },
                  {
                    text: { es: "Gobernanza y Desarrollo.", en: "Governance and Development." },
                  },
                  {
                    text: { es: "Economía y Evaluación del Desarrollo.", en: "Development Economics and Evaluation." },
                  },
                  {
                    text: { es: "Tecnología de Alimentos.", en: "Food Technology." },
                  },
                  {
                    text: { es: "Epidemiología.", en: "Epidemiology." },
                  },
                  {
                    text: { es: "Nutrición y Sistemas Alimentarios.", en: "Nutrition and Food Systems." },
                  },
                  {
                    text: { es: "Recursos Hídricos.", en: "Water Resources." },
                  },
                  {
                    text: { es: "Acuicultura.", en: "Aquaculture." },
                  },
                  {
                    text: { es: "Estadística y Ciencia de Datos.", en: "Statistics and Data Science." },
                  },
                  {
                    text: { es: "Transporte y Seguridad Vial.", en: "Transport and Road Safety." },
                  },
                  {
                    text: { es: "Biodiversidad y Ecosistemas Tropicales.", en: "Biodiversity and Tropical Ecosystems." },
                  },
                  {
                    text: { es: "Desarrollo Rural.", en: "Rural Development." },
                  },
                  {
                    text: { es: "Asentamientos Humanos.", en: "Human Settlements." },
                  },
                ],
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
                text: {
                  es: "Cumplir con los requisitos de admisión establecidos por el programa académico seleccionado.",
                  en: "Meet the admission requirements established by the selected academic program.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud a través de la universidad belga que ofrece el programa, indicando el interés en postular a una beca VLIR-UOS.",
                  en: "Submit the application through the Belgian university offering the program, indicating interest in applying for a VLIR-UOS scholarship.",
                },
              },
              {
                text: {
                  es: "Solo es posible presentar una solicitud de beca por convocatoria.",
                  en: "Only one scholarship application may be submitted per call.",
                },
              },
            ],
          },
        ],
        href: "https://www.vliruos.be/en/scholarships",
        linkLabel: {
          es: "Ver sitio oficial VLIR-UOS",
          en: "Open VLIR-UOS official site",
        },
      },
      {
        slug: "programa-becas-grupo-coimbra-latinoamerica",
        title: {
          es: "Programa de Becas del Grupo Coimbra para Profesores e Investigadores Latinoamericanos",
          en: "Coimbra Group Scholarship Program for Latin American Professors and Researchers",
        },
        body: {
          es: "El Programa de Becas del Grupo Coimbra es una iniciativa de la Coimbra Group que promueve la cooperación académica y científica mediante becas para realizar estancias cortas de investigación en Europa.",
          en: "The Coimbra Group Scholarship Program is an initiative of the Coimbra Group that promotes academic and scientific cooperation through scholarships for short research stays in Europe.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas del Grupo Coimbra es una iniciativa de la Coimbra Group, asociación integrada por prestigiosas universidades europeas, que promueve la cooperación académica y científica mediante becas para realizar estancias cortas de investigación en Europa.",
                en: "The Coimbra Group Scholarship Program is an initiative of the Coimbra Group, an association made up of prestigious European universities, that promotes academic and scientific cooperation through scholarships for short research stays in Europe.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estancias de investigación de 1 a 3 meses en universidades miembros del Grupo Coimbra.",
                  en: "Scholarships for research stays of 1 to 3 months at Coimbra Group member universities.",
                },
              },
              {
                text: {
                  es: "Oportunidad de fortalecer proyectos de investigación y establecer redes de cooperación internacional con instituciones europeas.",
                  en: "Opportunity to strengthen research projects and establish international cooperation networks with European institutions.",
                },
              },
              {
                text: {
                  es: "Financiamiento otorgado por la universidad anfitriona, el cual puede incluir apoyo para manutención, alojamiento y otros gastos relacionados con la estancia, según las condiciones de cada institución participante.",
                  en: "Funding awarded by the host university, which may include support for living expenses, accommodation and other costs related to the stay, according to the conditions of each participating institution.",
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
                text: {
                  es: "Ser profesor o investigador vinculado a una universidad reconocida de América Latina.",
                  en: "Be a professor or researcher affiliated with a recognized university in Latin America.",
                },
              },
              {
                text: {
                  es: "Contar con un título universitario.",
                  en: "Hold a university degree.",
                },
              },
              {
                text: {
                  es: "Obtener una carta de aceptación de un supervisor académico de la universidad europea anfitriona.",
                  en: "Obtain an acceptance letter from an academic supervisor at the European host university.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante la plataforma oficial del Grupo Coimbra dentro del período de la convocatoria.",
                  en: "Submit the application through the official Coimbra Group platform within the call period.",
                },
              },
            ],
          },
        ],
        href: "https://www.coimbra-group.eu/scholarships/grant-information-for-latin-america/",
        linkLabel: {
          es: "Ver sitio oficial Grupo Coimbra",
          en: "Open Coimbra Group official site",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "programa-estudios-posgrado-pec-pg",
        title: {
          es: "Programa de Estudios de Posgrado PEC-PG",
          en: "PEC-PG Graduate Studies Program",
        },
        body: {
          es: "El Programa de Estudiantes-Convênio de Posgrado ofrece becas para que ciudadanos de países participantes, entre ellos Bolivia, realicen estudios de maestría y doctorado en universidades brasileñas de reconocido prestigio.",
          en: "The Graduate Student Agreement Program offers scholarships for citizens of participating countries, including Bolivia, to pursue master's and doctoral studies at prestigious Brazilian universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Estudiantes-Convênio de Posgrado (PEC-PG) ofrece becas para que ciudadanos de países participantes, entre ellos Bolivia, realicen estudios de maestría y doctorado en universidades brasileñas de reconocido prestigio.",
                en: "The Graduate Student Agreement Program (PEC-PG) offers scholarships for citizens of participating countries, including Bolivia, to pursue master's and doctoral studies at prestigious Brazilian universities.",
              },
              {
                es: "Las becas contemplan una asignación mensual, apoyo para seguro médico y la posibilidad de desarrollar actividades académicas e investigativas en diversas áreas del conocimiento, conforme a las condiciones establecidas en cada convocatoria.",
                en: "The scholarships include a monthly allowance, support for health insurance and the possibility of carrying out academic and research activities in various fields of knowledge, according to the conditions established in each call.",
              },
            ],
          },
          {
            heading: {
              es: "¿Cómo aplicar?",
              en: "How to apply?",
            },
            paragraphs: [
              {
                es: "Las postulaciones se realizan en línea a través de la plataforma oficial de CAPES. Antes de postular, se recomienda revisar cuidadosamente los requisitos de elegibilidad, la convocatoria vigente y la documentación solicitada.",
                en: "Applications are submitted online through the official CAPES platform. Before applying, it is recommended to carefully review the eligibility requirements, the current call and the requested documentation.",
              },
              {
                es: "La convocatoria se publica anualmente, por lo que se recomienda consultar periódicamente los sitios oficiales para verificar las fechas de apertura y cierre de cada edición.",
                en: "The call is published annually, so it is recommended to periodically check the official websites to verify the opening and closing dates for each edition.",
              },
            ],
          },
        ],
        href: "https://www.gov.br/capes/pt-br/acesso-a-informacao/acoes-e-programas/cooperacao-internacional/multinacional/programa-de-estudantes-convenio-de-pos-graduacao-pec-pg",
        linkLabel: {
          es: "Información oficial",
          en: "Official information",
        },
        links: [
          {
            href: "https://www.gov.br/capes/pt-br/acesso-a-informacao/acoes-e-programas/cooperacao-internacional/multinacional/programa-de-estudantes-convenio-de-pos-graduacao-pec-pg",
            label: {
              es: "Información oficial",
              en: "Official information",
            },
          },
          {
            href: "https://inscricao.capes.gov.br/",
            label: {
              es: "Portal de postulaciones",
              en: "Application portal",
            },
          },
        ],
      },
      {
        slug: "programa-estudiantes-convenio-posgrado-pec-pg-mre",
        title: {
          es: "Programa de Estudiantes-Convênio de Posgrado (PEC-PG)",
          en: "Graduate Student Agreement Program (PEC-PG)",
        },
        body: {
          es: "El Programa de Estudiantes-Convênio de Posgrado (PEC-PG) es una iniciativa del Gobierno de Brasil, coordinada por el Ministerio de Relaciones Exteriores, CAPES y CNPq, que ofrece becas para realizar estudios de maestría y doctorado en universidades brasileñas participantes.",
          en: "The Graduate Student Agreement Program (PEC-PG) is an initiative of the Government of Brazil, coordinated by the Ministry of Foreign Affairs, CAPES and CNPq, offering scholarships for master's and doctoral studies at participating Brazilian universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Estudiantes-Convênio de Posgrado (PEC-PG) es una iniciativa del Gobierno de Brasil, coordinada por el Ministerio de Relaciones Exteriores (MRE), CAPES y CNPq, que ofrece becas para realizar estudios de maestría y doctorado en universidades brasileñas participantes.",
                en: "The Graduate Student Agreement Program (PEC-PG) is an initiative of the Government of Brazil, coordinated by the Ministry of Foreign Affairs (MRE), CAPES and CNPq, offering scholarships for master's and doctoral studies at participating Brazilian universities.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para cursar maestrías y doctorados presenciales en diversas áreas del conocimiento.",
                  en: "Scholarships for in-person master's and doctoral programs in various fields of knowledge.",
                },
              },
              {
                text: {
                  es: "Financiamiento que contempla asignación mensual, apoyo para seguro médico y otros beneficios establecidos en cada convocatoria.",
                  en: "Funding that includes a monthly allowance, support for health insurance and other benefits established in each call.",
                },
              },
              {
                text: {
                  es: "Oportunidad de desarrollar actividades académicas y de investigación en instituciones brasileñas de educación superior.",
                  en: "Opportunity to develop academic and research activities at Brazilian higher education institutions.",
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
                text: {
                  es: "Contar con el título académico requerido para el nivel de estudios al que se postula.",
                  en: "Hold the academic degree required for the level of study being applied to.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos establecidos por la universidad brasileña y por la convocatoria vigente.",
                  en: "Meet the requirements established by the Brazilian university and by the current call.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud a través de la plataforma oficial de CAPES, conforme al proceso de selección publicado para cada edición.",
                  en: "Submit the application through the official CAPES platform, according to the selection process published for each edition.",
                },
              },
            ],
          },
          
        ],
        href: "https://www.gov.br/mre/es/temas/cultura-y-educacion/cooperacion-educativa/oportunidades-de-estudio-para-extranjeros/pec-pg-posgrado/proceso-de-seleccion",
        linkLabel: {
          es: "Ver proceso de selección",
          en: "Open selection process",
        },
      },
      {
        slug: "unila-pregrado-proceso-selectivo-pueblos-indigenas",
        title: {
          es: "Universidad Federal de la Integración Latinoamericana - UNILA (Pregrado)",
          en: "Federal University of Latin American Integration - UNILA (Undergraduate)",
        },
        body: {
          es: "La Universidad Federal de la Integración Latinoamericana es una universidad pública ubicada en Foz do Iguaçu, en la triple frontera entre Brasil, Paraguay y Argentina, que promueve la integración académica, científica y cultural de América Latina y el Caribe.",
          en: "The Federal University of Latin American Integration is a public university located in Foz do Iguaçu, on the triple border between Brazil, Paraguay and Argentina, promoting academic, scientific and cultural integration in Latin America and the Caribbean.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Universidad Federal de la Integración Latinoamericana (UNILA) es una universidad pública ubicada en Foz do Iguaçu, en la triple frontera entre Brasil, Paraguay y Argentina. La institución promueve la integración académica, científica y cultural de América Latina y el Caribe, desarrollando sus actividades en un entorno bilingüe (portugués y español).",
                en: "The Federal University of Latin American Integration (UNILA) is a public university located in Foz do Iguaçu, on the triple border between Brazil, Paraguay and Argentina. The institution promotes academic, scientific and cultural integration in Latin America and the Caribbean, carrying out its activities in a bilingual environment (Portuguese and Spanish).",
              },
            ],
          },
          {
            heading: {
              es: "Proceso Selectivo para Pueblos Indígenas (PSIN)",
              en: "Selection Process for Indigenous Peoples (PSIN)",
            },
            paragraphs: [
              {
                es: "UNILA ofrece un proceso de admisión dirigido a estudiantes indígenas de América Latina y el Caribe interesados en cursar programas de pregrado en Brasil.",
                en: "UNILA offers an admission process aimed at Indigenous students from Latin America and the Caribbean interested in pursuing undergraduate programs in Brazil.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Acceso a programas de pregrado en una universidad pública sin costo de matrícula.",
                  en: "Access to undergraduate programs at a public university with no tuition fees.",
                },
              },
              {
                text: {
                  es: "Formación en un ambiente multicultural e internacional.",
                  en: "Education in a multicultural and international environment.",
                },
              },
              {
                text: {
                  es: "Programas impartidos en diversas áreas del conocimiento con enfoque en la integración latinoamericana.",
                  en: "Programs offered in various fields of knowledge with a focus on Latin American integration.",
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
                text: {
                  es: "Haber concluido la educación secundaria o equivalente.",
                  en: "Have completed secondary education or its equivalent.",
                },
              },
              {
                text: {
                  es: "Verificar los requisitos establecidos en la convocatoria vigente de UNILA.",
                  en: "Verify the requirements established in the current UNILA call.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación a través del Proceso Selectivo para Pueblos Indígenas (PSIN).",
                  en: "Apply through the Selection Process for Indigenous Peoples (PSIN).",
                },
              },
            ],
          },
        ],
        href: "https://divulga.unila.edu.br/internacional/graduacao/ingresso-psin/",
        linkLabel: {
          es: "Ver proceso PSIN",
          en: "Open PSIN process",
        },
      },
      {
        slug: "grupo-cooperacion-internacional-universidades-brasilenas-gcub",
        title: {
          es: "Grupo de Cooperación Internacional de Universidades Brasileñas (GCUB)",
          en: "International Cooperation Group of Brazilian Universities (GCUB)",
        },
        body: {
          es: "El Grupo de Cooperación Internacional de Universidades Brasileñas es una asociación académica sin fines de lucro que promueve la cooperación científica, académica y cultural, así como la internacionalización de la educación superior mediante programas de movilidad y becas.",
          en: "The International Cooperation Group of Brazilian Universities is a non-profit academic association that promotes scientific, academic and cultural cooperation, as well as the internationalization of higher education through mobility and scholarship programs.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Grupo de Cooperación Internacional de Universidades Brasileñas (GCUB) es una asociación académica sin fines de lucro que reúne a universidades brasileñas e internacionales con el objetivo de promover la cooperación científica, académica y cultural, así como la internacionalización de la educación superior mediante programas de movilidad y becas para estudiantes e investigadores.",
                en: "The International Cooperation Group of Brazilian Universities (GCUB) is a non-profit academic association that brings together Brazilian and international universities with the aim of promoting scientific, academic and cultural cooperation, as well as the internationalization of higher education through mobility and scholarship programs for students and researchers.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Programas de movilidad internacional, becas de maestría y doctorado, cursos, investigación y cooperación académica.",
                  en: "International mobility programs, master's and doctoral scholarships, courses, research and academic cooperation.",
                },
              },
              {
                text: {
                  es: "Oportunidades de estudio en universidades públicas brasileñas pertenecientes a la red GCUB.",
                  en: "Study opportunities at Brazilian public universities belonging to the GCUB network.",
                },
              },
              {
                text: {
                  es: "Convocatorias dirigidas a estudiantes internacionales, docentes e investigadores.",
                  en: "Calls aimed at international students, faculty and researchers.",
                },
              },
              {
                text: {
                  es: "Entre sus principales iniciativas se encuentra el Programa GCUB de Movilidad Internacional (GCUB-Mob), que ofrece becas para estudios de posgrado en universidades brasileñas.",
                  en: "Among its main initiatives is the GCUB International Mobility Program (GCUB-Mob), which offers scholarships for graduate studies at Brazilian universities.",
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
                text: {
                  es: "Cumplir con los requisitos establecidos por el programa o convocatoria de interés.",
                  en: "Meet the requirements established by the program or call of interest.",
                },
              },
              {
                text: {
                  es: "Contar con el grado académico requerido según el nivel de estudios al que se postula.",
                  en: "Hold the academic degree required according to the level of study being applied to.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud a través de la plataforma oficial correspondiente dentro de los plazos establecidos.",
                  en: "Submit the application through the corresponding official platform within the established deadlines.",
                },
              },
              {
                text: {
                  es: "Verificar los requisitos específicos de cada universidad y programa participante.",
                  en: "Verify the specific requirements of each participating university and program.",
                },
              },
            ],
          },
        ],
        href: "https://www.gcub.org.br/category/programas/ativos/",
        linkLabel: {
          es: "Ver programas activos GCUB",
          en: "Open GCUB active programs",
        },
      },
      {
        slug: "programa-becas-paec-oea-gcub",
        title: {
          es: "Programa de Becas PAEC OEA - GCUB",
          en: "PAEC OAS - GCUB Scholarship Program",
        },
        body: {
          es: "El Programa de Becas PAEC OEA - GCUB forma parte del Programa de Alianzas para la Educación y la Capacitación de la Organización de los Estados Americanos, en colaboración con el Grupo de Cooperación Internacional de Universidades Brasileñas.",
          en: "The PAEC OAS - GCUB Scholarship Program is part of the Partnerships Program for Education and Training of the Organization of American States, in collaboration with the International Cooperation Group of Brazilian Universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas PAEC OEA - GCUB forma parte del Programa de Alianzas para la Educación y la Capacitación (PAEC) de la Organización de los Estados Americanos (OEA), en colaboración con el Grupo de Cooperación Internacional de Universidades Brasileñas (GCUB). Su objetivo es promover la formación de profesionales mediante becas para realizar estudios de maestría y doctorado en universidades brasileñas participantes.",
                en: "The PAEC OAS - GCUB Scholarship Program is part of the Partnerships Program for Education and Training (PAEC) of the Organization of American States (OAS), in collaboration with the International Cooperation Group of Brazilian Universities (GCUB). Its objective is to promote the training of professionals through scholarships for master's and doctoral studies at participating Brazilian universities.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para programas presenciales de maestría y doctorado en universidades asociadas al GCUB.",
                  en: "Scholarships for in-person master's and doctoral programs at universities associated with GCUB.",
                },
              },
              {
                text: {
                  es: "Oportunidad de acceder a programas de posgrado en diversas áreas del conocimiento en instituciones de educación superior de Brasil.",
                  en: "Opportunity to access graduate programs in various fields of knowledge at higher education institutions in Brazil.",
                },
              },
              {
                text: {
                  es: "Convocatorias desarrolladas en el marco del Programa GCUB de Movilidad Internacional (GCUB-Mob), con el apoyo de la OEA y otras instituciones internacionales.",
                  en: "Calls developed within the framework of the GCUB International Mobility Program (GCUB-Mob), with the support of the OAS and other international institutions.",
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
                text: {
                  es: "Ser ciudadano de un Estado Miembro de la OEA.",
                  en: "Be a citizen of an OAS Member State.",
                },
              },
              {
                text: {
                  es: "Contar con el título académico requerido para el programa de posgrado al que se postula.",
                  en: "Hold the academic degree required for the graduate program being applied to.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos establecidos por la universidad brasileña seleccionada y por la convocatoria vigente.",
                  en: "Meet the requirements established by the selected Brazilian university and by the current call.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante la plataforma oficial del Programa GCUB-Mob dentro del período de postulación.",
                  en: "Submit the application through the official GCUB-Mob Program platform within the application period.",
                },
              },
            ],
          },
        ],
        href: "https://www.oas.org/es/becas/",
        linkLabel: {
          es: "Portal oficial de Becas OEA",
          en: "Official OAS Scholarships portal",
        },
        links: [
          {
            href: "https://www.oas.org/es/becas/",
            label: {
              es: "Portal oficial de Becas OEA",
              en: "Official OAS Scholarships portal",
            },
          },
          {
            href: "https://www.gcub.org.br/category/programas/ativos/",
            label: {
              es: "Programa GCUB-Mob",
              en: "GCUB-Mob Program",
            },
          },
        ],
      },
      {
        slug: "programa-estudiantes-convenio-grado-pec-g",
        title: {
          es: "Programa de Estudiantes-Convenio de Grado (PEC-G)",
          en: "Undergraduate Student Agreement Program (PEC-G)",
        },
        body: {
          es: "El Programa de Estudiantes-Convenio de Grado (PEC-G) es una iniciativa de cooperación educativa internacional del Gobierno de Brasil que ofrece a estudiantes extranjeros de países participantes la oportunidad de cursar gratuitamente una carrera de grado o pregrado en instituciones brasileñas de educación superior.",
          en: "The Undergraduate Student Agreement Program (PEC-G) is an international educational cooperation initiative of the Government of Brazil that offers foreign students from participating countries the opportunity to pursue an undergraduate degree free of charge at Brazilian higher education institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Estudiantes-Convenio de Grado (PEC-G) es una iniciativa de cooperación educativa internacional del Gobierno de Brasil que ofrece a estudiantes extranjeros de países participantes la oportunidad de cursar gratuitamente una carrera de grado o pregrado en instituciones brasileñas de educación superior.",
                en: "The Undergraduate Student Agreement Program (PEC-G) is an international educational cooperation initiative of the Government of Brazil that offers foreign students from participating countries the opportunity to pursue an undergraduate degree free of charge at Brazilian higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Acceso a plazas gratuitas en programas de grado ofrecidos por instituciones de educación superior de Brasil.",
                  en: "Access to tuition-free places in undergraduate programs offered by higher education institutions in Brazil.",
                },
              },
              {
                text: {
                  es: "Formación académica en distintas áreas del conocimiento.",
                  en: "Academic training in different fields of knowledge.",
                },
              },
              {
                text: {
                  es: "Oportunidad de obtener un título universitario brasileño, con el compromiso de regresar al país de origen al finalizar los estudios.",
                  en: "Opportunity to obtain a Brazilian university degree, with the commitment to return to the country of origin after completing the studies.",
                },
              },
              {
                text: {
                  es: "La gratuidad comprende los costos académicos del programa, pero no necesariamente los gastos de alojamiento, alimentación, transporte, seguro médico u otros costos personales.",
                  en: "The tuition-free benefit covers the academic costs of the program, but not necessarily accommodation, food, transportation, health insurance or other personal expenses.",
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
                text: {
                  es: "Ser ciudadano de uno de los países participantes del PEC-G y residir fuera de Brasil.",
                  en: "Be a citizen of one of the countries participating in PEC-G and reside outside Brazil.",
                },
              },
              {
                text: {
                  es: "No poseer nacionalidad brasileña ni encontrarse comprendido en las restricciones establecidas por el programa.",
                  en: "Not hold Brazilian nationality and not fall under the restrictions established by the program.",
                },
              },
              {
                text: {
                  es: "Haber concluido o estar finalizando la educación secundaria fuera de Brasil.",
                  en: "Have completed or be completing secondary education outside Brazil.",
                },
              },
              {
                text: {
                  es: "Acreditar conocimientos de portugués mediante el Certificado de Proficiência em Língua Portuguesa para Estrangeiros (Celpe-Bras) o cumplir las condiciones lingüísticas establecidas en la convocatoria.",
                  en: "Prove knowledge of Portuguese through the Certificate of Proficiency in Portuguese for Foreigners (Celpe-Bras) or meet the language conditions established in the call.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación académica, personal y financiera solicitada.",
                  en: "Submit the required academic, personal and financial documentation.",
                },
              },
              {
                text: {
                  es: "Realizar la inscripción mediante la Embajada, Consulado o puesto diplomático de Brasil correspondiente al país de residencia.",
                  en: "Register through the Brazilian Embassy, Consulate or diplomatic mission corresponding to the country of residence.",
                },
              },
            ],
          },
        ],
        href: "https://www.gov.br/mre/es/temas/cultura-y-educacion/cooperacion-educativa/oportunidades-de-estudio-para-extranjeros/pec-g/seleccion",
        linkLabel: {
          es: "Proceso de selección PEC-G",
          en: "PEC-G selection process",
        },
        links: [
          {
            href: "https://www.gov.br/mre/es/temas/cultura-y-educacion/cooperacion-educativa/oportunidades-de-estudio-para-extranjeros/pec-g/seleccion",
            label: {
              es: "Proceso de selección PEC-G",
              en: "PEC-G selection process",
            },
          },
          {
            href: "https://www.gov.br/pt-br/servicos/estudar-o-ensino-superior-no-brasil",
            label: {
              es: "Información oficial del servicio",
              en: "Official service information",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "programas-becas-agcid-extranjeros",
        title: {
          es: "Programas de Becas AGCID para Extranjeros",
          en: "AGCID Scholarship Programs for Foreign Applicants",
        },
        body: {
          es: "La Agencia Chilena de Cooperación Internacional para el Desarrollo ofrece programas de becas y oportunidades de formación dirigidos a ciudadanos extranjeros para fortalecer la cooperación internacional, el desarrollo de capital humano y el intercambio académico.",
          en: "The Chilean Agency for International Cooperation for Development offers scholarship programs and training opportunities for foreign citizens to strengthen international cooperation, human capital development and academic exchange.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Agencia Chilena de Cooperación Internacional para el Desarrollo (AGCID) ofrece programas de becas y oportunidades de formación dirigidos a ciudadanos extranjeros con el propósito de fortalecer la cooperación internacional, el desarrollo de capital humano y el intercambio académico mediante estudios de posgrado, cursos internacionales y programas de movilidad en Chile.",
                en: "The Chilean Agency for International Cooperation for Development (AGCID) offers scholarship programs and training opportunities for foreign citizens with the purpose of strengthening international cooperation, human capital development and academic exchange through postgraduate studies, international courses and mobility programs in Chile.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de magíster en universidades chilenas acreditadas.",
                  en: "Scholarships to pursue master's studies at accredited Chilean universities.",
                },
              },
              {
                text: {
                  es: "Programas de formación, cursos internacionales y oportunidades de perfeccionamiento en diversas áreas del conocimiento.",
                  en: "Training programs, international courses and professional development opportunities in various fields of knowledge.",
                },
              },
              {
                text: {
                  es: "Beneficios que pueden incluir estipendio mensual, seguro de salud, pasajes y otros apoyos, de acuerdo con cada convocatoria.",
                  en: "Benefits that may include a monthly stipend, health insurance, airfare and other support, according to each call.",
                },
              },
              {
                text: {
                  es: "Convocatorias dirigidas a profesionales y estudiantes de países de América Latina, el Caribe, África, Asia y otras regiones, según el programa correspondiente.",
                  en: "Calls aimed at professionals and students from countries in Latin America, the Caribbean, Africa, Asia and other regions, depending on the corresponding program.",
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
                text: {
                  es: "Cumplir con los requisitos establecidos en la convocatoria vigente del programa de interés.",
                  en: "Meet the requirements established in the current call for the program of interest.",
                },
              },
              {
                text: {
                  es: "Contar con el grado académico o título profesional requerido, cuando corresponda.",
                  en: "Hold the required academic degree or professional title, when applicable.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación solicitada dentro de los plazos establecidos.",
                  en: "Submit the requested documentation within the established deadlines.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación a través del Punto Focal, Embajada o institución designada por AGCID en el país de origen, según las bases de cada convocatoria.",
                  en: "Apply through the Focal Point, Embassy or institution designated by AGCID in the country of origin, according to the rules of each call.",
                },
              },
            ],
          },
         
        ],
        href: "https://appspublic.agci.cl/convocatorias/extranjeros.php",
        linkLabel: {
          es: "Ofertas vigentes AGCID",
          en: "Current AGCID opportunities",
        },
        links: [
          {
            href: "https://appspublic.agci.cl/convocatorias/extranjeros.php",
            label: {
              es: "Ofertas vigentes AGCID",
              en: "Current AGCID opportunities",
            },
          },
          {
            href: "https://www.agcid.gob.cl/becas/becas-para-extranjeros",
            label: {
              es: "Información oficial de Becas para Extranjeros",
              en: "Official information for foreign scholarships",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "programa-becas-gobierno-republica-popular-china",
        title: {
          es: "Programa de Becas del Gobierno de la República Popular China",
          en: "Scholarship Program of the Government of the People's Republic of China",
        },
        body: {
          es: "El Programa de Becas del Gobierno de la República Popular China, administrado por el China Scholarship Council, ofrece oportunidades de financiamiento para que estudiantes internacionales realicen estudios en universidades chinas participantes.",
          en: "The Scholarship Program of the Government of the People's Republic of China, administered by the China Scholarship Council, offers funding opportunities for international students to study at participating Chinese universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas del Gobierno de la República Popular China (Chinese Government Scholarship - CGS), administrado por el China Scholarship Council (CSC), ofrece oportunidades de financiamiento para que estudiantes internacionales realicen estudios de pregrado, maestría, doctorado, así como programas de investigación y formación en universidades chinas participantes.",
                en: "The Scholarship Program of the Government of the People's Republic of China (Chinese Government Scholarship - CGS), administered by the China Scholarship Council (CSC), offers funding opportunities for international students to pursue undergraduate, master's and doctoral studies, as well as research and training programs at participating Chinese universities.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para estudios de pregrado, maestría, doctorado y programas de investigación.",
                  en: "Scholarships for undergraduate, master's and doctoral studies, as well as research programs.",
                },
              },
              {
                text: {
                  es: "Oportunidad de estudiar en universidades chinas en diversas áreas del conocimiento.",
                  en: "Opportunity to study at Chinese universities in various fields of knowledge.",
                },
              },
              {
                text: {
                  es: "Beneficios que pueden incluir matrícula, alojamiento, estipendio mensual, seguro médico y otros apoyos, de acuerdo con la modalidad de la beca.",
                  en: "Benefits may include tuition, accommodation, monthly stipend, health insurance and other support, according to the scholarship category.",
                },
              },
              {
                text: {
                  es: "Las convocatorias son publicadas anualmente a través de la Embajada de la República Popular China y del China Scholarship Council (CSC).",
                  en: "Calls are published annually through the Embassy of the People's Republic of China and the China Scholarship Council (CSC).",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de edad establecidos para el nivel de estudios al que se postula.",
                  en: "Meet the academic and age requirements established for the level of study being applied to.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida, incluyendo pasaporte, certificados académicos, formulario de examen médico y demás documentos establecidos en la convocatoria vigente.",
                  en: "Submit the required documentation, including passport, academic certificates, medical examination form and other documents established in the current call.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante el Chinese Government Scholarship Information System (CGSIS) y cumplir con el procedimiento indicado por la Embajada de China correspondiente.",
                  en: "Apply through the Chinese Government Scholarship Information System (CGSIS) and follow the procedure indicated by the corresponding Chinese Embassy.",
                },
              },
            ],
          },
        ],
        href: "https://www.campuschina.org/",
        linkLabel: {
          es: "Portal oficial Study in China (CSC)",
          en: "Official Study in China portal (CSC)",
        },
        links: [
          {
            href: "https://www.campuschina.org/",
            label: {
              es: "Portal oficial Study in China (CSC)",
              en: "Official Study in China portal (CSC)",
            },
          },
          {
            href: "https://bo.china-embassy.gov.cn/esp/",
            label: {
              es: "Convocatorias oficiales de la Embajada de China en Bolivia",
              en: "Official calls from the Embassy of China in Bolivia",
            },
          },
        ],
      },
    ],
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
        opportunities: [
          {
            slug: "hong-kong-phd-fellowship-scheme",
            title: {
              es: "Hong Kong PhD Fellowship Scheme (HKPFS)",
              en: "Hong Kong PhD Fellowship Scheme (HKPFS)",
            },
            body: {
              es: "El Hong Kong PhD Fellowship Scheme (HKPFS) es un programa internacional de becas financiado por el Research Grants Council (RGC) de Hong Kong, cuyo objetivo es atraer a estudiantes internacionales con excelencia académica para realizar estudios de doctorado en universidades participantes de Hong Kong.",
              en: "The Hong Kong PhD Fellowship Scheme (HKPFS) is an international scholarship program funded by the Research Grants Council (RGC) of Hong Kong, aimed at attracting academically excellent international students to pursue doctoral studies at participating universities in Hong Kong.",
            },
            contentSections: [
              {
                paragraphs: [
                  {
                    es: "El Hong Kong PhD Fellowship Scheme (HKPFS) es un programa internacional de becas financiado por el Research Grants Council (RGC) de Hong Kong, cuyo objetivo es atraer a estudiantes internacionales con excelencia académica para realizar estudios de doctorado en universidades participantes de Hong Kong.",
                    en: "The Hong Kong PhD Fellowship Scheme (HKPFS) is an international scholarship program funded by the Research Grants Council (RGC) of Hong Kong, aimed at attracting academically excellent international students to pursue doctoral studies at participating universities in Hong Kong.",
                  },
                ],
                bullets: [
                  {
                    text: {
                      es: "Becas para realizar estudios de doctorado en universidades de Hong Kong.",
                      en: "Scholarships to pursue doctoral studies at universities in Hong Kong.",
                    },
                  },
                  {
                    text: {
                      es: "Las áreas de estudio incluyen ciencias, medicina, ingeniería, tecnología, humanidades, ciencias sociales, administración y otras disciplinas ofrecidas por las universidades participantes.",
                      en: "Fields of study include science, medicine, engineering, technology, humanities, social sciences, business administration and other disciplines offered by participating universities.",
                    },
                  },
                  {
                    text: {
                      es: "Los beneficios pueden incluir estipendio anual, apoyo para investigación, subsidios de viaje y otros beneficios establecidos en la convocatoria vigente.",
                      en: "Benefits may include an annual stipend, research support, travel allowances and other benefits established in the current call.",
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
                    text: {
                      es: "Contar con el título académico requerido para acceder a un programa de doctorado.",
                      en: "Hold the academic degree required to access a doctoral program.",
                    },
                  },
                  {
                    text: {
                      es: "Demostrar excelencia académica, potencial de investigación y capacidad de liderazgo.",
                      en: "Demonstrate academic excellence, research potential and leadership ability.",
                    },
                  },
                  {
                    text: {
                      es: "Cumplir con los requisitos de admisión de la universidad participante seleccionada.",
                      en: "Meet the admission requirements of the selected participating university.",
                    },
                  },
                  {
                    text: {
                      es: "Presentar la solicitud mediante el sistema oficial del HKPFS y completar el proceso de admisión de la universidad correspondiente.",
                      en: "Submit the application through the official HKPFS system and complete the admission process of the corresponding university.",
                    },
                  },
                ],
              },
            ],
            href: "https://cerg1.ugc.edu.hk/hkpfs/index.html",
            linkLabel: {
              es: "Hong Kong PhD Fellowship Scheme",
              en: "Hong Kong PhD Fellowship Scheme",
            },
            links: [
              {
                href: "https://cerg1.ugc.edu.hk/hkpfs/index.html",
                label: {
                  es: "Hong Kong PhD Fellowship Scheme",
                  en: "Hong Kong PhD Fellowship Scheme",
                },
              },
              {
                href: "https://www.studyinhongkong.edu.hk/",
                label: {
                  es: "Study in Hong Kong",
                  en: "Study in Hong Kong",
                },
              },
            ],
          },
        ],
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
    opportunities: [
      {
        slug: "programa-reciprocidad-extranjeros-colombia-icetex",
        title: {
          es: "Programa de Reciprocidad para Extranjeros en Colombia (ICETEX)",
          en: "Reciprocity Program for Foreigners in Colombia (ICETEX)",
        },
        body: {
          es: "El Programa de Reciprocidad para Extranjeros en Colombia, administrado por ICETEX, ofrece oportunidades de becas para ciudadanos extranjeros interesados en realizar estudios de especialización, maestría y programas de investigación en instituciones colombianas.",
          en: "The Reciprocity Program for Foreigners in Colombia, administered by ICETEX, offers scholarship opportunities for foreign citizens interested in pursuing specialization studies, master's programs and research programs at Colombian institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Reciprocidad para Extranjeros en Colombia, administrado por el Instituto Colombiano de Crédito Educativo y Estudios Técnicos en el Exterior (ICETEX), ofrece oportunidades de becas para ciudadanos extranjeros interesados en realizar estudios de especialización, maestría y programas de investigación en instituciones de educación superior colombianas participantes.",
                en: "The Reciprocity Program for Foreigners in Colombia, administered by the Colombian Institute of Educational Credit and Technical Studies Abroad (ICETEX), offers scholarship opportunities for foreign citizens interested in pursuing specialization studies, master's programs and research programs at participating Colombian higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para estudios de especialización, maestría y programas de investigación en universidades colombianas.",
                  en: "Scholarships for specialization studies, master's programs and research programs at Colombian universities.",
                },
              },
              {
                text: {
                  es: "Oportunidad de acceder a instituciones de educación superior públicas y privadas incluidas en el catálogo oficial de oferta académica.",
                  en: "Opportunity to access public and private higher education institutions included in the official academic offer catalog.",
                },
              },
              {
                text: {
                  es: "Beneficios que pueden incluir matrícula, apoyo económico mensual, seguro médico y otros apoyos establecidos en cada convocatoria.",
                  en: "Benefits may include tuition, monthly financial support, health insurance and other support established in each call.",
                },
              },
              {
                text: {
                  es: "Convocatorias publicadas periódicamente por ICETEX para ciudadanos extranjeros de países elegibles, entre ellos Bolivia.",
                  en: "Calls published periodically by ICETEX for foreign citizens from eligible countries, including Bolivia.",
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
                text: {
                  es: "Contar con un título profesional o de pregrado para acceder al programa académico correspondiente.",
                  en: "Hold a professional or undergraduate degree to access the corresponding academic program.",
                },
              },
              {
                text: {
                  es: "Obtener la admisión a uno de los programas incluidos en el catálogo oficial de la convocatoria vigente.",
                  en: "Obtain admission to one of the programs included in the official catalog of the current call.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y documentales establecidos por ICETEX y realizar la postulación mediante la plataforma oficial.",
                  en: "Meet the academic and documentary requirements established by ICETEX and apply through the official platform.",
                },
              },
            ],
          },
        ],
        href: "https://web.icetex.gov.co/es/becas/programa-de-reciprocidad-para-extranjeros-en-colombia",
        linkLabel: {
          es: "Programa de Reciprocidad para Extranjeros",
          en: "Reciprocity Program for Foreigners",
        },
        links: [
          {
            href: "https://web.icetex.gov.co/es/becas/programa-de-reciprocidad-para-extranjeros-en-colombia",
            label: {
              es: "Programa de Reciprocidad para Extranjeros",
              en: "Reciprocity Program for Foreigners",
            },
          },
          {
            href: "https://web.icetex.gov.co/es/web/portal/becas/beca-colombia-extranjeros",
            label: {
              es: "Convocatorias oficiales",
              en: "Official calls",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "programa-becas-koica",
        title: {
          es: "Programa de Becas KOICA",
          en: "KOICA Scholarship Program",
        },
        body: {
          es: "El Programa de Becas KOICA, administrado por la Agencia de Cooperación Internacional de Corea, ofrece oportunidades de formación para profesionales del sector público de países socios mediante programas de maestría y doctorado en universidades de la República de Corea.",
          en: "The KOICA Scholarship Program, administered by the Korea International Cooperation Agency, offers training opportunities for public sector professionals from partner countries through master's and doctoral programs at universities in the Republic of Korea.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas KOICA, administrado por la Agencia de Cooperación Internacional de Corea (KOICA), ofrece oportunidades de formación para profesionales del sector público de países socios mediante programas de maestría y doctorado en universidades de la República de Corea. Su objetivo es fortalecer las capacidades institucionales y promover el desarrollo sostenible a través de la formación de líderes y funcionarios públicos.",
                en: "The KOICA Scholarship Program, administered by the Korea International Cooperation Agency (KOICA), offers training opportunities for public sector professionals from partner countries through master's and doctoral programs at universities in the Republic of Korea. Its objective is to strengthen institutional capacities and promote sustainable development through the training of leaders and public officials.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para programas de maestría y doctorado impartidos en universidades de Corea.",
                  en: "Scholarships for master's and doctoral programs taught at universities in Korea.",
                },
              },
              {
                text: {
                  es: "Beneficios que pueden incluir matrícula, alojamiento, estipendio mensual, pasajes internacionales, seguro médico y otros apoyos establecidos por KOICA.",
                  en: "Benefits may include tuition, accommodation, monthly stipend, international airfare, health insurance and other support established by KOICA.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y son canalizadas a través de las instituciones gubernamentales designadas o de la Embajada de la República de Corea, según el país participante.",
                  en: "Calls are published annually and are channeled through designated government institutions or the Embassy of the Republic of Korea, depending on the participating country.",
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
                text: {
                  es: "Ser ciudadano de un país elegible para el programa.",
                  en: "Be a citizen of a country eligible for the program.",
                },
              },
              {
                text: {
                  es: "Desempeñarse como funcionario público o profesional del sector público, conforme a los requisitos de la convocatoria.",
                  en: "Work as a public official or public sector professional, according to the requirements of the call.",
                },
              },
              {
                text: {
                  es: "Contar con el título académico requerido para el nivel de estudios al que se postula.",
                  en: "Hold the academic degree required for the level of study being applied to.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos, profesionales y de idioma establecidos para el programa seleccionado.",
                  en: "Meet the academic, professional and language requirements established for the selected program.",
                },
              },
              {
                text: {
                  es: "Presentar la postulación mediante el organismo oficial designado en el país o conforme al procedimiento indicado por KOICA.",
                  en: "Submit the application through the official body designated in the country or according to the procedure indicated by KOICA.",
                },
              },
            ],
          },
        ],
        href: "https://www.koica.go.kr/sites/ciat/index.do",
        linkLabel: {
          es: "Programa oficial KOICA CIAT",
          en: "Official KOICA CIAT program",
        },
        links: [
          {
            href: "https://www.koica.go.kr/sites/ciat/index.do",
            label: {
              es: "Programa oficial KOICA CIAT",
              en: "Official KOICA CIAT program",
            },
          },
          {
            href: "https://www.koica.go.kr/",
            label: {
              es: "Portal oficial KOICA",
              en: "Official KOICA portal",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "flacso-ecuador-maestria-doctorado",
        title: {
          es: "FLACSO Ecuador - Programas de Maestría y Doctorado",
          en: "FLACSO Ecuador - Master's and Doctoral Programs",
        },
        body: {
          es: "FLACSO Ecuador ofrece programas de maestría y doctorado orientados a la formación de investigadores y profesionales en diversas áreas de las ciencias sociales, además de becas y apoyo financiero para estudiantes nacionales e internacionales.",
          en: "FLACSO Ecuador offers master's and doctoral programs aimed at training researchers and professionals in various areas of the social sciences, along with scholarships and financial support for national and international students.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Facultad Latinoamericana de Ciencias Sociales (FLACSO Ecuador) ofrece programas de maestría y doctorado orientados a la formación de investigadores y profesionales en diversas áreas de las ciencias sociales. Además, cuenta con un sistema de becas y apoyo financiero para estudiantes nacionales e internacionales que promueve la excelencia académica y la investigación.",
                en: "The Latin American Faculty of Social Sciences (FLACSO Ecuador) offers master's and doctoral programs aimed at training researchers and professionals in various areas of the social sciences. It also has a scholarship and financial support system for national and international students that promotes academic excellence and research.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Programas de maestría y doctorado en áreas como ciencias políticas, relaciones internacionales, estudios internacionales, sociología, antropología, historia, economía, desarrollo territorial, políticas públicas, estudios de género, estudios urbanos, estudios socioambientales, comunicación y otras disciplinas de las ciencias sociales.",
                  en: "Master's and doctoral programs in areas such as political science, international relations, international studies, sociology, anthropology, history, economics, territorial development, public policy, gender studies, urban studies, socio-environmental studies, communication and other social science disciplines.",
                },
              },
              {
                text: {
                  es: "Becas y apoyos financieros que pueden cubrir entre el 10% y el 100% de la colegiatura, de acuerdo con el programa y el proceso de selección.",
                  en: "Scholarships and financial support that may cover between 10% and 100% of tuition, according to the program and selection process.",
                },
              },
              {
                text: {
                  es: "Algunas modalidades incluyen becas de estipendio, becas de asistencia financiera, becas para investigación de tesis y otros beneficios para estudiantes internacionales, conforme a la convocatoria vigente.",
                  en: "Some modalities include stipend scholarships, financial assistance scholarships, thesis research scholarships and other benefits for international students, according to the current call.",
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
                text: {
                  es: "Contar con el título académico requerido para el programa al que se postula.",
                  en: "Hold the academic degree required for the program being applied to.",
                },
              },
              {
                text: {
                  es: "Completar la solicitud de admisión en línea y presentar la documentación requerida por FLACSO Ecuador.",
                  en: "Complete the online admission application and submit the documentation required by FLACSO Ecuador.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos específicos del programa seleccionado y participar en el proceso de admisión correspondiente.",
                  en: "Meet the specific requirements of the selected program and participate in the corresponding admission process.",
                },
              },
              {
                text: {
                  es: "Postular a las becas o apoyos financieros disponibles conforme a las bases de la convocatoria vigente.",
                  en: "Apply for available scholarships or financial support according to the rules of the current call.",
                },
              },
            ],
          },
        ],
        href: "https://www.flacso.edu.ec/es/maestria",
        linkLabel: {
          es: "Programas de Maestría",
          en: "Master's Programs",
        },
        links: [
          {
            href: "https://www.flacso.edu.ec/es/maestria",
            label: {
              es: "Programas de Maestría",
              en: "Master's Programs",
            },
          },
          {
            href: "https://doctoradosflacso.ec/",
            label: {
              es: "Doctorados",
              en: "Doctoral Programs",
            },
          },
          {
            href: "https://www.flacso.edu.ec/es/becas_y_apoyo_financiero",
            label: {
              es: "Becas y apoyo financiero",
              en: "Scholarships and financial support",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "programa-jovenes-lideres-iberoamericanos",
        title: {
          es: "Programa Jóvenes Líderes Iberoamericanos",
          en: "Ibero-American Young Leaders Program",
        },
        body: {
          es: "El Programa Jóvenes Líderes Iberoamericanos, organizado por la Fundación Carolina y Banco Santander, es una iniciativa de liderazgo y formación internacional dirigida a jóvenes universitarios con destacada trayectoria académica y compromiso social.",
          en: "The Ibero-American Young Leaders Program, organized by the Carolina Foundation and Banco Santander, is an international leadership and training initiative aimed at university students with an outstanding academic record and social commitment.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa Jóvenes Líderes Iberoamericanos, organizado por la Fundación Carolina y Banco Santander, es una iniciativa de liderazgo y formación internacional dirigida a jóvenes universitarios con una destacada trayectoria académica y compromiso social. Su objetivo es fortalecer el liderazgo, la cooperación iberoamericana y el intercambio de experiencias entre los futuros profesionales de los países de la Comunidad Iberoamericana de Naciones.",
                en: "The Ibero-American Young Leaders Program, organized by the Carolina Foundation and Banco Santander, is an international leadership and training initiative aimed at university students with an outstanding academic record and social commitment. Its objective is to strengthen leadership, Ibero-American cooperation and the exchange of experiences among future professionals from the countries of the Ibero-American Community of Nations.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Incluye conferencias, encuentros institucionales, visitas académicas y actividades de formación en España y otros países europeos, de acuerdo con la edición correspondiente.",
                  en: "It includes conferences, institutional meetings, academic visits and training activities in Spain and other European countries, according to the corresponding edition.",
                },
              },
              {
                text: {
                  es: "Promueve la creación de una red de jóvenes líderes comprometidos con el desarrollo, la cooperación internacional y la integración iberoamericana.",
                  en: "It promotes the creation of a network of young leaders committed to development, international cooperation and Ibero-American integration.",
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
                text: {
                  es: "Ser ciudadano de un país miembro de la Comunidad Iberoamericana de Naciones.",
                  en: "Be a citizen of a member country of the Ibero-American Community of Nations.",
                },
              },
              {
                text: {
                  es: "Contar con un excelente expediente académico, liderazgo, participación social y compromiso con su comunidad.",
                  en: "Have an excellent academic record, leadership, social participation and commitment to the community.",
                },
              },
              {
                text: {
                  es: "Completar la postulación mediante las plataformas oficiales de la Fundación Carolina y Santander Open Academy, presentando la documentación requerida.",
                  en: "Complete the application through the official Carolina Foundation and Santander Open Academy platforms, submitting the required documentation.",
                },
              },
            ],
          },
        ],
        href: "https://www.fundacioncarolina.es/programa-int-visitantes/visitas-de-grupo/programa-jovenes-lideres-iberoamericanos/",
        linkLabel: {
          es: "Programa Jóvenes Líderes Iberoamericanos",
          en: "Ibero-American Young Leaders Program",
        },
      },
      {
        slug: "fundacion-carolina",
        title: {
          es: "Fundación Carolina",
          en: "Carolina Foundation",
        },
        body: {
          es: "La Fundación Carolina ofrece un amplio programa de becas y ayudas al estudio para ciudadanos de América Latina que deseen realizar estudios de maestría, doctorado, estancias de investigación y programas de formación en España.",
          en: "The Carolina Foundation offers a broad program of scholarships and study grants for Latin American citizens who wish to pursue master's studies, doctoral studies, research stays and training programs in Spain.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Fundación Carolina ofrece un amplio programa de becas y ayudas al estudio para ciudadanos de América Latina que deseen realizar estudios de maestría, doctorado, estancias de investigación y programas de formación en universidades e instituciones académicas de España. Su objetivo es fortalecer la cooperación educativa, científica y cultural entre España y los países de la Comunidad Iberoamericana de Naciones.",
                en: "The Carolina Foundation offers a broad program of scholarships and study grants for Latin American citizens who wish to pursue master's studies, doctoral studies, research stays and training programs at universities and academic institutions in Spain. Its objective is to strengthen educational, scientific and cultural cooperation between Spain and the countries of the Ibero-American Community of Nations.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para maestrías, doctorados, estancias posdoctorales, movilidad académica y programas de formación permanente.",
                  en: "Scholarships for master's programs, doctoral studies, postdoctoral stays, academic mobility and continuing education programs.",
                },
              },
              {
                text: {
                  es: "Oportunidades de estudio en universidades e instituciones de educación superior de España.",
                  en: "Study opportunities at universities and higher education institutions in Spain.",
                },
              },
              {
                text: {
                  es: "Modalidades de becas completas o parciales, así como ayudas al estudio, dependiendo del programa y de la institución participante.",
                  en: "Full or partial scholarship modalities, as well as study grants, depending on the program and the participating institution.",
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
                text: {
                  es: "Contar con el título académico requerido para el programa al que se postula.",
                  en: "Hold the academic degree required for the program being applied to.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y de experiencia profesional establecidos por cada convocatoria.",
                  en: "Meet the academic and professional experience requirements established by each call.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación de forma en línea mediante la plataforma oficial de la Fundación Carolina y presentar la documentación solicitada.",
                  en: "Apply online through the official Carolina Foundation platform and submit the requested documentation.",
                },
              },
            ],
          },
        ],
        href: "https://gestion.fundacioncarolina.es/programas",
        linkLabel: {
          es: "Convocatoria anual de becas",
          en: "Annual scholarship call",
        },
      },
      {
        slug: "becas-captacion-talento-internacional-upna",
        title: {
          es: "Becas de Captación de Talento Internacional - Universidad Pública de Navarra (UPNA)",
          en: "International Talent Attraction Scholarships - Public University of Navarra (UPNA)",
        },
        body: {
          es: "La Universidad Pública de Navarra ofrece el programa de Becas de Captación de Talento Internacional, dirigido a estudiantes internacionales que deseen cursar estudios de pregrado, posgrado y otras modalidades de formación en España.",
          en: "The Public University of Navarra offers the International Talent Attraction Scholarships program, aimed at international students who wish to pursue undergraduate, graduate and other training programs in Spain.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Universidad Pública de Navarra (UPNA) ofrece el programa de Becas de Captación de Talento Internacional, dirigido a estudiantes internacionales que deseen cursar estudios de pregrado, posgrado y otras modalidades de formación en España. Estas becas buscan atraer talento académico de países no pertenecientes a la Unión Europea y apoyar la formación de profesionales en diversas áreas del conocimiento.",
                en: "The Public University of Navarra (UPNA) offers the International Talent Attraction Scholarships program, aimed at international students who wish to pursue undergraduate, graduate and other training programs in Spain. These scholarships seek to attract academic talent from countries outside the European Union and support the training of professionals in various fields of knowledge.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Dirigidas a estudiantes internacionales no residentes en un Estado miembro de la Unión Europea.",
                  en: "Aimed at international students who are not residents of a European Union Member State.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, apoyo para desplazamiento, alojamiento, manutención y otros conceptos, de acuerdo con la convocatoria vigente.",
                  en: "Benefits may include tuition, travel support, accommodation, living expenses and other items, according to the current call.",
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
                text: {
                  es: "Ser admitido o cumplir los requisitos de admisión a un máster oficial de la Universidad Pública de Navarra.",
                  en: "Be admitted or meet the admission requirements for an official master's program at the Public University of Navarra.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y documentales establecidos por la convocatoria vigente.",
                  en: "Meet the academic and documentary requirements established by the current call.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud dentro de los plazos y mediante el procedimiento oficial establecido por la UPNA.",
                  en: "Submit the application within the deadlines and through the official procedure established by UPNA.",
                },
              },
            ],
          },
        ],
        href: "https://sedeelectronica.unavarra.es/oficina/tramites/acceso.do?entity=1096&id=8390",
        linkLabel: {
          es: "Becas de Captación de Talento",
          en: "Talent Attraction Scholarships",
        },
        links: [
          {
            href: "https://sedeelectronica.unavarra.es/oficina/tramites/acceso.do?entity=1096&id=8390",
            label: {
              es: "Becas de Captación de Talento",
              en: "Talent Attraction Scholarships",
            },
          },
          {
            href: "https://www.unavarra.es/sites/estudios/becas-ayudas-premios/grado.html",
            label: {
              es: "Oferta oficial de becas",
              en: "Official scholarship offer",
            },
          },
        ],
      },
      {
        slug: "programa-becas-master-universitario-valladolid",
        title: {
          es: "Programa de Becas de Máster Universitario - Universidad de Valladolid",
          en: "University Master's Scholarship Program - University of Valladolid",
        },
        body: {
          es: "La Universidad de Valladolid ofrece un programa de becas dirigido a docentes y estudiantes que deseen realizar estudios oficiales de máster universitario en España, en el marco de su estrategia de internacionalización.",
          en: "The University of Valladolid offers a scholarship program for faculty and students who wish to pursue official university master's studies in Spain, within the framework of its internationalization strategy.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Universidad de Valladolid (UVa) ofrece un programa de becas dirigido a docentes y estudiantes que deseen realizar estudios oficiales de máster universitario en España. Esta iniciativa forma parte de la estrategia de internacionalización de la universidad y promueve la cooperación académica con instituciones de Iberoamérica y Asia.",
                en: "The University of Valladolid (UVa) offers a scholarship program for faculty and students who wish to pursue official university master's studies in Spain. This initiative is part of the university's internationalization strategy and promotes academic cooperation with institutions in Ibero-America and Asia.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para cursar másteres universitarios oficiales impartidos por la Universidad de Valladolid.",
                  en: "Scholarships to pursue official university master's programs offered by the University of Valladolid.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo para matrícula, alojamiento, manutención, desplazamiento y otros conceptos, conforme a la convocatoria vigente.",
                  en: "Benefits may include support for tuition, accommodation, living expenses, travel and other items, according to the current call.",
                },
              },
              {
                text: {
                  es: "La oferta de programas, el número de becas y las condiciones de financiación se actualizan en cada convocatoria anual.",
                  en: "The program offer, number of scholarships and funding conditions are updated in each annual call.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y documentales establecidos por la convocatoria vigente.",
                  en: "Meet the academic and documentary requirements established by the current call.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante el procedimiento oficial de la Universidad de Valladolid dentro de los plazos establecidos.",
                  en: "Submit the application through the official University of Valladolid procedure within the established deadlines.",
                },
              },
            ],
          },
          {
            paragraphs: [
              {
                es: "En el marco de nuestra alianza como socios Erasmus+, los postulantes de la UMSS contarán con preferencia en esta convocatoria, lo que representa una excelente oportunidad para acceder a este programa.",
                en: "Within the framework of our alliance as Erasmus+ partners, UMSS applicants will receive preference in this call, representing an excellent opportunity to access this program.",
              },
            ],
          },
        ],
        href: "https://iberoamerica-asia.uva.es/",
        linkLabel: {
          es: "Programa oficial de Becas de Máster Universitario",
          en: "Official University Master's Scholarship Program",
        },
      },
      {
        slug: "programa-becas-maec-aecid-master",
        title: {
          es: "Programa de Becas MAEC-AECID - Programa MASTER",
          en: "MAEC-AECID Scholarship Program - MASTER Program",
        },
        body: {
          es: "El Programa de Becas MAEC-AECID ofrece becas para que funcionarios y empleados públicos realicen estudios oficiales de máster universitario presencial en instituciones de educación superior españolas.",
          en: "The MAEC-AECID Scholarship Program offers scholarships for public officials and public employees to pursue official in-person university master's studies at Spanish higher education institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas MAEC-AECID, promovido por la Agencia Española de Cooperación Internacional para el Desarrollo (AECID) y el Ministerio de Asuntos Exteriores, Unión Europea y Cooperación de España (MAEC), ofrece becas para que funcionarios y empleados públicos realicen estudios oficiales de máster universitario presencial en instituciones de educación superior españolas.",
                en: "The MAEC-AECID Scholarship Program, promoted by the Spanish Agency for International Development Cooperation (AECID) and Spain's Ministry of Foreign Affairs, European Union and Cooperation (MAEC), offers scholarships for public officials and public employees to pursue official in-person university master's studies at Spanish higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para cursar másteres universitarios oficiales en universidades de España.",
                  en: "Scholarships to pursue official university master's programs at universities in Spain.",
                },
              },
              {
                text: {
                  es: "Dirigidas a funcionarios y empleados públicos de carácter permanente, incluido el personal del sistema educativo y universitario público, de los países elegibles establecidos en cada convocatoria.",
                  en: "Aimed at permanent public officials and public employees, including staff from the public education and university system, from eligible countries established in each call.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir asignación mensual, seguro de asistencia sanitaria y otros apoyos contemplados en la convocatoria vigente.",
                  en: "Benefits may include a monthly allowance, health care insurance and other support included in the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y las modalidades, beneficios y requisitos específicos pueden variar en cada edición.",
                  en: "Calls are published annually and the modalities, benefits and specific requirements may vary in each edition.",
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
                text: {
                  es: "Desempeñarse como funcionario o empleado público de carácter permanente, conforme a las condiciones del programa.",
                  en: "Work as a permanent public official or public employee, according to the conditions of the program.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante la sede electrónica de AECID y presentar la documentación requerida dentro de los plazos establecidos.",
                  en: "Apply through the AECID electronic office and submit the required documentation within the established deadlines.",
                },
              },
            ],
          },
        ],
        href: "https://www.aecid.gob.es/activos",
        linkLabel: {
          es: "Sede electrónica AECID",
          en: "AECID electronic office",
        },
        links: [
          {
            href: "https://www.aecid.gob.es/activos",
            label: {
              es: "Sede electrónica AECID",
              en: "AECID electronic office",
            },
          },
          {
            href: "https://www.aecid.es/es/becas-para-ciudadanos-de-paises-de-america-latina-africa-y-asia",
            label: {
              es: "Programa oficial de Becas MAEC-AECID",
              en: "Official MAEC-AECID Scholarship Program",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "programa-becas-fulbright-profesionales",
        title: {
          es: "Programa de Becas Fulbright para Profesionales",
          en: "Fulbright Scholarship Program for Professionals",
        },
        body: {
          es: "El Programa de Becas Fulbright para Profesionales ofrece a ciudadanos bolivianos la oportunidad de realizar estudios de maestría en universidades de los Estados Unidos.",
          en: "The Fulbright Scholarship Program for Professionals offers Bolivian citizens the opportunity to pursue master's studies at universities in the United States.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas Fulbright para Profesionales ofrece a ciudadanos bolivianos la oportunidad de realizar estudios de maestría en universidades de los Estados Unidos. Administrado por el Programa Fulbright y la Embajada de los Estados Unidos en Bolivia, este programa busca formar profesionales con excelencia académica, potencial de liderazgo y compromiso con el desarrollo de Bolivia.",
                en: "The Fulbright Scholarship Program for Professionals offers Bolivian citizens the opportunity to pursue master's studies at universities in the United States. Administered by the Fulbright Program and the Embassy of the United States in Bolivia, this program seeks to train professionals with academic excellence, leadership potential and commitment to Bolivia's development.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Dirigidas a profesionales bolivianos con un destacado desempeño académico y profesional.",
                  en: "Aimed at Bolivian professionals with outstanding academic and professional performance.",
                },
              },
              {
                text: {
                  es: "El programa puede incluir apoyo para matrícula, manutención, pasajes, seguro médico y otros beneficios, conforme a la convocatoria vigente.",
                  en: "The program may include support for tuition, living expenses, airfare, health insurance and other benefits, according to the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican periódicamente y los requisitos específicos pueden variar en cada edición.",
                  en: "Calls are published periodically and specific requirements may vary in each edition.",
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
                text: {
                  es: "Contar con un título universitario de licenciatura o equivalente.",
                  en: "Hold a bachelor's degree or equivalent university degree.",
                },
              },
              {
                text: {
                  es: "Demostrar un excelente historial académico, liderazgo y compromiso con el desarrollo del país.",
                  en: "Demonstrate an excellent academic record, leadership and commitment to the country's development.",
                },
              },
              {
                text: {
                  es: "Acreditar el nivel de inglés requerido y presentar la documentación solicitada durante el proceso de postulación.",
                  en: "Prove the required level of English and submit the requested documentation during the application process.",
                },
              },
              {
                text: {
                  es: "Realizar la solicitud mediante la plataforma oficial del Programa Fulbright y cumplir con las etapas de selección establecidas.",
                  en: "Apply through the official Fulbright Program platform and comply with the established selection stages.",
                },
              },
            ],
          },
        ],
        href: "https://foreign.fulbrightonline.org/apply?country=bolivia",
        linkLabel: {
          es: "Programa Fulbright para estudiantes internacionales",
          en: "Fulbright Foreign Student Program",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "becas-excelencia-eur-healthy",
        title: {
          es: "Becas de Excelencia EUR HEALTHY - Université Côte d'Azur",
          en: "EUR HEALTHY Excellence Scholarships - Université Côte d'Azur",
        },
        body: {
          es: "La École Universitaire de Recherche (EUR) HEALTHY de la Université Côte d'Azur, en Francia, ofrece un programa de Becas de Excelencia dirigido a estudiantes internacionales con un destacado rendimiento académico que deseen realizar estudios de maestría en las áreas de ciencias de la salud.",
          en: "The École Universitaire de Recherche (EUR) HEALTHY at Université Côte d'Azur, in France, offers an Excellence Scholarship program for international students with outstanding academic performance who wish to pursue master's studies in health sciences.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La École Universitaire de Recherche (EUR) HEALTHY de la Université Côte d'Azur, en Francia, ofrece un programa de Becas de Excelencia dirigido a estudiantes internacionales con un destacado rendimiento académico que deseen realizar estudios de maestría en las áreas de ciencias de la salud.",
                en: "The École Universitaire de Recherche (EUR) HEALTHY at Université Côte d'Azur, in France, offers an Excellence Scholarship program for international students with outstanding academic performance who wish to pursue master's studies in health sciences.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para cursar programas oficiales de maestría en la Université Côte d'Azur.",
                  en: "Scholarships to pursue official master's programs at Université Côte d'Azur.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo económico para facilitar la realización de los estudios, de acuerdo con la convocatoria vigente.",
                  en: "Benefits may include financial support to facilitate the completion of studies, according to the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y las modalidades, beneficios y requisitos específicos pueden variar en cada edición.",
                  en: "Calls are published annually, and the modalities, benefits and specific requirements may vary in each edition.",
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
                text: {
                  es: "Demostrar un excelente desempeño académico.",
                  en: "Demonstrate excellent academic performance.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida conforme a la convocatoria vigente.",
                  en: "Submit the required documentation according to the current call.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante el procedimiento oficial establecido por la Université Côte d'Azur.",
                  en: "Apply through the official procedure established by Université Côte d'Azur.",
                },
              },
            ],
          },
        ],
        href: "https://healthy.univ-cotedazur.fr/",
        linkLabel: {
          es: "EUR HEALTHY - Becas de Excelencia",
          en: "EUR HEALTHY - Excellence Scholarships",
        },
      },
      {
        slug: "becas-gobierno-frances",
        title: {
          es: "Becas del Gobierno Francés",
          en: "French Government Scholarships",
        },
        body: {
          es: "Las Becas del Gobierno Francés (BGF) son un programa de cooperación académica promovido por la Embajada de Francia en Bolivia y Campus France Bolivia, dirigido a estudiantes bolivianos que deseen realizar estudios de maestría o doctorado en instituciones de educación superior de Francia.",
          en: "The French Government Scholarships (BGF) are an academic cooperation program promoted by the Embassy of France in Bolivia and Campus France Bolivia, aimed at Bolivian students who wish to pursue master's or doctoral studies at higher education institutions in France.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas del Gobierno Francés (BGF) son un programa de cooperación académica promovido por la Embajada de Francia en Bolivia y Campus France Bolivia, dirigido a estudiantes bolivianos que deseen realizar estudios de maestría o doctorado en instituciones de educación superior de Francia. Estas becas tienen como objetivo fortalecer la formación académica y la cooperación científica entre ambos países.",
                en: "The French Government Scholarships (BGF) are an academic cooperation program promoted by the Embassy of France in Bolivia and Campus France Bolivia, aimed at Bolivian students who wish to pursue master's or doctoral studies at higher education institutions in France. These scholarships aim to strengthen academic training and scientific cooperation between both countries.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de posgrado en universidades y grandes escuelas francesas.",
                  en: "Scholarships to pursue graduate studies at French universities and grandes écoles.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo económico, cobertura de estudios, seguro y otros beneficios establecidos en la convocatoria vigente.",
                  en: "Benefits may include financial support, study coverage, insurance and other benefits established in the current call.",
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
                text: {
                  es: "Contar con el título académico requerido para el programa de estudios al que se postula.",
                  en: "Hold the academic degree required for the study program being applied to.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos de admisión de la institución francesa correspondiente.",
                  en: "Meet the admission requirements of the corresponding French institution.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida y realizar la postulación conforme al procedimiento establecido por la Embajada de Francia en Bolivia y Campus France Bolivia.",
                  en: "Submit the required documentation and apply according to the procedure established by the Embassy of France in Bolivia and Campus France Bolivia.",
                },
              },
            ],
          },
        ],
        href: "https://www.bolivie.campusfrance.org/",
        linkLabel: {
          es: "Campus France Bolivia",
          en: "Campus France Bolivia",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "nl-scholarship",
        title: {
          es: "NL Scholarship",
          en: "NL Scholarship",
        },
        body: {
          es: "La NL Scholarship, anteriormente conocida como Holland Scholarship, es un programa de becas financiado por el Ministerio de Educación, Cultura y Ciencia de los Países Bajos, en colaboración con universidades de investigación y universidades de ciencias aplicadas participantes.",
          en: "The NL Scholarship, formerly known as the Holland Scholarship, is a scholarship program funded by the Dutch Ministry of Education, Culture and Science, in collaboration with participating research universities and universities of applied sciences.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La NL Scholarship, anteriormente conocida como Holland Scholarship, es un programa de becas financiado por el Ministerio de Educación, Cultura y Ciencia de los Países Bajos, en colaboración con universidades de investigación y universidades de ciencias aplicadas participantes. Está dirigida a estudiantes internacionales que deseen realizar estudios de pregrado o maestría en los Países Bajos.",
                en: "The NL Scholarship, formerly known as the Holland Scholarship, is a scholarship program funded by the Dutch Ministry of Education, Culture and Science, in collaboration with participating research universities and universities of applied sciences. It is aimed at international students who wish to pursue bachelor's or master's studies in the Netherlands.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Dirigidas a estudiantes internacionales provenientes de países fuera del Espacio Económico Europeo (EEE).",
                  en: "Aimed at international students from countries outside the European Economic Area (EEA).",
                },
              },
              {
                text: {
                  es: "Los beneficios y el monto de la beca son establecidos por el programa y las instituciones participantes, conforme a la convocatoria vigente.",
                  en: "The benefits and scholarship amount are established by the program and participating institutions, according to the current call.",
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
                text: {
                  es: "Solicitar la admisión a un programa oficial de pregrado o maestría en una institución participante.",
                  en: "Apply for admission to an official bachelor's or master's program at a participating institution.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y de idioma establecidos por la universidad seleccionada.",
                  en: "Meet the academic and language requirements established by the selected university.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud de acuerdo con el procedimiento oficial de la institución participante y la convocatoria vigente.",
                  en: "Submit the application according to the official procedure of the participating institution and the current call.",
                },
              },
            ],
          },
        ],
        href: "https://www.studyinnl.org/finances/nl-scholarship",
        linkLabel: {
          es: "NL Scholarship",
          en: "NL Scholarship",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "government-ireland-international-education-scholarship",
        title: {
          es: "Government of Ireland International Education Scholarship (GOI-IES)",
          en: "Government of Ireland International Education Scholarship (GOI-IES)",
        },
        body: {
          es: "La Government of Ireland International Education Scholarship (GOI-IES) es un programa de becas financiado por el Gobierno de Irlanda y administrado por la Higher Education Authority (HEA), en colaboración con instituciones de educación superior participantes.",
          en: "The Government of Ireland International Education Scholarship (GOI-IES) is a scholarship program funded by the Government of Ireland and administered by the Higher Education Authority (HEA), in collaboration with participating higher education institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Government of Ireland International Education Scholarship (GOI-IES) es un programa de becas financiado por el Gobierno de Irlanda y administrado por la Higher Education Authority (HEA), en colaboración con instituciones de educación superior participantes.",
                en: "The Government of Ireland International Education Scholarship (GOI-IES) is a scholarship program funded by the Government of Ireland and administered by the Higher Education Authority (HEA), in collaboration with participating higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Dirigidas a estudiantes internacionales con un destacado desempeño académico y potencial de liderazgo.",
                  en: "Aimed at international students with outstanding academic performance and leadership potential.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo económico, exención de matrícula y otros beneficios establecidos en la convocatoria vigente.",
                  en: "Benefits may include financial support, tuition waiver and other benefits established in the current call.",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de admisión establecidos por la institución seleccionada.",
                  en: "Meet the academic and admission requirements established by the selected institution.",
                },
              },
              {
                text: {
                  es: "Demostrar excelencia académica, habilidades de liderazgo y compromiso con el desarrollo personal y profesional.",
                  en: "Demonstrate academic excellence, leadership skills and commitment to personal and professional development.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud conforme al procedimiento oficial del programa y de la institución participante.",
                  en: "Submit the application according to the official procedure of the program and the participating institution.",
                },
              },
            ],
          },
        ],
        href: "https://hea.ie/policy/internationalisation/goi-ies/",
        linkLabel: {
          es: "Government of Ireland International Education Scholarship (GOI-IES)",
          en: "Government of Ireland International Education Scholarship (GOI-IES)",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "becas-gobierno-italiano-maeci",
        title: {
          es: "Becas del Gobierno Italiano (MAECI)",
          en: "Italian Government Scholarships (MAECI)",
        },
        body: {
          es: "Las Becas del Gobierno Italiano (MAECI) son un programa oficial del Ministerio de Asuntos Exteriores y de Cooperación Internacional de Italia, destinado a promover la cooperación académica, científica y cultural mediante oportunidades de estudio e investigación para estudiantes internacionales.",
          en: "The Italian Government Scholarships (MAECI) are an official program of Italy's Ministry of Foreign Affairs and International Cooperation, aimed at promoting academic, scientific and cultural cooperation through study and research opportunities for international students.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas del Gobierno Italiano (MAECI) son un programa oficial del Ministerio de Asuntos Exteriores y de Cooperación Internacional de Italia, destinado a promover la cooperación académica, científica y cultural mediante oportunidades de estudio e investigación para estudiantes internacionales en instituciones italianas de educación superior.",
                en: "The Italian Government Scholarships (MAECI) are an official program of Italy's Ministry of Foreign Affairs and International Cooperation, aimed at promoting academic, scientific and cultural cooperation through study and research opportunities for international students at Italian higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de maestría, doctorado, investigación, programas AFAM (Alta Formación Artística, Musical y Coreográfica) y cursos de lengua y cultura italiana, conforme a la convocatoria vigente.",
                  en: "Scholarships to pursue master's studies, doctoral studies, research, AFAM programs (Higher Education in Art, Music and Dance) and Italian language and culture courses, according to the current call.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo económico, exención parcial o total de matrícula, seguro médico y otros beneficios establecidos en la convocatoria vigente.",
                  en: "Benefits may include financial support, partial or full tuition exemption, health insurance and other benefits established in the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente a través del portal oficial Study in Italy.",
                  en: "Calls are published annually through the official Study in Italy portal.",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de admisión del programa seleccionado.",
                  en: "Meet the academic and admission requirements of the selected program.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida conforme a las bases del programa.",
                  en: "Submit the required documentation according to the program guidelines.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante el portal oficial Study in Italy dentro del plazo establecido.",
                  en: "Apply through the official Study in Italy portal within the established deadline.",
                },
              },
            ],
          },
        ],
        href: "https://studyinitaly.esteri.it/",
        linkLabel: {
          es: "Study in Italy",
          en: "Study in Italy",
        },
        links: [
          {
            href: "https://studyinitaly.esteri.it/",
            label: {
              es: "Study in Italy",
              en: "Study in Italy",
            },
          },
          {
            href: "https://studyinitaly.esteri.it/ListaBandi",
            label: {
              es: "Convocatorias oficiales (Lista Bandi)",
              en: "Official calls (Lista Bandi)",
            },
          },
        ],
      },
    ],
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
    opportunities: [
      {
        slug: "becas-mext-institutos-tecnicos-senshu-gakko",
        title: {
          es: "Becas MEXT para Institutos Técnicos Especializados (Senshu-gakkō)",
          en: "MEXT Scholarships for Specialized Training Colleges (Senshu-gakko)",
        },
        body: {
          es: "Las Becas MEXT para Institutos Técnicos Especializados (Senshu-gakkō) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT).",
          en: "The MEXT Scholarships for Specialized Training Colleges (Senshu-gakko) are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas MEXT para Institutos Técnicos Especializados (Senshu-gakkō) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT).",
                en: "The MEXT Scholarships for Specialized Training Colleges (Senshu-gakko) are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT).",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para cursar programas de formación técnica y profesional en institutos técnicos especializados (Senshu-gakkō) de Japón.",
                  en: "Scholarships to pursue technical and professional training programs at specialized training colleges (Senshu-gakko) in Japan.",
                },
              },
              {
                text: {
                  es: "Incluyen un período preparatorio de idioma japonés antes del inicio de la formación especializada, conforme a la convocatoria vigente.",
                  en: "They include a preparatory Japanese language period before the start of specialized training, according to the current call.",
                },
              },
              {
                text: {
                  es: "Las áreas de estudio abarcan tecnología, ingeniería, negocios, bienestar, educación, moda, diseño, gastronomía, animación, manga, música y otras disciplinas técnicas y profesionales.",
                  en: "Fields of study include technology, engineering, business, welfare, education, fashion, design, gastronomy, animation, manga, music and other technical and professional disciplines.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, pasajes internacionales, estipendio mensual y otros apoyos establecidos por el programa MEXT.",
                  en: "Benefits may include tuition, international airfare, monthly stipend and other support established by the MEXT program.",
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
                text: {
                  es: "Haber concluido la educación secundaria o cumplir con los requisitos académicos establecidos por la convocatoria vigente.",
                  en: "Have completed secondary education or meet the academic requirements established by the current call.",
                },
              },
              {
                text: {
                  es: "Demostrar interés y aptitud para realizar estudios técnicos en Japón.",
                  en: "Demonstrate interest and aptitude for technical studies in Japan.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos, lingüísticos y documentales establecidos por MEXT y la Embajada del Japón.",
                  en: "Meet the academic, language and documentation requirements established by MEXT and the Embassy of Japan.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante el proceso oficial de selección de la Embajada del Japón en Bolivia.",
                  en: "Submit the application through the official selection process of the Embassy of Japan in Bolivia.",
                },
              },
            ],
          },
        ],
        href: "https://www.bo.emb-japan.go.jp/",
        linkLabel: {
          es: "Embajada del Japón en Bolivia - Becas MEXT",
          en: "Embassy of Japan in Bolivia - MEXT Scholarships",
        },
        links: [
          {
            href: "https://www.bo.emb-japan.go.jp/",
            label: {
              es: "Embajada del Japón en Bolivia - Becas MEXT",
              en: "Embassy of Japan in Bolivia - MEXT Scholarships",
            },
          },
          {
            href: "https://www.studyinjapan.go.jp/en/planning/scholarships/mext-scholarships/",
            label: {
              es: "Study in Japan - MEXT Scholarships",
              en: "Study in Japan - MEXT Scholarships",
            },
          },
        ],
      },
      {
        slug: "becas-mext-pregrado-undergraduate-students",
        title: {
          es: "Becas MEXT de Pregrado (Undergraduate Students)",
          en: "MEXT Undergraduate Scholarships (Undergraduate Students)",
        },
        body: {
          es: "Las Becas MEXT de Pregrado (Undergraduate Students) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT), dirigido a estudiantes internacionales que deseen realizar estudios universitarios de pregrado en instituciones de educación superior japonesas.",
          en: "The MEXT Undergraduate Scholarships (Undergraduate Students) are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT), aimed at international students who wish to pursue undergraduate university studies at Japanese higher education institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas MEXT de Pregrado (Undergraduate Students) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT), dirigido a estudiantes internacionales que deseen realizar estudios universitarios de pregrado en instituciones de educación superior japonesas.",
                en: "The MEXT Undergraduate Scholarships (Undergraduate Students) are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT), aimed at international students who wish to pursue undergraduate university studies at Japanese higher education institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Incluyen un período preparatorio de idioma japonés antes del inicio de los estudios universitarios, conforme a la convocatoria vigente.",
                  en: "They include a preparatory Japanese language period before the start of university studies, according to the current call.",
                },
              },
              {
                text: {
                  es: "Permiten acceder a una amplia variedad de áreas académicas, incluyendo ciencias sociales, humanidades, ciencias naturales, ingeniería, agricultura, medicina y otras disciplinas ofrecidas por las universidades japonesas.",
                  en: "They provide access to a wide variety of academic fields, including social sciences, humanities, natural sciences, engineering, agriculture, medicine and other disciplines offered by Japanese universities.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, pasajes internacionales, estipendio mensual y otros apoyos establecidos por el programa MEXT.",
                  en: "Benefits may include tuition, international airfare, monthly stipend and other support established by the MEXT program.",
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
                text: {
                  es: "Haber concluido la educación secundaria o cumplir con los requisitos académicos establecidos por la convocatoria vigente.",
                  en: "Have completed secondary education or meet the academic requirements established by the current call.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos lingüísticos y documentales establecidos por la Embajada del Japón.",
                  en: "Meet the language and documentation requirements established by the Embassy of Japan.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante el proceso oficial de selección de la Embajada del Japón en Bolivia.",
                  en: "Submit the application through the official selection process of the Embassy of Japan in Bolivia.",
                },
              },
            ],
          },
        ],
        href: "https://www.studyinjapan.go.jp/en/planning/scholarships/mext-scholarships/",
        linkLabel: {
          es: "Study in Japan - MEXT Scholarships",
          en: "Study in Japan - MEXT Scholarships",
        },
      },
      {
        slug: "becas-mext-investigadores-research-students",
        title: {
          es: "Becas MEXT para Investigadores (Research Students)",
          en: "MEXT Scholarships for Research Students",
        },
        body: {
          es: "Las Becas MEXT para Investigadores (Research Students) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT), dirigido a estudiantes internacionales que deseen realizar estudios de investigación, maestría o doctorado en universidades japonesas.",
          en: "The MEXT Scholarships for Research Students are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT), aimed at international students who wish to pursue research, master's or doctoral studies at Japanese universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas MEXT para Investigadores (Research Students) son un programa del Ministerio de Educación, Cultura, Deportes, Ciencia y Tecnología del Japón (MEXT), dirigido a estudiantes internacionales que deseen realizar estudios de investigación, maestría o doctorado en universidades japonesas.",
                en: "The MEXT Scholarships for Research Students are a program of Japan's Ministry of Education, Culture, Sports, Science and Technology (MEXT), aimed at international students who wish to pursue research, master's or doctoral studies at Japanese universities.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Permiten desarrollar un plan de investigación en universidades de Japón con posibilidad de continuar hacia un programa de maestría o doctorado, conforme a la convocatoria vigente.",
                  en: "They allow students to develop a research plan at universities in Japan, with the possibility of continuing into a master's or doctoral program, according to the current call.",
                },
              },
              {
                text: {
                  es: "Incluyen un período preparatorio de idioma japonés cuando la universidad anfitriona lo considere necesario.",
                  en: "They include a preparatory Japanese language period when the host university considers it necessary.",
                },
              },
              {
                text: {
                  es: "Están dirigidas a graduados universitarios de cualquier área del conocimiento interesados en desarrollar investigación académica en instituciones japonesas.",
                  en: "They are aimed at university graduates from any field of knowledge interested in developing academic research at Japanese institutions.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, pasajes internacionales, estipendio mensual y otros apoyos establecidos por el programa MEXT.",
                  en: "Benefits may include tuition, international airfare, monthly stipend and other support established by the MEXT program.",
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
                text: {
                  es: "Contar con un título universitario que permita el ingreso a estudios de posgrado.",
                  en: "Hold a university degree that allows admission to graduate studies.",
                },
              },
              {
                text: {
                  es: "Presentar un plan de investigación relacionado con el área académica de interés.",
                  en: "Submit a research plan related to the academic area of interest.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos, lingüísticos y documentales establecidos por MEXT y la Embajada del Japón.",
                  en: "Meet the academic, language and documentation requirements established by MEXT and the Embassy of Japan.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante el proceso oficial de selección de la Embajada del Japón en Bolivia.",
                  en: "Apply through the official selection process of the Embassy of Japan in Bolivia.",
                },
              },
            ],
          },
        ],
        href: "https://www.studyinjapan.go.jp/en/planning/scholarships/mext-scholarships/",
        linkLabel: {
          es: "Study in Japan - MEXT Scholarships",
          en: "Study in Japan - MEXT Scholarships",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "becas-excelencia-gobierno-mexico-amexcid",
        title: {
          es: "Becas de Excelencia del Gobierno de México para Extranjeros (AMEXCID)",
          en: "Mexican Government Excellence Scholarships for Foreigners (AMEXCID)",
        },
        body: {
          es: "Las Becas de Excelencia del Gobierno de México para Extranjeros, administradas por la Agencia Mexicana de Cooperación Internacional para el Desarrollo (AMEXCID) de la Secretaría de Relaciones Exteriores (SRE).",
          en: "The Mexican Government Excellence Scholarships for Foreigners are administered by the Mexican Agency for International Development Cooperation (AMEXCID) of the Ministry of Foreign Affairs (SRE).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas de Excelencia del Gobierno de México para Extranjeros, administradas por la Agencia Mexicana de Cooperación Internacional para el Desarrollo (AMEXCID) de la Secretaría de Relaciones Exteriores (SRE).",
                en: "The Mexican Government Excellence Scholarships for Foreigners are administered by the Mexican Agency for International Development Cooperation (AMEXCID) of the Ministry of Foreign Affairs (SRE).",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de licenciatura (movilidad académica), maestría, doctorado, especialidades médicas, estancias de investigación y estancias posdoctorales, conforme a la convocatoria vigente.",
                  en: "Scholarships to pursue undergraduate studies (academic mobility), master's studies, doctoral studies, medical specialties, research stays and postdoctoral stays, according to the current call.",
                },
              },
              {
                text: {
                  es: "Más de 90 instituciones mexicanas de educación superior participan en el programa con una amplia oferta académica en diversas áreas del conocimiento.",
                  en: "More than 90 Mexican higher education institutions participate in the program with a broad academic offer in various fields of knowledge.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir apoyo económico, matrícula, seguro médico y otros beneficios establecidos en la convocatoria vigente.",
                  en: "Benefits may include financial support, tuition, health insurance and other benefits established in the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y las modalidades, beneficios y requisitos específicos pueden variar en cada edición.",
                  en: "Calls are published annually, and the modalities, benefits and specific requirements may vary in each edition.",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de admisión del programa seleccionado.",
                  en: "Meet the academic and admission requirements of the selected program.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida conforme a las bases de la convocatoria.",
                  en: "Submit the required documentation according to the call guidelines.",
                },
              },
              {
                text: {
                  es: "Realizar la postulación mediante el procedimiento oficial establecido por AMEXCID.",
                  en: "Apply through the official procedure established by AMEXCID.",
                },
              },
            ],
          },
        ],
        href: "https://www.gob.mx/amexcid/acciones-y-programas/becas-para-extranjeros-29785",
        linkLabel: {
          es: "Portal oficial de Becas para Extranjeros",
          en: "Official Scholarships for Foreigners portal",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "programa-becas-chevening",
        title: {
          es: "Programa de Becas Chevening",
          en: "Chevening Scholarship Program",
        },
        body: {
          es: "El Programa de Becas Chevening es la iniciativa internacional de becas del Gobierno del Reino Unido, financiada por el Foreign, Commonwealth and Development Office (FCDO) y organizaciones asociadas.",
          en: "The Chevening Scholarship Program is the international scholarship initiative of the Government of the United Kingdom, funded by the Foreign, Commonwealth and Development Office (FCDO) and partner organizations.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Programa de Becas Chevening es la iniciativa internacional de becas del Gobierno del Reino Unido, financiada por el Foreign, Commonwealth and Development Office (FCDO) y organizaciones asociadas. Está dirigida a profesionales con potencial de liderazgo que deseen cursar una maestría presencial de un año en una universidad del Reino Unido.",
                en: "The Chevening Scholarship Program is the international scholarship initiative of the Government of the United Kingdom, funded by the Foreign, Commonwealth and Development Office (FCDO) and partner organizations. It is aimed at professionals with leadership potential who wish to pursue a one-year in-person master's degree at a university in the United Kingdom.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Cobertura que puede incluir matrícula universitaria, pasajes internacionales, estipendio mensual, visa, asignaciones de llegada y salida y otros apoyos establecidos por el programa.",
                  en: "Coverage may include university tuition, international airfare, monthly stipend, visa, arrival and departure allowances and other support established by the program.",
                },
              },
              {
                text: {
                  es: "Acceso a actividades académicas, profesionales y de relacionamiento con la red internacional de Chevening.",
                  en: "Access to academic, professional and networking activities with the international Chevening network.",
                },
              },
              {
                text: {
                  es: "No existe un límite máximo de edad para postular.",
                  en: "There is no maximum age limit to apply.",
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
                text: {
                  es: "Contar con un título universitario que permita acceder a estudios de maestría en el Reino Unido.",
                  en: "Hold a university degree that allows access to master's studies in the United Kingdom.",
                },
              },
              {
                text: {
                  es: "Haber concluido el pregrado dentro del plazo mínimo establecido por la convocatoria vigente.",
                  en: "Have completed undergraduate studies within the minimum period established by the current call.",
                },
              },
              {
                text: {
                  es: "Acreditar al menos 2.800 horas de experiencia laboral obtenidas después de finalizar el pregrado. Puede incluir empleo a tiempo completo o parcial, voluntariado y prácticas profesionales remuneradas o no remuneradas.",
                  en: "Prove at least 2,800 hours of work experience obtained after completing undergraduate studies. This may include full-time or part-time employment, volunteering and paid or unpaid internships.",
                },
              },
              {
                text: {
                  es: "Postular a tres programas elegibles de maestría y obtener posteriormente una oferta incondicional de al menos uno de ellos dentro del plazo señalado.",
                  en: "Apply to three eligible master's programs and later obtain an unconditional offer from at least one of them within the indicated deadline.",
                },
              },
              {
                text: {
                  es: "Demostrar liderazgo, capacidad para establecer redes profesionales y un proyecto claro de impacto para Bolivia.",
                  en: "Demonstrate leadership, the ability to build professional networks and a clear impact project for Bolivia.",
                },
              },
              {
                text: {
                  es: "Comprometerse a regresar al país de origen durante al menos dos años después de finalizar la beca.",
                  en: "Commit to returning to the country of origin for at least two years after completing the scholarship.",
                },
              },
            ],
          },
        ],
        href: "https://www.chevening.org/scholarship/bolivia/",
        linkLabel: {
          es: "Programa de Becas Chevening",
          en: "Chevening Scholarship Program",
        },
      },
      {
        slug: "gates-cambridge-scholarship",
        title: {
          es: "Gates Cambridge Scholarship",
          en: "Gates Cambridge Scholarship",
        },
        body: {
          es: "La Gates Cambridge Scholarship es un programa internacional de becas financiado por la Fundación Bill & Melinda Gates y administrado por la Universidad de Cambridge, dirigido a estudiantes internacionales con excelencia académica, liderazgo y compromiso con mejorar la vida de otras personas.",
          en: "The Gates Cambridge Scholarship is an international scholarship program funded by the Bill & Melinda Gates Foundation and administered by the University of Cambridge, aimed at international students with academic excellence, leadership and a commitment to improving the lives of others.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Gates Cambridge Scholarship es un programa internacional de becas financiado por la Fundación Bill & Melinda Gates y administrado por la Universidad de Cambridge, dirigido a estudiantes internacionales con excelencia académica, liderazgo y compromiso con mejorar la vida de otras personas.",
                en: "The Gates Cambridge Scholarship is an international scholarship program funded by the Bill & Melinda Gates Foundation and administered by the University of Cambridge, aimed at international students with academic excellence, leadership and a commitment to improving the lives of others.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas completas para realizar estudios de maestría y doctorado en la Universidad de Cambridge, Reino Unido.",
                  en: "Full scholarships to pursue master's and doctoral studies at the University of Cambridge, United Kingdom.",
                },
              },
              {
                text: {
                  es: "Disponibles para prácticamente todas las disciplinas académicas ofrecidas por la Universidad de Cambridge.",
                  en: "Available for almost all academic disciplines offered by the University of Cambridge.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula universitaria, estipendio de manutención, pasajes internacionales, costos de visa, seguro de salud y otros apoyos establecidos en la convocatoria vigente.",
                  en: "Benefits may include university tuition, maintenance stipend, international airfare, visa costs, health insurance and other support established in the current call.",
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
                text: {
                  es: "Postular a un programa de maestría o doctorado elegible en la Universidad de Cambridge.",
                  en: "Apply to an eligible master's or doctoral program at the University of Cambridge.",
                },
              },
              {
                text: {
                  es: "Demostrar excelencia académica, liderazgo y un firme compromiso con generar un impacto positivo en la sociedad.",
                  en: "Demonstrate academic excellence, leadership and a strong commitment to generating a positive impact on society.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud mediante el proceso oficial de admisión de la Universidad de Cambridge, incluyendo los requisitos específicos de la Gates Cambridge Scholarship.",
                  en: "Submit the application through the official University of Cambridge admission process, including the specific Gates Cambridge Scholarship requirements.",
                },
              },
            ],
          },
        ],
        href: "https://www.gatescambridge.org/",
        linkLabel: {
          es: "Gates Cambridge Scholarship",
          en: "Gates Cambridge Scholarship",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "lund-university-global-scholarship",
        title: {
          es: "Lund University Global Scholarship",
          en: "Lund University Global Scholarship",
        },
        body: {
          es: "La Lund University Global Scholarship es un programa de becas por mérito académico ofrecido por la Universidad de Lund (Suecia), dirigido a estudiantes internacionales con un excelente desempeño académico que deseen cursar estudios de pregrado o maestría.",
          en: "The Lund University Global Scholarship is an academic merit scholarship program offered by Lund University (Sweden), aimed at international students with excellent academic performance who wish to pursue bachelor's or master's studies.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Lund University Global Scholarship es un programa de becas por mérito académico ofrecido por la Universidad de Lund (Suecia), dirigido a estudiantes internacionales con un excelente desempeño académico que deseen cursar estudios de pregrado (programas seleccionados) o maestría.",
                en: "The Lund University Global Scholarship is an academic merit scholarship program offered by Lund University (Sweden), aimed at international students with excellent academic performance who wish to pursue bachelor's studies (selected programs) or master's studies.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas dirigidas a estudiantes internacionales provenientes de países fuera de la Unión Europea (UE) y del Espacio Económico Europeo (EEE).",
                  en: "Scholarships aimed at international students from countries outside the European Union (EU) and the European Economic Area (EEA).",
                },
              },
              {
                text: {
                  es: "La beca puede cubrir parcial o totalmente el costo de la matrícula, según la evaluación del candidato.",
                  en: "The scholarship may partially or fully cover tuition costs, depending on the candidate's evaluation.",
                },
              },
              {
                text: {
                  es: "Se otorga con base en la excelencia académica, el potencial del postulante y su motivación para estudiar en la Universidad de Lund.",
                  en: "It is awarded based on academic excellence, the applicant's potential and their motivation to study at Lund University.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los beneficios, requisitos y fechas pueden variar en cada edición.",
                  en: "Calls are published annually, and benefits, requirements and dates may vary in each edition.",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de admisión establecidos por la universidad.",
                  en: "Meet the academic and admission requirements established by the university.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud de beca dentro del plazo oficial y adjuntar la carta de motivación requerida.",
                  en: "Submit the scholarship application within the official deadline and attach the required motivation letter.",
                },
              },
              {
                text: {
                  es: "Demostrar un excelente rendimiento académico, ya que la selección se realiza exclusivamente por mérito.",
                  en: "Demonstrate excellent academic performance, since selection is based exclusively on merit.",
                },
              },
            ],
          },
        ],
        href: "https://www.lunduniversity.lu.se/study/admission-degree-studies/entry-requirements",
        linkLabel: {
          es: "Lund University Global Scholarship",
          en: "Lund University Global Scholarship",
        },
      },
      {
        slug: "uppsala-university-global-scholarship",
        title: {
          es: "Uppsala University Global Scholarship",
          en: "Uppsala University Global Scholarship",
        },
        body: {
          es: "La Uppsala University Global Scholarship es un programa de becas por mérito académico ofrecido por la Universidad de Uppsala (Suecia), dirigido a estudiantes internacionales con un excelente desempeño académico que deseen cursar estudios de maestría.",
          en: "The Uppsala University Global Scholarship is an academic merit scholarship program offered by Uppsala University (Sweden), aimed at international students with excellent academic performance who wish to pursue master's studies.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Uppsala University Global Scholarship es un programa de becas por mérito académico ofrecido por la Universidad de Uppsala (Suecia), dirigido a estudiantes internacionales con un excelente desempeño académico que deseen cursar estudios de maestría.",
                en: "The Uppsala University Global Scholarship is an academic merit scholarship program offered by Uppsala University (Sweden), aimed at international students with excellent academic performance who wish to pursue master's studies.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas dirigidas a estudiantes internacionales provenientes de países fuera de la Unión Europea (UE), del Espacio Económico Europeo (EEE) y Suiza.",
                  en: "Scholarships aimed at international students from countries outside the European Union (EU), the European Economic Area (EEA) and Switzerland.",
                },
              },
              {
                text: {
                  es: "La beca cubre el costo total de la matrícula, pero no incluye los gastos de manutención.",
                  en: "The scholarship covers the full cost of tuition, but does not include living expenses.",
                },
              },
              {
                text: {
                  es: "Se otorga con base en la excelencia académica, el potencial del postulante y su capacidad para desenvolverse en un entorno académico internacional.",
                  en: "It is awarded based on academic excellence, the applicant's potential and their ability to perform in an international academic environment.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los requisitos, beneficios y fechas pueden variar en cada edición.",
                  en: "Calls are published annually, and requirements, benefits and dates may vary in each edition.",
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
                text: {
                  es: "Haber postulado a un programa internacional de maestría en la Universidad de Uppsala, seleccionándolo como primera opción en University Admissions.",
                  en: "Have applied to an international master's program at Uppsala University, selecting it as the first choice in University Admissions.",
                },
              },
              {
                text: {
                  es: "Cumplir con todos los requisitos de admisión y presentar la documentación completa dentro de los plazos establecidos.",
                  en: "Meet all admission requirements and submit the complete documentation within the established deadlines.",
                },
              },
              {
                text: {
                  es: "Demostrar un excelente rendimiento académico y potencial para contribuir al entorno académico de la universidad.",
                  en: "Demonstrate excellent academic performance and potential to contribute to the university's academic environment.",
                },
              },
              {
                text: {
                  es: "Presentar la solicitud de la beca mediante el sistema oficial de la Universidad de Uppsala.",
                  en: "Submit the scholarship application through Uppsala University's official system.",
                },
              },
            ],
          },
        ],
        href: "https://www.uu.se/en/study/masters-studies/scholarships/uppsala-university-scholarships.html",
        linkLabel: {
          es: "Enlace oficial del programa",
          en: "Official program link",
        },
      },
      {
        slug: "kth-scholarship",
        title: {
          es: "KTH Scholarship",
          en: "KTH Scholarship",
        },
        body: {
          es: "La KTH Scholarship es un programa de becas por mérito académico ofrecido por el KTH Royal Institute of Technology, una de las universidades tecnológicas más prestigiosas de Europa.",
          en: "The KTH Scholarship is an academic merit scholarship program offered by KTH Royal Institute of Technology, one of Europe's most prestigious technological universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La KTH Scholarship es un programa de becas por mérito académico ofrecido por el KTH Royal Institute of Technology, una de las universidades tecnológicas más prestigiosas de Europa. Está dirigida a estudiantes internacionales con un excelente desempeño académico que deseen cursar estudios de maestría en Suecia.",
                en: "The KTH Scholarship is an academic merit scholarship program offered by KTH Royal Institute of Technology, one of Europe's most prestigious technological universities. It is aimed at international students with excellent academic performance who wish to pursue master's studies in Sweden.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas dirigidas a estudiantes internacionales provenientes de países fuera de la Unión Europea (UE), del Espacio Económico Europeo (EEE) y Suiza.",
                  en: "Scholarships aimed at international students from countries outside the European Union (EU), the European Economic Area (EEA) and Switzerland.",
                },
              },
              {
                text: {
                  es: "Destinadas a programas de maestría impartidos por el KTH Royal Institute of Technology.",
                  en: "Intended for master's programs offered by KTH Royal Institute of Technology.",
                },
              },
              {
                text: {
                  es: "La beca cubre el costo total de la matrícula durante uno o dos años de estudio, siempre que el estudiante mantenga un rendimiento académico satisfactorio.",
                  en: "The scholarship covers the full cost of tuition for one or two years of study, provided that the student maintains satisfactory academic performance.",
                },
              },
              {
                text: {
                  es: "Se otorga con base en la excelencia académica, la trayectoria del postulante y su potencial para contribuir al desarrollo sostenible mediante los conocimientos adquiridos en KTH.",
                  en: "It is awarded based on academic excellence, the applicant's background and their potential to contribute to sustainable development through the knowledge acquired at KTH.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los requisitos, beneficios y fechas pueden variar en cada edición.",
                  en: "Calls are published annually, and requirements, benefits and dates may vary in each edition.",
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
                text: {
                  es: "Haber postulado a un programa de maestría elegible en KTH como primera opción a través del sistema oficial University Admissions.",
                  en: "Have applied to an eligible master's program at KTH as the first choice through the official University Admissions system.",
                },
              },
              {
                text: {
                  es: "Ser un estudiante sujeto al pago de matrícula internacional.",
                  en: "Be a student subject to international tuition fees.",
                },
              },
              {
                text: {
                  es: "Cumplir con todos los requisitos de admisión y presentar la documentación dentro de los plazos establecidos.",
                  en: "Meet all admission requirements and submit the documentation within the established deadlines.",
                },
              },
              {
                text: {
                  es: "Demostrar un excelente historial académico, motivación y potencial para contribuir al desarrollo sostenible.",
                  en: "Demonstrate an excellent academic record, motivation and potential to contribute to sustainable development.",
                },
              },
            ],
          },
        ],
        href: "https://www.kth.se/en/studies/master/admissions/scholarships/kth-scholarship-1.72827",
        linkLabel: {
          es: "Enlace oficial del programa",
          en: "Official program link",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "becas-excelencia-gobierno-suizo",
        title: {
          es: "Becas de Excelencia del Gobierno Suizo",
          en: "Swiss Government Excellence Scholarships",
        },
        body: {
          es: "Las Becas de Excelencia del Gobierno Suizo son un programa internacional financiado por la Confederación Suiza y administrado por la Comisión Federal de Becas para Estudiantes Extranjeros (FCS/ESKAS).",
          en: "The Swiss Government Excellence Scholarships are an international program funded by the Swiss Confederation and administered by the Federal Commission for Scholarships for Foreign Students (FCS/ESKAS).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Becas de Excelencia del Gobierno Suizo son un programa internacional financiado por la Confederación Suiza y administrado por la Comisión Federal de Becas para Estudiantes Extranjeros (FCS/ESKAS). Su objetivo es promover el intercambio académico y la cooperación científica entre Suiza y más de 180 países.",
                en: "The Swiss Government Excellence Scholarships are an international program funded by the Swiss Confederation and administered by the Federal Commission for Scholarships for Foreign Students (FCS/ESKAS). Its objective is to promote academic exchange and scientific cooperation between Switzerland and more than 180 countries.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas dirigidas a jóvenes investigadores internacionales que deseen realizar estancias de investigación o estudios de doctorado en universidades, institutos federales de tecnología, universidades de ciencias aplicadas e institutos públicos de investigación de Suiza.",
                  en: "Scholarships aimed at young international researchers who wish to carry out research stays or doctoral studies at universities, federal institutes of technology, universities of applied sciences and public research institutes in Switzerland.",
                },
              },
              {
                text: {
                  es: "Disponibles para todas las áreas del conocimiento, siempre que el proyecto de investigación sea respaldado por un profesor o supervisor académico de una institución suiza.",
                  en: "Available for all fields of knowledge, provided that the research project is supported by a professor or academic supervisor from a Swiss institution.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir estipendio mensual, seguro médico, exención de matrícula cuando corresponda y otros apoyos establecidos en la convocatoria vigente.",
                  en: "Benefits may include a monthly stipend, health insurance, tuition exemption where applicable and other support established in the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los tipos de beca, requisitos y beneficios pueden variar según el país de origen y la edición correspondiente.",
                  en: "Calls are published annually, and scholarship types, requirements and benefits may vary according to the country of origin and the corresponding edition.",
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
                text: {
                  es: "Contar con un título de maestría o el grado académico requerido para la modalidad de beca solicitada.",
                  en: "Hold a master's degree or the academic degree required for the requested scholarship modality.",
                },
              },
              {
                text: {
                  es: "Presentar un proyecto de investigación o una propuesta doctoral de alta calidad.",
                  en: "Submit a high-quality research project or doctoral proposal.",
                },
              },
              {
                text: {
                  es: "Obtener el respaldo de un profesor o supervisor académico de una institución de educación superior en Suiza.",
                  en: "Obtain the support of a professor or academic supervisor from a higher education institution in Switzerland.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos de elegibilidad establecidos para el país de origen y presentar la solicitud conforme al procedimiento oficial.",
                  en: "Meet the eligibility requirements established for the country of origin and submit the application according to the official procedure.",
                },
              },
            ],
          },
        ],
        href: "https://www.sbfi.admin.ch/sbfi/en/home/education/scholarships-and-grants/swiss-government-excellence-scholarships.html",
        linkLabel: {
          es: "Becas Suizas",
          en: "Swiss Scholarships",
        },
      },
      {
        slug: "becas-maestria-fundacion-simon-patino",
        title: {
          es: "Becas de Maestría - Fundación Simón I. Patiño",
          en: "Master's Scholarships - Simón I. Patiño Foundation",
        },
        body: {
          es: "La Fundación Simón I. Patiño ofrece un programa de becas dirigido a profesionales bolivianos que deseen realizar estudios de maestría en universidades asociadas de Suiza.",
          en: "The Simón I. Patiño Foundation offers a scholarship program for Bolivian professionals who wish to pursue master's studies at partner universities in Switzerland.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Fundación Simón I. Patiño ofrece un programa de becas dirigido a profesionales bolivianos que deseen realizar estudios de maestría en universidades asociadas de Suiza. El programa busca fortalecer la formación académica de alto nivel y contribuir al desarrollo de Bolivia mediante el retorno y la aplicación de los conocimientos adquiridos.",
                en: "The Simón I. Patiño Foundation offers a scholarship program for Bolivian professionals who wish to pursue master's studies at partner universities in Switzerland. The program seeks to strengthen high-level academic training and contribute to Bolivia's development through the return and application of the knowledge acquired.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Dirigidas exclusivamente a profesionales bolivianos con excelencia académica y potencial de liderazgo.",
                  en: "Aimed exclusively at Bolivian professionals with academic excellence and leadership potential.",
                },
              },
              {
                text: {
                  es: "Los beneficios y la cobertura se establecen en la convocatoria vigente y pueden incluir apoyo para estudios y otros gastos asociados.",
                  en: "Benefits and coverage are established in the current call and may include support for studies and other associated expenses.",
                },
              },
              {
                text: {
                  es: "Los becarios asumen el compromiso de retornar a Bolivia al finalizar sus estudios para contribuir al desarrollo del país.",
                  en: "Scholarship recipients commit to returning to Bolivia after completing their studies to contribute to the country's development.",
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
                text: {
                  es: "Contar con un título universitario de licenciatura o equivalente.",
                  en: "Hold a bachelor's degree or equivalent university degree.",
                },
              },
              {
                text: {
                  es: "Obtener la admisión a un programa de maestría elegible en una universidad asociada.",
                  en: "Obtain admission to an eligible master's program at a partner university.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos establecidos por la Fundación Simón I. Patiño y la convocatoria vigente.",
                  en: "Meet the requirements established by the Simón I. Patiño Foundation and the current call.",
                },
              },
            ],
          },
        ],
        href: "https://patino.org/es/nuestras-becas-de-estudio/",
        linkLabel: {
          es: "Programa Fundación Patiño",
          en: "Patiño Foundation Program",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "taiwan-international-graduate-program-tigp",
        title: {
          es: "Taiwan International Graduate Program (TIGP)",
          en: "Taiwan International Graduate Program (TIGP)",
        },
        body: {
          es: "El Taiwan International Graduate Program (TIGP) es un programa internacional de doctorado desarrollado por Academia Sinica, en colaboración con las principales universidades de Taiwán.",
          en: "The Taiwan International Graduate Program (TIGP) is an international doctoral program developed by Academia Sinica, in collaboration with Taiwan's leading universities.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Taiwan International Graduate Program (TIGP) es un programa internacional de doctorado desarrollado por Academia Sinica, en colaboración con las principales universidades de Taiwán. Su objetivo es formar investigadores de excelencia mediante programas impartidos completamente en inglés en diversas áreas científicas y tecnológicas.",
                en: "The Taiwan International Graduate Program (TIGP) is an international doctoral program developed by Academia Sinica, in collaboration with Taiwan's leading universities. Its objective is to train excellent researchers through programs taught completely in English in various scientific and technological fields.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Programas de doctorado en ciencias, ingeniería, biotecnología, medicina, inteligencia artificial, ciencias ambientales y otras áreas de investigación.",
                  en: "Doctoral programs in science, engineering, biotechnology, medicine, artificial intelligence, environmental sciences and other research areas.",
                },
              },
              {
                text: {
                  es: "Los estudiantes realizan sus investigaciones en Academia Sinica y obtienen el grado de doctor en colaboración con una universidad asociada.",
                  en: "Students conduct their research at Academia Sinica and obtain the doctoral degree in collaboration with a partner university.",
                },
              },
              {
                text: {
                  es: "El programa ofrece apoyo financiero conforme a la convocatoria vigente, que puede incluir estipendio mensual, apoyo para matrícula y financiamiento para actividades de investigación.",
                  en: "The program offers financial support according to the current call, which may include a monthly stipend, tuition support and funding for research activities.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los programas, beneficios y requisitos pueden variar en cada edición.",
                  en: "Calls are published annually, and programs, benefits and requirements may vary in each edition.",
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
                text: {
                  es: "Contar con un título universitario que permita el ingreso a estudios de doctorado.",
                  en: "Hold a university degree that allows admission to doctoral studies.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y de idioma establecidos por el programa seleccionado.",
                  en: "Meet the academic and language requirements established by the selected program.",
                },
              },
              {
                text: {
                  es: "Presentar una solicitud completa mediante el sistema oficial de admisiones del TIGP.",
                  en: "Submit a complete application through the official TIGP admissions system.",
                },
              },
              {
                text: {
                  es: "Demostrar interés y potencial para desarrollar investigación científica de alto nivel.",
                  en: "Demonstrate interest and potential to develop high-level scientific research.",
                },
              },
            ],
          },
        ],
        href: "https://tigp.sinica.edu.tw/",
        linkLabel: {
          es: "Taiwan TIGP",
          en: "Taiwan TIGP",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "turkiye-scholarships-turkiye-burslari",
        title: {
          es: "Türkiye Scholarships (Türkiye Bursları)",
          en: "Türkiye Scholarships (Türkiye Bursları)",
        },
        body: {
          es: "Las Türkiye Scholarships (Türkiye Bursları) son el programa oficial de becas del Gobierno de Türkiye, administrado por la Presidencia para los Turcos en el Extranjero y las Comunidades Afines (YTB).",
          en: "Türkiye Scholarships (Türkiye Bursları) are the official scholarship program of the Government of Türkiye, administered by the Presidency for Turks Abroad and Related Communities (YTB).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "Las Türkiye Scholarships (Türkiye Bursları) son el programa oficial de becas del Gobierno de Türkiye, administrado por la Presidencia para los Turcos en el Extranjero y las Comunidades Afines (YTB). Su objetivo es brindar oportunidades de formación académica a estudiantes internacionales mediante estudios en las principales universidades de Türkiye.",
                en: "Türkiye Scholarships (Türkiye Bursları) are the official scholarship program of the Government of Türkiye, administered by the Presidency for Turks Abroad and Related Communities (YTB). Its objective is to provide academic training opportunities to international students through studies at Türkiye's leading universities.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de pregrado, maestría, doctorado, investigación y otros programas académicos especializados.",
                  en: "Scholarships to pursue undergraduate, master's, doctoral, research and other specialized academic programs.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir asignación universitaria, matrícula, estipendio mensual, alojamiento, seguro médico, curso de idioma turco, pasajes internacionales y actividades académicas, sociales y culturales.",
                  en: "Benefits may include university placement, tuition, monthly stipend, accommodation, health insurance, Turkish language course, international airfare and academic, social and cultural activities.",
                },
              },
              {
                text: {
                  es: "Las convocatorias se publican anualmente y los programas, beneficios y requisitos pueden variar en cada edición.",
                  en: "Calls are published annually, and programs, benefits and requirements may vary in each edition.",
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
                text: {
                  es: "Cumplir con los requisitos académicos y de edad establecidos para el nivel de estudios solicitado.",
                  en: "Meet the academic and age requirements established for the requested level of study.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación requerida mediante el sistema oficial de postulación.",
                  en: "Submit the required documentation through the official application system.",
                },
              },
              {
                text: {
                  es: "Demostrar un buen desempeño académico y cumplir con los criterios de selección del programa.",
                  en: "Demonstrate good academic performance and meet the program's selection criteria.",
                },
              },
            ],
          },
        ],
        href: "https://www.turkiyeburslari.gov.tr/",
        linkLabel: {
          es: "Programa oficial",
          en: "Official program",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "programa-becas-masta-agencia-boliviana-espacial",
        title: {
          es: "Programa de Becas MASTA - Agencia Boliviana Espacial",
          en: "MASTA Scholarship Program - Bolivian Space Agency",
        },
        body: {
          es: "El Master in Space Technology Applications (MASTA) es un programa internacional de maestría desarrollado por el Regional Centre for Space Science and Technology Education in Asia and the Pacific (RCSSTEAP), en colaboración con Beihang University y el China Scholarship Council (CSC).",
          en: "The Master in Space Technology Applications (MASTA) is an international master's program developed by the Regional Centre for Space Science and Technology Education in Asia and the Pacific (RCSSTEAP), in collaboration with Beihang University and the China Scholarship Council (CSC).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Master in Space Technology Applications (MASTA) es un programa internacional de maestría desarrollado por el Regional Centre for Space Science and Technology Education in Asia and the Pacific (RCSSTEAP), en colaboración con Beihang University y el China Scholarship Council (CSC). En Bolivia, las convocatorias son coordinadas por la Agencia Boliviana Espacial (ABE).",
                en: "The Master in Space Technology Applications (MASTA) is an international master's program developed by the Regional Centre for Space Science and Technology Education in Asia and the Pacific (RCSSTEAP), in collaboration with Beihang University and the China Scholarship Council (CSC). In Bolivia, calls are coordinated by the Bolivian Space Agency (ABE).",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas dirigidas a profesionales bolivianos interesados en especializarse en ciencia, tecnología y aplicaciones espaciales.",
                  en: "Scholarships aimed at Bolivian professionals interested in specializing in space science, technology and applications.",
                },
              },
              {
                text: {
                  es: "Programa académico impartido en inglés en la Universidad de Beihang, China.",
                  en: "Academic program taught in English at Beihang University, China.",
                },
              },
              {
                text: {
                  es: "Áreas de formación que pueden incluir:",
                  en: "Training areas may include:",
                },
                children: [
                  {
                    text: {
                      es: "Teledetección y Sistemas de Información Geográfica.",
                      en: "Remote Sensing and Geographic Information Systems.",
                    },
                  },
                  {
                    text: {
                      es: "Sistemas Globales de Navegación por Satélite.",
                      en: "Global Navigation Satellite Systems.",
                    },
                  },
                  {
                    text: {
                      es: "Gestión de Proyectos Espaciales.",
                      en: "Space Project Management.",
                    },
                  },
                  {
                    text: {
                      es: "Tecnología de Microsatélites.",
                      en: "Microsatellite Technology.",
                    },
                  },
                ],
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, alojamiento, estipendio, seguro médico y otros apoyos establecidos en la convocatoria vigente.",
                  en: "Benefits may include tuition, accommodation, stipend, health insurance and other support established in the current call.",
                },
              },
              {
                text: {
                  es: "Las convocatorias, el número de becas y las áreas disponibles pueden variar en cada edición.",
                  en: "Calls, the number of scholarships and available areas may vary in each edition.",
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
                text: {
                  es: "Ser profesional boliviano y contar con un título universitario de licenciatura o equivalente.",
                  en: "Be a Bolivian professional and hold a bachelor's degree or equivalent university degree.",
                },
              },
              {
                text: {
                  es: "Tener formación académica relacionada con ingeniería, ciencias, tecnología, telecomunicaciones, geografía u otras áreas afines al programa seleccionado.",
                  en: "Have academic training related to engineering, sciences, technology, telecommunications, geography or other areas related to the selected program.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos, profesionales, lingüísticos y documentales establecidos en la convocatoria vigente.",
                  en: "Meet the academic, professional, language and documentation requirements established in the current call.",
                },
              },
              {
                text: {
                  es: "Presentar la postulación mediante el procedimiento de preselección definido por la Agencia Boliviana Espacial.",
                  en: "Submit the application through the preselection procedure defined by the Bolivian Space Agency.",
                },
              },
              {
                text: {
                  es: "Superar las etapas de evaluación nacional y la selección final realizada por las instituciones responsables del programa.",
                  en: "Pass the national evaluation stages and the final selection carried out by the institutions responsible for the program.",
                },
              },
            ],
          },
        ],
        href: "https://www.abe.bo/estudiantes/becasmaestria/",
        linkLabel: {
          es: "Convocatorias MASTA - ABE",
          en: "MASTA Calls - ABE",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "robert-s-mcnamara-fellowships-program-rsmfp",
        title: {
          es: "Robert S. McNamara Fellowships Program (RSMFP)",
          en: "Robert S. McNamara Fellowships Program (RSMFP)",
        },
        body: {
          es: "El Robert S. McNamara Fellowships Program (RSMFP) es un programa del Banco Mundial que conecta a jóvenes investigadores de países en desarrollo con economistas e investigadores de la Vicepresidencia de Economía del Desarrollo (DEC).",
          en: "The Robert S. McNamara Fellowships Program (RSMFP) is a World Bank program that connects young researchers from developing countries with economists and researchers from the Development Economics Vice Presidency (DEC).",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Robert S. McNamara Fellowships Program (RSMFP) es un programa del Banco Mundial que conecta a jóvenes investigadores de países en desarrollo con economistas e investigadores de la Vicepresidencia de Economía del Desarrollo (DEC). Su objetivo es fortalecer la investigación aplicada y generar evidencia para apoyar el diseño de políticas públicas orientadas al desarrollo.",
                en: "The Robert S. McNamara Fellowships Program (RSMFP) is a World Bank program that connects young researchers from developing countries with economists and researchers from the Development Economics Vice Presidency (DEC). Its objective is to strengthen applied research and generate evidence to support the design of development-oriented public policies.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Los becarios desarrollan proyectos de investigación en la sede del Banco Mundial en Washington, D.C., bajo la supervisión de investigadores del Banco Mundial.",
                  en: "Fellows develop research projects at World Bank headquarters in Washington, D.C., under the supervision of World Bank researchers.",
                },
              },
              {
                text: {
                  es: "Ofrece formación en metodologías de investigación, análisis econométrico y participación en proyectos de alto impacto para el desarrollo internacional.",
                  en: "It offers training in research methodologies, econometric analysis and participation in high-impact projects for international development.",
                },
              },
              {
                text: {
                  es: "Las convocatorias, beneficios y requisitos se publican periódicamente y pueden variar en cada edición.",
                  en: "Calls, benefits and requirements are published periodically and may vary in each edition.",
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
                text: {
                  es: "Contar con estudios de maestría o estar cursando un doctorado en Economía o un campo relacionado.",
                  en: "Have master's studies or be pursuing a doctorate in Economics or a related field.",
                },
              },
              {
                text: {
                  es: "Demostrar interés y experiencia en investigación aplicada al desarrollo.",
                  en: "Demonstrate interest and experience in development-related applied research.",
                },
              },
              {
                text: {
                  es: "Poseer un buen dominio del idioma inglés.",
                  en: "Have a good command of English.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos establecidos en la convocatoria vigente.",
                  en: "Meet the requirements established in the current call.",
                },
              },
            ],
          },
        ],
        href: "https://www.worldbank.org/en/programs/scholarships/brief/robert-s-mcnamara-fellowships-program",
        linkLabel: {
          es: "Programa oficial",
          en: "Official program",
        },
      },
      {
        slug: "joint-japan-world-bank-graduate-scholarship-program",
        title: {
          es: "Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP)",
          en: "Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP)",
        },
        body: {
          es: "El Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP) es un programa del Banco Mundial, financiado por el Gobierno de Japón, que ofrece becas completas para profesionales de países en desarrollo interesados en cursar programas de maestría.",
          en: "The Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP) is a World Bank program funded by the Government of Japan that offers full scholarships for professionals from developing countries interested in pursuing master's programs.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "El Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP) es un programa del Banco Mundial, financiado por el Gobierno de Japón, que ofrece becas completas para profesionales de países en desarrollo interesados en cursar programas de maestría.",
                en: "The Joint Japan / World Bank Graduate Scholarship Program (JJ/WBGSP) is a World Bank program funded by the Government of Japan that offers full scholarships for professionals from developing countries interested in pursuing master's programs.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Becas para realizar estudios de maestría en áreas vinculadas con el desarrollo, como economía, políticas públicas, salud pública, infraestructura, gestión ambiental, cambio climático, agricultura, desarrollo urbano, gestión del agua y otras disciplinas afines.",
                  en: "Scholarships to pursue master's studies in development-related areas such as economics, public policy, public health, infrastructure, environmental management, climate change, agriculture, urban development, water management and other related disciplines.",
                },
              },
              {
                text: {
                  es: "Dirigidas a profesionales de países en desarrollo con experiencia laboral y compromiso demostrado con el desarrollo económico y social de su país.",
                  en: "Aimed at professionals from developing countries with work experience and demonstrated commitment to the economic and social development of their country.",
                },
              },
              {
                text: {
                  es: "Los programas elegibles se imparten en universidades participantes de Estados Unidos, Europa, África, Oceanía y Japón.",
                  en: "Eligible programs are taught at participating universities in the United States, Europe, Africa, Oceania and Japan.",
                },
              },
              {
                text: {
                  es: "Los beneficios pueden incluir matrícula, estipendio mensual, pasajes internacionales, seguro médico y apoyo para gastos de viaje, conforme a la convocatoria vigente.",
                  en: "Benefits may include tuition, monthly stipend, international airfare, health insurance and travel expense support, according to the current call.",
                },
              },
              {
                text: {
                  es: "Para postular, es obligatorio haber obtenido previamente la admisión a uno de los programas de maestría participantes.",
                  en: "To apply, it is mandatory to have previously obtained admission to one of the participating master's programs.",
                },
              },
              {
                text: {
                  es: "Al finalizar sus estudios, los becarios se comprometen a regresar a su país de origen para contribuir a su desarrollo.",
                  en: "After completing their studies, scholarship recipients commit to returning to their country of origin to contribute to its development.",
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
                text: {
                  es: "Ser ciudadano de un país en desarrollo miembro del Banco Mundial.",
                  en: "Be a citizen of a World Bank member developing country.",
                },
              },
              {
                text: {
                  es: "Contar con un título universitario y experiencia profesional relacionada con el desarrollo.",
                  en: "Hold a university degree and have professional experience related to development.",
                },
              },
              {
                text: {
                  es: "Cumplir con los requisitos académicos y documentales establecidos por el Banco Mundial y la universidad seleccionada.",
                  en: "Meet the academic and documentation requirements established by the World Bank and the selected university.",
                },
              },
            ],
          },
        ],
        href: "https://www.worldbank.org/en/programs/scholarships/jj-wbgsp",
        linkLabel: {
          es: "Programa JJ/WBGSP",
          en: "JJ/WBGSP Program",
        },
      },
    ],
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
    opportunities: [
      {
        slug: "convocatorias-internacionales-becas-egpp",
        title: {
          es: "Convocatorias Internacionales de Becas - Escuela de Gestión Pública Plurinacional (EGPP)",
          en: "International Scholarship Calls - Plurinational School of Public Management (EGPP)",
        },
        body: {
          es: "La Escuela de Gestión Pública Plurinacional (EGPP) es la entidad del Estado Plurinacional de Bolivia encargada de coordinar y canalizar las postulaciones a diversas becas internacionales ofrecidas por gobiernos, organismos multilaterales e instituciones de cooperación.",
          en: "The Plurinational School of Public Management (EGPP) is the institution of the Plurinational State of Bolivia responsible for coordinating and channeling applications to various international scholarships offered by governments, multilateral organizations and cooperation institutions.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La Escuela de Gestión Pública Plurinacional (EGPP) es la entidad del Estado Plurinacional de Bolivia encargada de coordinar y canalizar las postulaciones a diversas becas internacionales ofrecidas por gobiernos, organismos multilaterales e instituciones de cooperación.",
                en: "The Plurinational School of Public Management (EGPP) is the institution of the Plurinational State of Bolivia responsible for coordinating and channeling applications to various international scholarships offered by governments, multilateral organizations and cooperation institutions.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Publica de manera permanente convocatorias de pregrado, maestría, doctorado, investigación, cursos de especialización y programas de capacitación en diferentes países.",
                  en: "It permanently publishes calls for undergraduate, master's, doctoral, research, specialization courses and training programs in different countries.",
                },
              },
              {
                text: {
                  es: "Canaliza postulaciones para programas promovidos por gobiernos y organismos internacionales, entre ellos China, Corea, Japón, México, la Organización de los Estados Americanos (OEA) y otros países e instituciones cooperantes.",
                  en: "It channels applications for programs promoted by governments and international organizations, including China, Korea, Japan, Mexico, the Organization of American States (OAS) and other cooperating countries and institutions.",
                },
              },
              {
                text: {
                  es: "La EGPP verifica el cumplimiento de los requisitos establecidos por el Gobierno de Bolivia y por la institución patrocinadora, remitiendo posteriormente las postulaciones al organismo correspondiente.",
                  en: "EGPP verifies compliance with the requirements established by the Government of Bolivia and by the sponsoring institution, subsequently forwarding applications to the corresponding organization.",
                },
              },
              {
                text: {
                  es: "La selección final y la otorgación de las becas son realizadas exclusivamente por el país u organismo oferente.",
                  en: "Final selection and scholarship granting are carried out exclusively by the offering country or organization.",
                },
              },
              {
                text: {
                  es: "Las convocatorias, requisitos y áreas de estudio se actualizan periódicamente conforme a la oferta internacional vigente.",
                  en: "Calls, requirements and fields of study are updated periodically according to the current international offer.",
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
                text: {
                  es: "Cumplir con los requisitos establecidos por la EGPP y por la convocatoria internacional correspondiente.",
                  en: "Meet the requirements established by EGPP and by the corresponding international call.",
                },
              },
              {
                text: {
                  es: "Presentar la documentación dentro de los plazos oficiales.",
                  en: "Submit the documentation within the official deadlines.",
                },
              },
              {
                text: {
                  es: "Satisfacer las condiciones académicas, profesionales y lingüísticas exigidas por el organismo patrocinador.",
                  en: "Satisfy the academic, professional and language conditions required by the sponsoring organization.",
                },
              },
            ],
          },
        ],
        href: "https://egpp.gob.bo/oferta-de-becas/",
        linkLabel: {
          es: "Portal EGPP",
          en: "EGPP Portal",
        },
      },
    ],
  },
  {
    slug: "oea",
    type: "organization",
    name: { es: "OEA", en: "OAS" },
    region: { es: "Organismo internacional", en: "International organization" },
    summary: {
      es: "Becas y programas de cooperación académica de la Organización de los Estados Americanos.",
      en: "Scholarships and academic cooperation programs from the Organization of American States.",
    },
    accent: "#003770",
    opportunities: [
      {
        slug: "portal-becas-oea",
        title: {
          es: "Portal de Becas OEA",
          en: "OAS Scholarship Portal",
        },
        body: {
          es: "La Organización de los Estados Americanos ofrece programas de becas y oportunidades de formación para ciudadanos de sus Estados Miembros, orientados al fortalecimiento académico, profesional y regional.",
          en: "The Organization of American States offers scholarship programs and training opportunities for citizens of its Member States, aimed at academic, professional and regional development.",
        },
        contentSections: [
          {
            paragraphs: [
              {
                es: "La OEA difunde oportunidades de becas, capacitación y cooperación académica en alianza con universidades e instituciones internacionales. Las convocatorias, áreas de estudio, modalidades y beneficios pueden variar según cada programa.",
                en: "The OAS shares scholarship, training and academic cooperation opportunities in partnership with universities and international institutions. Calls, fields of study, formats and benefits may vary depending on each program.",
              },
            ],
            bullets: [
              {
                text: {
                  es: "Programas dirigidos a ciudadanos de Estados Miembros de la OEA.",
                  en: "Programs aimed at citizens of OAS Member States.",
                },
              },
              {
                text: {
                  es: "Oportunidades de formación, posgrado, capacitación profesional y cooperación académica.",
                  en: "Training, graduate study, professional development and academic cooperation opportunities.",
                },
              },
              {
                text: {
                  es: "Los requisitos, beneficios y fechas deben revisarse en cada convocatoria oficial.",
                  en: "Requirements, benefits and dates should be reviewed in each official call.",
                },
              },
            ],
          },
        ],
        href: "https://www.oas.org/es/becas/",
        linkLabel: {
          es: "Portal oficial de Becas OEA",
          en: "Official OAS Scholarship Portal",
        },
      },
    ],
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
