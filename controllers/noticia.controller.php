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

    public function mostrarNoticias() {
        $noticias = $this->model->getNoticias();
        $this->view->mostrarNoticias($noticias);
    }

    public function showError($error) {
        $this->view->showError($error);
    }

    public function verNoticia($id) {
        $noticia = $this->model->getNoticiaById($id);
        
        $this->view->mostrarNoticia($noticia);
    }
}