<?php
class db_connect {
    /**
     * @var string IP de la base de données
     */
    private $server = "localhost";
    /**
     * @var string Nom d'utilisateur de la base de données
     */
    private $username = "root";
    /**
     * @var string Mot de passe de la base de données
     */
    private $password = "";
    /**
     * @var string Nom de la base de données
     */
    private $db = "stock";

    public function __construct($db, $server, $username, $password) {
        $this->db=$db;
        $this->username=$username;
        $this->password=$password;
        $this->server=$server;
    }

    public function connect() {
        $dbh = new PDO("mysql:host=".$this->server.";"."dbname=".$this->db, $this->username, $this->password);
    }
}