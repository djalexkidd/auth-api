<?php
require("db_connect.php");

$database = new db_connect("auth_api", "192.168.122.58", "admin", "bite");

$database->connect();