export type Program = {
  title: string;
  summary: string;
  conditions: string[];
  tag: string;
  slug?: string;
  href?: string;
  highlights?: Array<{
    label: string;
    value: string;
  }>;
  sections?: Array<{
    title: string;
    body?: string;
    items?: string[];
  }>;
  reference?: {
    label: string;
    href: string;
  };
  calls?: Array<{
    title: string;
    description: string;
    benefits?: string[];
    documents?: string[];
    links?: Array<{
      label: string;
      href: string;
    }>;
    deadline?: string;
    note?: string;
  }>;
};

export const mobilityData = {
  es: {
    eyebrow: "Movilidad y pasantías internacionales",
    title: "Programas de movilidad",
    intro:
      "La DRIC canaliza programas de movilidad estudiantil, docente y administrativa, además de pasantías internacionales que fortalecen la formación académica, la cooperación institucional y la integración regional.",
    back: "Volver a Becas y Movilidad",
    students: "Movilidad estudiantil",
    staff: "Movilidad docente / administrativa",
    studentsIntro:
      "Opciones para que estudiantes de la UMSS realicen intercambios, estancias académicas o pasantías en instituciones y empresas internacionales.",
    staffIntro:
      "Programas dirigidos a docentes, gestores y personal administrativo para realizar movilidad académica, formación, docencia, investigación e intercambio institucional.",
    conditions: "Condiciones",
    studentPrograms: [
      {
        title: "Convenio Interinstitucional",
        tag: "Convenios",
        summary:
          "Permite realizar movilidad, generalmente por un semestre académico, con universidades que mantienen convenios suscritos con la UMSS. La persona interesada debe manifestar su interés al menos un semestre antes de iniciar la movilidad.",
        conditions: ["El estudiante cubre todos los gastos."],
        reference: {
          label: "Convenio Interinstitucional",
          href: "https://dric.umss.edu.bo/convocatorias/intercambio/convenio-interinstitucional/",
        },
        calls: [
          {
            title: "Movilidad por Convenio / UCB - periodo I/2026",
            description:
              "En el marco del acuerdo suscrito con la Universidad Católica Boliviana, sede Cochabamba, se convoca a estudiantes de la UMSS interesados en realizar un periodo de estudios en esta universidad durante el periodo I/2026.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar convocatoria.", "Formulario de postulación."],
            deadline: "18 de diciembre de 2025, hasta horas 15:00.",
          },
          {
            title: "Movilidad por Convenio / UCB - periodo II/2025",
            description:
              "Convocatoria para estudiantes de la UMSS interesados en realizar un periodo de estudios en la Universidad Católica Boliviana, sede Cochabamba, durante el periodo II/2025.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar Convocatoria Junio 2025.", "Formulario de postulación."],
            deadline: "11 de julio de 2025, hasta horas 15:00.",
          },
          {
            title: "Movilidad internacional autofinanciada - semestre II/2025",
            description:
              "Convocatoria para realizar movilidad estudiantil internacional con recursos propios en universidades de Argentina, Brasil, Chile, Ecuador, España, México, Paraguay y Perú.",
            benefits: ["La universidad de destino exime únicamente el pago de matrícula correspondiente."],
            documents: ["Convocatoria movilidad internacional autofinanciada.pdf"],
            deadline: "Dependiendo de la universidad, 15 de abril y 14 de mayo.",
            note:
              "El estudiante cubre pasaje aéreo, alojamiento, alimentación, seguro y otros gastos relacionados con la movilidad. La universidad de destino se reserva el derecho de aceptar postulantes según presupuesto, cupo u otros criterios.",
          },
          {
            title: "Programa de Intercambio Virtual EMOVIES - UNCUYO / AUGM",
            description:
              "La Universidad Nacional de Cuyo (UNCUYO), Argentina, recibe postulaciones de estudiantes interesados en participar en el programa EMOVIES durante el primer semestre 2025, de marzo a julio.",
            documents: ["Convocatoria EMOVIES."],
            deadline: "12 de febrero de 2025.",
            note:
              "Asignaturas ofertadas: Derecho Constitucional, Alfabetización Digital, Sistemas Electorales y de Partidos, Doctrinas e Ideas Políticas II, Literatura Norteamericana y Análisis Internacional.",
          },
          {
            title: "Movilidad por Convenio / UCB - periodo I/2025",
            description:
              "Convocatoria para estudiantes de la UMSS interesados en realizar un periodo de estudios en la Universidad Católica Boliviana, sede Cochabamba, durante el periodo I/2025.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar Convocatoria enero 2025.", "Formulario de postulación."],
            deadline: "23 de enero de 2025, hasta horas 17:00.",
          },
          {
            title: "Movilidad estudiantil UCSP - Perú",
            description:
              "Programa de movilidad estudiantil de la Universidad Católica San Pablo (UCSP) de Perú, con beca parcial.",
            benefits: ["Inscripción al gimnasio.", "Exención de pago de matrícula.", "Almuerzos de lunes a viernes."],
            documents: ["Convocatoria UCSP."],
            deadline: "11 de noviembre.",
          },
          {
            title: "Movilidad internacional autofinanciada - semestre I/2025",
            description:
              "Convocatoria para realizar movilidad internacional autofinanciada en universidades de Argentina, Brasil, Chile, Ecuador, España, México, Paraguay, Perú y Polonia.",
            benefits: ["La universidad de destino exime únicamente el pago de matrícula correspondiente."],
            documents: ["Convocatoria movilidad internacional autofinanciada.pdf"],
            deadline: "Dependiendo de la universidad, 14 o 30 de octubre.",
            note:
              "La movilidad consiste en cursar un semestre académico en la institución seleccionada, previa aprobación de la universidad de destino. El estudiante cubre pasaje aéreo, alojamiento, alimentación, seguro y otros gastos.",
          },
          {
            title: "Movilidad por Convenio / UCB - periodo II/2024",
            description:
              "Convocatoria para estudiantes de la UMSS interesados en realizar un periodo de estudios en la Universidad Católica Boliviana, sede Cochabamba, durante el periodo II/2024.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar Convocatoria Julio 2024.pdf", "Formulario."],
            deadline: "26 de julio de 2024, hasta horas 12:00.",
          },
          {
            title: "Movilidad por Convenio / UCB - periodo I/2024",
            description:
              "Convocatoria para estudiantes de la UMSS interesados en realizar un periodo de estudios en la Universidad Católica Boliviana, sede Cochabamba, durante el periodo I/2024.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar Convocatoria enero 2024.pdf", "Formulario."],
            deadline: "23 de enero de 2024.",
          },
          {
            title: "Movilidad por Convenio / UCB - periodo II/2023",
            description:
              "Convocatoria para estudiantes de la UMSS interesados en realizar un periodo de estudios en la Universidad Católica Boliviana, sede Cochabamba, durante el periodo II/2023.",
            benefits: ["Exención del pago de matrícula."],
            documents: ["Descargar convocatoria.", "Formulario."],
            deadline: "14 de julio de 2023.",
          },
          {
            title: "Movilidad académica - Universidad Simón Bolívar (Unisimón)",
            description:
              "Convocatoria de movilidad académica para estudiantes interesados en realizar intercambio durante el periodo 2023-II.",
            benefits: ["Exención del pago de matrícula."],
            deadline: "Solicitar mayor información en oficinas de la DRIC hasta el 10 de mayo de 2023.",
            note: "El estudiante seleccionado cubre transporte, estadía, visa y otros gastos.",
          },
          {
            title: "Movilidad - Universidad Jean Moulin Lyon 3 (Francia)",
            description:
              "Oportunidad de movilidad estudiantil en áreas relacionadas con Derecho, Administración y Lingüística.",
            benefits: ["Exención del pago de matrícula."],
            deadline: "Solicitar mayor información en oficinas de la DRIC hasta el 10 de mayo de 2023.",
            note: "El estudiante cubre transporte, estadía, visa y otros gastos.",
          },
        ],
      },
      {
        title: "Programa ERASMUS+/ICM",
        tag: "Europa",
        summary:
          "Ofrece oportunidades para realizar estudios en universidades de países socios de Erasmus+ mediante International Credit Mobility. Los estudiantes o doctorandos cursan un periodo limitado en el exterior, obtienen créditos y retornan a su institución de origen para completar sus estudios.",
        conditions: ["Todos los gastos son financiados por la Comisión Europea."],
        highlights: [
          { label: "Financiamiento", value: "Comisión Europea" },
          { label: "Modalidad", value: "Movilidad internacional con reconocimiento académico" },
          { label: "Destino recurrente", value: "Universidad de Hradec Králové, República Checa" },
          { label: "Áreas frecuentes", value: "Ciencias Políticas, Sociología, Antropología e Historia" },
        ],
        sections: [
          {
            title: "Perfil del programa",
            body:
              "El Programa Erasmus+ International Credit Mobility conecta a la UMSS con universidades europeas mediante acuerdos institucionales que permiten cursar un periodo de estudios en el exterior, fortalecer competencias interculturales y proyectar trayectorias académicas con alcance internacional.",
          },
          {
            title: "Preparación académica",
            items: [
              "Revisar cuidadosamente la oferta académica publicada por la universidad de destino.",
              "Preparar el Acuerdo de Aprendizaje o plan de estudios antes de la movilidad.",
              "Consultar en oficinas de la DRIC sobre el reconocimiento de estudios y los pasos internos de postulación.",
            ],
          },
          {
            title: "Cobertura orientativa",
            items: [
              "Ayuda mensual para alojamiento y manutención, según los montos definidos en cada convocatoria.",
              "Apoyo para pasaje aéreo cuando la convocatoria lo especifique.",
              "La cantidad de plazas, áreas elegibles y documentos requeridos pueden variar por universidad y gestión.",
            ],
          },
        ],
        reference: {
          label: "Información Erasmus+ ICM UHK",
          href: "https://www.uhk.cz/en/philosophical-faculty/exchanges/erasmus/international-credit-mobility",
        },
        calls: [
          {
            title: "Movilidad internacional en República Checa / UHK - febrero 2026",
            description:
              "En el marco del acuerdo suscrito con la Universidad de Hradec Králové (UHK), financiado por Erasmus+ International Credit Mobility, se convoca a estudiantes para realizar un periodo de estudios.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 3.400 € en total.", "Pasaje aéreo: 1.735 €."],
            documents: [
              "Listado de asignaturas disponibles: list-of-courses-2026_2027.pdf (winter semester).",
              "Convocatoria UHK febrero 2026.pdf.",
              "Acuerdo de Aprendizaje (Plan de estudios).",
            ],
            deadline: "10 de marzo de 2026.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología e Historia. Número de plazas: 2.",
          },
          {
            title: "Movilidad internacional en República Checa / UHK - junio 2025",
            description:
              "Convocatoria para realizar un periodo de estudios en la Universidad de Hradec Králové (UHK), República Checa, en el marco del Programa Erasmus+ ICM.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 3.400 € en total.", "Pasaje aéreo: 1.735 €."],
            documents: [
              "Listado de asignaturas disponibles: list-of-courses.pdf (summer semester).",
              "Convocatoria UHK junio 2025.pdf.",
              "Acuerdo de Aprendizaje (Plan de estudios).",
            ],
            deadline: "8 de agosto de 2025.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología e Historia. Número de plazas: 2.",
          },
          {
            title: "Movilidad de estudios de pregrado / UHK - enero 2025",
            description:
              "Convocatoria para realizar movilidad de estudios a nivel de pregrado en la Universidad de Hradec Králové (UHK), República Checa.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 3.200 € en total.", "Pasaje aéreo: 1.500 €."],
            documents: [
              "Listado de asignaturas disponibles: list-of-courses-20242025.pdf.",
              "Convocatoria UHK enero 2025.",
              "Acuerdo de Aprendizaje (Plan de estudios).",
            ],
            deadline: "6 de marzo de 2025 (plazo ampliado).",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología e Historia. Número de plazas: 1.",
          },
          {
            title: "Erasmus+ KA171 / Universidad de Deusto - semestre primavera 2024/25",
            description:
              "Convocatoria dirigida a estudiantes de pregrado de la UMSS para realizar un periodo de estudios durante el semestre de primavera 2024/25 en la Universidad de Deusto, España.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 850 €/mes, máximo 5 meses.", "Pasaje aéreo: 1.500 €."],
            documents: ["Revisar la oferta académica.", "Convocatoria Deusto."],
            deadline: "1 de noviembre de 2024, hasta horas 16:00.",
            note: "Número de plazas: 1.",
          },
          {
            title: "Movilidad de estudios de pregrado / UHK - julio 2024",
            description:
              "Convocatoria para movilidad de estudios a nivel de pregrado en la Universidad de Hradec Králové (UHK), República Checa, bajo Erasmus+ ICM.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 3.200 € en total.", "Pasaje aéreo: 1.500 €."],
            documents: ["Convocatoria UHK julio 2024.", "Acuerdo de Aprendizaje (Plan de estudios)."],
            deadline: "12 de agosto de 2024, hasta horas 17:30.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología e Historia. Número de plazas: 1.",
          },
          {
            title: "Movilidad de estudios de pregrado / UHK - enero 2024",
            description:
              "Convocatoria para movilidad de estudios a nivel de pregrado en la Universidad de Hradec Králové (UHK), República Checa, bajo Erasmus+ ICM.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 3.200 € en total.", "Pasaje aéreo: 1.500 €."],
            documents: ["Convocatoria UHK enero 2024.pdf.", "Acuerdo de Aprendizaje (Plan de estudios)."],
            deadline: "21 de febrero de 2024.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología e Historia. Número de plazas: 2.",
          },
          {
            title: "Movilidad de estudios de pregrado / UHK - agosto 2023",
            description:
              "Oportunidad de movilidad de estudios a nivel de pregrado en la Universidad de Hradec Králové (UHK), República Checa.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 800 €/mes.", "Pasaje aéreo."],
            documents: ["Descargar convocatoria.", "Acuerdo de Aprendizaje (Plan de estudios)."],
            deadline: "1 de agosto de 2023.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología, Historia y Trabajo Social. Número de plazas: 1.",
          },
          {
            title: "Movilidad de estudios de pregrado / UHK - Erasmus+ 2022",
            description:
              "Convocatoria para realizar movilidad de estudios a nivel de pregrado en la Universidad de Hradec Králové (UHK), República Checa.",
            benefits: ["Ayuda mensual de alojamiento y manutención: 800 €/mes.", "Pasaje aéreo."],
            documents: ["Descargar convocatoria.", "Acuerdo de Aprendizaje (Plan de estudios).", "Compromiso de reconocimiento de estudios."],
            deadline: "10 de febrero de 2022.",
            note: "Áreas: Ciencias Políticas, Sociología, Antropología y Trabajo Social.",
          },
          {
            title: "Movilidad de estudios / UHK - Erasmus+ 2021",
            description:
              "Oportunidad para realizar movilidad de estudios en la Universidad de Hradec Králové (UHK), dirigida a estudiantes de pregrado.",
            documents: ["Convocatoria.", "Mayor información institucional."],
            deadline: "24 de septiembre de 2021.",
          },
          {
            title: "Movilidad de estudiantes / Universidad de Valladolid",
            description:
              "Convocatoria para movilidad de estudiantes de pregrado, maestría y doctorado en el marco del acuerdo suscrito entre la UMSS y la Universidad de Valladolid.",
            documents: ["Información del programa UVAMobPlus."],
            deadline: "20 de septiembre de 2021.",
            note: "La Universidad de Valladolid manifestó especial interés en postulaciones de doctorado y de pregrado en programas impartidos en inglés.",
          },
          {
            title: "Movilidad doctoral / UHK - marzo 2021",
            description:
              "Convocatoria para movilidad de estudiantes de doctorado entre la UMSS y la Universidad de Hradec Králové, en el marco de Erasmus+.",
          },
        ],
      },
      {
        title: "Programa Escala de Estudiantes de Grado (PEEG) de AUGM",
        tag: "AUGM",
        summary:
          "Impulsa la construcción de un espacio académico común regional mediante la movilidad de estudiantes. Las convocatorias indican universidades participantes, condiciones y plazas disponibles.",
        conditions: ["La universidad receptora cubre alojamiento y alimentación de acuerdo con sus condiciones."],
        highlights: [
          { label: "Red académica", value: "Asociación de Universidades Grupo Montevideo (AUGM)" },
          { label: "Nivel", value: "Estudiantes de licenciatura" },
          { label: "Alcance", value: "Movilidad internacional regional" },
          { label: "Destinos frecuentes", value: "Argentina, Brasil, Paraguay y Uruguay" },
        ],
        sections: [
          {
            title: "Integración regional",
            body:
              "El Programa ESCALA de Estudiantes de Grado es uno de los emprendimientos más importantes de la AUGM para consolidar una comunidad universitaria regional. Permite que estudiantes de la UMSS cursen un periodo académico en universidades miembro, amplíen su formación y fortalezcan redes académicas en América Latina.",
          },
          {
            title: "Postulación",
            items: [
              "La oferta de áreas y plazas varía según la universidad de destino y debe verificarse en cada convocatoria.",
              "La documentación se presenta en oficinas de la DRIC o por correo institucional cuando la convocatoria lo indique.",
              "El contrato de estudios o formulario PEEG debe estar debidamente suscrito antes de la evaluación.",
            ],
          },
          {
            title: "Apoyo económico",
            items: [
              "La universidad de destino cubre alojamiento y alimentación o manutención de acuerdo con sus condiciones.",
              "El estudiante cubre el traslado internacional y el seguro de salud cuando la convocatoria lo especifique.",
              "Algunas convocatorias incorporan pasaje aéreo como parte del apoyo disponible.",
            ],
          },
        ],
        reference: {
          label: "Programa ESCALA de Estudiantes de Grado",
          href: "http://grupomontevideo.org/escalagrado/",
        },
        calls: [
          {
            title: "Programa PEEG - Convocatoria II/25",
            description:
              "Convocatoria para realizar movilidad internacional estudiantil a nivel de licenciatura con universidades miembro de AUGM en Argentina, Brasil y Paraguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "El estudiante cubre traslado internacional y seguro de salud.",
            ],
            documents: [
              "Contrato de estudios, debidamente suscrito.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Carta de motivación con objetivos y beneficios esperados.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Descargar la convocatoria.",
            ],
            deadline: "27 de octubre de 2025.",
            note:
              "Universidades: UNDMP y UNNE (Argentina), USP, FURG y UFSM (Brasil), UNA (Paraguay). Áreas: varía en cada universidad.",
          },
          {
            title: "Programa PEEG - Convocatoria II/24",
            description:
              "Convocatoria para movilidad internacional estudiantil de licenciatura con universidades de Argentina, Paraguay y Brasil.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación, debidamente suscrito.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Certificado de alumno regular.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Descargar la convocatoria.",
            ],
            deadline: "27 de octubre de 2025.",
            note:
              "Universidades: UNNOBA (Argentina), UNA (Paraguay), FURG y UNICAMP (Brasil). Áreas: varía en cada universidad.",
          },
          {
            title: "Programa PEEG - Convocatoria I/24",
            description:
              "Movilidad internacional estudiantil de licenciatura con universidades de Argentina, Brasil, Paraguay y Uruguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación, debidamente suscrito.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Certificado de alumno regular.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Descargar la convocatoria.",
            ],
            deadline: "20 de octubre de 2023.",
            note:
              "Universidades: UNL, UNSL, UFABC, FURG, UNICAMP, UNI y UDELAR. Áreas: varía en cada universidad.",
          },
          {
            title: "Programa PEEG - Convocatoria II/23 (cerrado)",
            description:
              "Convocatoria cerrada para movilidad internacional estudiantil de licenciatura con universidades de Argentina, Brasil, Paraguay y Uruguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "PEEG-1 Formulario, debidamente suscrito.",
              "PEEG-2 Contrato de Estudios, debidamente suscrito.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Certificado de alumno regular.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Descargar la convocatoria.",
            ],
            deadline: "15 de mayo de 2023.",
            note:
              "Universidades: UNCuyo, UNL, UNMdP, UNNE, UNSL, FURG, UFRGS, UFSC, UNICAMP, UNI y UDELAR. Áreas: varía en cada universidad.",
          },
          {
            title: "Programa PEEG - Convocatoria I/23",
            description:
              "Convocatoria para movilidad internacional estudiantil de licenciatura con universidades miembro de AUGM.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "PEEG-1 Formulario, debidamente suscrito.",
              "PEEG-2 Contrato de Estudios, debidamente suscrito.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Certificado de alumno regular.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Descargar la convocatoria.",
            ],
            deadline: "7 de octubre de 2022.",
            note:
              "Universidades: UNCuyo, UNLP, UNMdP, UNNE, UNQ, UFSC, UNICAMP, UFRGS, UNCp y UNA. Áreas: varía en cada universidad.",
          },
          {
            title: "Programa PEEG - Convocatoria II/22",
            description:
              "Convocatoria para movilidad estudiantil con universidades de Argentina, Paraguay y Brasil, abierta a todas las áreas.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación debidamente suscrito, con contrato de estudios (Learning Agreement).",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas.",
              "Carta del Director de Carrera acreditando el año de estudio.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Documento que certifique conocimiento de portugués, cuando corresponda.",
              "Curriculum Vitae.",
              "Descargar la convocatoria.",
              "Descargar formulario de postulación.",
            ],
            deadline: "13 de mayo de 2022.",
            note:
              "Universidades: UBA, UNMdP, UNT y UNNE (Argentina), UNC y UNA (Paraguay), UFRGS (Brasil).",
          },
        ],
      },
      {
        title: "Programa MARCA MERCOSUR",
        tag: "MERCOSUR",
        summary:
          "Permite intercambios estudiantiles, generalmente de un semestre académico, en carreras acreditadas como Agronomía, Arquitectura, Medicina e ingenierías. Las convocatorias se gestionan desde las respectivas facultades.",
        conditions: [
          "Solo pueden participar estudiantes de carreras acreditadas.",
          "Las personas interesadas deben consultar la información de convocatorias en sus respectivas carreras.",
          "El estudiante recibe apoyo financiero durante su estadía para alojamiento y alimentación.",
        ],
        highlights: [
          { label: "Marco regional", value: "MERCOSUR Educativo" },
          { label: "Participación", value: "Carreras acreditadas" },
          { label: "Duración habitual", value: "Un semestre académico" },
          { label: "Gestión", value: "Información canalizada por cada carrera" },
        ],
        sections: [
          {
            title: "Movilidad acreditada",
            body:
              "El Programa MARCA MERCOSUR promueve la movilidad de estudiantes en carreras acreditadas, fortaleciendo la calidad académica, la integración regional y el reconocimiento de trayectorias formativas dentro del espacio universitario del MERCOSUR.",
          },
          {
            title: "Carreras habilitadas",
            items: [
              "Medicina.",
              "Agronomía.",
              "Arquitectura.",
              "Ingeniería Eléctrica.",
              "Ingeniería Mecánica.",
              "Ingeniería Química.",
              "Ingeniería Industrial.",
              "Ingeniería Civil.",
            ],
          },
          {
            title: "Ruta de consulta",
            items: [
              "Consultar primero en la carrera acreditada correspondiente.",
              "Verificar si existe convocatoria vigente, plazas disponibles y universidad de destino.",
              "Coordinar con la DRIC los pasos institucionales cuando la carrera confirme la oportunidad.",
            ],
          },
        ],
        calls: [
          {
            title: "Programa MARCA MERCOSUR - convocatorias vigentes y fenecidas",
            description:
              "Las convocatorias del Programa MARCA MERCOSUR se habilitan para estudiantes de carreras acreditadas. La información específica de cada proceso debe consultarse en la carrera correspondiente.",
            benefits: ["Apoyo financiero durante la estadía para alojamiento y alimentación."],
            documents: [
              "La documentación requerida se define en cada convocatoria.",
              "La carrera acreditada informa requisitos, plazos y procedimientos internos.",
            ],
            note:
              "Carreras acreditadas: Medicina, Agronomía, Arquitectura, Ingeniería Eléctrica, Ingeniería Mecánica, Ingeniería Química, Ingeniería Industrial e Ingeniería Civil.",
          },
        ],
      },
      {
        title: "Programa de Movilidad Estudiantil (PME) - CRISCOS",
        tag: "CRISCOS",
        summary:
          "Facilita que estudiantes de universidades de la subregión realicen parte de sus estudios en otra institución participante. Las convocatorias detallan condiciones y plazas disponibles.",
        conditions: [
          "Participan estudiantes regulares de licenciatura, exceptuando carreras anualizadas.",
          "El estudiante debe revisar la oferta académica y las condiciones de beca de cada universidad.",
          "La universidad de destino cubre alojamiento y alimentación, según sus condiciones.",
          "El transporte internacional y el seguro de salud están a cargo del estudiante.",
        ],
        highlights: [
          { label: "Red", value: "Consejo de Rectores por la Integración de la Subregión Centro Oeste de Sudamérica" },
          { label: "Países", value: "Argentina, Bolivia, Chile, Ecuador, Paraguay y Perú" },
          { label: "Nivel", value: "Licenciatura" },
          { label: "Última convocatoria", value: "PME N° 51 - plazo 15 de octubre de 2025" },
        ],
        sections: [
          {
            title: "Cooperación subregional",
            body:
              "CRISCOS articula universidades de la subregión Centro Oeste de Sudamérica para ampliar la cooperación académica, científica, tecnológica y cultural. Su Programa de Movilidad Estudiantil permite cursar parte de la formación de licenciatura en una universidad participante.",
          },
          {
            title: "Documentación base",
            items: [
              "Formulario de postulación debidamente suscrito.",
              "Compromiso previo de reconocimiento de estudios.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex, no del WEBSISS.",
              "Curriculum Vitae documentado.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Oferta académica 51.",
              "Convocatoria 51.",
            ],
          },
          {
            title: "Estrategia de postulación",
            items: [
              "Considerar tres o cuatro opciones de universidad cuando la convocatoria lo recomiende.",
              "Comparar oferta académica, calendario, condiciones de alojamiento y alimentación antes de elegir destino.",
              "Confirmar con la DRIC los requisitos vigentes y la forma de entrega antes del plazo establecido.",
            ],
          },
        ],
        reference: {
          label: "Convocatorias PME - CRISCOS",
          href: "https://dric.umss.edu.bo/convocatorias-pme/",
        },
        calls: [
          {
            title: "PME / Convocatoria N° 51",
            description:
              "Movilidad internacional estudiantil a nivel de licenciatura con universidades participantes de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "El transporte internacional y el seguro de salud están a cargo del estudiante.",
            ],
            documents: [
              "Formulario de postulación debidamente suscrito, considerando preferentemente 3 o 4 opciones.",
              "Compromiso previo de reconocimiento de estudios.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex, no del WEBSISS.",
              "Curriculum Vitae documentado.",
              "Carta de motivación dirigida al Comité de Selección.",
            ],
            deadline: "15 de octubre de 2025.",
            note:
              "Destinos: Argentina, Chile, Ecuador, Paraguay y Perú. Participan todas las carreras de licenciatura, excepto las anualizadas.",
          },
          {
            title: "PME / Convocatoria N° 50",
            description:
              "Movilidad estudiantil de licenciatura con universidades de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "El transporte internacional y el seguro están a cargo del estudiante.",
            ],
            documents: [
              "Formulario de postulación debidamente suscrito, se recomienda considerar 3 o 4 opciones.",
              "Compromiso previo de reconocimiento de estudios.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex, no del WEBSISS.",
              "Curriculum Vitae documentado.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Oferta académica 50.",
              "Convocatoria 50.",
            ],
            deadline: "15 de mayo de 2025.",
            note:
              "Destinos disponibles en Argentina, Chile, Ecuador, Paraguay y Perú. Participan todas las carreras de licenciatura, excepto las anualizadas.",
          },
          {
            title: "PME / Convocatoria N° 48",
            description:
              "Movilidad internacional estudiantil con universidades de Argentina, Ecuador, Chile, Paraguay y Perú.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "El transporte internacional y el seguro están a cargo del estudiante.",
            ],
            documents: [
              "Formulario de postulación debidamente suscrito, se recomienda considerar 3 opciones.",
              "Compromiso previo de reconocimiento de estudios.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex, no del WEBSISS.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Oferta académica 48.",
              "Convocatoria48.pdf.",
            ],
            deadline: "30 de abril de 2024.",
            note:
              "Destinos disponibles en Argentina, Ecuador, Chile, Paraguay y Perú. Participan todas las carreras de licenciatura, excepto las anualizadas.",
          },
          {
            title: "PME / Convocatoria N° 47",
            description:
              "Movilidad estudiantil con universidades de Argentina, Chile, Ecuador, Paraguay y Perú, con revisión de oferta académica y condiciones por universidad.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "El transporte internacional y el seguro están a cargo del estudiante.",
            ],
            documents: [
              "Formulario de postulación debidamente suscrito, se recomienda considerar 3 opciones.",
              "Compromiso previo de reconocimiento de estudios.",
              "Certificado de alumno regular emitido por Registros e Inscripciones.",
              "Pasaporte o carnet de identidad.",
              "Certificado de notas o kardex.",
              "Curriculum Vitae documentado, solo con información relacionada al área.",
              "Carta de motivación dirigida al Comité de Selección.",
              "47ª Oferta académica.pdf.",
              "Convocatoria 47.pdf.",
            ],
            deadline: "10 de octubre de 2023.",
            note:
              "Requisitos destacados: ser estudiante regular de la UMSS, tener aprobado al menos el 40% de la carrera, promedio superior a 70 y no haber participado en programas de movilidad anteriores.",
          },
          {
            title: "PME / Convocatoria N° 46",
            description:
              "Movilidad estudiantil con universidades de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención durante la estadía, de acuerdo con sus condiciones.",
              "El transporte internacional y el seguro están a cargo del estudiante.",
            ],
            documents: ["46ª Oferta académica.pdf.", "Convocatoria 46.pdf."],
            deadline: "5 de mayo de 2023.",
            note:
              "Destinos disponibles en Argentina, Chile, Ecuador, Paraguay y Perú, con universidades participantes de la red CRISCOS.",
          },
        ],
      },
      {
        title: "Programa PUMA / CRULA - AUF",
        tag: "AUF",
        summary:
          "Permite a estudiantes de pregrado realizar un intercambio estudiantil presencial en América Latina con instituciones participantes del programa PUMA.",
        conditions: [
          "Exención del pago de matrícula.",
          "La universidad de origen cubre el traslado internacional.",
          "La universidad receptora cubre alojamiento y alimentación.",
        ],
        highlights: [
          { label: "Red", value: "CRULA - Agencia Universitaria de la Francofonía" },
          { label: "Destino 2023", value: "Universidad Nacional de Cuyo (UNCUYO)" },
          { label: "Duración", value: "90 a 180 días" },
          { label: "Plazas", value: "1 titular y 1 suplente" },
        ],
        sections: [
          {
            title: "Movilidad francófona",
            body:
              "El Programa PUMA conecta a universidades latinoamericanas miembros de la AUF mediante experiencias presenciales de movilidad. La convocatoria invita a estudiantes de pregrado a cursar asignaturas, homologarlas y participar en una comunidad académica regional con vocación francófona.",
          },
          {
            title: "Objetivos del programa",
            items: [
              "Realizar una experiencia de internacionalización que permita cursar asignaturas y homologarlas.",
              "Dinamizar la vida en red entre universidades de América Latina miembros de la AUF.",
              "Promover una francofonía solidaria mediante la participación en eventos de aprendizaje y difusión del francés.",
              "Impulsar la movilidad en América Latina y abrir camino a futuros proyectos de cooperación bilateral.",
            ],
          },
          {
            title: "Áreas y destino",
            items: [
              "Destino de la segunda convocatoria 2022-2023: Universidad Nacional de Cuyo (UNCUYO), Argentina.",
              "Participan todos los campos disciplinarios, excepto las carreras del Instituto Balseiro.",
              "La movilidad estaba prevista para el segundo semestre 2023, entre agosto y diciembre.",
            ],
          },
        ],
        reference: {
          label: "Oferta académica UNCUYO",
          href: "https://www.uncuyo.edu.ar/estudios",
        },
        calls: [
          {
            title: "Segunda Convocatoria PUMA 2022-2023",
            description:
              "La DRIC anuncia que la Conferencia Regional de Rectores de Universidades Latinoamericanas (CRULA), miembros de la AUF, invita a estudiantes de pregrado de la UMSS a postular a una movilidad presencial en la Universidad Nacional de Cuyo.",
            benefits: [
              "Exención del pago de matrícula.",
              "La universidad de origen cubre el traslado internacional.",
              "La universidad receptora cubre alojamiento y alimentación.",
            ],
            documents: ["PUMA Convocatoria febrero.pdf.", "Propuesta de movilidad."],
            links: [
              {
                label: "Áreas UNCUYO",
                href: "https://www.uncuyo.edu.ar/estudios",
              },
              {
                label: "PUMA Convocatoria febrero.pdf",
                href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZDsSJ_A02BPgamErc51cqQByTEJaUE5wyflCWLdokF17g?e=4VUgCQ",
              },
              {
                label: "Propuesta de movilidad",
                href: "https://miumssedu-my.sharepoint.com/:w:/g/personal/dric_mi_umss_edu/EVs1QwpxX0lIh5f1bhWxTiwBFfN3HhIIt07FPg-xqdFP-A?e=XPKuru",
              },
            ],
            deadline: "14 de abril de 2023.",
            note:
              "N° de plazas: 1. Se seleccionará un estudiante titular y un suplente. Duración: 90 a 180 días.",
          },
        ],
      },
      {
        title: "Pasantías Remuneradas IAESTE Bolivia",
        tag: "Pasantías",
        summary:
          "Permite realizar prácticas remuneradas, virtuales o presenciales, ofrecidas por empresas internacionales. Estudiantes destacados de la UMSS pueden acceder a una reducción del 50% del costo de uso de la plataforma IAESTE.",
        conditions: [
          "Dirigido a estudiantes regulares de la UMSS; egresados y recién titulados participan solo cuando la convocatoria lo indique.",
          "Se recomienda contar con promedio superior a 70 o compensarlo con méritos acreditados.",
          "La empresa internacional otorga un pago mensual para manutención, según cada convocatoria.",
          "Pasaje aéreo, seguro de salud y trámite de visa corren a cargo del estudiante.",
          "La condición de alumno regular debe mantenerse incluso durante la pasantía cuando la convocatoria lo requiera.",
        ],
        highlights: [
          { label: "Ciclo visible", value: "Convocatorias 2026" },
          { label: "Modalidad", value: "Pasantías internacionales remuneradas" },
          { label: "Contacto inicial", value: "m.zambrana@umss.edu" },
          { label: "Beneficio UMSS", value: "50% de descuento en plataforma para estudiantes destacados" },
        ],
        sections: [
          {
            title: "Cómo postular",
            body:
              "IAESTE conecta a estudiantes con empresas e instituciones internacionales que buscan perfiles destacados. La primera etapa consiste en escribir al contacto institucional con el certificado de notas o kardex; si el promedio no supera 70, el perfil puede fortalecerse con méritos documentados y Curriculum Vitae.",
          },
          {
            title: "Criterios de perfil",
            items: [
              "Buen promedio académico y correspondencia clara con el perfil solicitado por la empresa.",
              "Méritos acreditables como distinciones, premiaciones, pasantías, voluntariados, cursos u otras experiencias relevantes.",
              "Disponibilidad para mantener la regularidad académica durante el periodo de pasantía cuando sea requerido.",
            ],
          },
          {
            title: "Convocatorias futuras",
            items: [
              "Esta página muestra solo el ciclo 2026 para evitar un archivo extenso y repetitivo.",
              "Cada nueva pasantía puede publicarse como convocatoria específica con país, área, empresa, idioma, plazo y PDF.",
              "La participación en IAESTE no excluye la postulación a otras convocatorias de movilidad.",
            ],
          },
        ],
        reference: {
          label: "Convocatorias IAESTE - DRIC",
          href: "https://dric.umss.edu.bo/convocatorias-iaeste/",
        },
        calls: [
          {
            title: "ES-2026-8400 / España",
            description:
              "Pasantía internacional remunerada dirigida a estudiantes regulares con al menos 4 años de estudio. El postulante debe permanecer como alumno regular incluso durante la realización de la pasantía.",
            benefits: ["Pago mensual para manutención otorgado por la empresa internacional, según condiciones de la convocatoria."],
            documents: [
              "Certificado de notas o kardex para iniciar el proceso.",
              "Curriculum Vitae si el promedio debe compensarse con méritos adicionales.",
              "ES-2026-8400.pdf.",
            ],
            deadline: "23 de febrero de 2026.",
            note:
              "Área: Informática, Ingeniería de Sistemas. Empresa/Institución: Dismuntel S.L. Idioma: Inglés (C1, C2).",
          },
          {
            title: "DE-2026-2101-1 / Alemania",
            description:
              "Pasantía internacional remunerada dirigida a estudiantes regulares con al menos 3 años de estudio. El postulante debe permanecer como alumno regular incluso durante la realización de la pasantía.",
            benefits: ["Pago mensual para manutención otorgado por la empresa internacional, según condiciones de la convocatoria."],
            documents: [
              "Certificado de notas o kardex para iniciar el proceso.",
              "Curriculum Vitae si el promedio debe compensarse con méritos adicionales.",
              "DE-2026-2101-1.pdf.",
            ],
            deadline: "23 de febrero de 2026.",
            note:
              "Área: Bioquímica, Biología, Biotecnología. Empresa/Institución: Universitat Bayreuth Lehrstuhl Biochemie III. Idioma: Inglés (B1, B2).",
          },
        ],
      },
      {
        title: "Pasantías remuneradas BID",
        tag: "BID",
        summary:
          "Permite a estudiantes de pregrado y posgrado realizar pasantías remuneradas en la oficina central en Washington, oficinas locales en América Latina, el Caribe, Asia y Europa, y en INTAL en Argentina.",
        conditions: [
          "Dirigido a estudiantes con talento que aspiren adquirir experiencia profesional en desarrollo internacional.",
          "Las condiciones, requisitos y fechas se especifican en cada convocatoria publicada por el Grupo BID.",
          "Las pasantías pueden realizarse en la sede de Washington D.C., oficinas locales o INTAL, según disponibilidad.",
        ],
        highlights: [
          { label: "Institución", value: "Grupo BID: BID, BID Invest y BID Lab" },
          { label: "Campo", value: "Desarrollo internacional" },
          { label: "Sede principal", value: "Washington D.C." },
          { label: "Cronograma", value: "Washington: invierno y verano; oficinas locales según necesidad" },
        ],
        sections: [
          {
            title: "Programa de pasantías",
            body:
              "El Programa de Pasantías Remuneradas del Grupo BID busca estudiantes con talento que quieran adquirir experiencia profesional en proyectos vinculados al desarrollo internacional. Las oportunidades pueden abrirse en el BID, BID Invest y BID Lab.",
          },
          {
            title: "Modalidades",
            items: [
              "Pasantías en Washington D.C.: dos meses de duración, del 16 de enero al 15 de marzo en invierno y del 16 de junio al 15 de agosto en verano.",
              "Cada proceso competitivo para Washington inicia aproximadamente con tres meses de antelación.",
              "Pasantías remotas en oficinas locales: no tienen cronograma predefinido; las fechas se establecen según necesidades institucionales.",
            ],
          },
          {
            title: "Dónde revisar",
            items: [
              "Revisar con frecuencia el portal oficial de pasantías del Grupo BID.",
              "Consultar el cronograma del portal para actualizaciones de Washington D.C.",
              "Seguir los canales oficiales del Grupo BID para nuevas posiciones en oficinas locales.",
            ],
          },
        ],
        reference: {
          label: "Portal de pasantías Grupo BID",
          href: "https://jobs.iadb.org/es/pasantias",
        },
        calls: [
          {
            title: "Programa de Pasantías Remuneradas del Grupo BID",
            description:
              "Oportunidades remuneradas para adquirir experiencia profesional en desarrollo internacional en el BID, BID Invest y BID Lab, con posiciones en Washington D.C., oficinas en América Latina, el Caribe, Asia y Europa, e INTAL en Argentina.",
            benefits: [
              "Experiencia profesional en el campo del desarrollo internacional.",
              "Participación en equipos del Grupo BID según la posición disponible.",
              "Modalidades presenciales o remotas de acuerdo con la sede y convocatoria.",
            ],
            documents: [
              "Revisar requisitos específicos en cada posición publicada.",
              "Consultar el cronograma oficial para pasantías en Washington D.C.",
              "Preparar documentación académica y profesional según la convocatoria.",
            ],
            links: [
              { label: "BID", href: "https://www.iadb.org/es" },
              { label: "BID Invest", href: "https://www.idbinvest.org/es" },
              { label: "BID Lab", href: "https://bidlab.org/es" },
              { label: "Pasantías Grupo BID", href: "https://jobs.iadb.org/es/pasantias" },
            ],
            note:
              "Washington D.C. maneja ciclos de invierno y verano. Las oficinas locales publican pasantías según necesidades del negocio, por lo que conviene revisar el portal con frecuencia.",
          },
        ],
      },
      {
        title: "Global Connect Fellowship (GCF) - Singapur",
        tag: "Investigación",
        summary:
          "Oportunidad para que jóvenes académicos realicen dos o tres meses de investigación bajo la tutoría de profesores líderes a nivel mundial, dirigida a estudiantes de licenciatura y maestría con interés en investigación.",
        conditions: [
          "Dirigido a estudiantes destacados de grado y maestría con fuerte interés en investigación.",
          "Para la edición Summer Intake 2026, pueden postular estudiantes de Bachelor o Master's by Research que se gradúen en 2026 o 2027.",
          "La beca incluye monto de fellowship y alojamiento provisto, según las condiciones oficiales de NTU.",
        ],
        highlights: [
          { label: "Universidad", value: "Nanyang Technological University (NTU), Singapur" },
          { label: "Periodo 2026", value: "1 de julio al 31 de agosto de 2026" },
          { label: "Fellowship", value: "SGD 5.000" },
          { label: "Postulación", value: "15 de enero al 15 de febrero de 2026" },
        ],
        sections: [
          {
            title: "Investigación de frontera",
            body:
              "La Global Connect Fellowship es una oportunidad prestigiosa para que jóvenes académicos investiguen en el campus internacional de NTU Singapur bajo la tutoría de profesorado de renombre mundial. Está pensada para estudiantes con vocación investigadora y ambición de trabajar en desafíos globales.",
          },
          {
            title: "Áreas de investigación",
            items: [
              "Inteligencia artificial, aprendizaje automático, ciberseguridad y economía digital.",
              "Ciencia de materiales, fabricación inteligente, impresión 3D y sostenibilidad.",
              "Ciencias de la salud, tecnología financiera, finanzas verdes y cambio climático.",
              "Humanidades, artes, ciencias sociales, liderazgo, relaciones internacionales, seguridad, diplomacia, emprendimiento, educación, medios, diseño y comunicaciones.",
            ],
          },
          {
            title: "Experiencia académica",
            items: [
              "Participación en investigación avanzada en una universidad pública intensiva en investigación.",
              "Mentoría de profesores e investigadores reconocidos internacionalmente.",
              "Exposición a un campus dinámico, internacional y orientado a innovación.",
            ],
          },
        ],
        reference: {
          label: "Sitio oficial NTU Global Connect Fellowship",
          href: "https://www.ntu.edu.sg/about-us/global/global-connect-fellowship",
        },
        calls: [
          {
            title: "Global Connect Fellowship - Summer Intake 2026",
            description:
              "Convocatoria para estudiantes de grado o Master's by Research que se gradúen en 2026 o 2027, interesados en realizar investigación durante dos meses en NTU Singapur.",
            benefits: ["Fellowship amount: SGD 5.000.", "Alojamiento provisto por NTU."],
            documents: [
              "Revisar requisitos y pasos de postulación en el sitio oficial de NTU.",
              "Preparar documentación académica y perfil de investigación según el formulario oficial.",
            ],
            links: [
              {
                label: "Sitio oficial GCF",
                href: "https://www.ntu.edu.sg/about-us/global/global-connect-fellowship",
              },
              {
                label: "Application Link",
                href: "https://venus2.wis.ntu.edu.sg/NG_APP/Pages/RegistrationIC.aspx",
              },
            ],
            deadline: "Periodo de postulación: 15 de enero al 15 de febrero de 2026. Resultados: hasta fines de mayo de 2026.",
            note:
              "Periodo de fellowship: 1 de julio al 31 de agosto de 2026. NTU indica que la edición 2026 tiene una duración de 2 meses.",
          },
        ],
      },
    ] satisfies Program[],
    staffPrograms: [
      {
        title: "Convenio Interinstitucional",
        tag: "Convenios",
        summary:
          "Permite realizar movilidad docente o administrativa con universidades que mantienen convenios bilaterales con la UMSS.",
        conditions: [
          "La movilidad se habilita únicamente con instituciones que mantienen convenios vigentes con la UMSS.",
          "El docente o administrativo interesado debe ponerse en contacto con la DRIC para manifestar su interés e iniciar el proceso.",
          "Las condiciones académicas, administrativas y financieras se definen según el convenio y la institución de destino.",
          "Cuando no exista financiamiento específico, los gastos son cubiertos por el docente o administrativo participante.",
        ],
        highlights: [
          { label: "Modalidad", value: "Movilidad docente o administrativa" },
          { label: "Base institucional", value: "Convenios vigentes de la UMSS" },
          { label: "Primer paso", value: "Comunicar interés a la DRIC" },
          { label: "Gestión", value: "Coordinación caso por caso" },
        ],
        sections: [
          {
            title: "Cooperación especializada",
            body:
              "La movilidad por Convenio Interinstitucional permite activar vínculos académicos y administrativos con universidades socias de la UMSS. Es una vía flexible para fortalecer docencia, gestión, investigación, intercambio de buenas prácticas y construcción de nuevas agendas de cooperación.",
          },
          {
            title: "Ruta institucional",
            items: [
              "Revisar si la institución de interés cuenta con convenio vigente aplicable a movilidad docente o administrativa.",
              "Contactar a la DRIC para registrar el interés y recibir orientación sobre el procedimiento.",
              "Definir junto con la unidad académica o administrativa los objetivos, fechas tentativas y pertinencia institucional de la movilidad.",
              "Coordinar con la universidad de destino la aceptación, agenda de trabajo y condiciones específicas.",
            ],
          },
          {
            title: "Enfoque de la estancia",
            items: [
              "Docencia, conferencias, talleres o colaboración curricular.",
              "Investigación, reuniones técnicas o preparación de proyectos conjuntos.",
              "Intercambio de experiencias en gestión universitaria, internacionalización o procesos administrativos.",
              "Fortalecimiento de redes institucionales y seguimiento de convenios activos.",
            ],
          },
        ],
        calls: [
          {
            title: "Convocatorias por Convenio Interinstitucional",
            description:
              "Los convenios vigentes pueden permitir intercambio o movilidad docente y administrativa. La persona interesada debe ponerse en contacto con la DRIC para dar a conocer su interés e iniciar el proceso correspondiente.",
            benefits: [
              "Acompañamiento institucional para revisar convenio, destino, pertinencia y pasos de postulación.",
              "Posibilidad de articular actividades de docencia, investigación, gestión o cooperación con universidades socias.",
            ],
            documents: [
              "Nota o comunicación inicial manifestando interés.",
              "Propuesta breve de movilidad con objetivos, institución de destino y fechas tentativas.",
              "Curriculum Vitae actualizado.",
              "Documentación adicional solicitada por la DRIC, la unidad correspondiente o la universidad de destino.",
            ],
            deadline: "Según disponibilidad del convenio, calendario de la institución de destino y coordinación con la DRIC.",
            note:
              "La información específica de convocatorias, requisitos y beneficios se actualizará según cada convenio activo.",
          },
        ],
      },
      {
        title: "Programa de Movilidad Académica Administrativa (PMAA) - CRISCOS",
        tag: "CRISCOS",
        summary:
          "Permite movilidad para docencia o investigación al personal académico. El personal administrativo también puede realizar movilidad según los requerimientos de las universidades participantes.",
        conditions: [
          "Participan docentes, investigadores y personal administrativo de universidades CRISCOS.",
          "El personal docente puede postular en todas las áreas.",
          "El personal administrativo postula en temas relacionados con internacionalización y/o gestión universitaria.",
          "Hospedaje, alimentación y pasaje aéreo se cubren según las condiciones de cada convocatoria.",
        ],
        highlights: [
          { label: "Red", value: "CRISCOS" },
          { label: "Perfil", value: "Personal académico y administrativo" },
          { label: "Plazas recientes", value: "1 plaza por convocatoria" },
          { label: "Último plazo", value: "10 de octubre de 2025" },
        ],
        sections: [
          {
            title: "Movilidad académica administrativa",
            body:
              "El PMAA de CRISCOS permite que docentes, investigadores y personal administrativo realicen actividades académicas, de investigación, vinculación con el medio, internacionalización o gestión universitaria en otra universidad de la red.",
          },
          {
            title: "Alcance regional",
            items: [
              "Universidades participantes de Argentina, Chile, Ecuador, Paraguay y Perú.",
              "Oferta académica y condiciones revisadas por universidad y por convocatoria.",
              "Espacio de intercambio orientado a fortalecer capacidades institucionales y cooperación subregional.",
            ],
          },
          {
            title: "Preparación",
            items: [
              "Revisar la oferta académica y las condiciones de cada universidad antes de postular.",
              "Descargar la convocatoria y el formulario correspondiente al periodo vigente.",
              "Coordinar con la DRIC la documentación, plazos internos y pertinencia de la movilidad.",
            ],
          },
        ],
        reference: {
          label: "Convocatorias PMAA - CRISCOS",
          href: "https://dric.umss.edu.bo/convocatorias-pmaa/",
        },
        calls: [
          {
            title: "14ª Convocatoria PMAA",
            description:
              "Movilidad del personal académico y administrativo con universidades de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: ["Hospedaje y alimentación de acuerdo con las condiciones de cada universidad.", "Pasaje aéreo."],
            documents: [
              "PMAA 14 Oferta académica.",
              "14 Convocatoria.",
              "Formulario de postulación.pdf.",
              "Revisar condiciones y oferta académica de cada universidad.",
            ],
            deadline: "10 de octubre de 2025.",
            note:
              "Áreas: personal docente, todas; personal administrativo, internacionalización y/o gestión universitaria. N° de plazas: 1 para personal académico o administrativo.",
          },
          {
            title: "13ª Convocatoria PMAA",
            description:
              "Movilidad del personal académico y administrativo con universidades participantes de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: ["Hospedaje y alimentación de acuerdo con las condiciones de cada universidad.", "Pasaje aéreo."],
            documents: [
              "PMAA 13 CRISCOS 2-2025.pdf.",
              "13 Convocatoria.",
              "Formulario de postulación.pdf.",
              "Revisar condiciones y oferta académica de cada universidad.",
            ],
            deadline: "5 de mayo de 2025.",
            note:
              "Áreas: personal docente, todas; personal administrativo, internacionalización y/o gestión universitaria. N° de plazas: 1 para personal académico o administrativo.",
          },
          {
            title: "11ª Convocatoria PMAA",
            description:
              "Movilidad del personal académico y administrativo con universidades de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: ["Hospedaje y alimentación de acuerdo con las condiciones de cada universidad.", "Pasaje aéreo."],
            documents: [
              "PMAA CRISCOS 2-2024.pdf.",
              "48 Convocatoria.",
              "Formulario de postulación.pdf.",
              "Revisar condiciones y oferta académica de cada universidad.",
            ],
            deadline: "30 de abril de 2024.",
            note:
              "Áreas: personal docente, todas; personal administrativo, internacionalización y/o gestión universitaria.",
          },
          {
            title: "10ª Convocatoria PMAA",
            description:
              "Movilidad del personal académico y administrativo con universidades de Argentina, Chile, Ecuador, Paraguay y Perú.",
            benefits: ["Hospedaje y alimentación durante la estadía, de acuerdo con las condiciones de cada universidad.", "Pasaje aéreo."],
            documents: [
              "PMAA CRISCOS 1-2024.pdf.",
              "Descargar la Convocatoria.",
              "Formulario de postulación.pdf.",
            ],
            deadline: "10 de octubre de 2023.",
            note:
              "Áreas: personal docente, todas; personal administrativo, internacionalización y/o gestión universitaria. N° de plazas: 1 para personal académico y 1 para personal administrativo.",
          },
        ],
      },
      {
        title: "Programa Escala Docente (PED) de AUGM",
        tag: "AUGM",
        summary:
          "Promueve la cooperación e integración regional entre universidades miembro de AUGM mediante movilidad e intercambio docente, fortaleciendo relaciones académicas y proyectos conjuntos de investigación.",
        conditions: [
          "Dirigido a docentes e investigadores de la UMSS con más de dos años de antigüedad.",
          "No haber sido beneficiado en otro programa de movilidad promovido por la DRIC.",
          "No haber renunciado fuera de plazo a una plaza de movilidad internacional obtenida en convocatorias anteriores de la DRIC.",
          "La universidad de origen cubre el traslado internacional.",
          "La universidad receptora cubre alojamiento y alimentación.",
        ],
        highlights: [
          { label: "Red", value: "Asociación de Universidades Grupo Montevideo (AUGM)" },
          { label: "Perfil", value: "Docentes e investigadores" },
          { label: "Duración", value: "5 a 15 días" },
          { label: "Último plazo", value: "28 de octubre de 2025" },
        ],
        sections: [
          {
            title: "Cooperación académica",
            body:
              "El Programa ESCALA Docente de AUGM promueve la cooperación e integración regional mediante la movilidad e intercambio de docentes. Su propósito es fortalecer relaciones académicas, abrir conversaciones de investigación y facilitar la presentación de proyectos conjuntos entre universidades miembro.",
          },
          {
            title: "Postulación estratégica",
            items: [
              "Seleccionar universidades cuya oferta académica dialogue con la línea de docencia, investigación o extensión del postulante.",
              "Presentar una propuesta de movilidad clara, breve y orientada a resultados institucionales.",
              "Gestionar la carta de invitación con la universidad de destino antes de entregar la postulación.",
              "Coordinar con la DRIC la firma del Decano y del Delegado Asesor ante AUGM.",
            ],
          },
          {
            title: "Documentación base",
            items: [
              "Formulario de postulación firmado por el Decano de la Facultad y por el Delegado Asesor ante AUGM.",
              "Propuesta de movilidad, cuando corresponda, con extensión máxima de 2 páginas.",
              "Carta de invitación de la universidad de destino.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Certificado emitido por la DPA acreditando antigüedad y condición.",
              "CV documentado o resumido documentado, según la convocatoria.",
              "Cédula de identidad o pasaporte cuando la convocatoria lo solicite.",
            ],
          },
        ],
        reference: {
          label: "ESCALA Docente - AUGM",
          href: "https://grupomontevideo.org/escaladocente/",
        },
        calls: [
          {
            title: "Programa PED - Convocatoria II/25",
            description:
              "Movilidad de docentes e investigadores con universidades de Argentina, Brasil y Paraguay. Las áreas varían en cada universidad y deben revisarse en la convocatoria.",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM. Se sugiere presentar 2 opciones.",
              "Propuesta de movilidad, máximo 2 páginas.",
              "Carta de invitación de la universidad de destino, acordando movilidad entre marzo y julio.",
              "Modelo de carta de invitación.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Certificado DPA de antigüedad y condición.",
              "CV resumido documentado.",
              "Cédula de identidad o pasaporte.",
              "Descargar la convocatoria.",
            ],
            links: [
              { label: "Convocatorias PED - DRIC", href: "https://dric.umss.edu.bo/convocatorias-programa-escala-docente-ped/" },
              { label: "ESCALA Docente - AUGM", href: "https://grupomontevideo.org/escaladocente/" },
            ],
            deadline: "28 de octubre de 2025.",
            note:
              "Universidades: UBA, UNNE y Universidad Nacional de Mar del Plata (Argentina), USP y UFSM (Brasil), UNA (Paraguay). Duración: entre 5 y 15 días.",
          },
          {
            title: "Programa PED - Convocatoria II/24",
            description:
              "Movilidad de docentes e investigadores con Universidade Federal do ABC (Brasil) y Universidad de la República (Uruguay).",
            benefits: [
              "La universidad de destino cubre alojamiento y alimentación de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM.",
              "Carta de invitación.",
              "Modelo de carta de invitación.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Certificado DPA de antigüedad y condición.",
              "CV documentado.",
              "Descargar la convocatoria.",
            ],
            deadline: "17 de junio de 2024.",
            note:
              "Áreas: varía en cada universidad. Duración: mínimo 5 días y máximo 15 días.",
          },
          {
            title: "Programa PED - Convocatoria I/24",
            description:
              "Movilidad de docentes e investigadores con universidades de Argentina, Brasil y Uruguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM.",
              "Carta de invitación.",
              "Modelo de carta de invitación.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Certificado DPA de antigüedad y condición.",
              "CV documentado.",
              "Descargar la convocatoria.",
            ],
            deadline: "23 de octubre de 2023.",
            note:
              "Universidades: UBA, UNSL, UFABC, UNICAMP y UDELAR. Se dará prioridad a candidatos que no hayan participado en programas de movilidad.",
          },
          {
            title: "Programa PED - Convocatoria II/23",
            description:
              "Movilidad de docentes e investigadores con universidades de Argentina, Brasil y Paraguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM.",
              "Carta de invitación de la universidad de destino firmada por la autoridad de Facultad y Delegado Asesor.",
              "Modelo de carta de invitación.",
              "Carta de motivación dirigida al Comité de Selección.",
              "Certificado DPA de antigüedad y condición.",
              "CV documentado.",
              "Descargar la convocatoria.",
            ],
            deadline: "29 de mayo de 2023.",
            note:
              "Universidades: UNNE, UFSC, UNICAMP, UNA y UNCp. Criterios de selección disponibles en la convocatoria.",
          },
          {
            title: "Programa PED - Convocatoria I/23",
            description:
              "Movilidad de docentes e investigadores con universidades miembro de AUGM en Argentina, Brasil, Paraguay y Uruguay.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM.",
              "Carta de invitación de la universidad de destino.",
              "Modelo de carta de invitación.",
              "Copia del expediente académico.",
              "Carta de motivación.",
              "Certificado DPA de antigüedad y condición.",
              "CV documentado.",
              "Descargar la convocatoria.",
            ],
            deadline: "31 de octubre de 2022.",
            note:
              "Universidades: UBA, UNCUYO, UNLP, UNNE, UNR, UFSC, UNICAMP, UNA, UNCp y UDELAR. Una plaza figura seleccionada para Maritza Jimenez, FMED.",
          },
          {
            title: "Programa PED - Convocatoria II/22",
            description:
              "Movilidad de docentes e investigadores con universidades de Argentina, Paraguay y Chile.",
            benefits: [
              "La universidad de destino cubre alojamiento y manutención de acuerdo con sus condiciones.",
              "Pasaje aéreo.",
            ],
            documents: [
              "Formulario de postulación firmado por el Decano y por el Delegado Asesor ante AUGM.",
              "Carta de invitación de la universidad de destino.",
              "Copia del expediente académico.",
              "Carta de motivación.",
              "Certificado DPA de antigüedad y condición.",
              "CV documentado.",
              "Descargar la convocatoria.",
              "Descargar el formulario de postulación.",
            ],
            deadline: "20 de mayo de 2022.",
            note:
              "Universidades: UNT, UNNE y UNCUYO (Argentina), UNA (Paraguay), Universidad de Valparaíso (Chile). Duración: mínimo 5 días y máximo 15 días.",
          },
        ],
      },
      {
        title: "Programa Escala de Gestores y Administradores (PEGyA) de AUGM",
        tag: "AUGM",
        summary:
          "Promueve la movilidad e intercambio de directivos, gestores y administrativos entre universidades miembro de AUGM. Está orientado al personal administrativo y autoridades universitarias.",
        conditions: [
          "Orientado a personal administrativo, gestores, directivos y autoridades universitarias.",
          "La estancia debe vincularse al quehacer específico de la competencia del postulante.",
          "La movilidad se realiza en una universidad miembro de AUGM ubicada en un país distinto al de la universidad de origen.",
          "La universidad de origen cubre el traslado internacional.",
          "La universidad receptora cubre alojamiento y alimentación.",
        ],
        highlights: [
          { label: "Red", value: "AUGM" },
          { label: "Perfil", value: "Gestores, administrativos, directivos y autoridades" },
          { label: "Propósito", value: "Formación e intercambio en gestión universitaria" },
          { label: "Cobertura", value: "Traslado internacional, alojamiento y alimentación" },
        ],
        sections: [
          {
            title: "Gestión universitaria en red",
            body:
              "El Programa ESCALA de Gestores y Administradores de AUGM impulsa la cooperación entre universidades miembro mediante estancias de formación e intercambio. Su valor está en transferir buenas prácticas, fortalecer procesos institucionales y abrir canales de colaboración entre equipos de gestión universitaria.",
          },
          {
            title: "Ámbitos de intercambio",
            items: [
              "Internacionalización, cooperación académica y gestión de convenios.",
              "Administración universitaria, planificación, procesos y mejora institucional.",
              "Gestión académica, soporte a investigación, vinculación y servicios universitarios.",
              "Dirección, coordinación de equipos y fortalecimiento de capacidades institucionales.",
            ],
          },
          {
            title: "Preparación de la estancia",
            items: [
              "Definir objetivos concretos de aprendizaje, intercambio o mejora administrativa.",
              "Identificar una universidad miembro de AUGM con experiencia relevante para el área de trabajo.",
              "Coordinar con la DRIC la ruta de postulación, fechas, documentación y validación institucional.",
              "Plantear productos de retorno: informe, transferencia interna, protocolo, taller o propuesta de mejora.",
            ],
          },
        ],
        reference: {
          label: "ESCALA Gestores - AUGM",
          href: "https://grupomontevideo.org/escalagestores/",
        },
        calls: [
          {
            title: "Convocatorias PEGyA - AUGM",
            description:
              "Las convocatorias del Programa ESCALA de Gestores y Administradores habilitan movilidad para personal administrativo, gestores, directivos y autoridades universitarias de universidades miembro de AUGM.",
            benefits: [
              "La universidad de origen cubre el traslado internacional.",
              "La universidad receptora cubre alojamiento y alimentación.",
              "La estancia fortalece capacidades de gestión y cooperación institucional.",
            ],
            documents: [
              "Revisar condiciones y requisitos de la universidad de origen y de la universidad de destino.",
              "Preparar una propuesta de estancia vinculada al área de competencia del postulante.",
              "Completar los formularios o plataforma que indique la convocatoria vigente.",
              "Coordinar consultas y validación institucional con la DRIC.",
            ],
            links: [
              { label: "ESCALA Gestores - AUGM", href: "https://grupomontevideo.org/escalagestores/" },
            ],
            deadline: "Según cronograma de convocatoria vigente publicado por AUGM y coordinación interna de la DRIC.",
            note:
              "Esta sección queda preparada para publicar futuras convocatorias específicas con fechas, plazas, universidades y documentos.",
          },
        ],
      },
      {
        title: "Programa ERASMUS+/ICM",
        tag: "Europa",
        summary:
          "Permite al personal docente y administrativo realizar estancias de formación o docencia en universidades de países socios de Erasmus+ y viceversa.",
        conditions: [
          "Dirigido a personal docente, investigador y administrativo, según el tipo de movilidad indicado en cada convocatoria.",
          "Las estancias pueden orientarse a docencia, formación, investigación, prácticas doctorales o semanas internacionales.",
          "La Comisión Europea, a través de la institución coordinadora, cubre los gastos definidos en cada convocatoria.",
          "Los requisitos, criterios de selección, plazas y documentos deben revisarse en la convocatoria correspondiente.",
        ],
        highlights: [
          { label: "Programa", value: "Erasmus+ International Credit Mobility (ICM)" },
          { label: "Perfiles", value: "Docentes, investigadores, administrativos y doctorandos según convocatoria" },
          { label: "Destinos recientes", value: "República Checa, España, Polonia y Navarra" },
          { label: "Último plazo", value: "19 de agosto de 2024" },
        ],
        sections: [
          {
            title: "Movilidad con alcance europeo",
            body:
              "Erasmus+ ICM abre oportunidades para que el personal universitario ejerza funciones docentes, participe en formación especializada o fortalezca cooperación académica con instituciones de educación superior europeas. Cada convocatoria define el perfil, la duración, el destino y la cobertura económica.",
          },
          {
            title: "Modalidades frecuentes",
            items: [
              "Movilidad docente para dictar cursos en inglés en universidades socias.",
              "Movilidad de personal para formación, semanas internacionales y actualización metodológica.",
              "Movilidad académico-práctica para doctorandos cuando la convocatoria lo habilite.",
              "Cooperación orientada a investigación, docencia, laboratorios y desarrollo de futuras alianzas.",
            ],
          },
          {
            title: "Preparación de candidatura",
            items: [
              "Revisar cuidadosamente requisitos, criterios de selección y número de plazas de cada convocatoria.",
              "Gestionar cartas de invitación con anticipación cuando sean requeridas.",
              "Preparar acuerdos de movilidad, programas de trabajo o documentos específicos según el tipo de estancia.",
              "Coordinar con la DRIC la postulación, respaldo institucional y documentación final.",
            ],
          },
        ],
        reference: {
          label: "Convocatorias Erasmus+ ICM docentes y administrativos - DRIC",
          href: "https://dric.umss.edu.bo/convocatorias-programa-erasmus/",
        },
        calls: [
          {
            title: "Movilidad docente UHK Erasmus+/ICM - 2024",
            description:
              "Convocatoria para docentes e investigadores de la UMSS interesados en dictar un curso en inglés a estudiantes de la Facultad de Filosofía de la Universidad de Hradec Králové, República Checa.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, total 1.400 € para 8 días más 2 de viaje."],
            documents: ["Revisar requisitos y criterios de selección.", "Descargar la convocatoria."],
            links: [
              { label: "Convocatoria Erasmus+ ICM - DRIC", href: "https://dric.umss.edu.bo/convocatorias-programa-erasmus/" },
            ],
            deadline: "19 de agosto de 2024.",
            note:
              "Áreas: Historia, Sociología y Ciencias Políticas. Número de plazas: 1 plaza / 8 días, preferentemente entre octubre y noviembre de 2024.",
          },
          {
            title: "Universidad de Granada - Staff Training Week BIP 2024",
            description:
              "Semana de formación dedicada a programas intensivos combinados dentro de Erasmus+, organizada en el campus de Ceuta de la Universidad de Granada.",
            benefits: ["Alojamiento y manutención.", "Billete de ida y vuelta."],
            documents: ["Convocatoria.", "Programa provisional."],
            deadline: "24 de abril de 2024.",
            note:
              "Dirigida a docentes, investigadores y administrativos. Tipo de movilidad: formación para participar en la 31st Staff Training Week: Blended Intensive Programmes (BIP) and the New Mobility Opportunities within Erasmus+. Idioma: inglés. N° de plazas: 1.",
          },
          {
            title: "Universidad de Valladolid / Erasmus+ KA171 - prácticas doctorales",
            description:
              "Convocatoria para estudiantes matriculados en doctorado interesados en realizar una movilidad académico-práctica de 5 meses en la Universidad de Valladolid.",
            benefits: [
              "Alojamiento y manutención: 850 €/mes durante 5 meses.",
              "Billete de ida y vuelta: 1.500 €.",
              "Apoyo por obstáculos socioeconómicos y problemas de salud acreditados: 250 €/mes.",
              "Seguro médico y de asistencia en viaje: hasta 250 €.",
              "Visado: hasta 30 € adicionales.",
            ],
            documents: ["Convocatoria.", "Formulario de postulación.", "Carta de invitación requerida."],
            deadline: "2 de mayo de 2024.",
            note:
              "Tipo de movilidad: Student Mobility for Traineeships (SMP). Actividades financiables en septiembre 2024-febrero 2025 o febrero-julio 2025. N° de plazas: 1.",
          },
          {
            title: "Universidad de Deusto - Semana Internacional 2024",
            description:
              "Movilidad de personal académico y administrativo para participar en la Semana Internacional A Transversal Approach on Internationalization.",
            benefits: ["Pasaje aéreo.", "Ayuda de alojamiento y manutención."],
            documents: ["Convocatoria Semana Internacional."],
            deadline: "28 de febrero de 2024.",
            note: "PLAZAS: 1 plaza / 7 días. Idioma: inglés.",
          },
          {
            title: "Wroclaw University of Science and Technology - movilidad académica 2024",
            description:
              "Convocatoria para personal académico de la UMSS interesado en realizar movilidad académica en Polonia.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, total 980 €."],
            documents: ["Convocatoria docente wroclaw feb 2024.pdf."],
            deadline: "23 de febrero de 2024.",
            note:
              "Áreas: Negocios y Administración, Arquitectura, Bioquímica, Informática, Ingeniería de Sistemas, Eléctrica, Electrónica, Mecánica, Ingeniería Civil y Química. N° de plazas: 1 plaza / 7 días.",
          },
          {
            title: "Bialystok University of Technology - Semana Internacional 2024",
            description:
              "Subvención Erasmus+ para personal académico de la UMSS interesado en participar en la Semana Internacional organizada por BUT, Polonia.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, total 980 €."],
            documents: ["Convocatoria docente BUT.pdf."],
            deadline: "23 de noviembre de 2023.",
            note:
              "N° de plazas: 1 plaza / 7 días, 5 días en BUT más 2 de viaje. Fecha por definir durante el primer semestre 2024. Idioma: inglés.",
          },
          {
            title: "Bialystok University of Technology - Semana Internacional 2022",
            description:
              "Beca Erasmus+ para personal académico de la UMSS interesado en participar en la Semana Internacional organizada por BUT, Polonia.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, total 980 €."],
            documents: ["Convocatoria docente BUT octubre22.pdf."],
            deadline: "26 de octubre de 2022.",
            note:
              "N° de plazas: 1 plaza / 7 días, 5 días en BUT más 2 de viaje. Fecha: 12 al 16 de diciembre de 2022. Idioma: inglés.",
          },
          {
            title: "Convocatoria II/22 UHK Erasmus+/ICM",
            description:
              "Convocatoria para docentes e investigadores de la UMSS interesados en dictar un curso en inglés a estudiantes de la Facultad de Filosofía de la UHK.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, máximo 8 días."],
            documents: ["Revisar requisitos y criterios de selección.", "Descargar la convocatoria."],
            deadline: "17 de octubre de 2022.",
            note:
              "Áreas: Sociología, Ciencias Políticas, Antropología y Psicología. Número de plazas/duración: 1 plaza / 8 días, preferentemente entre marzo y abril de 2023.",
          },
          {
            title: "Convocatoria I/22 UHK Erasmus+/ICM",
            description:
              "Convocatoria para docentes e investigadores de la UMSS interesados en dictar un curso en inglés a estudiantes de la Facultad de Filosofía de la UHK.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 140 €/día, máximo 7 días."],
            documents: ["Revisar requisitos y criterios de selección.", "Descargar la convocatoria."],
            deadline: "26 de mayo de 2022.",
            note:
              "Áreas: Sociología y Ciencias Políticas. Número de plazas/duración: 1 plaza / 8 días, preferentemente entre octubre y noviembre de 2022. Convocatoria declarada desierta.",
          },
          {
            title: "Universidad Pública de Navarra - International Staff Week 2022",
            description:
              "Movilidad docente/administrativa para personal relacionado al ámbito internacional, con fines formativos en la International Staff Week de la UPNA.",
            benefits: ["Pasaje aéreo: 1.500 €.", "Ayuda de alojamiento y manutención: 160 €/día, máximo 7 días."],
            documents: ["Convocatoria.", "Acuerdo de Movilidad (Staff Mobility Agreement Training)."],
            links: [{ label: "Información UPNA", href: "https://bit.ly/3MaZdI7" }],
            deadline: "29 de abril de 2022.",
            note: "Estancia prevista del 13 al 17 de junio de 2022.",
          },
          {
            title: "Universidad de Valladolid - cooperación Erasmus+ KA131",
            description:
              "Posibilidad de cooperación para prácticas de doctorado y actividades de investigación o docencia de postdoctorados recientes, con financiamiento Erasmus+ y Universidad de Valladolid.",
            benefits: ["Gastos cubiertos por el Programa Erasmus+ y la Universidad de Valladolid."],
            documents: ["Solicitar documentos de oferta a la DRIC.", "Convenio Interinstitucional Erasmus+ KA131 para prácticas cuando corresponda."],
            deadline: "Según coordinación con la DRIC y la Universidad de Valladolid.",
            note:
              "Doctorandos: prácticas de 3 a 6 meses. Postdoctorados recientes: actividades de investigación o docencia de 4 a 6 meses.",
          },
        ],
      },
      {
        title: "INTERCOONECTA",
        tag: "Formación",
        summary:
          "Actividades formativas dirigidas principalmente a empleados públicos y profesionales de administraciones públicas de América Latina y el Caribe, con modalidades presenciales y en línea.",
        conditions: [
          "Dirigido principalmente a empleados públicos y profesionales de Administraciones Públicas de América Latina y el Caribe.",
          "Las actividades buscan fortalecer capacidades institucionales e inducir cambios en políticas públicas a favor del desarrollo humano sostenible.",
          "La modalidad, requisitos, fechas y ayudas se especifican en cada actividad publicada.",
          "Las actividades pueden desarrollarse de forma presencial, en línea o mediante centros de formación de la Cooperación Española.",
        ],
        highlights: [
          { label: "Institución", value: "Cooperación Española - AECID" },
          { label: "Enfoque", value: "Transferencia, intercambio y gestión de conocimiento" },
          { label: "Región", value: "América Latina y el Caribe" },
          { label: "Modalidad", value: "Presencial y en línea" },
        ],
        sections: [
          {
            title: "Conocimiento para el desarrollo",
            body:
              "INTERCOONECTA es la apuesta de la Cooperación Española por el conocimiento como herramienta efectiva para el desarrollo de América Latina y el Caribe. Su propósito es fortalecer instituciones, mejorar capacidades técnicas y acompañar políticas públicas con impacto en resultados de desarrollo.",
          },
          {
            title: "Formación especializada",
            items: [
              "Capacitación y formación técnica especializada para profesionales vinculados a la gestión pública.",
              "Actividades diseñadas para fortalecer las organizaciones a las que sirven los participantes.",
              "Contenidos orientados a desarrollo humano sostenible, cooperación, políticas públicas e innovación institucional.",
            ],
          },
          {
            title: "Dónde se desarrolla",
            items: [
              "Modalidad presencial en Centros de Formación de la Cooperación Española en América Latina y el Caribe.",
              "Actividades en sedes de instituciones públicas en España.",
              "Modalidad en línea a través del Aula Virtual de INTERCOONECTA.",
              "Agenda publicada por actividad y por centro de formación.",
            ],
          },
        ],
        reference: {
          label: "Portal INTERCOONECTA",
          href: "https://intercoonecta.aecid.es/",
        },
        calls: [
          {
            title: "Búsqueda de actividades INTERCOONECTA",
            description:
              "INTERCOONECTA publica actividades de formación y capacitación para fortalecer capacidades institucionales en América Latina y el Caribe. La programación puede consultarse por actividad, centro de formación y modalidad.",
            benefits: [
              "Acceso a formación técnica especializada de la Cooperación Española.",
              "Participación en espacios de intercambio de conocimiento con alcance regional.",
              "Fortalecimiento de capacidades institucionales orientadas al desarrollo sostenible.",
            ],
            documents: [
              "Revisar requisitos, fechas y ayudas en cada actividad.",
              "Consultar la agenda publicada por los Centros de Formación.",
              "Completar el proceso de inscripción indicado por INTERCOONECTA o el centro organizador.",
            ],
            links: [
              { label: "Portal INTERCOONECTA", href: "https://intercoonecta.aecid.es/" },
              {
                label: "Búsqueda de actividades",
                href: "https://intercoonecta.aecid.es/programaci%C3%B3n-de-actividades?accion=todas",
              },
              { label: "Centro Cartagena de Indias", href: "http://www.aecidcf.org.co/" },
              { label: "Centro Santa Cruz de la Sierra", href: "http://www.aecid-cf.bo/" },
              { label: "Centro La Antigua", href: "https://cfantigua.aecid.es/" },
              { label: "Centro Montevideo", href: "http://www.aecid.org.uy/CFCE/" },
            ],
            deadline: "Según la programación y plazo de inscripción de cada actividad.",
            note:
              "También se recomienda revisar la agenda publicada por cada centro de formación de la Cooperación Española.",
          },
        ],
      },
    ] satisfies Program[],
  },
  en: {
    eyebrow: "Mobility and international internships",
    title: "Mobility programs",
    intro:
      "DRIC channels student, faculty, and administrative mobility programs, as well as international internships that strengthen academic training, institutional cooperation, and regional integration.",
    back: "Back to Scholarships and Mobility",
    students: "Student mobility",
    staff: "Faculty / administrative mobility",
    studentsIntro:
      "Options for UMSS students to complete exchanges, academic stays, or internships with international institutions and companies.",
    staffIntro:
      "Programs for faculty, managers, and administrative staff to participate in academic mobility, training, teaching, research, and institutional exchange.",
    conditions: "Conditions",
    studentPrograms: [
      {
        title: "Interinstitutional Agreement",
        tag: "Agreements",
        summary:
          "Allows mobility, generally for one academic semester, with universities that have signed agreements with UMSS. Interested applicants should express their interest at least one semester before beginning mobility.",
        conditions: ["The student covers all expenses."],
        reference: {
          label: "Interinstitutional Agreement",
          href: "https://dric.umss.edu.bo/convocatorias/intercambio/convenio-interinstitucional/",
        },
        calls: [
          {
            title: "Agreement Mobility / UCB - term I/2026",
            description:
              "Under the agreement signed with Universidad Católica Boliviana, Cochabamba campus, UMSS students interested in completing a study period at this university during term I/2026 are invited to apply.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download call for applications.", "Application form."],
            deadline: "December 18, 2025, until 15:00.",
          },
          {
            title: "Agreement Mobility / UCB - term II/2025",
            description:
              "Call for UMSS students interested in completing a study period at Universidad Católica Boliviana, Cochabamba campus, during term II/2025.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download June 2025 call.", "Application form."],
            deadline: "July 11, 2025, until 15:00.",
          },
          {
            title: "Self-funded international mobility - semester II/2025",
            description:
              "Call for self-funded international student mobility at universities in Argentina, Brazil, Chile, Ecuador, Spain, Mexico, Paraguay, and Peru.",
            benefits: ["The host university only waives the corresponding tuition fee."],
            documents: ["Self-funded international mobility call.pdf"],
            deadline: "Depending on the university, April 15 and May 14.",
            note:
              "The student covers airfare, accommodation, meals, insurance, and other mobility-related expenses. The host university reserves the right to accept applicants according to budget, available places, or other criteria.",
          },
          {
            title: "EMOVIES Virtual Exchange Program - UNCUYO / AUGM",
            description:
              "Universidad Nacional de Cuyo (UNCUYO), Argentina, is receiving applications from students interested in participating in the EMOVIES program during the first semester of 2025, from March to July.",
            documents: ["EMOVIES call."],
            deadline: "February 12, 2025.",
            note:
              "Courses offered: Constitutional Law, Digital Literacy, Electoral and Party Systems, Political Doctrines and Ideas II, North American Literature, and International Analysis.",
          },
          {
            title: "Agreement Mobility / UCB - term I/2025",
            description:
              "Call for UMSS students interested in completing a study period at Universidad Católica Boliviana, Cochabamba campus, during term I/2025.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download January 2025 call.", "Application form."],
            deadline: "January 23, 2025, until 17:00.",
          },
          {
            title: "UCSP student mobility - Peru",
            description:
              "Student mobility program at Universidad Católica San Pablo (UCSP) in Peru, with a partial scholarship.",
            benefits: ["Gym registration.", "Tuition fee waiver.", "Lunches from Monday to Friday."],
            documents: ["UCSP call."],
            deadline: "November 11.",
          },
          {
            title: "Self-funded international mobility - semester I/2025",
            description:
              "Call for self-funded international mobility at universities in Argentina, Brazil, Chile, Ecuador, Spain, Mexico, Paraguay, Peru, and Poland.",
            benefits: ["The host university only waives the corresponding tuition fee."],
            documents: ["Self-funded international mobility call.pdf"],
            deadline: "Depending on the university, October 14 or 30.",
            note:
              "Mobility consists of completing one academic semester at the selected institution, subject to approval by the host university. The student covers airfare, accommodation, meals, insurance, and other expenses.",
          },
          {
            title: "Agreement Mobility / UCB - term II/2024",
            description:
              "Call for UMSS students interested in completing a study period at Universidad Católica Boliviana, Cochabamba campus, during term II/2024.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download July 2024 call.pdf", "Form."],
            deadline: "July 26, 2024, until 12:00.",
          },
          {
            title: "Agreement Mobility / UCB - term I/2024",
            description:
              "Call for UMSS students interested in completing a study period at Universidad Católica Boliviana, Cochabamba campus, during term I/2024.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download January 2024 call.pdf", "Form."],
            deadline: "January 23, 2024.",
          },
          {
            title: "Agreement Mobility / UCB - term II/2023",
            description:
              "Call for UMSS students interested in completing a study period at Universidad Católica Boliviana, Cochabamba campus, during term II/2023.",
            benefits: ["Tuition fee waiver."],
            documents: ["Download call for applications.", "Form."],
            deadline: "July 14, 2023.",
          },
          {
            title: "Academic mobility - Universidad Simón Bolívar (Unisimón)",
            description:
              "Academic mobility call for students interested in completing an exchange during the 2023-II period.",
            benefits: ["Tuition fee waiver."],
            deadline: "Request more information at DRIC offices by May 10, 2023.",
            note: "The selected student covers transportation, stay, visa, and other expenses.",
          },
          {
            title: "Mobility - Jean Moulin Lyon 3 University (France)",
            description:
              "Student mobility opportunity in areas related to Law, Administration, and Linguistics.",
            benefits: ["Tuition fee waiver."],
            deadline: "Request more information at DRIC offices by May 10, 2023.",
            note: "The student covers transportation, stay, visa, and other expenses.",
          },
        ],
      },
      {
        title: "ERASMUS+/ICM Program",
        tag: "Europe",
        summary:
          "Offers opportunities to study at universities in Erasmus+ partner countries through International Credit Mobility. Students or doctoral candidates study abroad for a limited period, earn credits, and return to their home institution to complete their studies.",
        conditions: ["All expenses are funded by the European Commission."],
        highlights: [
          { label: "Funding", value: "European Commission" },
          { label: "Format", value: "International mobility with academic recognition" },
          { label: "Recurring destination", value: "University of Hradec Králové, Czech Republic" },
          { label: "Frequent fields", value: "Political Science, Sociology, Anthropology and History" },
        ],
        sections: [
          {
            title: "Program profile",
            body:
              "Erasmus+ International Credit Mobility connects UMSS with European universities through institutional agreements that allow students to complete a study period abroad, strengthen intercultural skills and build academic pathways with international reach.",
          },
          {
            title: "Academic preparation",
            items: [
              "Review the academic offer published by the host university.",
              "Prepare the Learning Agreement or study plan before mobility.",
              "Consult DRIC offices about study recognition and internal application steps.",
            ],
          },
          {
            title: "Typical coverage",
            items: [
              "Monthly support for accommodation and subsistence, according to each call.",
              "Airfare support when specified in the call.",
              "Places, eligible fields and required documents may vary by university and academic year.",
            ],
          },
        ],
        reference: {
          label: "Erasmus+ ICM UHK information",
          href: "https://www.uhk.cz/en/philosophical-faculty/exchanges/erasmus/international-credit-mobility",
        },
        calls: [
          {
            title: "International mobility in the Czech Republic / UHK - February 2026",
            description:
              "Under the agreement with the University of Hradec Králové (UHK), funded by Erasmus+ International Credit Mobility, students are invited to apply for a study period.",
            benefits: ["Accommodation and subsistence support: 3,400 € total.", "Airfare: 1,735 €."],
            documents: [
              "Available course list: list-of-courses-2026_2027.pdf (winter semester).",
              "UHK February 2026 call.pdf.",
              "Learning Agreement (study plan).",
            ],
            deadline: "March 10, 2026.",
            note: "Fields: Political Science, Sociology, Anthropology and History. Places available: 2.",
          },
          {
            title: "International mobility in the Czech Republic / UHK - June 2025",
            description:
              "Call for a study period at the University of Hradec Králové (UHK), Czech Republic, under Erasmus+ ICM.",
            benefits: ["Accommodation and subsistence support: 3,400 € total.", "Airfare: 1,735 €."],
            documents: [
              "Available course list: list-of-courses.pdf (summer semester).",
              "UHK June 2025 call.pdf.",
              "Learning Agreement (study plan).",
            ],
            deadline: "August 8, 2025.",
            note: "Fields: Political Science, Sociology, Anthropology and History. Places available: 2.",
          },
          {
            title: "Undergraduate study mobility / UHK - January 2025",
            description:
              "Call for undergraduate study mobility at the University of Hradec Králové (UHK), Czech Republic.",
            benefits: ["Accommodation and subsistence support: 3,200 € total.", "Airfare: 1,500 €."],
            documents: [
              "Available course list: list-of-courses-20242025.pdf.",
              "UHK January 2025 call.",
              "Learning Agreement (study plan).",
            ],
            deadline: "March 6, 2025 (extended deadline).",
            note: "Fields: Political Science, Sociology, Anthropology and History. Places available: 1.",
          },
          {
            title: "Erasmus+ KA171 / University of Deusto - spring semester 2024/25",
            description:
              "Call for UMSS undergraduate students to complete a study period during the 2024/25 spring semester at the University of Deusto, Spain.",
            benefits: ["Accommodation and subsistence support: 850 €/month, maximum 5 months.", "Airfare: 1,500 €."],
            documents: ["Review the academic offer.", "Deusto call."],
            deadline: "November 1, 2024, until 16:00.",
            note: "Places available: 1.",
          },
          {
            title: "Undergraduate study mobility / UHK - July 2024",
            description:
              "Call for undergraduate study mobility at the University of Hradec Králové (UHK), Czech Republic, under Erasmus+ ICM.",
            benefits: ["Accommodation and subsistence support: 3,200 € total.", "Airfare: 1,500 €."],
            documents: ["UHK July 2024 call.", "Learning Agreement (study plan)."],
            deadline: "August 12, 2024, until 17:30.",
            note: "Fields: Political Science, Sociology, Anthropology and History. Places available: 1.",
          },
          {
            title: "Undergraduate study mobility / UHK - January 2024",
            description:
              "Call for undergraduate study mobility at the University of Hradec Králové (UHK), Czech Republic, under Erasmus+ ICM.",
            benefits: ["Accommodation and subsistence support: 3,200 € total.", "Airfare: 1,500 €."],
            documents: ["UHK January 2024 call.pdf.", "Learning Agreement (study plan)."],
            deadline: "February 21, 2024.",
            note: "Fields: Political Science, Sociology, Anthropology and History. Places available: 2.",
          },
          {
            title: "Undergraduate study mobility / UHK - August 2023",
            description:
              "Undergraduate study mobility opportunity at the University of Hradec Králové (UHK), Czech Republic.",
            benefits: ["Accommodation and subsistence support: 800 €/month.", "Airfare."],
            documents: ["Download call.", "Learning Agreement (study plan)."],
            deadline: "August 1, 2023.",
            note: "Fields: Political Science, Sociology, Anthropology, History and Social Work. Places available: 1.",
          },
          {
            title: "Undergraduate study mobility / UHK - Erasmus+ 2022",
            description:
              "Call for undergraduate study mobility at the University of Hradec Králové (UHK), Czech Republic.",
            benefits: ["Accommodation and subsistence support: 800 €/month.", "Airfare."],
            documents: ["Download call.", "Learning Agreement (study plan).", "Study recognition commitment."],
            deadline: "February 10, 2022.",
            note: "Fields: Political Science, Sociology, Anthropology and Social Work.",
          },
          {
            title: "Study mobility / UHK - Erasmus+ 2021",
            description:
              "Opportunity for undergraduate study mobility at the University of Hradec Králové (UHK).",
            documents: ["Call document.", "Institutional information."],
            deadline: "September 24, 2021.",
          },
          {
            title: "Student mobility / University of Valladolid",
            description:
              "Call for undergraduate, master's and doctoral student mobility under the agreement between UMSS and the University of Valladolid.",
            documents: ["UVAMobPlus program information."],
            deadline: "September 20, 2021.",
            note: "The University of Valladolid expressed particular interest in doctoral applications and undergraduate applications for programs taught in English.",
          },
          {
            title: "Doctoral mobility / UHK - March 2021",
            description:
              "Call for doctoral student mobility between UMSS and the University of Hradec Králové under Erasmus+.",
          },
        ],
      },
      {
        title: "AUGM Undergraduate Student Scale Program (PEEG)",
        tag: "AUGM",
        summary:
          "Supports the construction of a common regional academic space through student mobility. Calls indicate participating universities, conditions, and available places.",
        conditions: ["The host university covers accommodation and meals according to its conditions."],
        highlights: [
          { label: "Academic network", value: "Association of Universities Grupo Montevideo (AUGM)" },
          { label: "Level", value: "Undergraduate students" },
          { label: "Scope", value: "Regional international mobility" },
          { label: "Frequent destinations", value: "Argentina, Brazil, Paraguay and Uruguay" },
        ],
        sections: [
          {
            title: "Regional integration",
            body:
              "The Undergraduate Student ESCALA Program is one of AUGM's most important initiatives to consolidate a regional university community. It allows UMSS students to complete an academic period at member universities, broaden their education and strengthen academic networks across Latin America.",
          },
          {
            title: "Application",
            items: [
              "Fields and places vary by host university and must be reviewed in each call.",
              "Documents are submitted to DRIC offices or by institutional email when indicated by the call.",
              "The study contract or PEEG form must be duly signed before evaluation.",
            ],
          },
          {
            title: "Financial support",
            items: [
              "The host university covers accommodation and meals or subsistence according to its conditions.",
              "The student covers international travel and health insurance when specified in the call.",
              "Some calls include airfare as part of the available support.",
            ],
          },
        ],
        reference: {
          label: "Undergraduate Student ESCALA Program",
          href: "http://grupomontevideo.org/escalagrado/",
        },
        calls: [
          {
            title: "PEEG Program - Call II/25",
            description:
              "Call for undergraduate international student mobility with AUGM member universities in Argentina, Brazil and Paraguay.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "The student covers international travel and health insurance.",
            ],
            documents: [
              "Study contract, duly signed.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Regular student certificate issued by Records and Enrollment.",
              "Motivation letter describing objectives and expected benefits.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Download the call.",
            ],
            deadline: "October 27, 2025.",
            note:
              "Universities: UNDMP and UNNE (Argentina), USP, FURG and UFSM (Brazil), UNA (Paraguay). Fields vary by university.",
          },
          {
            title: "PEEG Program - Call II/24",
            description:
              "Call for undergraduate international student mobility with universities in Argentina, Paraguay and Brazil.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form, duly signed.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Regular student certificate.",
              "Motivation letter addressed to the Selection Committee.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Download the call.",
            ],
            deadline: "October 27, 2025.",
            note:
              "Universities: UNNOBA (Argentina), UNA (Paraguay), FURG and UNICAMP (Brazil). Fields vary by university.",
          },
          {
            title: "PEEG Program - Call I/24",
            description:
              "Undergraduate international student mobility with universities in Argentina, Brazil, Paraguay and Uruguay.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form, duly signed.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Regular student certificate.",
              "Motivation letter addressed to the Selection Committee.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Download the call.",
            ],
            deadline: "October 20, 2023.",
            note:
              "Universities: UNL, UNSL, UFABC, FURG, UNICAMP, UNI and UDELAR. Fields vary by university.",
          },
          {
            title: "PEEG Program - Call II/23 (closed)",
            description:
              "Closed call for undergraduate international student mobility with universities in Argentina, Brazil, Paraguay and Uruguay.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "PEEG-1 form, duly signed.",
              "PEEG-2 Study Contract, duly signed.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Regular student certificate.",
              "Motivation letter addressed to the Selection Committee.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Download the call.",
            ],
            deadline: "May 15, 2023.",
            note:
              "Universities: UNCuyo, UNL, UNMdP, UNNE, UNSL, FURG, UFRGS, UFSC, UNICAMP, UNI and UDELAR. Fields vary by university.",
          },
          {
            title: "PEEG Program - Call I/23",
            description:
              "Call for undergraduate international student mobility with AUGM member universities.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "PEEG-1 form, duly signed.",
              "PEEG-2 Study Contract, duly signed.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Regular student certificate.",
              "Motivation letter addressed to the Selection Committee.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Download the call.",
            ],
            deadline: "October 7, 2022.",
            note:
              "Universities: UNCuyo, UNLP, UNMdP, UNNE, UNQ, UFSC, UNICAMP, UFRGS, UNCp and UNA. Fields vary by university.",
          },
          {
            title: "PEEG Program - Call II/22",
            description:
              "Call for student mobility with universities in Argentina, Paraguay and Brazil, open to all fields.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form duly signed, including the study contract (Learning Agreement).",
              "Passport or identity card.",
              "Transcript.",
              "Letter from the Program Director certifying the year of study.",
              "Motivation letter addressed to the Selection Committee.",
              "Document certifying Portuguese language knowledge, when applicable.",
              "Curriculum Vitae.",
              "Download the call.",
              "Download application form.",
            ],
            deadline: "May 13, 2022.",
            note:
              "Universities: UBA, UNMdP, UNT and UNNE (Argentina), UNC and UNA (Paraguay), UFRGS (Brazil).",
          },
        ],
      },
      {
        title: "MARCA MERCOSUR Program",
        tag: "MERCOSUR",
        summary:
          "Allows student exchanges, generally for one academic semester, in accredited programs such as Agronomy, Architecture, Medicine, and engineering fields. Calls are managed by the respective faculties.",
        conditions: [
          "Only students from accredited programs may participate.",
          "Interested students must consult call information through their respective academic programs.",
          "The student receives financial support during the stay for accommodation and meals.",
        ],
        highlights: [
          { label: "Regional framework", value: "Educational MERCOSUR" },
          { label: "Participation", value: "Accredited academic programs" },
          { label: "Typical duration", value: "One academic semester" },
          { label: "Management", value: "Information handled by each academic program" },
        ],
        sections: [
          {
            title: "Accredited mobility",
            body:
              "The MARCA MERCOSUR Program promotes student mobility in accredited programs, strengthening academic quality, regional integration and recognition of academic pathways within the MERCOSUR university space.",
          },
          {
            title: "Eligible programs",
            items: [
              "Medicine.",
              "Agronomy.",
              "Architecture.",
              "Electrical Engineering.",
              "Mechanical Engineering.",
              "Chemical Engineering.",
              "Industrial Engineering.",
              "Civil Engineering.",
            ],
          },
          {
            title: "Consultation route",
            items: [
              "Consult first with the corresponding accredited academic program.",
              "Verify whether there is an active call, available places and host university.",
              "Coordinate institutional steps with DRIC once the academic program confirms the opportunity.",
            ],
          },
        ],
        calls: [
          {
            title: "MARCA MERCOSUR Program - current and past calls",
            description:
              "MARCA MERCOSUR calls are opened for students from accredited programs. Specific information for each process must be consulted through the corresponding academic program.",
            benefits: ["Financial support during the stay for accommodation and meals."],
            documents: [
              "Required documents are defined in each call.",
              "The accredited academic program provides requirements, deadlines and internal procedures.",
            ],
            note:
              "Accredited programs: Medicine, Agronomy, Architecture, Electrical Engineering, Mechanical Engineering, Chemical Engineering, Industrial Engineering and Civil Engineering.",
          },
        ],
      },
      {
        title: "CRISCOS Student Mobility Program (PME)",
        tag: "CRISCOS",
        summary:
          "Enables students from universities in the subregion to complete part of their studies at another participating institution. Calls detail conditions and available places.",
        conditions: [
          "Regular undergraduate students may participate, except students from annualized programs.",
          "Students must review the academic offer and scholarship conditions of each university.",
          "The host university covers accommodation and meals according to its conditions.",
          "International transportation and health insurance are covered by the student.",
        ],
        highlights: [
          { label: "Network", value: "Council of Rectors for the Integration of the Central-Western Subregion of South America" },
          { label: "Countries", value: "Argentina, Bolivia, Chile, Ecuador, Paraguay and Peru" },
          { label: "Level", value: "Undergraduate" },
          { label: "Latest call", value: "PME No. 51 - deadline October 15, 2025" },
        ],
        sections: [
          {
            title: "Subregional cooperation",
            body:
              "CRISCOS brings together universities from the Central-Western subregion of South America to expand academic, scientific, technological and cultural cooperation. Its Student Mobility Program allows undergraduate students to complete part of their studies at a participating university.",
          },
          {
            title: "Core documents",
            items: [
              "Application form, duly signed.",
              "Previous commitment for recognition of studies.",
              "Regular student certificate issued by Records and Enrollment.",
              "Passport or identity card.",
              "Transcript or academic record, not from WEBSISS.",
              "Documented Curriculum Vitae.",
              "Motivation letter addressed to the Selection Committee.",
              "Academic offer 51.",
              "Call 51.",
            ],
          },
          {
            title: "Application strategy",
            items: [
              "Consider three or four university options when the call recommends it.",
              "Compare academic offer, calendar, accommodation and meal conditions before choosing a destination.",
              "Confirm current requirements and submission process with DRIC before the deadline.",
            ],
          },
        ],
        reference: {
          label: "PME - CRISCOS calls",
          href: "https://dric.umss.edu.bo/convocatorias-pme/",
        },
        calls: [
          {
            title: "PME / Call No. 51",
            description:
              "Undergraduate international student mobility with participating universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "International transportation and health insurance are covered by the student.",
            ],
            documents: [
              "Application form duly signed, preferably considering 3 or 4 options.",
              "Previous commitment for recognition of studies.",
              "Regular student certificate issued by Records and Enrollment.",
              "Passport or identity card.",
              "Transcript or academic record, not from WEBSISS.",
              "Documented Curriculum Vitae.",
              "Motivation letter addressed to the Selection Committee.",
            ],
            deadline: "October 15, 2025.",
            note:
              "Destinations: Argentina, Chile, Ecuador, Paraguay and Peru. All undergraduate programs participate, except annualized programs.",
          },
          {
            title: "PME / Call No. 50",
            description:
              "Undergraduate student mobility with universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "International transportation and insurance are covered by the student.",
            ],
            documents: [
              "Application form duly signed, considering 3 or 4 options is recommended.",
              "Previous commitment for recognition of studies.",
              "Regular student certificate issued by Records and Enrollment.",
              "Passport or identity card.",
              "Transcript or academic record, not from WEBSISS.",
              "Documented Curriculum Vitae.",
              "Motivation letter addressed to the Selection Committee.",
              "Academic offer 50.",
              "Call 50.",
            ],
            deadline: "May 15, 2025.",
            note:
              "Destinations available in Argentina, Chile, Ecuador, Paraguay and Peru. All undergraduate programs participate, except annualized programs.",
          },
          {
            title: "PME / Call No. 48",
            description:
              "International student mobility with universities in Argentina, Ecuador, Chile, Paraguay and Peru.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "International transportation and insurance are covered by the student.",
            ],
            documents: [
              "Application form duly signed, considering 3 options is recommended.",
              "Previous commitment for recognition of studies.",
              "Regular student certificate issued by Records and Enrollment.",
              "Passport or identity card.",
              "Transcript or academic record, not from WEBSISS.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Motivation letter addressed to the Selection Committee.",
              "Academic offer 48.",
              "Convocatoria48.pdf.",
            ],
            deadline: "April 30, 2024.",
            note:
              "Destinations available in Argentina, Ecuador, Chile, Paraguay and Peru. All undergraduate programs participate, except annualized programs.",
          },
          {
            title: "PME / Call No. 47",
            description:
              "Student mobility with universities in Argentina, Chile, Ecuador, Paraguay and Peru, with academic offer and conditions reviewed by university.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "International transportation and insurance are covered by the student.",
            ],
            documents: [
              "Application form duly signed, considering 3 options is recommended.",
              "Previous commitment for recognition of studies.",
              "Regular student certificate issued by Records and Enrollment.",
              "Passport or identity card.",
              "Transcript or academic record.",
              "Documented Curriculum Vitae, only with information related to the field.",
              "Motivation letter addressed to the Selection Committee.",
              "47th Academic offer.pdf.",
              "Call 47.pdf.",
            ],
            deadline: "October 10, 2023.",
            note:
              "Highlighted requirements: be a regular UMSS student, have completed at least 40% of the degree, have an average above 70 and not have participated in previous mobility programs.",
          },
          {
            title: "PME / Call No. 46",
            description:
              "Student mobility with universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: [
              "The host university covers accommodation and subsistence during the stay according to its conditions.",
              "International transportation and insurance are covered by the student.",
            ],
            documents: ["46th Academic offer.pdf.", "Call 46.pdf."],
            deadline: "May 5, 2023.",
            note:
              "Destinations available in Argentina, Chile, Ecuador, Paraguay and Peru, with CRISCOS network universities.",
          },
        ],
      },
      {
        title: "PUMA / CRULA - AUF Program",
        tag: "AUF",
        summary:
          "Allows undergraduate students to complete an in-person student exchange in Latin America with institutions participating in the PUMA program.",
        conditions: [
          "Tuition fee waiver.",
          "The home university covers international transportation.",
          "The host university covers accommodation and meals.",
        ],
        highlights: [
          { label: "Network", value: "CRULA - Agence Universitaire de la Francophonie" },
          { label: "2023 destination", value: "National University of Cuyo (UNCUYO)" },
          { label: "Duration", value: "90 to 180 days" },
          { label: "Places", value: "1 selected student and 1 alternate" },
        ],
        sections: [
          {
            title: "Francophone mobility",
            body:
              "The PUMA Program connects Latin American universities that are members of AUF through in-person mobility experiences. The call invites undergraduate students to take courses, transfer credits and join a regional academic community with a Francophone orientation.",
          },
          {
            title: "Program objectives",
            items: [
              "Complete an internationalization experience that allows students to take courses and have them recognized.",
              "Strengthen network life among Latin American universities that are members of AUF.",
              "Promote a supportive Francophonie through participation in events for learning and disseminating French.",
              "Encourage mobility in Latin America and open paths for future bilateral cooperation projects.",
            ],
          },
          {
            title: "Fields and destination",
            items: [
              "Destination of the second 2022-2023 call: National University of Cuyo (UNCUYO), Argentina.",
              "All disciplinary fields participate, except programs from Instituto Balseiro.",
              "Mobility was planned for the second semester of 2023, from August to December.",
            ],
          },
        ],
        reference: {
          label: "UNCUYO academic offer",
          href: "https://www.uncuyo.edu.ar/estudios",
        },
        calls: [
          {
            title: "Second PUMA Call 2022-2023",
            description:
              "DRIC announces that the Regional Conference of Rectors of Latin American Universities (CRULA), members of AUF, invites UMSS undergraduate students to apply for in-person mobility at the National University of Cuyo.",
            benefits: [
              "Tuition fee waiver.",
              "The home university covers international transportation.",
              "The host university covers accommodation and meals.",
            ],
            documents: ["PUMA February call.pdf.", "Mobility proposal."],
            links: [
              {
                label: "UNCUYO fields",
                href: "https://www.uncuyo.edu.ar/estudios",
              },
              {
                label: "PUMA February call.pdf",
                href: "https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/EZDsSJ_A02BPgamErc51cqQByTEJaUE5wyflCWLdokF17g?e=4VUgCQ",
              },
              {
                label: "Mobility proposal",
                href: "https://miumssedu-my.sharepoint.com/:w:/g/personal/dric_mi_umss_edu/EVs1QwpxX0lIh5f1bhWxTiwBFfN3HhIIt07FPg-xqdFP-A?e=XPKuru",
              },
            ],
            deadline: "April 14, 2023.",
            note:
              "Places: 1. One selected student and one alternate will be chosen. Duration: 90 to 180 days.",
          },
        ],
      },
      {
        title: "IAESTE Bolivia Paid Internships",
        tag: "Internships",
        summary:
          "Allows students to complete paid virtual or in-person internships offered by international companies. Outstanding UMSS students may receive a 50% reduction in the IAESTE platform usage cost.",
        conditions: [
          "Open to regular UMSS students; graduates and recent graduates participate only when the call indicates it.",
          "A grade average above 70 is recommended, or it may be complemented with documented merits.",
          "The international company provides a monthly payment for subsistence, according to each call.",
          "Airfare, health insurance and visa processing are covered by the student.",
          "Regular student status must be maintained during the internship when required by the call.",
        ],
        highlights: [
          { label: "Visible cycle", value: "2026 calls" },
          { label: "Format", value: "Paid international internships" },
          { label: "Initial contact", value: "m.zambrana@umss.edu" },
          { label: "UMSS benefit", value: "50% platform discount for outstanding students" },
        ],
        sections: [
          {
            title: "How to apply",
            body:
              "IAESTE connects students with international companies and institutions seeking strong profiles. The first step is to email the institutional contact with a transcript or academic record; if the average is not above 70, the profile may be strengthened with documented merits and a Curriculum Vitae.",
          },
          {
            title: "Profile criteria",
            items: [
              "Strong academic average and clear fit with the profile requested by the company.",
              "Documented merits such as distinctions, awards, internships, volunteering, courses or other relevant experience.",
              "Availability to maintain regular student status during the internship period when required.",
            ],
          },
          {
            title: "Future calls",
            items: [
              "This page displays only the 2026 cycle to avoid a long repetitive archive.",
              "Each new internship can be published as a specific call with country, field, company, language, deadline and PDF.",
              "Participation in IAESTE does not exclude applications to other mobility calls.",
            ],
          },
        ],
        reference: {
          label: "IAESTE calls - DRIC",
          href: "https://dric.umss.edu.bo/convocatorias-iaeste/",
        },
        calls: [
          {
            title: "ES-2026-8400 / Spain",
            description:
              "Paid international internship for regular students with at least 4 years of study. The applicant must remain a regular student during the internship.",
            benefits: ["Monthly subsistence payment provided by the international company, according to the call conditions."],
            documents: [
              "Transcript or academic record to start the process.",
              "Curriculum Vitae if the average must be complemented with additional merits.",
              "ES-2026-8400.pdf.",
            ],
            deadline: "February 23, 2026.",
            note:
              "Field: Computer Science, Systems Engineering. Company/Institution: Dismuntel S.L. Language: English (C1, C2).",
          },
          {
            title: "DE-2026-2101-1 / Germany",
            description:
              "Paid international internship for regular students with at least 3 years of study. The applicant must remain a regular student during the internship.",
            benefits: ["Monthly subsistence payment provided by the international company, according to the call conditions."],
            documents: [
              "Transcript or academic record to start the process.",
              "Curriculum Vitae if the average must be complemented with additional merits.",
              "DE-2026-2101-1.pdf.",
            ],
            deadline: "February 23, 2026.",
            note:
              "Field: Biochemistry, Biology, Biotechnology. Company/Institution: Universitat Bayreuth Lehrstuhl Biochemie III. Language: English (B1, B2).",
          },
        ],
      },
      {
        title: "IDB Paid Internships",
        tag: "IDB",
        summary:
          "Allows undergraduate and graduate students to complete paid internships at the headquarters in Washington, local offices in Latin America, the Caribbean, Asia and Europe, and INTAL in Argentina.",
        conditions: [
          "Aimed at talented students seeking professional experience in international development.",
          "Conditions, requirements and dates are specified in each call published by the IDB Group.",
          "Internships may take place at Washington D.C. headquarters, local offices or INTAL, depending on availability.",
        ],
        highlights: [
          { label: "Institution", value: "IDB Group: IDB, IDB Invest and IDB Lab" },
          { label: "Field", value: "International development" },
          { label: "Main location", value: "Washington D.C." },
          { label: "Schedule", value: "Washington: winter and summer; local offices according to need" },
        ],
        sections: [
          {
            title: "Internship program",
            body:
              "The IDB Group Paid Internship Program seeks talented students who want to gain professional experience in projects connected to international development. Opportunities may open at IDB, IDB Invest and IDB Lab.",
          },
          {
            title: "Formats",
            items: [
              "Washington D.C. internships last two months: January 16 to March 15 in winter and June 16 to August 15 in summer.",
              "Each competitive Washington process begins approximately three months in advance.",
              "Remote internships in local offices do not have a predefined schedule; dates are set according to institutional needs.",
            ],
          },
          {
            title: "Where to check",
            items: [
              "Review the official IDB Group internship portal frequently.",
              "Check the portal schedule for Washington D.C. updates.",
              "Follow official IDB Group channels for new local-office positions.",
            ],
          },
        ],
        reference: {
          label: "IDB Group internship portal",
          href: "https://jobs.iadb.org/es/pasantias",
        },
        calls: [
          {
            title: "IDB Group Paid Internship Program",
            description:
              "Paid opportunities to gain professional experience in international development at IDB, IDB Invest and IDB Lab, with positions in Washington D.C., offices in Latin America, the Caribbean, Asia and Europe, and INTAL in Argentina.",
            benefits: [
              "Professional experience in international development.",
              "Participation in IDB Group teams according to the available position.",
              "In-person or remote formats according to location and call.",
            ],
            documents: [
              "Review specific requirements in each published position.",
              "Check the official schedule for Washington D.C. internships.",
              "Prepare academic and professional documents according to the call.",
            ],
            links: [
              { label: "IDB", href: "https://www.iadb.org/es" },
              { label: "IDB Invest", href: "https://www.idbinvest.org/es" },
              { label: "IDB Lab", href: "https://bidlab.org/es" },
              { label: "IDB Group internships", href: "https://jobs.iadb.org/es/pasantias" },
            ],
            note:
              "Washington D.C. has winter and summer cycles. Local offices publish internships according to business needs, so the portal should be checked often.",
          },
        ],
      },
      {
        title: "Global Connect Fellowship (GCF) - Singapore",
        tag: "Research",
        summary:
          "An opportunity for young scholars to spend two or three months conducting research under the mentorship of world-leading professors, aimed at bachelor's and master's students with strong research interest.",
        conditions: [
          "Aimed at outstanding bachelor's and master's students with strong research interest.",
          "For the 2026 Summer Intake, bachelor's or Master's by Research students graduating in 2026 or 2027 are eligible.",
          "The fellowship includes a fellowship amount and accommodation, according to NTU's official conditions.",
        ],
        highlights: [
          { label: "University", value: "Nanyang Technological University (NTU), Singapore" },
          { label: "2026 period", value: "July 1 to August 31, 2026" },
          { label: "Fellowship", value: "SGD 5,000" },
          { label: "Application", value: "January 15 to February 15, 2026" },
        ],
        sections: [
          {
            title: "Frontier research",
            body:
              "The Global Connect Fellowship is a prestigious opportunity for young scholars to conduct research on NTU Singapore's international campus under the mentorship of world-renowned faculty. It is designed for students with research drive and ambition to work on global challenges.",
          },
          {
            title: "Research areas",
            items: [
              "Artificial intelligence, machine learning, cybersecurity and digital economy.",
              "Material science, smart manufacturing, 3D printing and sustainability.",
              "Health sciences, fintech, green finance and climate change.",
              "Humanities, arts, social sciences, leadership, international relations, security, diplomacy, entrepreneurship, education, media, design and communications.",
            ],
          },
          {
            title: "Academic experience",
            items: [
              "Participation in advanced research at a research-intensive public university.",
              "Mentorship from internationally recognized faculty and researchers.",
              "Exposure to a dynamic, international and innovation-oriented campus.",
            ],
          },
        ],
        reference: {
          label: "Official NTU Global Connect Fellowship site",
          href: "https://www.ntu.edu.sg/about-us/global/global-connect-fellowship",
        },
        calls: [
          {
            title: "Global Connect Fellowship - Summer Intake 2026",
            description:
              "Call for bachelor's or Master's by Research students graduating in 2026 or 2027 who are interested in completing two months of research at NTU Singapore.",
            benefits: ["Fellowship amount: SGD 5,000.", "Accommodation provided by NTU."],
            documents: [
              "Review requirements and application steps on NTU's official site.",
              "Prepare academic documents and research profile according to the official form.",
            ],
            links: [
              {
                label: "Official GCF site",
                href: "https://www.ntu.edu.sg/about-us/global/global-connect-fellowship",
              },
              {
                label: "Application Link",
                href: "https://venus2.wis.ntu.edu.sg/NG_APP/Pages/RegistrationIC.aspx",
              },
            ],
            deadline: "Application period: January 15 to February 15, 2026. Result notification: by end May 2026.",
            note:
              "Fellowship period: July 1 to August 31, 2026. NTU states that the 2026 edition lasts 2 months.",
          },
        ],
      },
    ] satisfies Program[],
    staffPrograms: [
      {
        title: "Interinstitutional Agreement",
        tag: "Agreements",
        summary:
          "Allows faculty or administrative mobility with universities that maintain bilateral agreements with UMSS.",
        conditions: [
          "Mobility is enabled only with institutions that maintain active agreements with UMSS.",
          "Interested faculty or administrative staff must contact DRIC to express interest and begin the process.",
          "Academic, administrative and financial conditions are defined according to the agreement and host institution.",
          "When no specific funding is available, expenses are covered by the participating faculty or administrative staff member.",
        ],
        highlights: [
          { label: "Format", value: "Faculty or administrative mobility" },
          { label: "Institutional basis", value: "Active UMSS agreements" },
          { label: "First step", value: "Express interest to DRIC" },
          { label: "Management", value: "Case-by-case coordination" },
        ],
        sections: [
          {
            title: "Specialized cooperation",
            body:
              "Mobility through Interinstitutional Agreements activates academic and administrative links with UMSS partner universities. It is a flexible pathway to strengthen teaching, management, research, good-practice exchange and new cooperation agendas.",
          },
          {
            title: "Institutional route",
            items: [
              "Check whether the institution of interest has an active agreement applicable to faculty or administrative mobility.",
              "Contact DRIC to register the interest and receive guidance on the procedure.",
              "Define objectives, tentative dates and institutional relevance with the academic or administrative unit.",
              "Coordinate acceptance, work agenda and specific conditions with the host university.",
            ],
          },
          {
            title: "Focus of the stay",
            items: [
              "Teaching, lectures, workshops or curricular collaboration.",
              "Research, technical meetings or preparation of joint projects.",
              "Exchange of experience in university management, internationalization or administrative processes.",
              "Strengthening institutional networks and following up active agreements.",
            ],
          },
        ],
        calls: [
          {
            title: "Calls through Interinstitutional Agreements",
            description:
              "Active agreements may allow faculty and administrative exchange or mobility. Interested applicants should contact DRIC to express interest and begin the corresponding process.",
            benefits: [
              "Institutional guidance to review the agreement, destination, relevance and application steps.",
              "Possibility to organize teaching, research, management or cooperation activities with partner universities.",
            ],
            documents: [
              "Initial note or communication expressing interest.",
              "Brief mobility proposal with objectives, destination institution and tentative dates.",
              "Updated Curriculum Vitae.",
              "Additional documents requested by DRIC, the corresponding unit or the host university.",
            ],
            deadline: "According to agreement availability, host institution calendar and coordination with DRIC.",
            note:
              "Specific call information, requirements and benefits will be updated according to each active agreement.",
          },
        ],
      },
      {
        title: "CRISCOS Academic Administrative Mobility Program (PMAA)",
        tag: "CRISCOS",
        summary:
          "Allows academic staff to complete teaching or research mobility. Administrative staff may also participate depending on the requirements of participating universities.",
        conditions: [
          "Faculty, researchers and administrative staff from CRISCOS universities may participate.",
          "Faculty may apply in all areas.",
          "Administrative staff apply in topics related to internationalization and/or university management.",
          "Accommodation, meals and airfare are covered according to each call's conditions.",
        ],
        highlights: [
          { label: "Network", value: "CRISCOS" },
          { label: "Profile", value: "Academic and administrative staff" },
          { label: "Recent places", value: "1 place per call" },
          { label: "Latest deadline", value: "October 10, 2025" },
        ],
        sections: [
          {
            title: "Academic administrative mobility",
            body:
              "The CRISCOS PMAA allows faculty, researchers and administrative staff to carry out academic, research, community engagement, internationalization or university management activities at another university in the network.",
          },
          {
            title: "Regional scope",
            items: [
              "Participating universities from Argentina, Chile, Ecuador, Paraguay and Peru.",
              "Academic offer and conditions are reviewed by university and by call.",
              "An exchange space designed to strengthen institutional capacities and subregional cooperation.",
            ],
          },
          {
            title: "Preparation",
            items: [
              "Review the academic offer and conditions of each university before applying.",
              "Download the call and application form corresponding to the active period.",
              "Coordinate documentation, internal deadlines and mobility relevance with DRIC.",
            ],
          },
        ],
        reference: {
          label: "PMAA - CRISCOS calls",
          href: "https://dric.umss.edu.bo/convocatorias-pmaa/",
        },
        calls: [
          {
            title: "14th PMAA Call",
            description:
              "Mobility for academic and administrative staff with universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: ["Accommodation and meals according to each university's conditions.", "Airfare."],
            documents: [
              "PMAA 14 Academic offer.",
              "14th Call.",
              "Application form.pdf.",
              "Review each university's conditions and academic offer.",
            ],
            deadline: "October 10, 2025.",
            note:
              "Areas: faculty, all areas; administrative staff, internationalization and/or university management. Places: 1 for academic or administrative staff.",
          },
          {
            title: "13th PMAA Call",
            description:
              "Mobility for academic and administrative staff with participating universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: ["Accommodation and meals according to each university's conditions.", "Airfare."],
            documents: [
              "PMAA 13 CRISCOS 2-2025.pdf.",
              "13th Call.",
              "Application form.pdf.",
              "Review each university's conditions and academic offer.",
            ],
            deadline: "May 5, 2025.",
            note:
              "Areas: faculty, all areas; administrative staff, internationalization and/or university management. Places: 1 for academic or administrative staff.",
          },
          {
            title: "11th PMAA Call",
            description:
              "Mobility for academic and administrative staff with universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: ["Accommodation and meals according to each university's conditions.", "Airfare."],
            documents: [
              "PMAA CRISCOS 2-2024.pdf.",
              "48th Call.",
              "Application form.pdf.",
              "Review each university's conditions and academic offer.",
            ],
            deadline: "April 30, 2024.",
            note:
              "Areas: faculty, all areas; administrative staff, internationalization and/or university management.",
          },
          {
            title: "10th PMAA Call",
            description:
              "Mobility for academic and administrative staff with universities in Argentina, Chile, Ecuador, Paraguay and Peru.",
            benefits: ["Accommodation and meals during the stay, according to each university's conditions.", "Airfare."],
            documents: [
              "PMAA CRISCOS 1-2024.pdf.",
              "Download the call.",
              "Application form.pdf.",
            ],
            deadline: "October 10, 2023.",
            note:
              "Areas: faculty, all areas; administrative staff, internationalization and/or university management. Places: 1 for academic staff and 1 for administrative staff.",
          },
        ],
      },
      {
        title: "AUGM Faculty Scale Program (PED)",
        tag: "AUGM",
        summary:
          "Promotes regional cooperation and integration among AUGM member universities through faculty mobility and exchange, strengthening academic relations and joint research projects.",
        conditions: [
          "Aimed at UMSS faculty and researchers with more than two years of seniority.",
          "Applicants must not have benefited from another mobility program promoted by DRIC.",
          "Applicants must not have withdrawn after the deadline from an international mobility place obtained through previous DRIC calls.",
          "The home university covers international transportation.",
          "The host university covers accommodation and meals.",
        ],
        highlights: [
          { label: "Network", value: "Association of Universities Grupo Montevideo (AUGM)" },
          { label: "Profile", value: "Faculty and researchers" },
          { label: "Duration", value: "5 to 15 days" },
          { label: "Latest deadline", value: "October 28, 2025" },
        ],
        sections: [
          {
            title: "Academic cooperation",
            body:
              "The AUGM Faculty ESCALA Program promotes regional cooperation and integration through faculty mobility and exchange. Its purpose is to strengthen academic relations, open research conversations and support joint project development among member universities.",
          },
          {
            title: "Strategic application",
            items: [
              "Select universities whose academic offer connects with the applicant's teaching, research or extension line.",
              "Submit a clear, brief mobility proposal oriented toward institutional outcomes.",
              "Secure the invitation letter from the host university before submitting the application.",
              "Coordinate with DRIC the signatures of the Dean and the AUGM Advisor Delegate.",
            ],
          },
          {
            title: "Core documents",
            items: [
              "Application form signed by the Faculty Dean and the AUGM Advisor Delegate.",
              "Mobility proposal, when applicable, with a maximum length of 2 pages.",
              "Invitation letter from the host university.",
              "Motivation letter addressed to the Selection Committee.",
              "Certificate issued by DPA accrediting seniority and status.",
              "Documented CV or summarized documented CV, according to the call.",
              "Identity card or passport when requested by the call.",
            ],
          },
        ],
        reference: {
          label: "AUGM Faculty ESCALA",
          href: "https://grupomontevideo.org/escaladocente/",
        },
        calls: [
          {
            title: "PED Program - Call II/25",
            description:
              "Faculty and researcher mobility with universities in Argentina, Brazil and Paraguay. Areas vary by university and must be reviewed in the call.",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate. Submitting 2 options is suggested.",
              "Mobility proposal, maximum 2 pages.",
              "Invitation letter from the host university, agreeing mobility between March and July.",
              "Invitation letter template.",
              "Motivation letter addressed to the Selection Committee.",
              "DPA certificate of seniority and status.",
              "Summarized documented CV.",
              "Identity card or passport.",
              "Download the call.",
            ],
            links: [
              { label: "PED calls - DRIC", href: "https://dric.umss.edu.bo/convocatorias-programa-escala-docente-ped/" },
              { label: "AUGM Faculty ESCALA", href: "https://grupomontevideo.org/escaladocente/" },
            ],
            deadline: "October 28, 2025.",
            note:
              "Universities: UBA, UNNE and National University of Mar del Plata (Argentina), USP and UFSM (Brazil), UNA (Paraguay). Duration: between 5 and 15 days.",
          },
          {
            title: "PED Program - Call II/24",
            description:
              "Faculty and researcher mobility with Federal University of ABC (Brazil) and University of the Republic (Uruguay).",
            benefits: [
              "The host university covers accommodation and meals according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate.",
              "Invitation letter.",
              "Invitation letter template.",
              "Motivation letter addressed to the Selection Committee.",
              "DPA certificate of seniority and status.",
              "Documented CV.",
              "Download the call.",
            ],
            deadline: "June 17, 2024.",
            note:
              "Areas vary by university. Duration: minimum 5 days and maximum 15 days.",
          },
          {
            title: "PED Program - Call I/24",
            description:
              "Faculty and researcher mobility with universities in Argentina, Brazil and Uruguay.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate.",
              "Invitation letter.",
              "Invitation letter template.",
              "Motivation letter addressed to the Selection Committee.",
              "DPA certificate of seniority and status.",
              "Documented CV.",
              "Download the call.",
            ],
            deadline: "October 23, 2023.",
            note:
              "Universities: UBA, UNSL, UFABC, UNICAMP and UDELAR. Priority is given to candidates who have not participated in mobility programs.",
          },
          {
            title: "PED Program - Call II/23",
            description:
              "Faculty and researcher mobility with universities in Argentina, Brazil and Paraguay.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate.",
              "Invitation letter from the host university signed by the Faculty authority and Advisor Delegate.",
              "Invitation letter template.",
              "Motivation letter addressed to the Selection Committee.",
              "DPA certificate of seniority and status.",
              "Documented CV.",
              "Download the call.",
            ],
            deadline: "May 29, 2023.",
            note:
              "Universities: UNNE, UFSC, UNICAMP, UNA and UNCp. Selection criteria are available in the call.",
          },
          {
            title: "PED Program - Call I/23",
            description:
              "Faculty and researcher mobility with AUGM member universities in Argentina, Brazil, Paraguay and Uruguay.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate.",
              "Invitation letter from the host university.",
              "Invitation letter template.",
              "Copy of academic record.",
              "Motivation letter.",
              "DPA certificate of seniority and status.",
              "Documented CV.",
              "Download the call.",
            ],
            deadline: "October 31, 2022.",
            note:
              "Universities: UBA, UNCUYO, UNLP, UNNE, UNR, UFSC, UNICAMP, UNA, UNCp and UDELAR. One place is listed as selected for Maritza Jimenez, FMED.",
          },
          {
            title: "PED Program - Call II/22",
            description:
              "Faculty and researcher mobility with universities in Argentina, Paraguay and Chile.",
            benefits: [
              "The host university covers accommodation and subsistence according to its conditions.",
              "Airfare.",
            ],
            documents: [
              "Application form signed by the Dean and the AUGM Advisor Delegate.",
              "Invitation letter from the host university.",
              "Copy of academic record.",
              "Motivation letter.",
              "DPA certificate of seniority and status.",
              "Documented CV.",
              "Download the call.",
              "Download the application form.",
            ],
            deadline: "May 20, 2022.",
            note:
              "Universities: UNT, UNNE and UNCUYO (Argentina), UNA (Paraguay), University of Valparaíso (Chile). Duration: minimum 5 days and maximum 15 days.",
          },
        ],
      },
      {
        title: "AUGM Managers and Administrators Scale Program (PEGyA)",
        tag: "AUGM",
        summary:
          "Promotes mobility and exchange among directors, managers, and administrative staff from AUGM member universities. It is oriented toward administrative staff and university authorities.",
        conditions: [
          "Aimed at administrative staff, managers, directors and university authorities.",
          "The stay must be connected to the applicant's specific area of responsibility.",
          "Mobility takes place at an AUGM member university located in a country different from the home university.",
          "The home university covers international transportation.",
          "The host university covers accommodation and meals.",
        ],
        highlights: [
          { label: "Network", value: "AUGM" },
          { label: "Profile", value: "Managers, administrative staff, directors and authorities" },
          { label: "Purpose", value: "Training and exchange in university management" },
          { label: "Coverage", value: "International transportation, accommodation and meals" },
        ],
        sections: [
          {
            title: "University management in network",
            body:
              "The AUGM Managers and Administrators ESCALA Program promotes cooperation among member universities through training and exchange stays. Its value lies in transferring good practices, strengthening institutional processes and opening collaboration channels among university management teams.",
          },
          {
            title: "Exchange areas",
            items: [
              "Internationalization, academic cooperation and agreement management.",
              "University administration, planning, processes and institutional improvement.",
              "Academic management, research support, outreach and university services.",
              "Leadership, team coordination and institutional capacity building.",
            ],
          },
          {
            title: "Stay preparation",
            items: [
              "Define concrete learning, exchange or administrative improvement objectives.",
              "Identify an AUGM member university with relevant experience for the work area.",
              "Coordinate the application route, dates, documents and institutional validation with DRIC.",
              "Plan return outputs: report, internal transfer, protocol, workshop or improvement proposal.",
            ],
          },
        ],
        reference: {
          label: "AUGM ESCALA Managers",
          href: "https://grupomontevideo.org/escalagestores/",
        },
        calls: [
          {
            title: "PEGyA Calls - AUGM",
            description:
              "The Managers and Administrators ESCALA Program calls enable mobility for administrative staff, managers, directors and university authorities from AUGM member universities.",
            benefits: [
              "The home university covers international transportation.",
              "The host university covers accommodation and meals.",
              "The stay strengthens management capacities and institutional cooperation.",
            ],
            documents: [
              "Review conditions and requirements from both the home university and host university.",
              "Prepare a stay proposal connected to the applicant's area of responsibility.",
              "Complete the forms or platform indicated by the active call.",
              "Coordinate enquiries and institutional validation with DRIC.",
            ],
            links: [
              { label: "AUGM ESCALA Managers", href: "https://grupomontevideo.org/escalagestores/" },
            ],
            deadline: "According to the active call schedule published by AUGM and DRIC internal coordination.",
            note:
              "This section is ready for future specific calls with dates, places, universities and documents.",
          },
        ],
      },
      {
        title: "ERASMUS+/ICM Program",
        tag: "Europe",
        summary:
          "Allows faculty and administrative staff to complete training or teaching stays at universities in Erasmus+ partner countries and vice versa.",
        conditions: [
          "Aimed at faculty, researchers and administrative staff, according to the mobility type indicated in each call.",
          "Stays may focus on teaching, training, research, doctoral traineeships or international staff weeks.",
          "The European Commission, through the coordinating institution, covers the expenses defined in each call.",
          "Requirements, selection criteria, places and documents must be reviewed in the corresponding call.",
        ],
        highlights: [
          { label: "Program", value: "Erasmus+ International Credit Mobility (ICM)" },
          { label: "Profiles", value: "Faculty, researchers, administrative staff and doctoral students depending on the call" },
          { label: "Recent destinations", value: "Czech Republic, Spain, Poland and Navarra" },
          { label: "Latest deadline", value: "August 19, 2024" },
        ],
        sections: [
          {
            title: "European mobility scope",
            body:
              "Erasmus+ ICM opens opportunities for university staff to teach, participate in specialized training or strengthen academic cooperation with European higher education institutions. Each call defines the profile, duration, destination and financial coverage.",
          },
          {
            title: "Frequent formats",
            items: [
              "Teaching mobility to deliver courses in English at partner universities.",
              "Staff mobility for training, international weeks and methodological updating.",
              "Academic-practical mobility for doctoral students when enabled by the call.",
              "Cooperation focused on research, teaching, laboratories and future alliance development.",
            ],
          },
          {
            title: "Application preparation",
            items: [
              "Review requirements, selection criteria and number of places carefully in each call.",
              "Arrange invitation letters early when required.",
              "Prepare mobility agreements, work programs or specific documents according to the type of stay.",
              "Coordinate application, institutional endorsement and final documentation with DRIC.",
            ],
          },
        ],
        reference: {
          label: "Erasmus+ ICM faculty and administrative calls - DRIC",
          href: "https://dric.umss.edu.bo/convocatorias-programa-erasmus/",
        },
        calls: [
          {
            title: "UHK Erasmus+/ICM teaching mobility - 2024",
            description:
              "Call for UMSS faculty and researchers interested in teaching a course in English to students from the Faculty of Arts at the University of Hradec Králové, Czech Republic.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, total 1,400 € for 8 days plus 2 travel days."],
            documents: ["Review requirements and selection criteria.", "Download the call."],
            links: [
              { label: "Erasmus+ ICM calls - DRIC", href: "https://dric.umss.edu.bo/convocatorias-programa-erasmus/" },
            ],
            deadline: "August 19, 2024.",
            note:
              "Areas: History, Sociology and Political Science. Places: 1 place / 8 days, preferably between October and November 2024.",
          },
          {
            title: "University of Granada - BIP Staff Training Week 2024",
            description:
              "Training week dedicated to Erasmus+ Blended Intensive Programmes, organized at the University of Granada's Ceuta campus.",
            benefits: ["Accommodation and subsistence.", "Round-trip ticket."],
            documents: ["Call.", "Provisional program."],
            deadline: "April 24, 2024.",
            note:
              "Aimed at faculty, researchers and administrative staff. Mobility type: staff training for the 31st Staff Training Week: Blended Intensive Programmes (BIP) and the New Mobility Opportunities within Erasmus+. Language: English. Places: 1.",
          },
          {
            title: "University of Valladolid / Erasmus+ KA171 - doctoral traineeships",
            description:
              "Call for enrolled doctoral students interested in a 5-month academic-practical mobility period at the University of Valladolid.",
            benefits: [
              "Accommodation and subsistence: 850 €/month for 5 months.",
              "Round-trip ticket: 1,500 €.",
              "Support for socioeconomic obstacles and accredited health problems: 250 €/month.",
              "Medical and travel assistance insurance: up to 250 €.",
              "Visa: up to 30 € additional.",
            ],
            documents: ["Call.", "Application form.", "Required invitation letter."],
            deadline: "May 2, 2024.",
            note:
              "Mobility type: Student Mobility for Traineeships (SMP). Activities may be funded in September 2024-February 2025 or February-July 2025. Places: 1.",
          },
          {
            title: "University of Deusto - International Week 2024",
            description:
              "Academic and administrative staff mobility to participate in the International Week A Transversal Approach on Internationalization.",
            benefits: ["Airfare.", "Accommodation and subsistence support."],
            documents: ["International Week call."],
            deadline: "February 28, 2024.",
            note: "Places: 1 place / 7 days. Language: English.",
          },
          {
            title: "Wroclaw University of Science and Technology - academic mobility 2024",
            description:
              "Call for UMSS academic staff interested in completing academic mobility in Poland.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, total 980 €."],
            documents: ["Wroclaw faculty call Feb 2024.pdf."],
            deadline: "February 23, 2024.",
            note:
              "Areas: Business and Administration, Architecture, Biochemistry, Computer Science, Systems Engineering, Electrical/Electronics, Mechanical, Civil Engineering and Chemistry. Places: 1 place / 7 days.",
          },
          {
            title: "Bialystok University of Technology - International Week 2024",
            description:
              "Erasmus+ grant for UMSS academic staff interested in participating in the International Week organized by BUT, Poland.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, total 980 €."],
            documents: ["BUT faculty call.pdf."],
            deadline: "November 23, 2023.",
            note:
              "Places: 1 place / 7 days, 5 days at BUT plus 2 travel days. Date to be defined during the first semester of 2024. Language: English.",
          },
          {
            title: "Bialystok University of Technology - International Week 2022",
            description:
              "Erasmus+ scholarship for UMSS academic staff interested in participating in the International Week organized by BUT, Poland.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, total 980 €."],
            documents: ["BUT faculty call October 2022.pdf."],
            deadline: "October 26, 2022.",
            note:
              "Places: 1 place / 7 days, 5 days at BUT plus 2 travel days. Date: December 12 to 16, 2022. Language: English.",
          },
          {
            title: "UHK Erasmus+/ICM Call II/22",
            description:
              "Call for UMSS faculty and researchers interested in teaching a course in English to students from the Faculty of Arts at UHK.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, maximum 8 days."],
            documents: ["Review requirements and selection criteria.", "Download the call."],
            deadline: "October 17, 2022.",
            note:
              "Areas: Sociology, Political Science, Anthropology and Psychology. Places/duration: 1 place / 8 days, preferably between March and April 2023.",
          },
          {
            title: "UHK Erasmus+/ICM Call I/22",
            description:
              "Call for UMSS faculty and researchers interested in teaching a course in English to students from the Faculty of Arts at UHK.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 140 €/day, maximum 7 days."],
            documents: ["Review requirements and selection criteria.", "Download the call."],
            deadline: "May 26, 2022.",
            note:
              "Areas: Sociology and Political Science. Places/duration: 1 place / 8 days, preferably between October and November 2022. Call declared void.",
          },
          {
            title: "Public University of Navarra - International Staff Week 2022",
            description:
              "Teaching/administrative mobility for staff connected to international affairs, for training purposes at UPNA's International Staff Week.",
            benefits: ["Airfare: 1,500 €.", "Accommodation and subsistence support: 160 €/day, maximum 7 days."],
            documents: ["Call.", "Staff Mobility Agreement Training."],
            links: [{ label: "UPNA information", href: "https://bit.ly/3MaZdI7" }],
            deadline: "April 29, 2022.",
            note: "Stay planned from June 13 to 17, 2022.",
          },
          {
            title: "University of Valladolid - Erasmus+ KA131 cooperation",
            description:
              "Cooperation opportunity for doctoral traineeships and research or teaching activities for recent postdoctoral graduates, funded by Erasmus+ and the University of Valladolid.",
            benefits: ["Expenses covered by the Erasmus+ Program and the University of Valladolid."],
            documents: ["Request offer documents from DRIC.", "Erasmus+ KA131 Interinstitutional Agreement for traineeships when applicable."],
            deadline: "According to coordination with DRIC and the University of Valladolid.",
            note:
              "Doctoral students: traineeships from 3 to 6 months. Recent postdoctoral graduates: research or teaching activities from 4 to 6 months.",
          },
        ],
      },
      {
        title: "INTERCOONECTA",
        tag: "Training",
        summary:
          "Training activities aimed mainly at public employees and professionals from public administrations in Latin America and the Caribbean, offered in both in-person and online formats.",
        conditions: [
          "Aimed mainly at public employees and professionals from public administrations in Latin America and the Caribbean.",
          "Activities seek to strengthen institutional capacities and encourage public policy changes in favor of sustainable human development.",
          "Format, requirements, dates and financial support are specified in each published activity.",
          "Activities may take place in person, online or through Spanish Cooperation training centers.",
        ],
        highlights: [
          { label: "Institution", value: "Spanish Cooperation - AECID" },
          { label: "Focus", value: "Knowledge transfer, exchange and management" },
          { label: "Region", value: "Latin America and the Caribbean" },
          { label: "Format", value: "In person and online" },
        ],
        sections: [
          {
            title: "Knowledge for development",
            body:
              "INTERCOONECTA is Spanish Cooperation's commitment to knowledge as an effective tool for development in Latin America and the Caribbean. Its purpose is to strengthen institutions, improve technical capacities and support public policies with development impact.",
          },
          {
            title: "Specialized training",
            items: [
              "Specialized technical training for professionals connected to public management.",
              "Activities designed to strengthen the organizations served by participants.",
              "Content focused on sustainable human development, cooperation, public policy and institutional innovation.",
            ],
          },
          {
            title: "Where it takes place",
            items: [
              "In-person training at Spanish Cooperation Training Centers in Latin America and the Caribbean.",
              "Activities hosted by public institutions in Spain.",
              "Online training through the INTERCOONECTA Virtual Classroom.",
              "Agenda published by activity and by training center.",
            ],
          },
        ],
        reference: {
          label: "INTERCOONECTA portal",
          href: "https://intercoonecta.aecid.es/",
        },
        calls: [
          {
            title: "INTERCOONECTA activity search",
            description:
              "INTERCOONECTA publishes training and capacity-building activities to strengthen institutional capacities in Latin America and the Caribbean. Programming can be searched by activity, training center and format.",
            benefits: [
              "Access to specialized technical training from Spanish Cooperation.",
              "Participation in knowledge-exchange spaces with regional scope.",
              "Strengthening institutional capacities oriented toward sustainable development.",
            ],
            documents: [
              "Review requirements, dates and financial support in each activity.",
              "Check the agenda published by the Training Centers.",
              "Complete the registration process indicated by INTERCOONECTA or the organizing center.",
            ],
            links: [
              { label: "INTERCOONECTA portal", href: "https://intercoonecta.aecid.es/" },
              {
                label: "Activity search",
                href: "https://intercoonecta.aecid.es/programaci%C3%B3n-de-actividades?accion=todas",
              },
              { label: "Cartagena de Indias Center", href: "http://www.aecidcf.org.co/" },
              { label: "Santa Cruz de la Sierra Center", href: "http://www.aecid-cf.bo/" },
              { label: "La Antigua Center", href: "https://cfantigua.aecid.es/" },
              { label: "Montevideo Center", href: "http://www.aecid.org.uy/CFCE/" },
            ],
            deadline: "According to each activity's programming and registration deadline.",
            note:
              "It is also recommended to review the agenda published by each Spanish Cooperation training center.",
          },
        ],
      },
    ] satisfies Program[],
  },
};

export function slugifyProgramTitle(title: string, trackId?: string) {
  const slug = title
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "");

  return trackId ? `${slug}-${trackId}` : slug;
}
