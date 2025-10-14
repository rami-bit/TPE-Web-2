<?php 
class NoticiasView {

    function mostrarNoticias($noticias) {
        require_once  './templates/noticias.php';
    }


    function showError($error) {
        echo $error;
    }

    function mostrarNoticia($noticia) {
        require_once './templates/noticia.php';
    }
}


?>