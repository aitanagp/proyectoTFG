1. Introducción
Este proyecto consiste en el desarrollo de una página web relacionada con una base de datos para gestionar la información sobre películas. 
Utilizando MySQL Workbench, se ha creado el esquema con las correspondientes tablas.
El proceso de creación nos lleva a exportar el esquema a un archivo .sql, el cual se ha importado a phpMyAdmin, donde accedemos a través de XAMPP. 
Esto nos ha permitido crear automáticamente las tablas.
Se ha creado la interfaz web mediante PHP, HTML y CSS en Visual Studio, utilizando además la ayuda de los repositorios de GitHub, que ha permitido trabajar desde cualquier lugar.

2. Tecnologías Empleadas
PHP: Lenguaje de programación del lado del servidor utilizado para desarrollar la lógica de la aplicación web.
MySQL: Sistema de gestión de base de datos utilizado para almacenar y organizar la información de películas.
HTML: Lenguaje usado para definir la estructura y contenido de las páginas web.
CSS: Lenguaje utilizado para definir el estilo de la web.
Workbench: MySQL Workbench es una herramienta de diseño de bases de datos, modelado y mantenimiento de base de datos.
phpMyAdmin: Herramienta de administración de base de datos MySQL. Permite administrar y mantener bases de datos, crear tablas, ejecutar consultas y gestionar usuarios.
Visual Studio Code: Entorno de desarrollo para escribir código en varios lenguajes de programación.
GitHub: Integración de repositorios de GitHub. Permite la sincronización con Visual Studio Code.

3. Modelo relacional detallado
Director
‘Iddirector’ (PK): identificador del director, es único para cada uno.
‘nombre’: Nombre del director.
‘anyo_nacimiento’: Año de nacimiento del director.
‘nacionalidad’: Nacionalidad del director.

Películas
‘idpelicula’ (PK): identificador único para cada película.
‘titulo’: Título de la película.
‘anyo_produccion’: Año de producción de la película.
‘nacionalidad’: Nacionalidad de la película.
‘idremake’ (FK): Referencia a otra película(‘idpelicula’) que es un remake.
 ‘idguion’ (FK): Referencia al guión de la película(‘idguion’) en la tabla Guion.

Dirige
‘idpelicula’(PK, FK): identificador de la película(‘idpelícula’) de la tabla Películas.
‘iddirector’ (PK, FK): Identificador del director (‘iddirector’) de la tabla Director.

Guion
‘idguion’ (PK): Identificador único del guión.
‘título’: Título del guión.
‘autor’: Autor del guión.

Intérprete
‘idinterprete’ (PK): Identificador único del intérprete.
‘nombre’: Nombre del intérprete.
‘anyo_nacimiento’: Año de nacimiento del intérprete.
‘nacionalidad’: Nacionalidad del intérprete.

Actua
‘idinterprete’ (PK, FK): Identificador del intérprete (idinterprete) de la tabla Intérpretes.
‘idpelicula’ (PK, FK): Identificador de la película (idpelicula) de la tabla Películas.

g_gana
‘idguion’ (PK, FK): Identificador del guion (idguion) de la tabla Guión.
‘idpelicula’ (PK, FK): Identificador de la película (idpelicula) de la tabla Películas.
‘edición’ (PK, FK): Edición del premio.

d_gana
‘iddirector’ (PK, FK): Identificador del director (iddirector) de la tabla Director.
‘idpelicula’ (PK, FK): Identificador de la película (idpelicula) de la tabla Películas.
‘edición’ (PK, FK): Edición del premio.

a_gana
‘idactor’ (PK, FK): Identificador del actor (idactor) de la tabla Intérpretes.
‘idpelicula’ (PK, FK): Identificador de la película (idpelicula) de la tabla Películas.
‘edición’ (PK, FK): Edición del premio.

p_gana
‘idpelicula’ (PK, FK): Identificador de la película (idpelicula) de la tabla Películas.
‘edición’ (PK, FK): Edición del premio.

Login
‘idlogin’ (PK): Identificador único del login.
‘usuario’: Nombre de usuario.
‘password’: Contraseña del usuario.


4. Relaciones
Director y Películas: Un director puede dirigir muchas películas (Películas.iddirector FK a Director.iddirector).
Películas y Guion: Una película tiene un guion asociado (Películas.idguion FK a Guion.idguion).
Películas y Remakes: Una película puede ser un remake de otra (Películas.idremake FK a Películas.idpelicula).
Películas e Intérpretes: Muchos intérpretes pueden actuar en muchas películas (relación muchos a muchos implementada mediante la tabla Actúa).
Películas y Premios: Una película, guion, director, o actor puede ganar premios en diferentes ediciones (relaciones muchos a muchos implementadas mediante las tablas G_Gana, D_Gana, A_Gana, y P_Gana).

5. Líneas futuras
Implementación de una Api REST: Desarrollar una Api Rest para permitir que otras aplicaciones se integren en la base de datos. Esto proporciona endpoints para realizar operaciones de CRUD(Create, Read, Update, Delete) en los datos. Además, facilitará la integración con otras aplicaciones y servicios, haciendo más útil la página. Esto también permite el desarrollo de aplicaciones móviles que conectan con mi base de datos. Se podría implementar con PHP, con frameworks como Laravel.
Publicación en sitio web: Se podría adquirir un dominio y un servicio de hosting para publicar la web en línea, haciéndola accesible a un público más amplio. Se debería de registrar en un dominio, con un proveedor de hosting y configurar el entorno del servidor con PHP y MySQL.
Optimizar el rendimiento: Mejorar el rendimiento mediante la optimización de consultas SQL, el uso de almacenamiento de caché y optimización del código eliminando redundancias. De esta forma podemos aumentar la velocidad de carga y mejorar la experiencia del usuario.
Implementación de seguridad avanzada: Añadir autenticación de dos factores, cifrar datos sensibles e implementar HTTPS mediante un certificado SSL. Proteger los datos de los usuarios y garantizar la integridad y confidencialidad de la información es un factor importante.
Desarrollo de una aplicación móvil: Crear una aplicación móvil para Android e iOS que conecte con mi base de datos a través de API RESTful.
Integración de plataformas de streaming: Explorar la posibilidad de integrar servicios de streaming(como Netflix, Amazon Prime…) para proporcionar enlaces directos a las películas disponibles.
Análisis y reportes: Implementar funcionalidades de análisis y reportes que permitan obtener insights del uso del sitio, lo más buscado y el comportamiento general de los usuarios. Esto ayudaría a la toma de decisiones para futuras mejoras.

