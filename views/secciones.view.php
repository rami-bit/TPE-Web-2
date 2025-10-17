<?php
class SeccionesView {
    
    function mostrarSecciones($secciones, $user) {
        require_once './templates/adminSecciones.phtml';
    }

    function mostrarNoticiasPorSeccion($noticias,$user) {
        require_once './templates/noticias.phtml';
    }

    function showError($error, $user) {
        echo $error;
    }

    function showEditar($seccion, $user) {
        require_once './templates/editarSecciones.phtml';
    }
}