<?php
require_once './models/secciones.model.php';
require_once './views/secciones.view.php';
class SeccionesController
{
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new SeccionesView();
        $this->model = new SeccionesModel();
    }

    public function listarSecciones($request)
    {
        $secciones = $this->model->getSecciones();

        $this->view->mostrarSecciones($secciones, $request->user);
    }

    public function getNoticiasBySeccion($nombre,$request)
    {
        $nombre = str_replace('-', ' ', $nombre);
        $noticias = $this->model->getNoticiasBySeccion($nombre);
        $this->view->mostrarNoticiasPorSeccion($noticias,$request->user);
    }

    public function agregarSeccion($request) {
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            return $this->view->showError("Error Campo obligatorio: falta el nombre", $request->user);
        }

       if (!isset($_POST['img_url']) || empty($_POST['img_url'])) {
            return $this->view->showError("Error Campo obligatorio: falta la imgen", $request->user);
        }

        if (!isset($_POST['genero']) || empty($_POST['genero'])) {
            return $this->view->showError("Error Campo obligatorio: falta el genero", $request->user);
        }

        $nombre = $_POST['nombre'];
        $img = $_POST['img_url'];
        $genero = $_POST['genero'];

        $id = $this->model->insertarSeccion($nombre, $img, $genero);

        if (!$id) {
            return $this->view->showError('Error al insertar la noticia', $request->user);
        } 

        header('Location: ' . BASE_URL . 'secciones');
    }

    public function eliminarSeccion($request) {
        $id = $request->id ?? null;
        if (!$id) {
            return $this->view->showError("Id de Seccion no proporcionado", $request->user);
        }

        $noticia = $this->model->getSeccion($id);
        if ($noticia === null) {
            return $this->view->showError("Seccion no existente", $request->user);
        }

    
        $this->model->eliminarSeccion($id);
        header('Location: ' . BASE_URL .'/secciones');
    }


    public function showEditar($request) {
        $seccion = $this->model->getSeccion($request->id);
        $this->view->showEditar($seccion,$request->user);
    }


    public function editar($request) {
        if (!isset($_POST['nombre']) && !isset($_POST['imagen']) && !isset($_POST['genero'])) {
            return $this->view->showError("Falta rellenar al menos un campo",$request->user);
        }

        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }else {
            $nombre = null;
        }

        if (isset($_POST['imagen'])) {
            $imagen = $_POST['imagen'];
        }else{
            $imagen = null;
        }

        if (isset($_POST['genero'])) {
            $genero = $_POST['genero'];
        }else {
            $genero = null;
        }
        
        $edito = $this->model->editarSecciones($request->id,$nombre,$imagen,$genero);

        if (!$edito) {
            return $this->view->showError('No se pudo editar la Seccion', $request->user);
        } 

        header('Location: ' . BASE_URL . '/secciones');
        
    }

}