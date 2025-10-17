<?php
require_once __DIR__ . '/../config.php';

class NoticiaModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST .
            ";dbname=" . MYSQL_DB . ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->_deploy();
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

    public function getNoticias()
    {
        $query = $this->db->prepare('
        SELECT n.*, s.nombre AS seccion
        FROM noticia n
        JOIN secciones s ON n.seccion_id = s.id
        ');
        $query->execute();

        $noticias = $query->fetchAll(PDO::FETCH_OBJ);
        return $noticias;
    }

    public function getNoticiaById($id)
    {
        $query = $this->db->prepare('select * from noticia where id = ?');
        $query->execute([$id]);

        $noticia = $query->fetch(PDO::FETCH_OBJ);
        return $noticia;
    }

    public function getNoticiasBySeccion($nombre)
    {
        $query = $this->db->prepare('SELECT n.*, s.nombre AS seccion
        FROM noticia n
        JOIN secciones s ON n.seccion_id = s.id
        WHERE LOWER(s.nombre) = LOWER(?)');
        $query->execute([$nombre]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function obtenerSeccionByNombre($nombre)
    {
        $query = $this->db->prepare('SELECT id FROM secciones WHERE LOWER(nombre) = LOWER(?)');
        $query->execute([$nombre]);
        $seccion = $query->fetch(PDO::FETCH_OBJ);
        return $seccion ? $seccion->id : null;
    }

    function insertarNoticia($titulo, $img, $resumen, $contenido, $seccion)
    {
        $query = $this->db->prepare('
        INSERT INTO noticia (titulo, img, resumen, contenido, seccion_id)
        VALUES (?, ?, ?, ?, ?)
        ');
        $query->execute([$titulo, $img, $resumen, $contenido, $seccion]);

        return $this->db->lastInsertId();
    }

    function eliminarNoticia($id)
    {
        $query = $this->db->prepare('DELETE FROM `noticia` WHERE id = ?');
        $query->execute([$id]);
    }

    function editarNoticia($id, $titulo,$img ,$resumen, $contenido,$seccionID )
    {
        $campos = [];
        $valores = [];

        if ($titulo !== null) {
            $campos[] = "titulo = ?";
            $valores[] = $titulo;
        }
        if ($resumen !== null) {
            $campos[] = "resumen = ?";
            $valores[] = $resumen;
        }
        if ($contenido !== null) {
            $campos[] = "contenido = ?";
            $valores[] = $contenido;
        }
        if ($img !== null) {
            $campos[] = "img = ?";
            $valores[] = $img;
        }
        if ($seccionID !== null) {
            $campos[] = "seccion_id = ?";
            $valores[] = $seccionID;
        }

        if (empty($campos)) {
            return false;
        }

        $sql = "UPDATE noticia SET " . implode(", ", $campos) . " WHERE id = ?";

        $valores[] = $id;

        $query = $this->db->prepare($sql);
        $query->execute($valores);
        return true;
    }

    
}