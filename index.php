<?php
require_once './config/db.php';
require_once './config/helpers.php';

// Lấy danh sách chủ đề
$sql = 'SELECT * FROM tbl_chude';
$cmd = $conn->prepare($sql);
$cmd->execute();
$topics = $cmd->fetchAll();

$currentTopic = isset($_GET['topic']) ? (int) $_GET['topic'] : 0;

// Hàm hiển thị thời gian tương đối
function timeAgo($datetime)
{
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return $diff . ' giây trước';
    if ($diff < 3600) return floor($diff / 60) . ' phút trước';
    if ($diff < 86400) return floor($diff / 3600) . ' giờ trước';
    if ($diff < 2592000) return floor($diff / 86400) . ' ngày trước';

    return date('d/m/Y', $time); // quá 30 ngày thì hiển thị ngày tháng
}

/* ====== LẤY 4 BÀI MỚI NHẤT ====== */
$sql = "SELECT b.ID, b.TieuDe, b.TomTat, b.HinhAnh, b.NgayDang, c.TenChuDe
        FROM tbl_baiviet b
        LEFT JOIN tbl_chude c ON b.MaChuDe = c.ID
        WHERE b.KiemDuyet = 1";

if ($currentTopic > 0) {
    $sql .= " AND b.MaChuDe = :topic";
}

$sql .= " ORDER BY b.NgayDang DESC LIMIT 4";
$cmd = $conn->prepare($sql);

if ($currentTopic > 0) {
    $cmd->bindValue(':topic', $currentTopic, PDO::PARAM_INT);
}

$cmd->execute();
$posts = $cmd->fetchAll();

/* ====== PHÂN TRANG BÀI THỨ 5 TRỞ ĐI ====== */
$limit = 6;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $limit + 4; // bỏ qua 4 bài đầu

// Đếm tổng số bài (trừ 4 bài đầu)
$countSql = "SELECT COUNT(*) FROM tbl_baiviet WHERE KiemDuyet = 1";
if ($currentTopic > 0) {
    $countSql .= " AND MaChuDe = :topic";
}
$countCmd = $conn->prepare($countSql);
if ($currentTopic > 0) {
    $countCmd->bindValue(':topic', $currentTopic, PDO::PARAM_INT);
}
$countCmd->execute();
$totalPosts = $countCmd->fetchColumn();
$totalPostsAfter4 = max(0, $totalPosts - 4);
$totalPages = ceil($totalPostsAfter4 / $limit);

// Lấy bài viết phân trang
$sql = "SELECT b.ID, b.TieuDe, b.TomTat, b.HinhAnh, b.NgayDang, c.TenChuDe
        FROM tbl_baiviet b
        LEFT JOIN tbl_chude c ON b.MaChuDe = c.ID
        WHERE b.KiemDuyet = 1";

if ($currentTopic > 0) {
    $sql .= " AND b.MaChuDe = :topic";
}

$sql .= " ORDER BY b.NgayDang DESC LIMIT :limit OFFSET :offset";

$cmd = $conn->prepare($sql);

if ($currentTopic > 0) {
    $cmd->bindValue(':topic', $currentTopic, PDO::PARAM_INT);
}

$cmd->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
$cmd->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
$cmd->execute();
$highlightPosts = $cmd->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <style>
        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include_once './includes/navbar.php'; ?>

        <!-- Subnav chủ đề -->
        <nav class="navbar navbar-expand bg-light border-bottom mt-3">
            <div class="container-fluid">
                <ul class="navbar-nav d-flex flex-row flex-nowrap overflow-auto w-100 hide-scrollbar">
                    <?php foreach ($topics as $topic): ?>
                        <li class="nav-item flex-shrink-0">
                            <a class="nav-link fs-5 <?= $currentTopic === (int)$topic['ID'] ? 'fw-bold' : '' ?>"
                                href="index.php?topic=<?= $topic['ID'] ?>">
                                <?= htmlspecialchars($topic['TenChuDe']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>

        <div class="card mt-4">
            <div class="card-header">Trang chủ</div>
            <div class="card-body">
                <div class="container my-4">
                    <?php if (count($posts) > 0): ?>
                        <?php
                        $mainPost = $posts[0];
                        $subPosts = array_slice($posts, 1, 3);
                        ?>

                        <!-- Bài lớn -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <a href="/post/detail.php?id=<?= $mainPost['ID'] ?>">
                                            <img src="<?= getPostImage($mainPost['HinhAnh']) ?>"
                                                class="img-fluid rounded object-fit-cover"
                                                style="width: 100%; height: 250px;"
                                                alt="<?= htmlspecialchars($mainPost['TieuDe']) ?>">
                                        </a>
                                    </div>
                                    <div class="col-md-6 d-flex flex-column justify-content-center">
                                        <h3 class="fw-bold">
                                            <a href="/post/detail.php?id=<?= $mainPost['ID'] ?>" class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($mainPost['TieuDe']) ?>
                                            </a>
                                        </h3>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($mainPost['TenChuDe'] ?? 'Chưa phân loại') ?> ·
                                            <?= timeAgo($mainPost['NgayDang']) ?>
                                        </small>
                                        <p class="text-muted mt-2">
                                            <?= htmlspecialchars($mainPost['TomTat']) ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- 3 bài dưới -->
                                <div class="row g-4">
                                    <?php
                                    $stt = 0;
                                    foreach ($subPosts as $post) {
                                    ?>
                                        <div class="col-md-4 <?php echo $stt++ < count($subPosts) - 1 ? 'border-end' : '' ?>">
                                            <div class="card border-0">
                                                <a href="/post/detail.php?id=<?= $post['ID'] ?>">
                                                    <img src="<?= getPostImage($post['HinhAnh']) ?>"
                                                        class="card-img-top rounded object-fit-cover"
                                                        style="width: 100%; height: 200px;"
                                                        alt="<?= htmlspecialchars($post['TieuDe']) ?>">
                                                </a>
                                                <div class="card-body px-0">
                                                    <small class="text-muted d-block mb-1">
                                                        <?= htmlspecialchars($post['TenChuDe'] ?? 'Chưa phân loại') ?> ·
                                                        <?= timeAgo($post['NgayDang']) ?>
                                                    </small>
                                                    <h6 class="card-title fw-semibold">
                                                        <a href="/post/detail.php?id=<?= $post['ID'] ?>" class="text-decoration-none text-dark">
                                                            <?= htmlspecialchars($post['TieuDe']) ?>
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <hr>
                                        <h4 id="posts">Tin tức</h4>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php if (count($highlightPosts) > 0): ?>
                                        <?php foreach ($highlightPosts as $hp): ?>
                                            <div class="col-12 mb-3">
                                                <div class="row g-3 align-items-center border-bottom pb-3">
                                                    <div class="col-md-4">
                                                        <a href="/post/detail.php?id=<?= $hp['ID'] ?>">
                                                            <img src="<?= getPostImage($hp['HinhAnh']) ?>"
                                                                class="img-fluid rounded object-fit-cover"
                                                                style="width: 100%; height: 150px;"
                                                                alt="<?= htmlspecialchars($hp['TieuDe']) ?>">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <small class="text-muted d-block mb-1">
                                                            <?= htmlspecialchars($hp['TenChuDe'] ?? 'Chưa phân loại') ?> ·
                                                            <?= timeAgo($hp['NgayDang']) ?>
                                                        </small>
                                                        <h5 class="mb-2">
                                                            <a href="/post/detail.php?id=<?= $hp['ID'] ?>" class="text-decoration-none text-dark">
                                                                <?= htmlspecialchars($hp['TieuDe']) ?>
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-0"><?= htmlspecialchars($hp['TomTat']) ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">Không có bài viết nào.</div>
                                    <?php endif; ?>
                                </div>


                                <!-- Phân trang -->
                                <?php include_once './includes/pagination.php' ?>

                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">

                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">Chưa có bài viết nào!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include_once './includes/footer.php'; ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>