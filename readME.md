📌 TPE Primera Entrega

👥 Integrantes del Grupo
- Tobias Davila — tobiasdavnic.13@gmail.com
- Ramiro Del Valle — ramidv12@gmail.com

📖 Contexto
El presente repositorio corresponde a la primera entrega del Trabajo Práctico Especial de la materia Web 2. El objetivo es desarrollar un sitio web dinámico que permita la visualización y administración de un conjunto de ítems.
El acceso al portal será público para cualquier usuario, mientras que solo la cuenta de administrador dispondrá de permisos para crear, modificar y eliminar contenidos.

📰 Temática: Portal de Noticias de Videojuegos
La aplicación gira en torno a un portal de noticias dedicado al mundo de los videojuegos. Los visitantes podrán explorar artículos organizados por secciones temáticas, y cada noticia incluirá atributos como título, resumen e imagen asociada.

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
