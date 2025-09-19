<?php
require_once '../../config/db.php';
$requireAdmin = true;
require_once '../check_auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body>
    <div class="container">
        <?php include_once '../../includes/navbar.php'; ?>
        <div class="card mt-4">
            <div class="card-header">
                Bài viết đã duyệt
            </div>
            <div class="card-body">
                <a href="moderation.php" class="btn btn-warning ms-2"><i class="bi bi-pen"></i> Chưa duyệt</a>

                <table class="table table-sm table-hover table-striped table-bordered mt-3 mb-0">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Người đăng</th>
                            <th width="10%">Chủ đề</th>
                            <th width="40%">Tiêu đề</th>
                            <th width="15%">Ngày đăng</th>
                            <th width="7%">Duyệt</th>
                            <th width="5%">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Sắp xếp bài chưa duyệt lên trên
                        $sql = 'SELECT b.*, c.TenChuDe, n.HoVaTen
                        FROM tbl_baiviet b
                        JOIN tbl_chude c ON b.MaChuDe = c.ID
                        JOIN tbl_nguoidung n ON b.MaNguoiDung = n.ID
                        WHERE KiemDuyet = 1;
                        ORDER BY b.NgayDang DESC';
                        $cmd = $conn->prepare($sql);
                        $cmd->execute();
                        $result = $cmd->fetchAll();

                        if (count($result) != 0) {
                            $stt = 1;
                            foreach ($result as $value) {
                                $isApproved = $value['KiemDuyet'] == 1;
                                $toggleText = $isApproved ? "Bỏ duyệt" : "Duyệt";
                                $toggleClass = $isApproved ? "btn-secondary" : "btn-success";
                                echo '<tr>
                            <td>' . $stt++ . '</td>
                            <td>' . htmlspecialchars($value['HoVaTen']) . '</td>
                            <td>' . htmlspecialchars($value['TenChuDe']) . '</td>
                            <td>
                                    <a href="/post/detail.php?id=' . $value['ID'] . '" class="text-decoration-none">
                                    ' . $value['TieuDe'] . '
                                    </a>
                            </td>
                            <td>' . $value['NgayDang'] . '</td>
                            <td class="text-center">
                                <a href="toggle_approve.php?id=' . $value['ID'] . '" class="btn btn-sm ' . $toggleClass . '">' . $toggleText . '</a>
                            </td>
                            <td class="text-center">
                                <a
                                    href="#"
                                    class="btn-delete"
                                    data-id="' . $value['ID'] . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                >
                                    <i class="bi bi-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>';
                            }
                        } else {
                            echo '<tr>
                            <td colspan="8" class="text-center text-muted">
                                Chưa có bài viết nào.
                            </td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include_once '../../includes/footer.php'; ?>
    </div>

    <!-- Modal Xác Nhận Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa <b>bài viết</b> không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('confirmDeleteBtn').href = '/post/delete_handle.php?id=' + id;
            });
        });
    </script>

</body>

</html>