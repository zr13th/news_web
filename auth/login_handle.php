<?php
require_once '../config/db.php';

$TenDangNhap = $_POST['TenDangNhap'];
$MatKhau = $_POST['MatKhau'];

try {
    $sql = 'SELECT * FROM tbl_nguoidung WHERE TenDangNhap = :TenDangNhap AND MatKhau = :MatKhau';
    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':TenDangNhap', $TenDangNhap);
    $cmd->bindValue(':MatKhau', sha1($MatKhau));
    $cmd->execute();
    $result = $cmd->fetch();
    if ($result) {
        if ($result['Khoa'] == 1) {
            $error_message = "Tài khoản đã bị khóa!";
            include_once '../includes/error.php';
        } else {
            $_SESSION['ID'] = $result['ID'];
            $_SESSION['HoVaTen'] = $result['HoVaTen'];
            $_SESSION['QuyenHan'] = $result['QuyenHan'];

            header('Location: ../index.php');
        }
    } else {
        $error_message = "Tài khoản không tồn tại!";
        include_once '../includes/error.php';
    }
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
