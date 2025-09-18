<?php
require_once '../config/db.php';

$HoVaTen = $_POST['HoVaTen'];
$TenDangNhap = $_POST['TenDangNhap'];
$MatKhau = $_POST['MatKhau'];
$XacNhanMatKhau = $_POST['XacNhanMatKhau'];

try {
    $sql = 'INSERT INTO tbl_nguoidung(HoVaTen, TenDangNhap, MatKhau, QuyenHan, Khoa)
 VALUES (:HoVaTen, :TenDangNhap, :MatKhau, :QuyenHan, :Khoa)';
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':HoVaTen', $HoVaTen);
    $cmd->bindValue(':TenDangNhap', $TenDangNhap);
    $cmd->bindValue(':MatKhau', sha1($MatKhau));
    $cmd->bindValue(':QuyenHan', 3);
    $cmd->bindValue(':Khoa', 0);
    $result = $cmd->execute();

    $_SESSION['ID'] = $result['ID'];
    $_SESSION['HoVaTen'] = $result['HoVaTen'];
    $_SESSION['QuyenHan'] = $result['QuyenHan'];

    header('Location: ../index.php');
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
