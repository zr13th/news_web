<?php
require_once '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo "Bài viết không hợp lệ.";
    exit;
}

$sql = 'SELECT b.*, u.HoVaTen AS TenTacGia
FROM tbl_baiviet b
LEFT JOIN tbl_nguoidung u ON b.MaNguoiDung = u.ID
WHERE b.ID = :id';

$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$baiviet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$baiviet) {
    echo "Bài viết không tồn tại.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($baiviet['TieuDe']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body class="bg-light">

    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($baiviet['TieuDe']) ?></h2>
                <p class="text-muted mb-3">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($baiviet['TenTacGia']) ?> |
                    <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($baiviet['NgayDang'])) ?>
                </p>
                <hr>
                <div class="card-text">
                    <?= $baiviet['NoiDung'] ?>
                </div>
                <a href="/" class="btn btn-outline-primary mt-4"><i class="bi bi-arrow-left"></i> Quay về</a>
            </div>
        </div>
    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>