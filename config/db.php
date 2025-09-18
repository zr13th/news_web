<?php

$dsn = 'mysql:host=localhost;dbname=trangtin;charset=utf8mb4';
$user = 'root';
$pass = '';
$option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $conn = new PDO($dsn, $user, $pass, $option);
} catch (PDOException $e) {
    echo $e->getMessage();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
