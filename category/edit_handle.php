<?php
require_once '../config/db.php';
$requireAdmin = true;
require_once '../admin/check_auth.php';

$ID = $_POST['ID'];
$TenChuDe = $_POST['TenChuDe'];

try {
    $sql = "update tbl_chude set TenChuDe = :TenChuDe where ID = :ID ";
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':TenChuDe', $TenChuDe);
    $cmd->bindValue(':ID', $ID);
    $cmd->execute();

    header('Location: index.php');
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
