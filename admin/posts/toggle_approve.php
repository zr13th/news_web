<?php
require_once '../../config/db.php';
$requireAdmin = true;
require_once '../check_auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {

    $stmt = $conn->prepare("SELECT KiemDuyet FROM tbl_baiviet WHERE ID = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $post = $stmt->fetch();

    if ($post) {
        $newStatus = $post['KiemDuyet'] == 1 ? 0 : 1;
        $update = $conn->prepare("UPDATE tbl_baiviet SET KiemDuyet = :status WHERE ID = :id");
        $update->bindValue(':status', $newStatus);
        $update->bindValue(':id', $id);
        $update->execute();
    }
}

$redirect = $_SERVER['HTTP_REFERER'];
header("Location: $redirect");
exit;
