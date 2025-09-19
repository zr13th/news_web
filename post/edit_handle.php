<?php
require_once '../config/db.php';
$requireEditor = true;
require_once '../admin/check_auth.php';

$ID = $_POST['ID'];
$MaChuDe = $_POST['MaChuDe'];
$TieuDe = $_POST['TieuDe'];
$TomTat = $_POST['TomTat'];
$NoiDung = $_POST['NoiDung'];

$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 1️⃣ Lấy bài viết hiện tại (để biết ảnh cũ)
$stmt = $conn->prepare("SELECT HinhAnh FROM tbl_baiviet WHERE ID = :ID");
$stmt->bindValue(':ID', $ID);
$stmt->execute();
$currentPost = $stmt->fetch(PDO::FETCH_ASSOC);
$oldImage = $currentPost['HinhAnh'] ?? null;

$fileName = $oldImage; // mặc định giữ nguyên ảnh cũ
$isNewImageUploaded = !empty($_FILES['HinhAnh']['name']);

if ($isNewImageUploaded) {
    $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['HinhAnh']['name']);
    $destPath = $uploadDir . $fileName;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (in_array($_FILES['HinhAnh']['type'], $allowedTypes)) {
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // 2️⃣ Nếu có ảnh cũ, xóa file cũ
            if (!empty($oldImage) && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
        } else {
            die('Không thể upload ảnh.');
        }
    } else {
        die('Định dạng ảnh không hợp lệ.');
    }
}

echo $ID . 'cc';

try {
    $KiemDuyet = $_SESSION['QuyenHan'] == 1 ? 1 : 0;

    if ($isNewImageUploaded) {
        $sql = 'UPDATE tbl_baiviet
                SET MaChuDe = :MaChuDe,
                    TieuDe = :TieuDe,
                    TomTat = :TomTat,
                    NoiDung = :NoiDung,
                    KiemDuyet = :KiemDuyet,
                    HinhAnh = :HinhAnh
                WHERE ID = :ID';
    } else {
        $sql = 'UPDATE tbl_baiviet
                SET MaChuDe = :MaChuDe,
                    TieuDe = :TieuDe,
                    TomTat = :TomTat,
                    NoiDung = :NoiDung,
                    KiemDuyet = :KiemDuyet
                WHERE ID = :ID';
    }

    $cmd = $conn->prepare($sql);
    $cmd->bindValue(':ID', $ID);
    $cmd->bindValue(':MaChuDe', $MaChuDe);
    $cmd->bindValue(':TieuDe', $TieuDe);
    $cmd->bindValue(':TomTat', $TomTat);
    $cmd->bindValue(':NoiDung', $NoiDung);
    $cmd->bindValue(':KiemDuyet', $KiemDuyet);
    if ($isNewImageUploaded) {
        $cmd->bindValue(':HinhAnh', $fileName);
    }

    $cmd->execute();

    if ($cmd->rowCount() > 0) {
        $message = 'Cập nhật bài viết thành công!';
    } else {
        $message = 'Không có thay đổi nào được lưu (dữ liệu cũ giống dữ liệu mới).';
    }
    include_once '../includes/success.php';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include_once '../includes/error.php';
}
