export type Locale = "es" | "en";

export type LocalizedText = Record<Locale, string>;

export type NewsRecord = {
  id: string;
  title: LocalizedText;
  date: LocalizedText;
  publishedAt: string;
  category: LocalizedText;
  excerpt: LocalizedText;
  deck?: LocalizedText;
  image?: string;
  body?: {
    heading?: LocalizedText;
    paragraphs: LocalizedText[];
    bullets?: LocalizedText[];
  };
};

export type NewsItem = {
  id: string;
  title: string;
  date: string;
  publishedAt: string;
  category: string;
  excerpt: string;
  href: string;
};

export const newsSourceUrl = "https://dric.umss.edu.bo/convocatorias/noticias-eventos/";

export const newsCatalog: NewsRecord[] = [
  {
    id: "movilidad-academica-escala-docente-augm-brasil",
    title: {
      es: "Movilidad académica en el marco del Programa Escala Docente (PED) de AUGM, Brasil",
      en: "Academic mobility through the AUGM Faculty Scale Program (PED), Brazil",
    },
    date: { es: "Dic 17, 2024", en: "Dec 17, 2024" },
    publishedAt: "2024-12-17",
    category: { es: "Movilidad académica", en: "Academic mobility" },
    excerpt: {
      es: "Marco Antonio Alcalá Cuba, jefe del Departamento de Desarrollo Curricular de la UMSS, compartió una experiencia de movilidad docente en el marco del Programa Escala Docente de AUGM.",
      en: "Marco Antonio Alcalá Cuba, head of UMSS Curriculum Development, shared a faculty mobility experience through the AUGM Faculty Scale Program.",
    },
    deck: {
      es: "Una estancia académica en la Universidad Federal do ABC abrió nuevas referencias para la innovación curricular en la UMSS.",
      en: "An academic stay at Universidade Federal do ABC opened new references for curricular innovation at UMSS.",
    },
    image: "/images/news/noticia-1.png",
    body: {
      heading: {
        es: "Experiencia de Movilidad Docente",
        en: "Faculty Mobility Experience",
      },
      paragraphs: [
        {
          es: "En el marco del Programa Escala Docente (PED) de la Asociación de Universidades del Grupo Montevideo (AUGM), Marco Antonio Alcalá Cuba, jefe del Departamento de Desarrollo Curricular de la Universidad Mayor de San Simón (UMSS), participó en una estancia académica en la Universidad Federal do ABC (UFABC), Brasil, del 2 al 6 de diciembre de 2024.",
          en: "Within the framework of the Faculty Scale Program (PED) of the Association of Universities of the Montevideo Group (AUGM), Marco Antonio Alcalá Cuba, head of the Curriculum Development Department at Universidad Mayor de San Simón (UMSS), participated in an academic stay at Universidade Federal do ABC (UFABC), Brazil, from December 2 to 6, 2024.",
        },
        {
          es: "La visita tuvo como objetivo principal conocer y analizar las políticas de currículo flexible y el sistema matricial que implementa esta destacada institución brasileña, reconocida por su enfoque innovador en la educación superior.",
          en: "The main objective of the visit was to learn about and analyze the flexible curriculum policies and matrix system implemented by this leading Brazilian institution, recognized for its innovative approach to higher education.",
        },
        {
          es: "Durante la estancia académica, se lograron avances significativos, entre los cuales destacan:",
          en: "During the academic stay, several significant advances were achieved, including:",
        },
        {
          es: "Este tipo de experiencias académicas no solo permiten el intercambio de conocimientos y buenas prácticas entre universidades de la región, sino que también abren puertas a nuevas oportunidades de cooperación internacional. La colaboración entre la UMSS y la UFABC refleja el compromiso con la mejora continua de los procesos educativos, en busca de una educación más inclusiva, flexible y orientada a las necesidades actuales.",
          en: "These academic experiences not only enable the exchange of knowledge and good practices among universities in the region, but also open the door to new opportunities for international cooperation. The collaboration between UMSS and UFABC reflects a commitment to the continuous improvement of educational processes in pursuit of a more inclusive, flexible, and current-needs-oriented education.",
        },
      ],
      bullets: [
        {
          es: "Comprensión profunda del sistema matricial y el currículo flexible adoptados en la UFABC, que promueven una educación adaptable y centrada en las necesidades de los estudiantes.",
          en: "A deeper understanding of UFABC's matrix system and flexible curriculum, which promote adaptable education centered on students' needs.",
        },
        {
          es: "Identificación de buenas prácticas en metodologías de enseñanza, organización institucional y sistemas de evaluación del aprendizaje que pueden servir como referencia para mejorar los procesos educativos en la UMSS.",
          en: "Identification of good practices in teaching methodologies, institutional organization, and learning assessment systems that can inform improvements at UMSS.",
        },
        {
          es: "Establecimiento de acuerdos preliminares para futuros intercambios académicos y proyectos de investigación entre ambas universidades, fortaleciendo la colaboración internacional.",
          en: "Establishment of preliminary agreements for future academic exchanges and research projects between both universities, strengthening international collaboration.",
        },
        {
          es: "Recopilación de recursos y materiales académicos fundamentales para la adaptación e implementación de un modelo curricular flexible en la UMSS.",
          en: "Collection of academic resources and materials that will support the adaptation and implementation of a flexible curricular model at UMSS.",
        },
      ],
    },
  },
  {
    id: "conversatorios-jovenes-investigadores-31-jji-augm",
    title: {
      es: "Serie de conversatorios con investigadores que participaron en las 31° Jornadas de Jóvenes Investigadores de AUGM",
      en: "Talk series with researchers who participated in the 31st AUGM Young Researchers Conference",
    },
    date: { es: "Dic 10, 2024", en: "Dec 10, 2024" },
    publishedAt: "2024-12-10",
    category: { es: "Investigación", en: "Research" },
    excerpt: {
      es: "Durante la tercera Semana Internacional de la Ciencia, la DRIC impulsó espacios de diálogo con investigadores participantes de las Jornadas de Jóvenes Investigadores.",
      en: "During the third International Science Week, DRIC promoted dialogue spaces with researchers who participated in the Young Researchers Conference.",
    },
    deck: {
      es: "La Semana Internacional de la Ciencia reunió voces jóvenes de Bolivia, Paraguay y Brasil en un espacio virtual dedicado al intercambio científico regional.",
      en: "International Science Week brought together young voices from Bolivia, Paraguay, and Brazil in a virtual space dedicated to regional scientific exchange.",
    },
    image: "/images/news/noticia-2.png",
    body: {
      heading: {
        es: "Un espacio de intercambio internacional",
        en: "A Space for International Exchange",
      },
      paragraphs: [
        {
          es: "Del 2 al 5 de diciembre de 2024, se llevó a cabo la tercera versión de la Semana Internacional de la Ciencia, organizada por la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón (UMSS), conmemorando el Día Mundial de la Ciencia para la Paz y el Desarrollo. Este evento virtual reunió a destacados investigadores de la región en un espacio de diálogo y aprendizaje mutuo.",
          en: "From December 2 to 5, 2024, the third edition of International Science Week was held, organized by the Office of International Relations and Agreements of Universidad Mayor de San Simón (UMSS), commemorating World Science Day for Peace and Development. This virtual event brought together outstanding researchers from the region in a space for dialogue and mutual learning.",
        },
        {
          es: "Durante las jornadas, se realizaron una serie de conversatorios con los investigadores que representaron a la UMSS (Bolivia), la UNI (Paraguay) y la UNICAMP (Brasil) en las 31° Jornadas de Jóvenes Investigadores de la Asociación de Universidades Grupo Montevideo (AUGM), celebradas en Uruguay.",
          en: "Throughout the sessions, a series of talks was held with researchers who represented UMSS (Bolivia), UNI (Paraguay), and UNICAMP (Brazil) at the 31st Young Researchers Conference of the Association of Universities of the Montevideo Group (AUGM), held in Uruguay.",
        },
        {
          es: "Este evento forma parte del compromiso de la UMSS con la iniciativa Impacto Académico de las Naciones Unidas (United Nations Academic Impact), a la cual pertenece desde 2018. Esta alianza busca promover el aporte de las instituciones de educación superior a los objetivos globales, como la promoción de la ciencia al servicio del desarrollo sostenible y la paz.",
          en: "This event is part of UMSS's commitment to the United Nations Academic Impact initiative, which it has belonged to since 2018. This alliance seeks to promote the contribution of higher education institutions to global goals, including science in service of sustainable development and peace.",
        },
        {
          es: "A través de las sesiones virtuales, se exploraron temas de gran relevancia científica y social, destacando los logros de los jóvenes investigadores y promoviendo un intercambio enriquecedor de ideas entre las universidades del Grupo Montevideo. La participación activa de investigadores bolivianos, paraguayos y brasileños subrayó la importancia de la colaboración regional en la construcción de conocimiento.",
          en: "Through the virtual sessions, topics of major scientific and social relevance were explored, highlighting the achievements of young researchers and encouraging an enriching exchange of ideas among universities of the Montevideo Group. The active participation of Bolivian, Paraguayan, and Brazilian researchers underscored the importance of regional collaboration in building knowledge.",
        },
        {
          es: "La Semana Internacional de la Ciencia 2024 reafirmó el compromiso de la UMSS con la difusión del conocimiento y el fortalecimiento de redes internacionales que impulsan la investigación científica como herramienta para un futuro más equitativo y sostenible.",
          en: "International Science Week 2024 reaffirmed UMSS's commitment to sharing knowledge and strengthening international networks that advance scientific research as a tool for a more equitable and sustainable future.",
        },
      ],
    },
  },
  {
    id: "jimmy-delgado-unju-argentina",
    title: {
      es: "Movilidad académica administrativa: experiencia de Jimmy Delgado en la UNJU, Argentina",
      en: "Administrative academic mobility: Jimmy Delgado's experience at UNJU, Argentina",
    },
    date: { es: "Dic 4, 2024", en: "Dec 4, 2024" },
    publishedAt: "2024-12-04",
    category: { es: "Movilidad académica", en: "Academic mobility" },
    excerpt: {
      es: "Jimmy Delgado Villca, docente de la Facultad de Humanidades y Ciencias de la Educación, realizó una experiencia académica en la Universidad Nacional de Jujuy.",
      en: "Jimmy Delgado Villca, faculty member from Humanities and Education Sciences, completed an academic experience at Universidad Nacional de Jujuy.",
    },
    deck: {
      es: "Una experiencia PMAA-CRISCOS fortaleció el intercambio académico entre la UMSS y la Universidad Nacional de Jujuy.",
      en: "A PMAA-CRISCOS experience strengthened academic exchange between UMSS and Universidad Nacional de Jujuy.",
    },
    image: "/images/news/noticia-3.png",
    body: {
      heading: {
        es: "Experiencia académica administrativa",
        en: "Administrative Academic Experience",
      },
      paragraphs: [
        {
          es: "Del 18 al 22 de noviembre de 2024, Jimmy Delgado Villca, docente de la Facultad de Humanidades y Ciencias de la Educación de la Universidad Mayor de San Simón (UMSS), tuvo la oportunidad de vivir una enriquecedora experiencia académica en la Universidad Nacional de Jujuy (UNJU), Argentina. Esta iniciativa se desarrolló en el marco del Programa de Movilidad Académica Administrativa (PMAA) de CRISCOS, fortaleciendo los lazos de colaboración entre instituciones educativas de la región.",
          en: "From November 18 to 22, 2024, Jimmy Delgado Villca, faculty member at the Faculty of Humanities and Education Sciences of Universidad Mayor de San Simón (UMSS), had the opportunity to take part in an enriching academic experience at Universidad Nacional de Jujuy (UNJU), Argentina. This initiative was developed within the framework of the CRISCOS Administrative Academic Mobility Program (PMAA), strengthening collaboration among educational institutions in the region.",
        },
        {
          es: "Durante su estancia, el profesor Delgado compartió su amplia experiencia en procesos formativos, diseño curricular, investigaciones académicas y el sistema de créditos académicos. Su participación incluyó sesiones con estudiantes de la asignatura Teoría y Desarrollo del Currículum, así como encuentros con equipos académicos de pregrado y posgrado de la Facultad de Humanidades y Ciencias Sociales de la UNJU.",
          en: "During his stay, Professor Delgado shared his extensive experience in educational processes, curriculum design, academic research, and the academic credit system. His participation included sessions with students in the Theory and Curriculum Development course, as well as meetings with undergraduate and graduate academic teams from UNJU's Faculty of Humanities and Social Sciences.",
        },
        {
          es: "El intercambio no solo permitió el enriquecimiento mutuo a través de la discusión de metodologías y estrategias, sino que también resultó en compromisos concretos para futuras colaboraciones. Entre ellos destacan la planificación de clases espejo, el apoyo a los procesos de transformación curricular y la implementación del sistema de créditos académicos en ambas instituciones.",
          en: "The exchange not only enabled mutual enrichment through discussion of methodologies and strategies, but also resulted in concrete commitments for future collaboration. These include planning mirror classes, supporting curriculum transformation processes, and implementing the academic credit system at both institutions.",
        },
      ],
    },
  },
  {
    id: "escala-docente-augm-montevideo-uruguay",
    title: {
      es: "Movilidad académica Programa Escala Docente (PED) de AUGM - Montevideo, Uruguay",
      en: "Academic mobility through AUGM Faculty Scale Program (PED) - Montevideo, Uruguay",
    },
    date: { es: "Nov 29, 2024", en: "Nov 29, 2024" },
    publishedAt: "2024-11-29",
    category: { es: "Cooperación internacional", en: "International cooperation" },
    excerpt: {
      es: "El arquitecto Fabián Farfán Espinoza fortaleció vínculos académicos en la Facultad de Arquitectura, Diseño y Urbanismo de la Universidad de la República.",
      en: "Architect Fabián Farfán Espinoza strengthened academic ties at the Faculty of Architecture, Design, and Urbanism of Universidad de la República.",
    },
    deck: {
      es: "Una movilidad docente en Montevideo abrió nuevas rutas de colaboración, publicación académica e innovación arquitectónica entre la UMSS y UDELAR.",
      en: "A faculty mobility stay in Montevideo opened new paths for collaboration, academic publication, and architectural innovation between UMSS and UDELAR.",
    },
    image: "/images/news/noticia-4.png",
    body: {
      heading: {
        es: "Arquitectura, diseño e intercambio académico",
        en: "Architecture, Design, and Academic Exchange",
      },
      paragraphs: [
        {
          es: "Del 4 al 8 de noviembre de 2024, el arquitecto Fabián Farfán Espinoza, docente de la Facultad de Arquitectura de la Universidad Mayor de San Simón (UMSS), vivió una enriquecedora movilidad académica en la Facultad de Arquitectura, Diseño y Urbanismo (FADU) de la Universidad de la República (UDELAR), en Montevideo, Uruguay. La experiencia se desarrolló en el marco del Programa Escala Docente (PED) de la Asociación de Universidades Grupo Montevideo (AUGM).",
          en: "From November 4 to 8, 2024, architect Fabián Farfán Espinoza, faculty member at the Faculty of Architecture of Universidad Mayor de San Simón (UMSS), took part in an enriching academic mobility experience at the Faculty of Architecture, Design, and Urbanism (FADU) of Universidad de la República (UDELAR), in Montevideo, Uruguay. The experience was carried out within the framework of the Faculty Scale Program (PED) of the Association of Universities of the Montevideo Group (AUGM).",
        },
        {
          es: "Durante su estancia, Fabián compartió las experiencias y resultados del Taller de Diseño IV de la UMSS, un espacio clave para la exploración creativa en la formación arquitectónica. Asimismo, tuvo la oportunidad de conocer los procesos y resultados de diseño de los talleres de la FADU, destacando el enfoque innovador y vanguardista de sus metodologías.",
          en: "During his stay, Fabián shared the experiences and results of UMSS's Design Studio IV, a key space for creative exploration in architectural education. He also had the opportunity to learn about the design processes and outcomes of FADU's studios, highlighting the innovative and forward-looking approach of their methodologies.",
        },
        {
          es: "El intercambio propició el diálogo académico entre ambas instituciones y sentó las bases para una publicación conjunta que reúna las experiencias y enfoques de los talleres de diseño de ambas facultades. Esta proyección editorial permitirá documentar aprendizajes compartidos y fortalecer la circulación regional de conocimiento arquitectónico.",
          en: "The exchange encouraged academic dialogue between both institutions and laid the groundwork for a joint publication bringing together the experiences and approaches of the design studios from both faculties. This editorial initiative will help document shared learning and strengthen the regional circulation of architectural knowledge.",
        },
        {
          es: "La visita incluyó recorridos por proyectos arquitectónicos emblemáticos de Montevideo, una experiencia que permitió apreciar el valor patrimonial de la ciudad y sus apuestas contemporáneas por la innovación en el diseño urbano.",
          en: "The visit also included tours of emblematic architectural projects in Montevideo, offering an opportunity to appreciate the city's heritage value as well as its contemporary commitment to innovation in urban design.",
        },
        {
          es: "Esta movilidad académica reafirma el compromiso de la UMSS con la internacionalización y el aprendizaje mutuo, fortaleciendo la colaboración académica y la innovación en el campo de la arquitectura.",
          en: "This academic mobility experience reaffirms UMSS's commitment to internationalization and mutual learning, strengthening academic collaboration and innovation in the field of architecture.",
        },
      ],
    },
  },
  {
    id: "innovacion-colaboracion-uaa-criscos-paraguay",
    title: {
      es: "Experiencia académica de innovación y colaboración en la UAA - Programa de Movilidad Académica Administrativa de CRISCOS, Paraguay",
      en: "Academic experience in innovation and collaboration at UAA - CRISCOS Administrative Academic Mobility Program, Paraguay",
    },
    date: { es: "Nov 20, 2024", en: "Nov 20, 2024" },
    publishedAt: "2024-11-20",
    category: { es: "Movilidad administrativa", en: "Administrative mobility" },
    excerpt: {
      es: "José Limberg Camacho Acosta desarrolló una estancia académica en innovación en educación universitaria en la Universidad Autónoma de Asunción.",
      en: "José Limberg Camacho Acosta completed an academic stay focused on innovation in higher education at Universidad Autónoma de Asunción.",
    },
    deck: {
      es: "Una estancia PMAA-CRISCOS en Paraguay impulsó el diálogo sobre innovación curricular, publicaciones conjuntas y educación superior latinoamericana.",
      en: "A PMAA-CRISCOS stay in Paraguay advanced dialogue on curricular innovation, joint publications, and Latin American higher education.",
    },
    image: "/images/news/noticia-5.png",
    body: {
      heading: {
        es: "Innovación universitaria y colaboración regional",
        en: "University Innovation and Regional Collaboration",
      },
      paragraphs: [
        {
          es: "Del 4 al 8 de noviembre de 2024, José Limberg Camacho Acosta llevó a cabo una destacada estancia académica en el área de Innovación en Educación Universitaria en la Universidad Autónoma de Asunción (UAA), Paraguay, como parte del Programa de Movilidad Académica Administrativa (PMAA) de CRISCOS.",
          en: "From November 4 to 8, 2024, José Limberg Camacho Acosta completed a distinguished academic stay in the area of Innovation in University Education at Universidad Autónoma de Asunción (UAA), Paraguay, as part of the CRISCOS Administrative Academic Mobility Program (PMAA).",
        },
        {
          es: "Durante su visita, se reunió con autoridades de diversas unidades académicas de la UAA para intercambiar ideas y explorar temas de interés mutuo. Su participación incluyó actividades clave como la disertación en conversatorios y la presentación de propuestas para desarrollar publicaciones conjuntas sobre temas relevantes como la situación de la educación superior en América Latina y los procesos de innovación curricular.",
          en: "During his visit, he met with authorities from several UAA academic units to exchange ideas and explore topics of mutual interest. His participation included key activities such as presentations in discussion sessions and the proposal of joint publications on relevant topics including the state of higher education in Latin America and curricular innovation processes.",
        },
        {
          es: "La estancia permitió consolidar espacios de diálogo académico orientados a identificar oportunidades de cooperación, fortalecer redes institucionales y proyectar líneas de trabajo compartidas entre universidades de la región.",
          en: "The stay helped consolidate spaces for academic dialogue aimed at identifying cooperation opportunities, strengthening institutional networks, and projecting shared lines of work among universities in the region.",
        },
        {
          es: "Esta experiencia resalta la importancia de la colaboración internacional en el fortalecimiento de la educación superior y reafirma el compromiso con el avance académico en la región.",
          en: "This experience highlights the importance of international collaboration in strengthening higher education and reaffirms a commitment to academic progress across the region.",
        },
      ],
    },
  },
  {
    id: "umss-31-jornadas-jovenes-investigadores-augm",
    title: {
      es: "Participación de la UMSS en las 31° Jornadas de Jóvenes Investigadores de la AUGM",
      en: "UMSS participation in the 31st AUGM Young Researchers Conference",
    },
    date: { es: "Nov 13, 2024", en: "Nov 13, 2024" },
    publishedAt: "2024-11-13",
    category: { es: "Investigación", en: "Research" },
    excerpt: {
      es: "Una delegación de jóvenes investigadores de la UMSS participó en el encuentro académico regional de AUGM realizado del 6 al 8 de noviembre.",
      en: "A delegation of young UMSS researchers participated in the AUGM regional academic meeting held from November 6 to 8.",
    },
    deck: {
      es: "Jóvenes investigadores de la UMSS representaron a Bolivia en Uruguay, en uno de los espacios científicos regionales más importantes de la AUGM.",
      en: "Young UMSS researchers represented Bolivia in Uruguay at one of AUGM's most important regional scientific gatherings.",
    },
    image: "/images/news/noticia-6.png",
    body: {
      heading: {
        es: "Ciencia joven con presencia internacional",
        en: "Young Science with International Presence",
      },
      paragraphs: [
        {
          es: "La Universidad Mayor de San Simón (UMSS) estuvo presente en las 31° Jornadas de Jóvenes Investigadores de la Asociación de Universidades Grupo Montevideo (AUGM), consolidando su participación en un espacio académico regional dedicado al intercambio científico, la innovación y la cooperación universitaria.",
          en: "Universidad Mayor de San Simón (UMSS) took part in the 31st Young Researchers Conference of the Association of Universities of the Montevideo Group (AUGM), consolidating its presence in a regional academic space dedicated to scientific exchange, innovation, and university cooperation.",
        },
        {
          es: "Del 6 al 8 de noviembre de 2024, una delegación de jóvenes investigadores de la UMSS participó en este importante encuentro académico realizado en la Universidad de la República, en Uruguay. La edición reunió a más de 700 estudiantes y académicos de toda la región, generando un escenario de diálogo, presentación de resultados y construcción de redes de colaboración.",
          en: "From November 6 to 8, 2024, a delegation of young UMSS researchers participated in this important academic gathering held at Universidad de la República in Uruguay. The edition brought together more than 700 students and academics from across the region, creating a space for dialogue, presentation of results, and the building of collaborative networks.",
        },
        {
          es: "Los representantes de la UMSS destacaron en diversas áreas de investigación, demostrando el talento, la capacidad académica y el compromiso científico de la universidad en el ámbito internacional. Su participación refleja el impulso institucional por abrir oportunidades para nuevas generaciones de investigadores.",
          en: "UMSS representatives stood out across several research areas, demonstrating the university's talent, academic capacity, and scientific commitment on the international stage. Their participation reflects the institution's drive to open opportunities for new generations of researchers.",
        },
        {
          es: "La DRIC felicita a los jóvenes investigadores por su excelente trabajo y por representar a la UMSS con responsabilidad, solvencia académica y visión regional. Su presencia en las Jornadas reafirma el valor de la investigación como motor de desarrollo universitario y cooperación internacional.",
          en: "DRIC congratulates the young researchers for their excellent work and for representing UMSS with responsibility, academic strength, and a regional vision. Their presence at the conference reaffirms the value of research as a driver of university development and international cooperation.",
        },
        {
          es: "Este tipo de experiencias impulsa la ciencia, la innovación y la cooperación, fortaleciendo la comunidad universitaria y proyectando el trabajo de la UMSS hacia escenarios de mayor intercambio académico en América Latina.",
          en: "Experiences like this advance science, innovation, and cooperation, strengthening the university community and projecting UMSS's work into broader spaces of academic exchange in Latin America.",
        },
      ],
    },
  },
  {
    id: "patricia-espinoza-unjbg-peru-criscos",
    title: {
      es: "Movilidad administrativa en el marco del Programa CRISCOS: Patricia Ericka Espinoza García en la UNJBG, Perú",
      en: "Administrative mobility through the CRISCOS Program: Patricia Ericka Espinoza García at UNJBG, Peru",
    },
    date: { es: "Nov 8, 2024", en: "Nov 8, 2024" },
    publishedAt: "2024-11-08",
    category: { es: "Movilidad administrativa", en: "Administrative mobility" },
    excerpt: {
      es: "Patricia Ericka Espinoza García realizó movilidad administrativa en la Universidad Nacional Jorge Basadre Grohmann de Perú.",
      en: "Patricia Ericka Espinoza García completed an administrative mobility stay at Universidad Nacional Jorge Basadre Grohmann in Peru.",
    },
    deck: {
      es: "Una movilidad administrativa en Perú fortaleció capacidades en gestión del talento humano, normativa laboral y evaluación del rendimiento institucional.",
      en: "An administrative mobility stay in Peru strengthened capacities in human talent management, workplace regulations, and institutional performance evaluation.",
    },
    image: "/images/news/noticia-7.png",
    body: {
      heading: {
        es: "Gestión humana y cooperación interinstitucional",
        en: "Human Resource Management and Interinstitutional Cooperation",
      },
      paragraphs: [
        {
          es: "En el marco del Programa de Movilidad Académica Administrativa (PMAA) de CRISCOS, Patricia Ericka Espinoza García, funcionaria de la Universidad Mayor de San Simón (UMSS), realizó una movilidad administrativa en la Universidad Nacional Jorge Basadre Grohmann (UNJBG) de Perú, durante el periodo comprendido del 21 al 31 de octubre de 2024.",
          en: "Within the framework of the CRISCOS Administrative Academic Mobility Program (PMAA), Patricia Ericka Espinoza García, staff member of Universidad Mayor de San Simón (UMSS), completed an administrative mobility stay at Universidad Nacional Jorge Basadre Grohmann (UNJBG) in Peru, from October 21 to 31, 2024.",
        },
        {
          es: "La movilidad permitió alcanzar avances significativos en la gestión del talento humano de la UNJBG. Entre los resultados principales, se logró actualizar el Reglamento Interno de Trabajo, alineándolo con la legislación peruana y con mejores prácticas aplicables a la administración universitaria.",
          en: "The mobility experience made it possible to achieve significant progress in human talent management at UNJBG. Among the main results, the Internal Work Regulations were updated and aligned with Peruvian legislation and best practices applicable to university administration.",
        },
        {
          es: "Asimismo, se avanzó en el diseño de un sistema de gestión del rendimiento, estableciendo indicadores clave de desempeño y procesos de evaluación orientados a fortalecer la organización institucional y la mejora continua.",
          en: "Progress was also made in designing a performance management system, establishing key performance indicators and evaluation processes aimed at strengthening institutional organization and continuous improvement.",
        },
        {
          es: "Esta experiencia permitió a la profesional enriquecer notablemente su formación en gestión de recursos humanos, incorporando nuevos conocimientos, herramientas y habilidades que contribuyen a su desempeño administrativo dentro de la UMSS.",
          en: "This experience enabled the professional to significantly enrich her training in human resource management, incorporating new knowledge, tools, and skills that contribute to her administrative work within UMSS.",
        },
        {
          es: "La estancia fomentó la colaboración interinstitucional y permitió establecer redes de contacto que proyectan futuras colaboraciones entre ambas universidades, reafirmando el valor de la movilidad administrativa como una vía concreta para fortalecer la gestión universitaria regional.",
          en: "The stay fostered interinstitutional collaboration and helped establish contact networks that open the way for future cooperation between both universities, reaffirming the value of administrative mobility as a concrete path for strengthening regional university management.",
        },
      ],
    },
  },
  {
    id: "silvia-arze-pegya-augm-argentina",
    title: {
      es: "Estancia en el Programa Escala de Gestores y Administradores (PEGyA) de AUGM - Argentina",
      en: "Stay through the AUGM Managers and Administrators Scale Program (PEGyA) - Argentina",
    },
    date: { es: "Nov 8, 2024", en: "Nov 8, 2024" },
    publishedAt: "2024-11-08",
    category: { es: "Gestión universitaria", en: "University management" },
    excerpt: {
      es: "Silvia del Pilar Arze Orellana, funcionaria de la UMSS, realizó una estancia en la Universidad Nacional de Córdoba, Argentina.",
      en: "Silvia del Pilar Arze Orellana, UMSS staff member, completed a stay at Universidad Nacional de Córdoba in Argentina.",
    },
    deck: {
      es: "Una estancia PEGyA-AUGM en Córdoba fortaleció el diálogo sobre gestión universitaria, redes colaborativas y movilidad académica regional.",
      en: "A PEGyA-AUGM stay in Córdoba strengthened dialogue on university management, collaborative networks, and regional academic mobility.",
    },
    image: "/images/news/noticia-8.png",
    body: {
      heading: {
        es: "Gestión universitaria con mirada internacional",
        en: "University Management with an International Outlook",
      },
      paragraphs: [
        {
          es: "La Dirección de Relaciones Internacionales y Convenios comparte la experiencia de Silvia del Pilar Arze Orellana, funcionaria de la Universidad Mayor de San Simón (UMSS), quien realizó una estancia en la Universidad Nacional de Córdoba, Argentina, durante el periodo comprendido entre el 28 de octubre y el 1 de noviembre de 2024.",
          en: "The Office of International Relations and Agreements shares the experience of Silvia del Pilar Arze Orellana, staff member of Universidad Mayor de San Simón (UMSS), who completed a stay at Universidad Nacional de Córdoba, Argentina, from October 28 to November 1, 2024.",
        },
        {
          es: "La movilidad se desarrolló en el marco del Programa Escala de Gestores y Administradores (PEGyA) de la Asociación de Universidades Grupo Montevideo (AUGM), una iniciativa que promueve el intercambio de experiencias entre equipos de gestión universitaria de la región.",
          en: "The mobility experience took place within the framework of the Managers and Administrators Scale Program (PEGyA) of the Association of Universities of the Montevideo Group (AUGM), an initiative that promotes the exchange of experiences among university management teams in the region.",
        },
        {
          es: "Durante el encuentro, se compartieron experiencias sobre el enfoque de trabajo académico de cada universidad participante, destacando la importancia de adaptar estrategias institucionales que respondan a las necesidades de cada contexto universitario.",
          en: "During the meeting, participants shared experiences related to the academic work approach of each participating university, emphasizing the importance of adapting institutional strategies to respond to the needs of each university context.",
        },
        {
          es: "También se discutieron métodos para fortalecer las relaciones internacionales, con especial atención en la creación de redes colaborativas y convenios que impulsen la movilidad de estudiantes y docentes. Estas conversaciones generaron una base sólida para proyectar futuras alianzas estratégicas.",
          en: "Methods for strengthening international relations were also discussed, with special attention to the creation of collaborative networks and agreements that promote student and faculty mobility. These conversations created a solid foundation for future strategic alliances.",
        },
        {
          es: "Esta estancia reafirma el valor de la movilidad de gestores y administradores como un espacio de aprendizaje mutuo, innovación institucional y cooperación sostenida entre universidades latinoamericanas.",
          en: "This stay reaffirms the value of mobility for managers and administrators as a space for mutual learning, institutional innovation, and sustained cooperation among Latin American universities.",
        },
      ],
    },
  },
  {
    id: "docente-unjbg-visita-umss-criscos",
    title: {
      es: "Docente de la Universidad Nacional Jorge Basadre Grohmann de Perú visita la UMSS - Programa PMAA de CRISCOS",
      en: "Professor from Universidad Nacional Jorge Basadre Grohmann of Peru visits UMSS - CRISCOS PMAA Program",
    },
    date: { es: "Oct 22, 2024", en: "Oct 22, 2024" },
    publishedAt: "2024-10-22",
    category: { es: "Visita académica", en: "Academic visit" },
    excerpt: {
      es: "La UMSS recibió al Dr. Juan Francisco Alberto Yábar Jibaya como parte del Programa de Movilidad Académica Administrativa de CRISCOS.",
      en: "UMSS welcomed Dr. Juan Francisco Alberto Yábar Jibaya as part of the CRISCOS Administrative Academic Mobility Program.",
    },
    deck: {
      es: "La visita académica del Dr. Juan Francisco Alberto Yábar Jibaya abrió un espacio de intercambio en arquitectura, método científico, arte sistémico e inteligencia artificial.",
      en: "Dr. Juan Francisco Alberto Yábar Jibaya's academic visit opened a space for exchange in architecture, scientific method, systemic art, and artificial intelligence.",
    },
    image: "/images/news/noticia-9.png",
    body: {
      heading: {
        es: "Arquitectura, ciencia e inteligencia artificial",
        en: "Architecture, Science, and Artificial Intelligence",
      },
      paragraphs: [
        {
          es: "Del 14 al 18 de octubre de 2024, la Universidad Mayor de San Simón (UMSS) tuvo el honor de recibir al Dr. Juan Francisco Alberto Yábar Jibaya, destacado docente de la Universidad Nacional Jorge Basadre Grohmann de Perú, como parte del Programa de Movilidad Académica Administrativa (PMAA) de CRISCOS.",
          en: "From October 14 to 18, 2024, Universidad Mayor de San Simón (UMSS) had the honor of welcoming Dr. Juan Francisco Alberto Yábar Jibaya, distinguished professor from Universidad Nacional Jorge Basadre Grohmann in Peru, as part of the CRISCOS Administrative Academic Mobility Program (PMAA).",
        },
        {
          es: "Durante su estadía, el Dr. Yábar Jibaya desarrolló una serie de actividades académicas en la Facultad de Arquitectura, enfocadas en tres importantes líneas de acción: el método científico, el arte sistémico y el uso de la inteligencia artificial en la metodología del diseño arquitectónico.",
          en: "During his stay, Dr. Yábar Jibaya carried out a series of academic activities at the Faculty of Architecture, focused on three important lines of work: the scientific method, systemic art, and the use of artificial intelligence in architectural design methodology.",
        },
        {
          es: "Su colaboración aportó un significativo enriquecimiento a la comunidad académica, generando un espacio de intercambio de conocimientos, experiencias y perspectivas contemporáneas para docentes y estudiantes.",
          en: "His collaboration brought meaningful enrichment to the academic community, creating a space for the exchange of knowledge, experiences, and contemporary perspectives for faculty members and students.",
        },
        {
          es: "La visita permitió fortalecer el diálogo académico regional y evidenciar el valor de la movilidad como herramienta para renovar enfoques pedagógicos, metodológicos y creativos dentro de la formación arquitectónica.",
          en: "The visit strengthened regional academic dialogue and highlighted the value of mobility as a tool for renewing pedagogical, methodological, and creative approaches within architectural education.",
        },
        {
          es: "La UMSS expresa su profundo agradecimiento por la visita del Dr. Yábar Jibaya y por el impacto positivo que dejó en la Facultad de Arquitectura y en sus estudiantes.",
          en: "UMSS expresses its sincere gratitude for Dr. Yábar Jibaya's visit and for the positive impact he left on the Faculty of Architecture and its students.",
        },
      ],
    },
  },
  {
    id: "convenio-colegio-ingenieros-petroquimicos-energias",
    title: {
      es: "Suscripción de convenio con el Colegio de Ingenieros Petroquímicos y Energías de Cochabamba",
      en: "Agreement signed with the College of Petrochemical and Energy Engineers of Cochabamba",
    },
    date: { es: "Oct 22, 2024", en: "Oct 22, 2024" },
    publishedAt: "2024-10-22",
    category: { es: "Convenios", en: "Agreements" },
    excerpt: {
      es: "La UMSS y el CIPQEC firmaron un convenio interinstitucional para beneficiar a miembros y dependientes mediante cooperación académica.",
      en: "UMSS and CIPQEC signed an interinstitutional agreement to benefit members and dependents through academic cooperation.",
    },
    deck: {
      es: "El acuerdo abre beneficios de posgrado y nuevas acciones de formación continua entre la UMSS y el sector petroquímico y energético de Cochabamba.",
      en: "The agreement opens postgraduate benefits and new continuing education initiatives between UMSS and Cochabamba's petrochemical and energy sector.",
    },
    image: "/images/news/noticia-10.png",
    body: {
      heading: {
        es: "Cooperación académica y desarrollo profesional",
        en: "Academic Cooperation and Professional Development",
      },
      paragraphs: [
        {
          es: "La Universidad Mayor de San Simón (UMSS) y el Colegio de Ingenieros Petroquímicos y Energías de Cochabamba (CIPQEC) firmaron un convenio interinstitucional con el propósito de beneficiar a los miembros y dependientes del CIPQEC.",
          en: "Universidad Mayor de San Simon (UMSS) and the College of Petrochemical and Energy Engineers of Cochabamba (CIPQEC) signed an interinstitutional agreement designed to benefit CIPQEC members and their dependents.",
        },
        {
          es: "A través de este acuerdo, la UMSS ofrecerá descuentos que van desde el 10% hasta el 50% en sus programas de posgrado, para grupos de tres o más personas, según la viabilidad económica de cada programa.",
          en: "Through this agreement, UMSS will offer discounts ranging from 10% to 50% in its postgraduate programs for groups of three or more people, according to the financial viability of each program.",
        },
        {
          es: "Además, ambas instituciones colaborarán en la organización de cursos, talleres y seminarios en áreas de interés común, promoviendo espacios de actualización académica y fortalecimiento profesional.",
          en: "In addition, both institutions will collaborate in organizing courses, workshops, and seminars in areas of shared interest, promoting spaces for academic updating and professional strengthening.",
        },
        {
          es: "La suscripción de este convenio reafirma el compromiso de la UMSS con la articulación institucional y con la generación de oportunidades de formación especializada para sectores estratégicos del desarrollo regional.",
          en: "The signing of this agreement reaffirms UMSS's commitment to institutional coordination and to creating specialized training opportunities for strategic sectors of regional development.",
        },
      ],
    },
  },
];

export function getNews(locale: string): NewsItem[] {
  const language: Locale = locale === "en" ? "en" : "es";

  return newsCatalog.map((item) => ({
    id: item.id,
    title: item.title[language],
    date: item.date[language],
    publishedAt: item.publishedAt,
    category: item.category[language],
    excerpt: item.excerpt[language],
    href: `/${language}/noticias/${item.id}`,
  }));
}

export function getNewsRecordBySlug(newsSlug: string) {
  const numericIndex = Number(newsSlug) - 1;

  if (Number.isInteger(numericIndex) && numericIndex >= 0) {
    return newsCatalog[numericIndex] ?? null;
  }

  return newsCatalog.find((item) => item.id === newsSlug) ?? null;
}
