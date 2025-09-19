<?php
require_once '../config/db.php';
$requireAdmin = true;
require_once '../admin/check_auth.php';

$ID = $_GET['id'];

try {
    $sql = "delete from tbl_nguoidung where ID = :ID ";
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':ID', $ID);
    $cmd->execute();

    header('Location: index.php');
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
