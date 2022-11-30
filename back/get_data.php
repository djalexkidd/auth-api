<?php
require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

if ($database->is_user_connected()) {
    echo "bite";
}