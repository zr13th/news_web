<?php

if (!isset($_SESSION['QuyenHan'])) {
    header("Location: /index.php");
    exit;
}

// Kiểm tra quyền admin chung
$requireAdmin = $requireEditor = false; // mặc định không yêu cầu

// Nếu file cần admin mới vào được
if (isset($requireAdmin) && $requireAdmin && $_SESSION['QuyenHan'] !== 1) {
    header("Location: /index.php");
    exit;
}

// Nếu file cho phép admin + editor
if (
    isset($requireEditor) && $requireEditor &&
    !in_array($_SESSION['QuyenHan'], ['admin', 2])
) {
    header("Location: /index.php");
    exit;
}
