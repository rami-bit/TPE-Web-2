<?php
require_once __DIR__ . '/../config.php';
require_once 'noticia.model.php';

class SeccionesModel
{
    private $db;
    private $modelNoticias;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST .
            ";dbname=" . MYSQL_DB . ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->_deploy();
        $this->modelNoticias = new NoticiaModel();
    }

    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();

        if (count($tables) == 0) {
            $sqlFile = __DIR__ . '/sql/noticiero.sql';

            $sql = file_get_contents($sqlFile);

            $this->db->query($sql);

        }
    }

    public function getSecciones()
    {
        $query = $this->db->prepare('select * from secciones');
        $query->execute();

        $secciones = $query->fetchAll(PDO::FETCH_OBJ);
        return $secciones;
    }

    public function getNoticiasBySeccion($nombre)
    {
        $noticias = $this->modelNoticias->getNoticiasBySeccion($nombre);
        return $noticias;
    }

    function insertarSeccion($nombre, $img_url, $genero)
    {
        $query = $this->db->prepare('
        INSERT INTO secciones (nombre, img_url, genero)
        VALUES (?, ?, ?)
        ');
        $query->execute([$nombre, $img_url, $genero]);

        return $this->db->lastInsertId();
    }

    function eliminarSeccion($id)
    {
        $query = $this->db->prepare('DELETE FROM `secciones` WHERE id = ?');
        $query->execute([$id]);
    }

    function editarSecciones($id, $nombre, $img_url, $genero)
    {
        $campos = [];
        $valores = [];

        if ($nombre !== null) {
            $campos[] = "nombre = ?";
            $valores[] = $nombre;
        }
        if ($img_url !== null) {
            $campos[] = "img_url = ?";
            $valores[] = $img_url;
        }
        if ($genero !== null) {
            $campos[] = "genero = ?";
            $valores[] = $genero;
        }

        if (empty($campos)) {
            return false;
        }

        $sql = "UPDATE secciones SET " . implode(", ", $campos) . " WHERE id = ?";

        $valores[] = $id;

        $query = $this->db->prepare($sql);
        $query->execute($valores);
        return true;
    }


    public function getSeccion($id)
    {
        $query = $this->db->prepare('select * from secciones where id = ?');
        $query->execute([$id]);

        $seccion = $query->fetch(PDO::FETCH_OBJ);
        return $seccion;
    }

}