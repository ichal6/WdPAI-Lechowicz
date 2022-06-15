<?php
require_once 'Database.php';

$db = new Database();
$conn = $db->connect();
$db->executeSQLFile('init-database.sql', $conn);
