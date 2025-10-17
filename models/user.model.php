<?php 

require_once __DIR__ . '/../config.php';

class UserModel {
    private $db;

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

   public function get($id) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = ?');
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }

    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE nombre = ?');
        $query->execute([$user]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }
    
    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM usuarios');
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_OBJ);

        return $users;
    }
}