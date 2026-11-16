# Reconstrucción del desarrollo de DRIC para la tesis

## 1. Alcance y respaldo de esta guía

Esta guía se elaboró mediante la revisión del historial Git disponible, los manifiestos de dependencias, las migraciones, la organización de modelos y seeders, las rutas activas, los componentes de acceso a la API y los flujos de páginas públicas, certificados y solicitudes de cita. No constituye una auditoría línea por línea de todos los archivos ni una certificación del funcionamiento del sistema en producción. No se ejecutó la aplicación ni se consultaron los valores del archivo `.env`.

La autora declara haber desarrollado individualmente el proyecto utilizando Kanban y un enfoque iterativo e incremental. El repositorio respalda la incorporación sucesiva de funcionalidades y las modificaciones repetidas sobre ellas. No se encontró un tablero Kanban, exportación de tarjetas, límites de trabajo en curso ni registros de tiempos de flujo. Esos elementos deben documentarse con los registros reales de la autora.

Las fechas de esta guía corresponden a commits del historial local consultado. Indican cuándo se registraron cambios; no prueban el día exacto en que comenzó cada actividad, su duración, una entrega institucional o su aceptación. Las etapas siguientes son una reconstrucción documental y pueden superponerse.

## 2. Cómo denominar el enfoque

Redacción propuesta, sustentada en la declaración de la autora y en la evolución del código:

> El proyecto se desarrolló de manera individual, utilizando Kanban para organizar y dar seguimiento al trabajo, junto con un enfoque de construcción iterativo e incremental. El carácter incremental se manifestó en la incorporación progresiva de módulos y capacidades al portal. El carácter iterativo se reflejó en la revisión y modificación de funcionalidades existentes, particularmente en la estructura de datos, la adaptación a dispositivos móviles, la presentación visual y la administración de contenidos.

Kanban explica cómo se organizó el trabajo; el enfoque iterativo e incremental explica cómo evolucionó el producto. No debe atribuirse al proyecto una duración fija de iteraciones, ceremonias Scrum o sprints sin evidencia de que realmente se utilizaron.

El desarrollo individual significa que una misma persona asumió las actividades técnicas de preparación, programación e integración. No permite deducir que no hubo asesoramiento o revisión institucional. Los participantes y sus intervenciones deben describirse según lo que efectivamente ocurrió.

## 3. Desarrollo paso a paso

### Paso 1. Contexto, problema y alcance: información previa por completar

La narración de la tesis debe comenzar por el problema que motivó el portal y las necesidades que se pretendían atender, antes de presentar herramientas o código.

El código actual permite identificar capacidades implementadas: publicación de información institucional, convenios, proyectos, membresías, noticias, normativas, informes, becas y movilidad; administración de contenidos; idiomas español e inglés; consulta de certificados y envío de solicitudes de cita.

No permite reconstruir por sí solo las necesidades iniciales, entrevistas, observaciones, aprobación del alcance ni prioridades originales. Tampoco permite afirmar que todas las capacidades actuales estaban previstas desde el inicio.

Para esta sección, incorporar únicamente los antecedentes, documentos, entrevistas o solicitudes que realmente existieron. Separar los requisitos iniciales de los incorporados durante el desarrollo.

### Paso 2. Inicio del control de versiones

El primer registro disponible es `9bc6dcc`, del 26 de febrero de 2026, con el mensaje `Create README`. Existen otros registros de preparación y fusión ese mismo día.

Redacción propuesta:

> Se estableció un repositorio Git como soporte para registrar la evolución del proyecto. El historial disponible inicia el 26 de febrero de 2026 y conserva cambios posteriores de estructura, implementación y ajuste de funcionalidades.

Esto no demuestra que el análisis o trabajo previo empezara ese día. Para documentar el inicio real, utilizar también los antecedentes externos que existan.

### Paso 3. Preparación del entorno del backend

El commit `27e735c`, del 4 de marzo, incorpora el proyecto backend: `artisan`, configuración, `composer.json`, `composer.lock`, migraciones, modelos, recursos y pruebas de ejemplo.

El manifiesto actual declara PHP `^8.2`, Laravel `^12.0` y `spatie/laravel-permission` `^7.2`. Son restricciones declaradas; no equivalen a las versiones exactas instaladas inicialmente ni prueban qué versión de PHP se ejecutó.

Redacción propuesta:

> Se incorporó la base del backend en Laravel y se organizaron sus dependencias con Composer. La estructura incluyó configuración, rutas, modelos y migraciones, sobre la cual se desarrollaron las capacidades de persistencia y administración del portal.

Para completar la preparación del entorno en la tesis, registrar las versiones realmente utilizadas de PHP, Composer y del motor de base de datos, además de cómo se configuró la conexión. `config/database.php` admite varios motores y selecciona la conexión mediante `DB_CONNECTION`; por ello, ese archivo no basta para confirmar el motor utilizado. Algunas vistas mencionan PostgreSQL, pero se necesita confirmar la configuración efectiva antes de afirmarlo como dato del entorno.

### Paso 4. Construcción y ajuste del modelo de datos

Las migraciones incorporadas inicialmente incluyen usuarios, permisos, idiomas, páginas, traducciones, secciones, bloques de contenido, medios y registros de auditoría. La existencia de una tabla de auditoría no prueba que todas las operaciones estén auditadas.

Los commits `ae18ac9` del 7 de marzo y `e30a323` del 9 de marzo registran ajustes de base de datos. Las migraciones conservadas muestran adición de claves relacionadas, campos de contenido, estructura e índices. `86f5ad7`, del 9 de marzo, registra modelos y seeders.

El modelo actual `Page` relaciona páginas con traducciones, secciones, SEO, usuarios creadores y usuarios modificadores. Las secciones y bloques permiten organizar contenido dentro de una página.

Redacción propuesta:

> La persistencia se estructuró mediante migraciones y modelos relacionados. Su diseño se ajustó progresivamente al incorporar campos, relaciones e índices requeridos por la administración de contenidos. Los seeders permitieron definir datos iniciales para distintos módulos.

No presentar el orden de llamadas de `DatabaseSeeder` como si fuera la cronología histórica de implementación: representa un orden de carga de datos.

### Paso 5. Primer avance administrativo

El commit `4657ed9`, del 10 de marzo, se denomina `basic admin page test`. Es evidencia de un avance administrativo temprano, no de que el panel completo estuviera terminado.

Redacción propuesta:

> Se registró una primera aproximación a la interfaz administrativa, que posteriormente se amplió con gestión de usuarios, roles, permisos y formularios especializados de edición.

### Paso 6. Preparación del entorno del frontend

El commit `b6ba694`, del 17 de marzo, incorpora la estructura del frontend: `package.json`, archivo de bloqueo, TypeScript, configuración de Next.js, rutas, componentes y archivos de internacionalización.

El manifiesto actual declara Next.js `16.1.7`, React `19.2.3`, TypeScript `^5`, Tailwind CSS `^4` y `next-intl`. Incluye los comandos `dev`, `build`, `start` y `lint`. Las versiones actuales no deben trasladarse automáticamente al relato del entorno inicial.

El commit inicial del frontend ya incluye rutas bajo `[locale]`, archivos `es.json` y `en.json`, cabecera y menú móvil. Algunas páginas se incorporaron vacías, de modo que la existencia de su ruta no significaba que su funcionalidad estuviera concluida.

Redacción propuesta:

> Se incorporó una aplicación frontend separada, organizada con Next.js y TypeScript. Desde su estructura inicial se contemplaron rutas por idioma y componentes de navegación, que sirvieron como base para ampliar las páginas públicas.

### Paso 7. Reorganización y primera integración de contenido

El historial registra una reorganización el 28 de abril (`99a0a43`) y ajustes de base de datos, relaciones y seeders entre el 5 y el 6 de mayo.

El 7 de mayo, `f2475b5` modifica recursos de API e incorpora `lib/api/pages.ts`, `types/cms.ts`, `SectionRenderer.tsx` y componentes de la página de inicio. Esto respalda una integración inicial entre la presentación pública y el contenido del backend antes de septiembre.

El flujo actual de consulta de páginas es: frontend → `GET /api/pages/{slug}?locale=...` → `PublicPageController` → modelos relacionados → `PageResource` y recursos de secciones/bloques → respuesta JSON → presentación pública.

El endpoint activo utiliza `PublicPageController`; no debe describirse `PageService` como intermediario obligatorio, porque la ruta consultada no lo utiliza.

### Paso 8. Ampliación de las páginas públicas

Entre mayo y agosto, el historial registra la incorporación y ampliación de páginas y contenido. Algunos hitos son:

| Fecha del commit | Registro | Evidencia del avance |
| --- | --- | --- |
| 27 de mayo | `37508cd` | Ampliación de pestañas/páginas. |
| 1 de junio | `a9c6750` | Actualización de más páginas. |
| 3 de junio | `a2c6051` | Implementación inicial de verificación de certificados. |
| 16 de junio | `e209bf0`, `ae38ca1` | Normativas, convenios y membresías. |
| 21 y 22 de julio | `43d2c7e`, `840d835` | Ampliación de contenido de becas y otras páginas. |
| 13 de agosto | `7bea116` | Primera parte de solicitud de cita. |
| 17 y 18 de agosto | `00d760d`, `06aaa7e` | Documentos y contenido de convenios. |
| 20 de agosto | `d178574` | Testimonios de estudiantes. |

Estos hitos describen incorporación de código, no entregas aceptadas por usuarios. Las funciones de certificados y citas tuvieron modificaciones posteriores; no deben presentarse como terminadas definitivamente en su primer commit.

### Paso 9. Iteraciones sobre presentación y adaptación móvil

Hay registros de cambios de tema y estilo en junio, ajustes de responsividad el 26 y el 29 de junio y modificaciones de cabecera, pie y contenido durante julio y agosto. `b6a885e`, del 23 de agosto, registra el trabajo sobre la línea gráfica de las páginas.

Redacción propuesta:

> Se realizaron revisiones sucesivas de la interfaz pública, con cambios de presentación, contraste, espaciado, navegación y adaptación a dispositivos móviles. Estos ajustes muestran el componente iterativo del desarrollo, ya que se modificaron elementos previamente implementados.

Los mensajes de cambios no prueban una evaluación formal de accesibilidad, una muestra de dispositivos probados o la aprobación de usuarios. Tales afirmaciones requieren resultados y registros específicos.

### Paso 10. Ampliación de roles y permisos

El commit `7fb824f`, del 30 de junio, registra la implementación de roles y permisos. Ya había tablas y dependencias relacionadas desde marzo, por lo que junio corresponde a un avance posterior y no necesariamente al origen de toda la funcionalidad.

El proyecto actual contiene controladores administrativos de usuarios, roles y permisos, junto con catálogos y mapas de permisos por página. Las rutas administrativas se agrupan con autenticación.

Redacción propuesta:

> La administración se amplió mediante capacidades de gestión de usuarios, roles y permisos, sobre una estructura de datos y dependencias incorporadas previamente.

### Paso 11. Ampliación de la edición de contenidos mediante el CMS

En septiembre aparecen cambios que conectan formularios administrativos, persistencia y páginas públicas para numerosos módulos. La revisión de los archivos modificados en estos commits respalda los siguientes hitos:

| Fecha | Commit | Módulos o capacidades incorporadas/ampliadas |
| --- | --- | --- |
| 1 de septiembre | `b4cd383` | Presentación: controlador, formulario administrativo, seeder y consumo público. |
| 3 de septiembre | `88d478b` | Convenios, proyectos, apoyo financiero y membresías. |
| 3 de septiembre | `732c533` | Edición y presentación de detalles de noticias. |
| 4 de septiembre | `f104de6` | Normativas, informes y administración de certificados. |
| 7 de septiembre | `3589f29` | Becas, movilidad, oportunidades, contacto y vida universitaria. |
| 8 de septiembre | `4fbee44` | Información para nacionales y extranjeros. |
| 10 de septiembre | `27b93d1` | Edición de inicio, testimonios e internacionalización. |

Redacción propuesta:

> La capacidad de edición se extendió por módulos. Para ellos se incorporaron o ajustaron controladores, formularios administrativos, carga de datos y consumo desde la interfaz pública, ampliando progresivamente el contenido administrable del portal.

No afirmar que el CMS comenzó por primera vez en septiembre: existen avances de administración e integración anteriores.

### Paso 12. Ajustes administrativos, correo y sesiones

El historial de septiembre registra organización de campos administrativos, ajustes de inicio de sesión y perfil, edición de elementos globales, recuperación de contraseña mediante correo y cambios de middleware.

Hitos: `45f5826` del 16 de septiembre; `f42ac50` del 23; `47e2278` del 24; `c2ab1a7` del 25; y ajustes posteriores de correo y citas el 27.

El código actual incluye middleware para expiración por inactividad y control del historial de navegación administrativo. La solicitud de recuperación de contraseña tiene limitación de frecuencia en su ruta.

El endpoint de citas valida la solicitud y envía un correo. No representa, por sí mismo, un sistema de reserva con comprobación de disponibilidad, confirmación automática y persistencia de turnos. Su descripción precisa es recepción y envío de solicitudes de cita.

La verificación de certificados consulta registros activos por código. No debe describirse como firma digital o autenticación criptográfica de documentos.

### Paso 13. Refinamiento registrado hasta octubre

El historial consultado conserva ajustes de finales de septiembre y octubre en conexiones, panel administrativo, configuración y menú móvil. El último commit disponible es `7c227e1`, del 11 de octubre de 2026, denominado `last retouches`.

Redacción propuesta:

> Se registraron ajustes posteriores de integración y presentación, incluidos cambios en el panel administrativo y la navegación móvil. El historial disponible para esta reconstrucción llega al 11 de octubre de 2026.

Esta fecha no prueba cierre formal, despliegue, entrega o aceptación institucional.

### Paso 14. Verificación y documentación: alcance comprobable

Los archivos de prueba revisados son ejemplos básicos de Laravel: una comprobación de respuesta HTTP en `/` y una aserción `true`. No se identificó en los archivos versionados consultados una batería específica de pruebas automatizadas de los módulos DRIC.

No se ejecutaron esas pruebas durante esta revisión. Su presencia no acredita resultados satisfactorios ni cobertura funcional. Tampoco los mensajes de corrección de errores permiten reconstruir casos y resultados de pruebas manuales.

Los documentos existentes `architecture.md`, `deployment.md`, `admin-workflow.md`, `cms-modules.md` y `api-contracts.md` estaban vacíos. Los README de backend y frontend conservan contenido de las plantillas de los frameworks. Por ello, no prueban una documentación previa específica de arquitectura o despliegue.

Para completar la tesis, incorporar las verificaciones realmente realizadas con: caso, precondición, datos utilizados, resultado esperado, resultado obtenido, fecha y evidencia. Las pruebas nuevas deben fecharse como nuevas, sin atribuirlas retrospectivamente al desarrollo.

## 4. Preparación del entorno: cómo documentarla con precisión

La sección de entorno puede organizarse en este orden, siempre usando datos reales:

1. Identificar equipo y sistema operativo utilizados durante el desarrollo.
2. Registrar versiones de PHP, Composer, Node.js, npm y motor de base de datos. Distinguir versiones iniciales de las actuales.
3. Explicar la incorporación de Laravel en `backend` y Next.js en `frontend`, respaldada por los commits de marzo.
4. Describir dependencias con `composer.json`, `composer.lock`, `package.json` y `package-lock.json`.
5. Explicar la configuración de conexión y servicios mediante variables de entorno, sin publicar credenciales.
6. Describir las migraciones y seeders realmente ejecutados y su finalidad.
7. Explicar cómo se iniciaron los servicios locales y cómo se conectó el frontend con la URL de la API.
8. Adjuntar evidencia disponible de que se consultó una página y se recuperó contenido del backend.

Los scripts actuales permiten identificar tareas como `composer install`, `php artisan key:generate`, `php artisan migrate`, `npm install` y `npm run build`; el frontend declara `npm run dev`. Son una base para explicar o reconstruir la preparación, no una prueba de los comandos exactos que la autora ejecutó inicialmente. No se ejecutaron en esta revisión.

## 5. Cómo explicar Kanban sin inventar prácticas

La declaración de uso de Kanban debe complementarse con la forma concreta en que la autora lo utilizó. Documentar la herramienta o soporte real, las columnas reales, qué representaba cada tarjeta, cómo se elegía la siguiente tarea, cómo se atendían bloqueos y qué condición se utilizaba para finalizarla.

Una tarea técnica real puede referirse, por ejemplo, a conectar Presentación con el CMS. El commit `b4cd383` permite rastrear controlador, formulario, seeder y consumo público. Eso no demuestra que existiera una tarjeta con ese nombre: solo ofrece un ejemplo de trabajo que puede vincularse con una tarjeta auténtica, si se conserva.

Un flujo como «Pendiente → En desarrollo → En revisión → Finalizado» es únicamente un ejemplo ilustrativo. Sustituirlo por las columnas efectivamente utilizadas. No afirmar límites de trabajo en curso, métricas, reuniones diarias, revisiones periódicas o priorización institucional sin respaldo.

Si el tablero original no se conserva, puede prepararse una reconstrucción retrospectiva a partir de commits, identificándola expresamente como tal. Esa reconstrucción ayuda a explicar la evolución, pero no sustituye la evidencia contemporánea del uso del tablero.

## 6. Diferencia entre incremento e iteración en DRIC

| Concepto | Ejemplo respaldado | Explicación |
| --- | --- | --- |
| Incremento | Incorporación inicial de verificación de certificados en junio. | Se añade una capacidad al portal. |
| Incremento | Incorporación de edición administrativa de Presentación en septiembre. | Se amplía la capacidad de gestionar contenido. |
| Iteración | Cambios de responsividad en junio y del menú móvil en octubre. | Se revisa una capacidad existente. |
| Iteración | Ajustes de estructura de datos durante marzo y mayo. | Se modifica y refina una base ya incorporada. |
| Ambos | Certificados: implementación inicial en junio y ampliación administrativa y de idiomas en septiembre. | Se revisa lo existente y se agregan capacidades. |

No es necesario convertir cada commit en una iteración formal. Tampoco corresponde llamar «incremento funcional completo» a una ruta vacía o a un cambio aislado sin su integración correspondiente.

## 7. Guion para la exposición

> Desarrollé el proyecto de manera individual y utilicé Kanban para organizar el trabajo, junto con un enfoque iterativo e incremental para construir el sistema. En la explicación del tablero, presentaré las columnas y la forma de seguimiento que realmente utilicé.
>
> El historial del repositorio comienza en febrero de 2026. En marzo incorporé el backend en Laravel, la estructura de persistencia y posteriormente el frontend en Next.js. La base de datos se fue ajustando mediante migraciones, relaciones y carga inicial de datos.
>
> En mayo ya existía una integración inicial entre el frontend y la API. Después amplié las páginas públicas y capacidades como la consulta de certificados y las solicitudes de cita. Paralelamente realicé modificaciones de presentación, navegación y adaptación móvil.
>
> Durante septiembre amplié la edición de contenidos mediante el CMS, conectando progresivamente módulos como Presentación, Convenios, Proyectos, Noticias, Becas y Movilidad. También se registraron ajustes de administración, correo y sesiones, seguidos por refinamientos hasta octubre.
>
> El desarrollo fue incremental porque se incorporaron nuevas capacidades, e iterativo porque regresé sobre componentes existentes para modificarlos y mejorarlos. Kanban fue el mecanismo de organización del trabajo; el historial Git permite mostrar la evolución técnica mediante cambios concretos.

Este guion debe complementarse con el problema original y con evidencia real del tablero y las verificaciones realizadas. La descripción metodológica del desarrollo tampoco sustituye la metodología de investigación que pueda exigir la universidad. Las definiciones teóricas de Kanban y del desarrollo iterativo e incremental necesitan referencias bibliográficas verificadas; esta guía aporta evidencia del repositorio, no una revisión bibliográfica.

## 8. Archivos de referencia

- Entorno backend: `backend/composer.json` y `backend/package.json`.
- Entorno frontend: `frontend/package.json` y `frontend/tsconfig.json`.
- Persistencia: `backend/config/database.php`, `backend/database/migrations/` y `backend/app/Models/`.
- Datos iniciales: `backend/database/seeders/DatabaseSeeder.php` y seeders específicos.
- Rutas activas: `backend/routes/api.php`, `backend/routes/admin.php`, `backend/routes/web.php` y `backend/bootstrap/app.php`.
- Consulta pública: `backend/app/Http/Controllers/Api/PublicPageController.php` y `backend/app/Http/Resources/PageResource.php`.
- Consumo frontend: `frontend/lib/api/pages.ts` y `frontend/types/cms.ts`.
- Idiomas: `frontend/i18n/routing.ts` y `frontend/messages/`.
- Servicios públicos específicos: `backend/app/Http/Controllers/Api/CertificateVerificationController.php` y `AppointmentRequestController.php`.
- Pruebas existentes: `backend/tests/Feature/ExampleTest.php` y `backend/tests/Unit/ExampleTest.php`.
