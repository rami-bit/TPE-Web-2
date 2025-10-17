📌 TPE 

👥 Integrantes del Grupo
- Tobias Davila — tobiasdavnic.13@gmail.com
- Ramiro Del Valle — ramidv12@gmail.com

📖 Contexto
El presente repositorio corresponde a la entrega del Trabajo Práctico Especial de la materia Web 2. El objetivo es desarrollar un sitio web dinámico que permita la visualización y administración de un conjunto de ítems.
El acceso al portal será público para cualquier usuario, mientras que solo la cuenta de administrador dispondrá de permisos para crear, modificar y eliminar contenidos.

📰 Temática: Portal de Noticias de Videojuegos
La aplicación gira en torno a un portal de noticias dedicado al mundo de los videojuegos. Los visitantes podrán explorar artículos organizados por secciones, donde cada sección corresponde a un videojuego distinto, y cada noticia incluirá atributos como título, resumen e imagen asociada.


🔗 Relación entre Secciones y Noticias
Según el diagrama entidad-relación:
- La tabla secciones contiene:
- id: identificador único de la sección (INT)
- nombre: nombre de la sección (VARCHAR)
- La tabla noticia contiene:
- id: identificador único de la noticia (INT)
- titulo: título de la noticia (VARCHAR)
- resumen: extracto o descripción breve (TEXT)
- img: URL o ruta de la imagen asociada (VARCHAR)
- seccion_id: clave foránea que referencia a secciones.id (INT)
Esta estructura establece una relación uno a muchos: cada noticia pertenece a una única sección, y cada sección puede agrupar múltiples noticias.

## Instrucciones de uso y despliegue

Para usar la página localmente seguí estos pasos mínimos:

1. Clona o copia este repositorio dentro del directorio de XAMPP: `C:/xampp/htdocs/TPE-Web-2` (la aplicación asume estar en `htdocs`).
2. Base de datos: tienes dos opciones válidas para que la aplicación funcione correctamente:
   - Importar manualmente el archivo `sql/noticiero.sql` en tu servidor MySQL (por ejemplo desde phpMyAdmin). Esto creará las tablas y datos iniciales.
   - O dejar el archivo `sql/noticiero.sql` en su ubicación dentro del repo. El código incluye un _auto-deploy_ que ejecutará el SQL desde `sql/noticiero.sql` si la base de datos está vacía.

	Nota: si no importas manualmente y no colocas `sql/noticiero.sql` en el proyecto, el auto-deploy no podrá crear las tablas.
3. Inicia Apache y MySQL desde el panel de control de XAMPP.
4. Abre tu navegador y navega a: `http://localhost/TPE-Web-2/` (o la URL que corresponda según donde lo hayas clonado).

## Estructura de directorios
A continuación una descripción rápida de las carpetas/archivos más importantes del proyecto:

- `controllers/` — Controladores que manejan la lógica de la aplicación y orquestan modelo/vista. Ej: `noticia.controller.php`, `auth.controller.php`.
- `models/` — Acceso a datos y consultas SQL (PDO). Ej: `noticia.model.php`, `user.model.php`.
- `views/` — Clases que preparan y cargan plantillas (templates) para mostrar contenido.
- `templates/` — Plantillas PHTML (HTML + PHP) usadas por las vistas para renderizar páginas (header/footer, formularios, listados).
- `css/` — Hojas de estilo para la apariencia del sitio.
- `middlewares/` — Middlewares para sesiones y control de acceso (ej. `session.middleware.php`, `guard.middleware.php`).
- `sql/` — Archivo de volcado SQL inicial `noticiero.sql` usado por el auto-deploy (debes mantenerlo aquí o importarlo manualmente).
- `router.php` — Punto de entrada / enrutador de la aplicación que define las rutas y crea el `request`.
- `config.php` — Configuración de conexión a la base de datos.
- `readME.md` — Este archivo con instrucciones y notas del proyecto.



