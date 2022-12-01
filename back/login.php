<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    die("405 Method Not Allowed");
}

require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

if ($database->connect($_REQUEST['username'], $_REQUEST['password'])) {
    header('Location: /front/index.html');
    exit;
} else {
    header('Location: /front/login.html?status=incorrect');
    exit;
}