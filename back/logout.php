<?php

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    die("405 Method Not Allowed");
}

require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

$database->logout();

header('Location: /front/index.html');
exit;