<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("All we had to do was follow the damn train CJ !");
}

require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

$database->register($_REQUEST['username'], $_REQUEST['password']);