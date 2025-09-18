<?php
require_once '../config/db.php';

$HoVaTen = $_POST['HoVaTen'];
$TenDangNhap = $_POST['TenDangNhap'];
$MatKhau = $_POST['MatKhau'];
$XacNhanMatKhau = $_POST['XacNhanMatKhau'];
$QuyenHan = $_POST['QuyenHan'];
$Khoa = empty($_POST['KhoaTaiKhoan']) ? 0 : 1;

try {
    $sql = 'INSERT INTO tbl_nguoidung(HoVaTen, TenDangNhap, MatKhau, QuyenHan, Khoa)
 VALUES (:HoVaTen, :TenDangNhap, :MatKhau, :QuyenHan, :Khoa)';
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':HoVaTen', $HoVaTen);
    $cmd->bindValue(':TenDangNhap', $TenDangNhap);
    $cmd->bindValue(':MatKhau', sha1($MatKhau));
    $cmd->bindValue(':QuyenHan', $QuyenHan);
    $cmd->bindValue(':Khoa', $Khoa);
    $result = $cmd->execute();

    header('Location: index.php');
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
