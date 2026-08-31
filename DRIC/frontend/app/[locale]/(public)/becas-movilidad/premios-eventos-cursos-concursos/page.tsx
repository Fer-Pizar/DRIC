"use client";

import Link from "next/link";
import { use, useMemo, useState, type ReactNode } from "react";
import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import ArrowBackRoundedIcon from "@mui/icons-material/ArrowBackRounded";
import ArrowForwardRoundedIcon from "@mui/icons-material/ArrowForwardRounded";
import CalendarMonthRoundedIcon from "@mui/icons-material/CalendarMonthRounded";
import DescriptionRoundedIcon from "@mui/icons-material/DescriptionRounded";
import EmojiEventsRoundedIcon from "@mui/icons-material/EmojiEventsRounded";
import LanguageRoundedIcon from "@mui/icons-material/LanguageRounded";
import LinkRoundedIcon from "@mui/icons-material/LinkRounded";
import LocationOnRoundedIcon from "@mui/icons-material/LocationOnRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";
import SchoolRoundedIcon from "@mui/icons-material/SchoolRounded";
import WorkRoundedIcon from "@mui/icons-material/WorkRounded";

type Locale = "es" | "en";

type LocalizedText = Record<Locale, string>;

type Opportunity = {
  title: LocalizedText;
  category: LocalizedText;
  audience: LocalizedText;
  summary: LocalizedText;
  dates?: LocalizedText;
  deadline?: LocalizedText;
  location?: LocalizedText;
  format?: LocalizedText;
  details: LocalizedText[];
  benefits?: LocalizedText[];
  requirements?: LocalizedText[];
  documents?: LocalizedText[];
  links?: {
    label: LocalizedText;
    href: string;
  }[];
  contact?: string;
};

const copy = {
  es: {
    back: "Volver a Becas y Movilidad",
    eyebrow: "Convocatorias academicas",
    title: "Premios, eventos, cursos y concursos",
    intro:
      "Oportunidades de formacion, investigacion, liderazgo, intercambio academico y participacion internacional difundidas por la DRIC para la comunidad universitaria.",
    cms: "Contenido organizado para una futura administracion desde CMS: categorias, fechas, enlaces, requisitos y documentos pueden migrarse a registros editables.",
    featured: "Oportunidades destacadas",
    archive: "Archivo y convocatorias difundidas",
    deadline: "Plazo",
    dates: "Fechas",
    location: "Lugar",
    format: "Modalidad",
    audience: "Dirigido a",
    details: "Informacion clave",
    benefits: "Beneficios",
    requirements: "Requisitos",
    documents: "Documentos",
    links: "Enlaces",
    contact: "Contacto",
    all: "Todas",
    filtered: "Convocatorias filtradas",
  },
  en: {
    back: "Back to Scholarships and Mobility",
    eyebrow: "Academic calls",
    title: "Awards, events, courses and contests",
    intro:
      "Training, research, leadership, academic exchange, and international participation opportunities shared by DRIC for the university community.",
    cms: "Content structured for future CMS administration: categories, dates, links, requirements, and documents can be migrated into editable records.",
    featured: "Featured opportunities",
    archive: "Archive and shared calls",
    deadline: "Deadline",
    dates: "Dates",
    location: "Location",
    format: "Format",
    audience: "Audience",
    details: "Key information",
    benefits: "Benefits",
    requirements: "Requirements",
    documents: "Documents",
    links: "Links",
    contact: "Contact",
    all: "All",
    filtered: "Filtered calls",
  },
};

const opportunities: Opportunity[] = [
  {
    title: {
      es: "Programa para el Fortalecimiento de la Funcion Publica en America Latina",
      en: "Program for Strengthening Public Service in Latin America",
    },
    category: { es: "Liderazgo publico", en: "Public leadership" },
    audience: {
      es: "Universitarios latinoamericanos de todas las carreras con vocacion de liderazgo publico.",
      en: "Latin American university students from all fields with a vocation for public leadership.",
    },
    summary: {
      es: "La Fundacion Botin impulsa una experiencia internacional para formar universitarios comprometidos con la mejora de las instituciones publicas.",
      en: "Fundacion Botin offers an international experience for university students committed to strengthening public institutions.",
    },
    dates: {
      es: "13 de octubre al 3 de diciembre de 2026",
      en: "October 13 to December 3, 2026",
    },
    deadline: {
      es: "20 de mayo de 2026",
      en: "May 20, 2026",
    },
    location: {
      es: "Colombia, Espana, Camino de Santiago, Rio de Janeiro",
      en: "Colombia, Spain, Camino de Santiago, Rio de Janeiro",
    },
    format: { es: "Presencial internacional", en: "In-person international program" },
    details: [
      {
        es: "La XVII edicion inicia en Colombia, en la Universidad de los Andes, y continua por Madrid, Santander, Salamanca, Camino de Santiago y Rio de Janeiro.",
        en: "The 17th edition begins in Colombia at Universidad de los Andes and continues through Madrid, Santander, Salamanca, Camino de Santiago, and Rio de Janeiro.",
      },
      {
        es: "El programa busca mejorar las instituciones promoviendo que mas jovenes talentosos orienten su carrera hacia lo publico.",
        en: "The program aims to improve institutions by encouraging talented young people to dedicate their careers to public service.",
      },
    ],
    benefits: [
      {
        es: "Cobertura de pasajes aereos de ida y vuelta.",
        en: "Round-trip airfare covered.",
      },
      {
        es: "Gastos de desplazamiento y alojamiento durante el desarrollo del programa.",
        en: "Travel and accommodation expenses covered during the program.",
      },
    ],
    links: [
      {
        label: { es: "Ver programa oficial", en: "View official program" },
        href: "https://fundacionbotin.org/programas/fortalecimiento-funcion-publica-america-latina/",
      },
    ],
  },
  {
    title: {
      es: "Profesor/a visitante en la UFMG de Brasil",
      en: "Visiting Professor at UFMG, Brazil",
    },
    category: { es: "Docencia internacional", en: "International teaching" },
    audience: {
      es: "Docentes del area de Lengua Espanola de universidades miembro de AUGM, excepto Brasil.",
      en: "Faculty in Spanish Language fields from AUGM member universities, except Brazil.",
    },
    summary: {
      es: "La Universidade Federal de Minas Gerais abre la Convocatoria 08/2026 para seleccionar dos profesores visitantes del area de Lengua Espanola.",
      en: "Universidade Federal de Minas Gerais opens Call 08/2026 to select two visiting professors in the Spanish Language area.",
    },
    dates: {
      es: "Estancias abril-julio de 2026 y agosto-noviembre de 2026",
      en: "Stays from April-July 2026 and August-November 2026",
    },
    deadline: { es: "13 de marzo de 2026", en: "March 13, 2026" },
    location: { es: "Universidade Federal de Minas Gerais, Brasil", en: "Universidade Federal de Minas Gerais, Brazil" },
    format: { es: "Estancia presencial de 2 a 4 meses", en: "In-person stay of 2 to 4 months" },
    details: [
      {
        es: "Primera modalidad: abril a julio de 2026, perfil docente del area de Literaturas en Lengua Espanola.",
        en: "First modality: April to July 2026, faculty profile in Spanish-language literature.",
      },
      {
        es: "Segunda modalidad: agosto a noviembre de 2026, perfil en Lengua Espanola y/o Linguistica, preferentemente Espanol como Lengua Extranjera.",
        en: "Second modality: August to November 2026, profile in Spanish Language and/or Linguistics, preferably Spanish as a Foreign Language.",
      },
    ],
    benefits: [
      { es: "Pasaje aereo internacional ida y vuelta.", en: "Round-trip international airfare." },
      { es: "Alojamiento en residencia universitaria.", en: "Accommodation in university residence." },
      { es: "Beca mensual de R$ 1.500.", en: "Monthly stipend of R$ 1,500." },
    ],
    requirements: [
      { es: "Impartir docencia actualmente en el area correspondiente.", en: "Currently teaching in the relevant field." },
      { es: "Contar con formacion y produccion academica en el area.", en: "Have academic training and production in the field." },
      { es: "Acreditar experiencia en intercambio y colaboracion academica.", en: "Show experience in academic exchange and collaboration." },
    ],
    documents: [
      { es: "Curriculum Vitae.", en: "Curriculum Vitae." },
      { es: "Carta de motivacion indicando claramente la estancia a la que postula.", en: "Motivation letter clearly indicating the stay applied for." },
      { es: "Convocatoria para profesor visitante del Area de Lengua Espanola.pdf", en: "Call for visiting professor in Spanish Language Area.pdf" },
    ],
    contact: "info@dri.ufmg.br",
  },
  {
    title: { es: "Curso online gratuito de Portugues Lengua Extranjera PLE 2026", en: "Free Online Portuguese as a Foreign Language Course PLE 2026" },
    category: { es: "Curso internacional", en: "International course" },
    audience: { es: "Estudiantes de pregrado e investigadores de la UMSS.", en: "UMSS undergraduate students and researchers." },
    summary: {
      es: "La UNESP ofrece plazas a socios de AUGM para un curso de portugues con actividades asincronas y clases sincronas semanales.",
      en: "UNESP offers places to AUGM partners for a Portuguese course with asynchronous activities and weekly synchronous classes.",
    },
    dates: { es: "Marzo a junio de 2026, 60 horas", en: "March to June 2026, 60 hours" },
    deadline: { es: "18 de febrero de 2026, hasta horas 15:00", en: "February 18, 2026, by 15:00" },
    format: { es: "Online asincronico con clases sincronas semanales", en: "Online asynchronous format with weekly synchronous classes" },
    details: [
      { es: "Niveles ofertados: Portugues Basico A1 e Intermedio B1 con enfoque en escritura academica.", en: "Offered levels: Basic Portuguese A1 and Intermediate B1 with a focus on academic writing." },
      { es: "Se utilizara la plataforma Google Scholar con herramientas como Meeting y Classroom.", en: "The course uses the Google Scholar platform with tools such as Meeting and Classroom." },
    ],
    requirements: [
      { es: "Estudiantes: estar matriculado en la UMSS en una carrera de pregrado.", en: "Students: be enrolled at UMSS in an undergraduate program." },
      { es: "Investigadores: desarrollar actividades en una unidad de investigacion de la UMSS.", en: "Researchers: carry out activities in a UMSS research unit." },
      { es: "Certificado que avale el conocimiento de portugues cuando corresponda.", en: "Portuguese proficiency certificate when applicable." },
    ],
    benefits: [
      { es: "3 plazas para Portugues Basico A1: 2 estudiantes y 1 investigador.", en: "3 places for Basic Portuguese A1: 2 students and 1 researcher." },
      { es: "2 plazas para Intermedio B1: 1 estudiante y 1 investigador.", en: "2 places for Intermediate B1: 1 student and 1 researcher." },
      { es: "Certificado para quienes completen el curso y aprueben el trabajo final.", en: "Certificate for participants who complete the course and pass the final assignment." },
    ],
    links: [{ label: { es: "Formulario de postulacion", en: "Application form" }, href: "https://forms.gle/b6YVZKWSkVE1pBPY8" }],
  },
  {
    title: { es: "Curso online gratuito de Portugues Lengua Extranjera PLE 2025-II", en: "Free Online Portuguese as a Foreign Language Course PLE 2025-II" },
    category: { es: "Curso internacional", en: "International course" },
    audience: { es: "Estudiantes de pregrado de la UMSS.", en: "UMSS undergraduate students." },
    summary: {
      es: "Convocatoria UNESP-AUGM para el curso gratuito de portugues en niveles A2 y B1.",
      en: "UNESP-AUGM call for a free Portuguese course at A2 and B1 levels.",
    },
    dates: { es: "Agosto a noviembre de 2025, 60 horas", en: "August to November 2025, 60 hours" },
    deadline: { es: "18 de agosto de 2025, hasta horas 15:00", en: "August 18, 2025, by 15:00" },
    format: { es: "Online asincronico con clases sincronas opcionales", en: "Online asynchronous format with optional synchronous classes" },
    details: [
      { es: "Se ofertaron una plaza para Portugues Basico A2 y una plaza para Intermedio B1.", en: "One place was offered for Basic Portuguese A2 and one for Intermediate B1." },
      { es: "La seleccion se realizo de acuerdo al promedio de notas y orden de prelacion.", en: "Selection was based on grade average and ranking order." },
    ],
    requirements: [
      { es: "Estar matriculado en la UMSS en una carrera de pregrado.", en: "Be enrolled at UMSS in an undergraduate program." },
      { es: "Certificado que avale el conocimiento de portugues.", en: "Certificate proving Portuguese knowledge." },
    ],
    links: [{ label: { es: "Formulario PLE UMSS", en: "PLE UMSS form" }, href: "https://bit.ly/PLE-UMSS-02-25" }],
  },
  {
    title: { es: "IV Congreso Internacional Agua, Ambiente y Energia", en: "4th International Congress on Water, Environment, and Energy" },
    category: { es: "Congreso", en: "Congress" },
    audience: {
      es: "Expertos, academicos, investigadores y profesionales de diversas disciplinas.",
      en: "Experts, academics, researchers, and professionals from multiple disciplines.",
    },
    summary: {
      es: "Evento AUGM dedicado a los desafios del cambio climatico y la gestion sostenible del agua, el ambiente y la energia.",
      en: "AUGM event focused on climate change challenges and sustainable management of water, environment, and energy.",
    },
    dates: { es: "3 y 4 de noviembre de 2025", en: "November 3 and 4, 2025" },
    deadline: { es: "Presentacion de trabajos: 16 de junio al 22 de agosto de 2025", en: "Paper submission: June 16 to August 22, 2025" },
    location: { es: "Universidad Nacional de Tucuman, San Miguel de Tucuman", en: "Universidad Nacional de Tucuman, San Miguel de Tucuman" },
    format: { es: "Presencial", en: "In-person" },
    details: [
      { es: "Organizado por los Comites Academicos de Agua, Medio Ambiente y Energia.", en: "Organized by the Academic Committees on Water, Environment, and Energy." },
      { es: "Lema: Lo urgente e importante como nexo con el agua, ambiente y energia.", en: "Theme: What is urgent and important as a link with water, environment, and energy." },
      { es: "Busca fomentar dialogo, colaboracion interinstitucional y soluciones sostenibles.", en: "It promotes dialogue, interinstitutional collaboration, and sustainable solutions." },
    ],
    contact: "caae2025augm@webmail.unt.edu.ar",
  },
  {
    title: { es: "32 Jornadas de Jovenes Investigadores de la AUGM", en: "32nd AUGM Young Researchers Conference" },
    category: { es: "Investigacion", en: "Research" },
    audience: { es: "Jovenes investigadores de la Universidad Mayor de San Simon.", en: "Young researchers from Universidad Mayor de San Simon." },
    summary: {
      es: "Convocatoria DRIC-DICyT para presentar proyectos de investigacion rumbo a las Jornadas de Jovenes Investigadores de la AUGM.",
      en: "DRIC-DICyT call to submit research projects for the AUGM Young Researchers Conference.",
    },
    dates: { es: "5, 6 y 7 de noviembre de 2025", en: "November 5, 6, and 7, 2025" },
    deadline: { es: "31 de julio de 2025, 23:59", en: "July 31, 2025, 23:59" },
    location: { es: "Universidad Nacional de Tucuman, Tucuman, Argentina", en: "Universidad Nacional de Tucuman, Tucuman, Argentina" },
    details: [
      { es: "La consigna del encuentro fue: La educacion y la ciencia transforman realidades.", en: "The conference theme was: Education and science transform realities." },
      { es: "La convocatoria incluye formulario de postulacion y documentos relacionados.", en: "The call includes an application form and related documents." },
    ],
    links: [
      { label: { es: "Formulario de postulacion", en: "Application form" }, href: "https://bit.ly/Formulario-32JJI-UMSS" },
      { label: { es: "Convocatoria y documentos", en: "Call and documents" }, href: "https://bit.ly/32JJI-UMSS" },
    ],
    contact: "jo.medina@umss.edu",
  },
  {
    title: { es: "International Computer Science Competition INSC", en: "International Computer Science Competition INSC" },
    category: { es: "Concurso", en: "Contest" },
    audience: { es: "Estudiantes interesados en logica, algoritmos e informatica.", en: "Students interested in logic, algorithms, and computer science." },
    summary: {
      es: "Competencia educativa global que invita a estudiantes a resolver problemas conceptuales y tareas practicas de programacion.",
      en: "Global educational competition inviting students to solve conceptual problems and practical programming tasks.",
    },
    deadline: { es: "24 de agosto de 2025, 23:59 UTC+0", en: "August 24, 2025, 23:59 UTC+0" },
    format: { es: "Ronda de clasificacion online", en: "Online qualification round" },
    details: [
      { es: "La ronda consta de cinco problemas sobre fundamentos, logica y algoritmos introductorios.", en: "The round includes five problems covering fundamentals, logic, and introductory algorithms." },
      { es: "Algunos problemas requieren explicacion abstracta y otros escritura de codigo.", en: "Some problems require abstract explanation and others involve writing code." },
    ],
    benefits: [
      { es: "Premios por valor superior a 1000 USD, incluyendo efectivo y certificados.", en: "Prizes worth more than USD 1,000, including cash awards and certificates." },
    ],
    links: [{ label: { es: "Informacion de clasificacion", en: "Qualification information" }, href: "https://icscompetition.org/en/#qualification" }],
    contact: "info@icscompetition.org",
  },
  {
    title: { es: "Programa de Becas YLAI", en: "YLAI Fellowship Program" },
    category: { es: "Emprendimiento", en: "Entrepreneurship" },
    audience: { es: "Emprendedores de 25 a 35 anos.", en: "Entrepreneurs aged 25 to 35." },
    summary: {
      es: "Intercambio totalmente financiado en Estados Unidos para fortalecer liderazgo, emprendimiento y redes profesionales.",
      en: "Fully funded exchange in the United States to strengthen leadership, entrepreneurship, and professional networks.",
    },
    dates: { es: "27 de abril al 3 de junio de 2026", en: "April 27 to June 3, 2026" },
    deadline: { es: "15 de mayo de 2026", en: "May 15, 2026" },
    location: { es: "Estados Unidos", en: "United States" },
    details: [
      { es: "Programa de cuatro semanas con experiencia practica, cursos online y colaboracion con profesionales estadounidenses.", en: "Four-week program with hands-on experience, online coursework, and collaboration with U.S. professionals." },
      { es: "Promueve relaciones comerciales y conexiones en el Hemisferio Occidental.", en: "It promotes business relationships and connections across the Western Hemisphere." },
    ],
    benefits: [
      { es: "Intercambio totalmente financiado.", en: "Fully funded exchange." },
      { es: "Fortalecimiento de habilidades de liderazgo y emprendimiento.", en: "Leadership and entrepreneurship skill development." },
    ],
    links: [{ label: { es: "Postular a YLAI", en: "Apply to YLAI" }, href: "https://YLAI.State.gov/apply" }],
    contact: "exchangesusabolivia@state.gov",
  },
  {
    title: { es: "Programa de Funcion Publica Fundacion Botin 2025", en: "Fundacion Botin Public Service Program 2025" },
    category: { es: "Liderazgo publico", en: "Public leadership" },
    audience: { es: "Universitarios llamados a liderar procesos de cambio en America Latina.", en: "University students called to lead change processes in Latin America." },
    summary: {
      es: "La XVI edicion promovio formacion, estudio y trabajo en equipo para prestigiar el ejercicio de la funcion publica.",
      en: "The 16th edition promoted training, study, and teamwork to strengthen the practice of public service.",
    },
    dates: { es: "Octubre a diciembre de 2025", en: "October to December 2025" },
    deadline: { es: "20 de mayo de 2025", en: "May 20, 2025" },
    location: { es: "Mexico, Espana, Colombia y Brasil", en: "Mexico, Spain, Colombia, and Brazil" },
    details: [
      { es: "La formacion de ocho semanas incluyo sesiones en Monterrey, Santander, Madrid, Santiago de Compostela, Salamanca, Bogota y Rio de Janeiro.", en: "The eight-week training included sessions in Monterrey, Santander, Madrid, Santiago de Compostela, Salamanca, Bogota, and Rio de Janeiro." },
      { es: "Se solicito carta aval del rector en rectorado.", en: "Applicants were asked to request the rector's endorsement letter at the Rectorate." },
    ],
    benefits: [
      { es: "Cobertura de traslados, alojamiento y manutencion.", en: "Travel, accommodation, and meals covered." },
    ],
    links: [{ label: { es: "Ver Fundacion Botin", en: "View Fundacion Botin" }, href: "https://fundacionbotin.org/programas/fortalecimiento-funcion-publica-america-latina/" }],
  },
  {
    title: { es: "Clase abierta FLACSO", en: "FLACSO Open Class" },
    category: { es: "Clase abierta", en: "Open class" },
    audience: { es: "Comunidad universitaria interesada.", en: "Interested university community." },
    summary: {
      es: "Invitacion difundida por la DRIC para participar en una clase abierta de FLACSO.",
      en: "Invitation shared by DRIC to participate in a FLACSO open class.",
    },
    details: [
      { es: "La informacion ampliada fue publicada en el canal oficial de Facebook de la DRIC.", en: "Further information was published on DRIC's official Facebook channel." },
    ],
    links: [{ label: { es: "Ver publicacion", en: "View post" }, href: "https://www.facebook.com/UMSS.DRIC/posts/pfbid038MyuFioWdVZeUQCan1odSWAZgPgoqriFug3EMK5ExZ81gEWu4FdtgnAUx556qT4rl" }],
  },
  {
    title: { es: "Curso online de Portugues Lengua Extranjera PLE 2025-I", en: "Online Portuguese as a Foreign Language Course PLE 2025-I" },
    category: { es: "Curso internacional", en: "International course" },
    audience: { es: "Estudiantes de pregrado de la UMSS.", en: "UMSS undergraduate students." },
    summary: {
      es: "Curso gratuito de UNESP para socios AUGM, con niveles principiante e intermedio.",
      en: "Free UNESP course for AUGM partners, with beginner and intermediate levels.",
    },
    dates: { es: "Marzo a junio de 2025, 60 horas", en: "March to June 2025, 60 hours" },
    deadline: { es: "6 de marzo de 2025, hasta horas 15:00", en: "March 6, 2025, by 15:00" },
    format: { es: "Online asincronico con clases sincronas opcionales", en: "Online asynchronous format with optional synchronous classes" },
    details: [
      { es: "El curso fue organizado por la Assessoria de Relacoes Externas de la UNESP bajo coordinacion academica especializada.", en: "The course was organized by UNESP's Office of External Relations under specialized academic coordination." },
      { es: "La seleccion considero promedio de notas y orden de prelacion para titulares y suplentes.", en: "Selection considered grade average and ranking order for selected and alternate students." },
    ],
    requirements: [
      { es: "Estar matriculado en la UMSS en una carrera de pregrado.", en: "Be enrolled at UMSS in an undergraduate program." },
      { es: "Certificado de conocimiento de portugues para postulantes al nivel intermedio.", en: "Portuguese proficiency certificate for intermediate-level applicants." },
    ],
    benefits: [
      { es: "Una plaza para nivel principiante y una para nivel intermedio.", en: "One place for beginner level and one for intermediate level." },
      { es: "Certificado para quienes completen el curso y aprueben el trabajo final.", en: "Certificate for students who complete the course and pass the final assignment." },
    ],
    links: [{ label: { es: "Formulario de postulacion", en: "Application form" }, href: "https://forms.gle/N2nMR6qodLpfmvgd9" }],
  },
  {
    title: { es: "Curso-taller COIL: Colaboraciones Internacionales Virtuales", en: "COIL Workshop: Virtual International Collaborations" },
    category: { es: "Curso-taller docente", en: "Faculty workshop" },
    audience: { es: "Docentes interesados en internacionalizacion del curriculo.", en: "Faculty interested in curriculum internationalization." },
    summary: {
      es: "La Universidad Veracruzana ofrecio un curso-taller gratuito para promover la metodologia COIL entre academicos y pares internacionales.",
      en: "Universidad Veracruzana offered a free workshop to promote the COIL methodology among academics and international peers.",
    },
    dates: { es: "Septiembre a diciembre de 2024", en: "September to December 2024" },
    deadline: { es: "9 de septiembre de 2024", en: "September 9, 2024" },
    format: { es: "Ediciones en espanol, ingles y frances", en: "Editions in Spanish, English, and French" },
    details: [
      { es: "COIL fomenta interaccion entre docentes y estudiantes con pares del extranjero mediante entornos multiculturales en linea y aprendizaje colaborativo.", en: "COIL promotes interaction among faculty and students with peers abroad through multicultural online environments and collaborative learning." },
      { es: "El modelo se enfoca en cursos co-disenados, trabajo academico consistente y experiencias de aprendizaje vivencial.", en: "The model focuses on co-designed courses, consistent academic work, and experiential learning." },
    ],
    links: [
      { label: { es: "Video oficial", en: "Official video" }, href: "https://www.uv.mx/celulaode/video/coil.mp4" },
      { label: { es: "Inscripcion", en: "Registration" }, href: "https://forms.office.com/r/xcDr95SjZX" },
      { label: { es: "Mayor informacion", en: "More information" }, href: "https://www.uv.mx/coil-vic" },
    ],
  },
];

function iconForCategory(category: string) {
  const lower = category.toLowerCase();

  if (lower.includes("curso") || lower.includes("course") || lower.includes("workshop")) {
    return <SchoolRoundedIcon />;
  }

  if (lower.includes("concurso") || lower.includes("contest") || lower.includes("premio")) {
    return <EmojiEventsRoundedIcon />;
  }

  if (lower.includes("docencia") || lower.includes("teaching")) {
    return <WorkRoundedIcon />;
  }

  return <PublicRoundedIcon />;
}

export default function PremiosEventosCursosConcursosPage({ params }: { params: Promise<{ locale: string }> }) {
  const { locale } = use(params);
  const language: Locale = locale === "en" ? "en" : "es";
  const t = copy[language];
  const [activeCategory, setActiveCategory] = useState("all");
  const categories = useMemo(
    () => Array.from(new Set(opportunities.map((item) => item.category[language]))),
    [language],
  );
  const filteredOpportunities = useMemo(
    () =>
      activeCategory === "all"
        ? opportunities
        : opportunities.filter((item) => item.category[language] === activeCategory),
    [activeCategory, language],
  );
  const featured = filteredOpportunities.slice(0, 3);
  const archived = activeCategory === "all" ? filteredOpportunities.slice(3) : filteredOpportunities;

  return (
    <main className="dric-theme-page dric-awards-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-awards-hero relative isolate px-5 pb-16 pt-36 md:px-10 md:pb-20 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <Link
            href={`/${locale}/becas-movilidad`}
            className="dric-awards-back inline-flex items-center gap-2 rounded-full border border-white/12 bg-white/10 px-4 py-2 text-sm font-semibold text-white/72 backdrop-blur transition hover:border-white/25 hover:bg-white/15 hover:text-white"
          >
            <ArrowBackRoundedIcon fontSize="small" />
            {t.back}
          </Link>

          <div className="mt-14">
            <div>
              <p className="dric-awards-eyebrow mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
                {t.eyebrow}
              </p>

              <h1 className="max-w-5xl text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] text-white md:text-7xl lg:text-8xl">
                {t.title}
              </h1>

              <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
                {t.intro}
              </p>
            </div>
          </div>

          <div className="dric-awards-category-rail mt-12 flex flex-wrap gap-3">
            <button
              type="button"
              onClick={() => setActiveCategory("all")}
              className={`dric-awards-filter rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] transition ${
                activeCategory === "all" ? "dric-awards-filter-active" : ""
              }`}
            >
              {t.all}
            </button>
            {categories.map((category) => (
              <button
                key={category}
                type="button"
                onClick={() => setActiveCategory(category)}
                className={`dric-awards-filter rounded-full border px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] transition ${
                  activeCategory === category ? "dric-awards-filter-active" : ""
                }`}
              >
                {category}
              </button>
            ))}
          </div>
        </div>
      </section>

      {activeCategory === "all" ? (
        <section className="relative isolate px-5 pb-20 pt-4 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-8 flex items-end justify-between gap-6">
            <div>
              <p className="dric-awards-section-kicker text-xs font-bold uppercase tracking-[0.24em] text-[#E30613]">
                DRIC · UMSS
              </p>
              <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
                {t.featured}
              </h2>
            </div>
          </div>

          <div className="grid gap-5 lg:grid-cols-3">
            {featured.map((item) => (
              <OpportunityCard key={item.title.es} item={item} language={language} featured labels={t} />
            ))}
          </div>
        </div>
        </section>
      ) : null}

      <section className="relative isolate px-5 pb-24 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <div className="mb-8">
            <h2 className="text-3xl font-semibold tracking-[-0.04em] md:text-5xl">
              {activeCategory === "all" ? t.archive : `${t.filtered}: ${activeCategory}`}
            </h2>
          </div>

          <div className="grid gap-5 md:grid-cols-2">
            {archived.map((item) => (
              <OpportunityCard key={item.title.es} item={item} language={language} labels={t} />
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function OpportunityCard({
  item,
  language,
  labels,
  featured = false,
}: {
  item: Opportunity;
  language: Locale;
  labels: typeof copy.es;
  featured?: boolean;
}) {
  const meta = [
    item.deadline ? { icon: <CalendarMonthRoundedIcon />, label: labels.deadline, value: item.deadline[language] } : null,
    item.dates ? { icon: <CalendarMonthRoundedIcon />, label: labels.dates, value: item.dates[language] } : null,
    item.location ? { icon: <LocationOnRoundedIcon />, label: labels.location, value: item.location[language] } : null,
    item.format ? { icon: <LanguageRoundedIcon />, label: labels.format, value: item.format[language] } : null,
  ].filter(Boolean) as { icon: ReactNode; label: string; value: string }[];

  return (
    <article className={`dric-awards-card group relative overflow-hidden rounded-[2rem] p-[1px] ${featured ? "dric-awards-card-featured" : ""}`}>
      <div className="dric-awards-card-inner relative flex h-full flex-col rounded-[calc(2rem-1px)] px-6 py-7 md:px-7 md:py-8">
        <div className="flex items-start justify-between gap-4">
          <div className="dric-awards-icon flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-white">
            {iconForCategory(item.category[language])}
          </div>

          <span className="dric-awards-chip rounded-full border border-cyan-200/20 bg-cyan-200/10 px-3 py-1 text-right text-[0.68rem] font-bold uppercase tracking-[0.16em] text-cyan-100">
            {item.category[language]}
          </span>
        </div>

        <h3 className="mt-7 text-2xl font-semibold leading-tight tracking-[-0.04em] text-white md:text-3xl">
          {item.title[language]}
        </h3>

        <p className="mt-5 text-sm leading-7 text-white/66">
          {item.summary[language]}
        </p>

        <div className="mt-6 rounded-3xl border border-white/10 bg-[#020617]/36 p-5">
          <div className="mb-3 flex items-center gap-2 text-sm font-bold text-white">
            <PublicRoundedIcon sx={{ color: "#E30613", fontSize: 20 }} />
            {labels.audience}
          </div>
          <p className="text-sm leading-7 text-white/64">{item.audience[language]}</p>
        </div>

        {meta.length > 0 ? (
          <div className="mt-5 grid gap-3">
            {meta.map((entry) => (
              <div key={`${entry.label}-${entry.value}`} className="dric-awards-meta flex gap-3 rounded-2xl border border-white/10 bg-white/[0.045] px-4 py-3 text-sm">
                <span className="mt-0.5 text-[#E30613] [&>svg]:h-5 [&>svg]:w-5">{entry.icon}</span>
                <span>
                  <span className="font-bold text-white">{entry.label}: </span>
                  <span className="text-white/62">{entry.value}</span>
                </span>
              </div>
            ))}
          </div>
        ) : null}

        <InfoList title={labels.details} items={item.details} language={language} />
        <InfoList title={labels.benefits} items={item.benefits} language={language} />
        <InfoList title={labels.requirements} items={item.requirements} language={language} />
        <InfoList title={labels.documents} items={item.documents} language={language} icon="document" />

        {item.contact ? (
          <div className="mt-5 text-sm leading-7">
            <span className="font-bold text-white">{labels.contact}: </span>
            <span className="text-white/64">{item.contact}</span>
          </div>
        ) : null}

        {item.links?.length ? (
          <div className="mt-7 flex flex-wrap gap-3">
            {item.links.map((link) => (
              <a
                key={link.href}
                href={link.href}
                target="_blank"
                rel="noopener noreferrer"
                className="dric-awards-link inline-flex items-center justify-center gap-2 rounded-full px-4 py-2 text-sm font-bold text-white transition hover:scale-[1.02]"
              >
                <LinkRoundedIcon fontSize="small" />
                {link.label[language]}
                <ArrowForwardRoundedIcon fontSize="small" />
              </a>
            ))}
          </div>
        ) : null}
      </div>
    </article>
  );
}

function InfoList({
  title,
  items,
  language,
  icon = "default",
}: {
  title: string;
  items?: LocalizedText[];
  language: Locale;
  icon?: "default" | "document";
}) {
  if (!items?.length) {
    return null;
  }

  const Icon = icon === "document" ? DescriptionRoundedIcon : WorkRoundedIcon;

  return (
    <div className="mt-6">
      <div className="mb-3 flex items-center gap-2 text-sm font-bold text-white">
        <Icon sx={{ color: "#c59dff", fontSize: 19 }} />
        {title}
      </div>

      <ul className="space-y-2">
        {items.map((item) => (
          <li key={item.es} className="flex gap-3 text-sm leading-7 text-white/64">
            <span className="mt-3 h-1.5 w-1.5 shrink-0 rounded-full bg-[#E30613]" />
            <span>{item[language]}</span>
          </li>
        ))}
      </ul>
    </div>
  );
}
