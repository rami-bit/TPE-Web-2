<?php
require_once 'controllers/noticia.controller.php';

// Tabla de ruteo:
// Listar items->noticiaController->listarNoticias();
// Mostrar item->noticiaController->verNoticias($id);
define(
    'BASE_URL',
    '//' . $_SERVER['SERVER_NAME'] .
    ':' . $_SERVER['SERVER_PORT'] .
    '/web2/TPE-Web-2/'
);

$action = "noticias";
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);



switch ($params[0]) {
    case 'noticias':
        $noticiasController = new NoticiaController();
        $noticiasController->mostrarNoticias();
    break;
    case 'verNoticia':
        $noticiasController = new NoticiaController();
        $id = $params[1] ?? null;
        if ($id) {
            $noticiasController->verNoticia($id);
            break;
        }
        $noticiasController->showError("Noticia vacia");
    break;

    default:
        $noticiasController = new NoticiaController();
        $noticiasController->showError("Pagina no encontrada");
        break;
    

}

