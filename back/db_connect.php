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

        $query = $dbh->prepare("SELECT email FROM users WHERE email = '$username'");
        $query->execute();

        if( $query->rowCount() > 0 ) { # If rows are found for query
            die("L'utilisateur existe déjà");
        } else {
            $sql = "INSERT INTO users (id, email, password, rank) VALUES (:id, :username, :password, :rank)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
        }
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout() {
        setcookie("token", null, 1);

        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $insertToken = $dbh->prepare("UPDATE users SET token = null WHERE token = '$_COOKIE[token]'");
        $insertToken->execute();
    }

    /**
     * Vérifie si l'utilisateur est connecté
     * @return bool
     */
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

    /**
     * Sélectionne tout dans une table
     * @param string $table Nom de la table
     * @return array
     */
    public function get_table($table) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sth = $dbh->prepare("SELECT * FROM $table");
        $sth->execute();
        $result = $sth->fetchAll();

        return $result;
    }

    /**
     * Récupère les informations de l'utilisateur connecté
     * @return array
     */
    public function get_myself_info() {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sth = $dbh->prepare("SELECT email, rank FROM users WHERE token = '$_COOKIE[token]'");
        $sth->execute();
        $result = $sth->fetchAll();

        return $result;
    }

    /**
     * Ajouter un fruit
     * @param string $fruit_name Nom du fruit
     */
    public function add_fruit($fruit_name) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sql = "INSERT INTO fruits (name) VALUES ('$fruit_name')";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    }

    /**
     * Supprimer un fruit
     * @param string $fruit_name Nom du fruit
     */
    public function delete_fruit($fruit_name) {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        $sql = "DELETE FROM fruits WHERE name = '$fruit_name'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    }
}