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

    public function getNoticias() {
        $query = $this->db->query('select * from noticia');
        $query->execute();

        $noticias = $query->fetchAll(PDO::FETCH_OBJ);
        return $noticias;
    }

    public function getNoticiaById($id) {
        $query = $this->db->prepare('select * from noticia where id = ?');
        $query->execute([$id]);

        $noticia = $query->fetch(PDO::FETCH_OBJ);
        return $noticia;
    }


}