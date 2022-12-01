<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    die("405 Method Not Allowed");
}

require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

if(filter_var($_REQUEST['username'], FILTER_VALIDATE_EMAIL)) {
    if ($database->register($_REQUEST['username'], $_REQUEST['password'])) {
        header('Location: /front/login.html');
        exit;
    } else {
        header('Location: /front/register.html?status=exists');
        exit;
    }
} else {
    header('Location: /front/register.html?status=regexed');
    exit;
}