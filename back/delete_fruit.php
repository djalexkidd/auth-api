<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    die("405 Method Not Allowed");
}

require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

if ($database->is_user_connected() && $database->get_myself_info()[0]["rank"] == "admin") {
    $database->delete_fruit($_REQUEST['fruit']);
    header('Location: /front/admin.html');
    exit;
} else {
    http_response_code(403);
}