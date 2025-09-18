<?php
require_once '../config/db.php';
$MaChuDe = $_POST['MaChuDe'];
$TieuDe = $_POST['TieuDe'];
$TomTat = $_POST['TomTat'];
$NoiDung = $_POST['NoiDung'];

try {
    $MaNguoiDung = $_SESSION['ID'];

    $KiemDuyet = $_SESSION['QuyenHan'] == 1 ? 1 : 0;

    $sql = 'INSERT INTO tbl_baiviet(MaChuDe, MaNguoiDung, TieuDe, TomTat, NoiDung, NgayDang, LuotXem, KiemDuyet)
    VALUES (:MaChuDe, :MaNguoiDung, :TieuDe, :TomTat, :NoiDung, :NgayDang, :LuotXem, :KiemDuyet)';

    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':MaChuDe', $MaChuDe);
    $cmd->bindValue(':MaNguoiDung', $MaNguoiDung);
    $cmd->bindValue(':TieuDe', $TieuDe);
    $cmd->bindValue(':TomTat', $TomTat);
    $cmd->bindValue(':NoiDung', $NoiDung);
    $cmd->bindValue(':NgayDang', date('Y-m-d H:i:s'));
    $cmd->bindValue(':LuotXem', 0);
    $cmd->bindValue(':KiemDuyet', $KiemDuyet);
    $result = $cmd->execute();

    $message = 'Đăng bài viết thành công!';
    include_once '../includes/success.php';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/success.php';
}
