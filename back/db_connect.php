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

    public function connect() {
        $dbh = new PDO("mysql:host=".$this->db_host.";"."dbname=".$this->db_name, $this->db_username, $this->db_password);
        // utiliser la connexion ici
        $sth = $dbh->query('SELECT * FROM users');

        foreach ($sth as $row) {
            print($row['email']);
        }
    }
}