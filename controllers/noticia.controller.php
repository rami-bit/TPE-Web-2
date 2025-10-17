<?php
 require_once './models/noticia.model.php';
 require_once './views/noticias.view.php'; 

class NoticiaController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new NoticiaModel();
        $this ->view = new NoticiasView();
    }

    public function mostrarNoticias($request) {
        $noticias = $this->model->getNoticias();
        $this->view->mostrarNoticias($noticias,$request->user);
    }

    public function showError($error, $request) {
        $this->view->showError($error,$request->user);
    }

    public function verNoticia($request) {
        $noticia = $this->model->getNoticiaById($request->id);
        
        $this->view->mostrarNoticia($noticia, $request -> user);
    }


    public function agregarNoticia($request) {
        if (!isset($_POST['titulo']) || empty($_POST['titulo'])) {
            return $this->view->showError('Error: falta completar el titulo', $request->user);
        }
        
        if(!isset($_POST['img']) || empty($_POST['img'])) {
            return $this->view->showError('Error: falta completar el link de la imagen', $request->user);
        }

        if (!isset($_POST['resumen']) || empty($_POST['resumen'])) {
            return $this->view->showError('Error: falta completar el resumen', $request->user);
        }

         if (!isset($_POST['contenido']) || empty($_POST['contenido'])) {
            return $this->view->showError('Error: falta completar el contenido', $request->user);
        }
        
        if (!isset($_POST['seccion']) || empty($_POST['seccion'])) {
            return $this->view->showError('Error: falta completar la seccion', $request->user);
        }

        $titulo = $_POST['titulo'];
        $img = $_POST['img'];
        $resumen = $_POST['resumen'];
        $contenido = $_POST['contenido'];
       
        $seccion = $this->obtenerSeccionByNombre($_POST['seccion']);
        if ($seccion == null) {
            return $this->view->showError("Error Seccion aun no existente",$request->user);
        }

        $id = $this -> model -> insertarNoticia($titulo, $img, $resumen, $contenido, $seccion);

        if (!$id) {
            return $this->view->showError('Error al insertar la noticia', $request->user);
        } 

        header('Location: ' . BASE_URL);

    }


    private function obtenerSeccionByNombre($nombre) {
        $seccion = $this->model->obtenerSeccionByNombre($nombre);
        return $seccion;
    }

    public function eliminarNoticia($request) {
        $id = $request->id ?? null;
        if (!$id) {
            return $this->view->showError("Id de noticia no proporcionado", $request->user);
        }

        $noticia = $this->model->getNoticiaById($id);
        if ($noticia === null) {
            return $this->view->showError("Noticia no existente", $request->user);
        }

    
        $this->model->eliminarNoticia($id);
        header('Location: ' . BASE_URL);
    }
        

    public function showEditar($request) {
        $noticia = $this->model->getNoticiaById($request->id);

        $this->view->showEditar($noticia,$request->user);
    }


    public function guardarEdicionNoticia($request) {
        if (!isset($_POST['titulo']) && !isset($_POST['imagen']) && !isset($_POST['resumen']) && !isset($_POST['contenido']) && !isset($_POST['seccion_id'])) {
            return $this->view->showError("Falta rellenar al menos un campo",$request->user);
        }

        if (isset($_POST['titulo'])) {
            $titulo = $_POST['titulo'];
        }else {
            $titulo = null;
        }

        if (isset($_POST['imagen'])) {
            $imagen = $_POST['imagen'];
        }else{
            $imagen = null;
        }

        if (isset($_POST['resumen'])) {
            $resumen = $_POST['resumen'];
        }else {
            $resumen = null;
        }
        
        if (isset($_POST['contenido'])) {
            $contenido = $_POST['contenido'];
        }else {
            $contenido = null;
        }
        
        if(isset($_POST['seccion_id'])) {
            $seccion = $_POST['seccion_id'];
            $seccionID = $this->obtenerSeccionByNombre($seccion);
        }else{
            $seccionID = null;
        }
        
        $edito = $this->model->editarNoticia($request->id,$titulo,$imagen,$resumen,$contenido,$seccionID);

        if (!$edito) {
            return $this->view->showError('No se pudo editar la noticia', $request->user);
        } 

        header('Location: ' . BASE_URL);
        
    }

    
}