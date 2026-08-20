export type Program = {
  title: string;
  summary: string;
  conditions: string[];
  tag: string;
  reference?: {
    label: string;
    href: string;
  };
  calls?: Array<{
    title: string;
    description: string;
    benefits?: string[];
    documents?: string[];
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
      },
      {
        title: "Programa Escala de Estudiantes de Grado (PEEG) de AUGM",
        tag: "AUGM",
        summary:
          "Impulsa la construcción de un espacio académico común regional mediante la movilidad de estudiantes. Las convocatorias indican universidades participantes, condiciones y plazas disponibles.",
        conditions: ["La universidad receptora cubre alojamiento y alimentación de acuerdo con sus condiciones."],
      },
      {
        title: "Programa MARCA MERCOSUR",
        tag: "MERCOSUR",
        summary:
          "Permite intercambios estudiantiles, generalmente de un semestre académico, en carreras acreditadas como Agronomía, Arquitectura, Medicina e ingenierías. Las convocatorias se gestionan desde las respectivas facultades.",
        conditions: ["El estudiante recibe apoyo financiero durante su estadía para alojamiento y alimentación."],
      },
      {
        title: "Programa de Movilidad Estudiantil (PME) - CRISCOS",
        tag: "CRISCOS",
        summary:
          "Facilita que estudiantes de universidades de la subregión realicen parte de sus estudios en otra institución participante. Las convocatorias detallan condiciones y plazas disponibles.",
        conditions: ["El estudiante recibe apoyo financiero durante su estadía para alojamiento y alimentación."],
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
      },
      {
        title: "Pasantías Remuneradas IAESTE Bolivia",
        tag: "Pasantías",
        summary:
          "Permite realizar prácticas remuneradas, virtuales o presenciales, ofrecidas por empresas internacionales. Estudiantes destacados de la UMSS pueden acceder a una reducción del 50% del costo de uso de la plataforma IAESTE.",
        conditions: [
          "La empresa internacional cubre el pago mensual.",
          "El pasaje aéreo debe ser cubierto por el estudiante.",
        ],
      },
      {
        title: "Pasantías remuneradas BID",
        tag: "BID",
        summary:
          "Permite a estudiantes de pregrado y posgrado realizar pasantías remuneradas en la oficina central en Washington, oficinas locales en América Latina, el Caribe, Asia y Europa, y en INTAL en Argentina.",
        conditions: ["Las condiciones se especifican en cada convocatoria."],
      },
      {
        title: "Global Connect Fellowship (GCF) - Singapur",
        tag: "Investigación",
        summary:
          "Oportunidad para que jóvenes académicos realicen dos o tres meses de investigación bajo la tutoría de profesores líderes a nivel mundial, dirigida a estudiantes de licenciatura y maestría con interés en investigación.",
        conditions: ["Incluye alojamiento y una asignación mensual para cubrir gastos."],
      },
    ] satisfies Program[],
    staffPrograms: [
      {
        title: "Convenio Interinstitucional",
        tag: "Convenios",
        summary:
          "Permite realizar movilidad docente o administrativa con universidades que mantienen convenios bilaterales con la UMSS.",
        conditions: ["El docente o administrativo cubre todos los gastos."],
      },
      {
        title: "Programa de Movilidad Académica Administrativa (PMAA) - CRISCOS",
        tag: "CRISCOS",
        summary:
          "Permite movilidad para docencia o investigación al personal académico. El personal administrativo también puede realizar movilidad según los requerimientos de las universidades participantes.",
        conditions: ["Los gastos están cubiertos por la UMSS y por la universidad de destino."],
      },
      {
        title: "Programa Escala Docente (PED) de AUGM",
        tag: "AUGM",
        summary:
          "Promueve la cooperación e integración regional entre universidades miembro de AUGM mediante movilidad e intercambio docente, fortaleciendo relaciones académicas y proyectos conjuntos de investigación.",
        conditions: [
          "La universidad de origen cubre el traslado internacional.",
          "La universidad receptora cubre alojamiento y alimentación.",
        ],
      },
      {
        title: "Programa Escala de Gestores y Administradores (PEGyA) de AUGM",
        tag: "AUGM",
        summary:
          "Promueve la movilidad e intercambio de directivos, gestores y administrativos entre universidades miembro de AUGM. Está orientado al personal administrativo y autoridades universitarias.",
        conditions: [
          "La universidad de origen cubre el traslado internacional.",
          "La universidad receptora cubre alojamiento y alimentación.",
        ],
      },
      {
        title: "Programa ERASMUS+/ICM",
        tag: "Europa",
        summary:
          "Permite al personal docente y administrativo realizar estancias de formación o docencia en universidades de países socios de Erasmus+ y viceversa.",
        conditions: ["La Comisión Europea, a través de la institución coordinadora, cubre todos los gastos."],
      },
      {
        title: "INTERCOONECTA",
        tag: "Formación",
        summary:
          "Actividades formativas dirigidas principalmente a empleados públicos y profesionales de administraciones públicas de América Latina y el Caribe, con modalidades presenciales y en línea.",
        conditions: ["Las ayudas están especificadas en cada actividad."],
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
      },
      {
        title: "AUGM Undergraduate Student Scale Program (PEEG)",
        tag: "AUGM",
        summary:
          "Supports the construction of a common regional academic space through student mobility. Calls indicate participating universities, conditions, and available places.",
        conditions: ["The host university covers accommodation and meals according to its conditions."],
      },
      {
        title: "MARCA MERCOSUR Program",
        tag: "MERCOSUR",
        summary:
          "Allows student exchanges, generally for one academic semester, in accredited programs such as Agronomy, Architecture, Medicine, and engineering fields. Calls are managed by the respective faculties.",
        conditions: ["The student receives financial support during the stay for accommodation and meals."],
      },
      {
        title: "CRISCOS Student Mobility Program (PME)",
        tag: "CRISCOS",
        summary:
          "Enables students from universities in the subregion to complete part of their studies at another participating institution. Calls detail conditions and available places.",
        conditions: ["The student receives financial support during the stay for accommodation and meals."],
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
      },
      {
        title: "IAESTE Bolivia Paid Internships",
        tag: "Internships",
        summary:
          "Allows students to complete paid virtual or in-person internships offered by international companies. Outstanding UMSS students may receive a 50% reduction in the IAESTE platform usage cost.",
        conditions: [
          "The international company covers the monthly payment.",
          "Airfare must be covered by the student.",
        ],
      },
      {
        title: "IDB Paid Internships",
        tag: "IDB",
        summary:
          "Allows undergraduate and graduate students to complete paid internships at the headquarters in Washington, local offices in Latin America, the Caribbean, Asia and Europe, and INTAL in Argentina.",
        conditions: ["Conditions are specified in each call."],
      },
      {
        title: "Global Connect Fellowship (GCF) - Singapore",
        tag: "Research",
        summary:
          "An opportunity for young scholars to spend two or three months conducting research under the mentorship of world-leading professors, aimed at bachelor's and master's students with strong research interest.",
        conditions: ["Includes accommodation and a monthly allowance to cover expenses."],
      },
    ] satisfies Program[],
    staffPrograms: [
      {
        title: "Interinstitutional Agreement",
        tag: "Agreements",
        summary:
          "Allows faculty or administrative mobility with universities that maintain bilateral agreements with UMSS.",
        conditions: ["The faculty or administrative staff member covers all expenses."],
      },
      {
        title: "CRISCOS Academic Administrative Mobility Program (PMAA)",
        tag: "CRISCOS",
        summary:
          "Allows academic staff to complete teaching or research mobility. Administrative staff may also participate depending on the requirements of participating universities.",
        conditions: ["Expenses are covered by UMSS and the destination university."],
      },
      {
        title: "AUGM Faculty Scale Program (PED)",
        tag: "AUGM",
        summary:
          "Promotes regional cooperation and integration among AUGM member universities through faculty mobility and exchange, strengthening academic relations and joint research projects.",
        conditions: [
          "The home university covers international transportation.",
          "The host university covers accommodation and meals.",
        ],
      },
      {
        title: "AUGM Managers and Administrators Scale Program (PEGyA)",
        tag: "AUGM",
        summary:
          "Promotes mobility and exchange among directors, managers, and administrative staff from AUGM member universities. It is oriented toward administrative staff and university authorities.",
        conditions: [
          "The home university covers international transportation.",
          "The host university covers accommodation and meals.",
        ],
      },
      {
        title: "ERASMUS+/ICM Program",
        tag: "Europe",
        summary:
          "Allows faculty and administrative staff to complete training or teaching stays at universities in Erasmus+ partner countries and vice versa.",
        conditions: ["The European Commission, through the coordinating institution, covers all expenses."],
      },
      {
        title: "INTERCOONECTA",
        tag: "Training",
        summary:
          "Training activities aimed mainly at public employees and professionals from public administrations in Latin America and the Caribbean, offered in both in-person and online formats.",
        conditions: ["Financial support is specified in each activity."],
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
