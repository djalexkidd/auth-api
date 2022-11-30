<?php
class db_connect {
    /**
     * @var string IP de la base de données
     */
    private $db_host = "192.168.122.58";
    /**
     * @var string Nom d'utilisateur de la base de données
     */
    private $db_username = "admin";
    /**
     * @var string Mot de passe de la base de données
     */
    private $db_password = "bite";
    /**
     * @var string Nom de la base de données
     */
    private $db_name = "auth_api";

    public function __construct($db_name, $db_host, $db_username, $db_password) {
        $this->db_name=$db_name;
        $this->db_username=$db_username;
        $this->db_password=$db_password;
        $this->db_host=$db_host;
    }

    /**
     * Connexion à un compte utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     */
    public function connect($username, $password) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        // utiliser la connexion ici
        $sth = $dbh->prepare("SELECT * FROM users WHERE email = '$username'");
        $sth->execute();
        $result = $sth->fetchAll();

        $token = uniqid();
        $insertToken = $dbh->prepare("UPDATE users SET token = '$token' WHERE email = '$username'");

        if ($username == $result[0]['email'] && password_verify($password, $result[0]['password'])) {
            $insertToken->execute();
            setcookie("token", $token, time()+3600); // Le cookie expire dans 1 heure
            header('Location: /front/index.html');
            exit;
        } else {
            echo "Incorrect";
        }
    }

    /**
     * Création d'un nouvel utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     */
    public function register($username, $password) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);

        $options = [
            'cost' => 12,
        ];

        $data = [
            'id' => 0,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT, $options),
            'rank' => "member",
        ];

        $sql = "INSERT INTO users (id, email, password, rank) VALUES (:id, :username, :password, :rank)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: /front/login.html');
        exit;
    }

    public function logout() {
        setcookie("token", null, 1);

        header('Location: /front/index.html');
        exit;
    }

    public function is_user_connected() {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sth = $dbh->prepare("SELECT token FROM users WHERE token = '$_COOKIE[token]'");
        $sth->execute();
        $result = $sth->fetchAll();

        if ($_COOKIE['token'] == $result[0]['token'] && $_COOKIE['token'] != null) {
            return True;
        }
        else {
            return False;
        }
    }

    public function get_table($table) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sth = $dbh->prepare("SELECT * FROM $table");
        $sth->execute();
        $result = $sth->fetchAll();

        return $result;
    }

    public function get_myself_info() {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sth = $dbh->prepare("SELECT email, rank FROM users WHERE token = '$_COOKIE[token]'");
        $sth->execute();
        $result = $sth->fetchAll();

        return $result;

    }
}