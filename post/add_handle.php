<?php
require_once '../config/db.php';
$requireEditor = true;
require_once '../admin/check_auth.php';

$MaChuDe = $_POST['MaChuDe'];
$TieuDe = $_POST['TieuDe'];
$TomTat = $_POST['TomTat'];
$NoiDung = $_POST['NoiDung'];

$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileName = null;
if (!empty($_FILES['HinhAnh']['name'])) {
    $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['HinhAnh']['name']);
    $destPath = $uploadDir . $fileName;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (in_array($_FILES['HinhAnh']['type'], $allowedTypes)) {
        if (move_uploaded_file($fileTmpPath, $destPath)) {
        } else {
            die('Không thể upload ảnh.');
        }
    } else {
        die('Định dạng ảnh không hợp lệ.');
    }
}

try {
    $MaNguoiDung = $_SESSION['ID'];

    $KiemDuyet = $_SESSION['QuyenHan'] == 1 ? 1 : 0;

    $sql = 'INSERT INTO tbl_baiviet(MaChuDe, MaNguoiDung, TieuDe, TomTat, NoiDung, NgayDang, LuotXem, KiemDuyet, HinhAnh)
    VALUES (:MaChuDe, :MaNguoiDung, :TieuDe, :TomTat, :NoiDung, :NgayDang, :LuotXem, :KiemDuyet, :HinhAnh)';

    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':MaChuDe', $MaChuDe);
    $cmd->bindValue(':MaNguoiDung', $MaNguoiDung);
    $cmd->bindValue(':TieuDe', $TieuDe);
    $cmd->bindValue(':TomTat', $TomTat);
    $cmd->bindValue(':NoiDung', $NoiDung);
    $cmd->bindValue(':NgayDang', date('Y-m-d H:i:s'));
    $cmd->bindValue(':LuotXem', 0);
    $cmd->bindValue(':KiemDuyet', $KiemDuyet);
    $cmd->bindValue(':HinhAnh', $fileName);
    $result = $cmd->execute();

    $message = 'Đăng bài viết thành công!';
    include_once '../includes/success.php';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
