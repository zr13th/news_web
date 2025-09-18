<?php
require_once '../config/db.php';

$ID = $_POST['ID'];
$MaChuDe = $_POST['MaChuDe'];
$TieuDe = $_POST['TieuDe'];
$TomTat = $_POST['TomTat'];
$NoiDung = $_POST['NoiDung'];

try {
    $KiemDuyet = $_SESSION['QuyenHan'] == 1 ? 1 : 0;

    $sql = 'UPDATE tbl_baiviet
            SET MaChuDe = :MaChuDe,
            TieuDe = :TieuDe,
            TomTat = :TomTat,
            NoiDung = :NoiDung,
            KiemDuyet = :KiemDuyet
            WHERE ID = :ID';

    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':ID', $ID);
    $cmd->bindValue(':MaChuDe', $MaChuDe);
    $cmd->bindValue(':TieuDe', $TieuDe);
    $cmd->bindValue(':TomTat', $TomTat);
    $cmd->bindValue(':NoiDung', $NoiDung);
    $cmd->bindValue(':KiemDuyet', $KiemDuyet);
    $result = $cmd->execute();

    $message = 'Cập nhật bài viết thành công!';
    include_once '../includes/success.php';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/success.php';
}
