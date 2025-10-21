<?php
require_once 'controllers/noticia.controller.php';
require_once 'controllers/secciones.controller.php';
require_once 'controllers/auth.controller.php';
require_once 'middlewares/guard.middleware.php';
require_once 'middlewares/session.middleware.php';

/** Tabla de Ruteo (actualizada):
 * Formato: ruta -> Controlador->método(parametros)
 *
 * noticias                      -> NoticiaController->mostrarNoticias($request)
 * verNoticia/:ID                -> NoticiaController->verNoticia($request)           (requiere id en $params[1])
 * secciones                     -> SeccionesController->listarSecciones($request)
 * secciones/:nombreSeccion      -> SeccionesController->getNoticiasBySeccion($nombre,$request)
 * login                         -> AuthController->showLogin($request)
 * do_login                      -> AuthController->doLogin($request)
 * logout                        -> AuthController->logout($request)
 * agregar                       -> NoticiaController->agregarNoticia($request)         (requiere sesión - GuardMiddleware)
 * eliminarNoticia/:ID           -> NoticiaController->eliminarNoticia($request)      (requiere id y sesión - GuardMiddleware)
 * editarNoticia/:ID             -> NoticiaController->showEditar($request)           (muestra formulario - requiere sesión)
 * guardarEdicionNoticia/:ID     -> NoticiaController->guardarEdicionNoticia($request) (guarda cambios - requiere sesión)
 * agregarSeccion                -> SeccionesController->agregarSeccion($request)     (requiere sesión - GuardMiddleware)
 * eliminarSeccion/:ID           -> SeccionesController->eliminarSeccion($request)    (requiere id y sesión - GuardMiddleware)
 * editarSeccion/:ID             -> SeccionesController->showEditar($request)         (muestra formulario - requiere sesión)
 * guardarEdicionSeccion/:ID     -> SeccionesController->editar($request)             (guarda cambios - requiere sesión)

 */

session_start();


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$action = "noticias";
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

$request = new StdClass();
$request = (new SessionMiddleware())->run($request);

switch ($params[0]) {
    case 'noticias':
        $noticiasController = new NoticiaController();
        $noticiasController->mostrarNoticias($request);
        break;
    case 'verNoticia':
        $noticiasController = new NoticiaController();
        $request->id = $params[1] ?? null;
        if ($request->id) {
            $noticiasController->verNoticia($request);
            break;
        }
        $noticiasController->showError("Noticia vacia", $request);
        break;

    case 'secciones':
        $seccionesController = new SeccionesController();

        if (isset($params[1])) {
            $seccionesController->getNoticiasBySeccion($params[1], $request);
        } else {
            $seccionesController->listarSecciones($request);
        }
        break;
    case 'login':
        $authController = new AuthController();
        $authController->showLogin($request);
        break;
    case 'do_login':
        $authController = new AuthController();
        $authController->doLogin($request);
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout($request);
        break;

    case 'agregar':
        $request = (new GuardMiddleware())->run($request);
        $controller = new NoticiaController();
        $controller->agregarNoticia($request);
        break;
    case 'eliminarNoticia':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1] ?? null;
        $controllerNoticia = new NoticiaController();
        if ($request->id) {
            $controllerNoticia->eliminarNoticia($request);
        }
        break;
    case 'editarNoticia':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1];
        $controllerNoticia = new NoticiaController();
        $controllerNoticia->showEditar($request);
        break;
    case 'guardarEdicionNoticia':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1];
        $controllerNoticia = new NoticiaController();
        $controllerNoticia->guardarEdicionNoticia($request);
        break;
    case 'agregarSeccion':
        $request = (new GuardMiddleware())->run($request);
        $controllerSeccion = new SeccionesController();
        $controllerSeccion->agregarSeccion($request);
        break;
    case 'eliminarSeccion':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1];
        $controllerSeccion = new SeccionesController();
        $controllerSeccion->eliminarSeccion($request);
        break;
    case 'editarSeccion':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1];
        $controllerSeccion = new SeccionesController();
        $controllerSeccion->showEditar($request);
        break;
    case 'guardarEdicionSeccion':
        $request = (new GuardMiddleware())->run($request);
        $request->id = $params[1];
        $controllerSeccion = new SeccionesController();
        $controllerSeccion->editar($request);
        break;
    default:
        $noticiasController = new NoticiaController();
        $noticiasController->showError("Errror 404 not found", $request);
        break;
}

