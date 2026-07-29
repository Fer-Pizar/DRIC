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
