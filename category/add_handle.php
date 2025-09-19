<?php
require_once '../config/db.php';

$requireAdmin = true;
require_once '../admin/check_auth.php';

$TenChuDe = $_POST['TenChuDe'];

try {
    $sql = "insert into tbl_chude (TenChuDe) values (:TenChuDe)";
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':TenChuDe', $TenChuDe);
    $result = $cmd->execute();

    header('Location: index.php');
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
