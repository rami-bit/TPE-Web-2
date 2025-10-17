<?php 
class NoticiasView {

    function mostrarNoticias($noticias, $user) {
        require_once  './templates/adminNoticias.phtml';
    }


    function showError($error, $user) {
        echo $error;
    }

    function mostrarNoticia($noticia, $user) {
        require_once './templates/noticia.phtml';
    }

    function showEditar($noticia,$user) {
        require_once './templates/editarNoticia.phtml';
    }   
}


?>