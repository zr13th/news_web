<?php
require_once '../config/db.php';
$requireEditor = true;
require_once '../admin/check_auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

</head>

<body>
    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>
        <div class="card mt-4">
            <div class="card-header">
                Bài viết
            </div>
            <div class="card-body">
                <p><a href="add.php" class="btn btn-warning"><i class="bi bi-plus-lg"></i> Thêm</a></p>

                <table class="table table-sm table-hover table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Người đăng</th>
                            <th width="10%">Chủ đề</th>
                            <th width="40%">Tiêu đề</th>
                            <th width="15%">Ngày đăng</th>
                            <th width="7%" title="Tình trạng kiểm duyệt">D?</th>
                            <th width="5%">Sửa</th>
                            <th width="5%">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = 'SELECT b.*, c.TenChuDe, n.HoVaTen
                            FROM tbl_baiviet b, tbl_chude c, tbl_nguoidung n
                            WHERE b.MaChuDe = c.ID AND b.MaNguoiDung = n.ID';
                        $cmd = $conn->prepare($sql);
                        $cmd->execute();
                        $result = $cmd->fetchAll();

                        if (count($result) != 0) {
                            $stt = 1;
                            foreach ($result as $value) {
                                echo '<tr>
                                    <td>' . $stt++ . '</td>
                                    <td>' . $value['HoVaTen'] . '</td>
                                    <td>' . $value['TenChuDe'] . '</td>

                                    <td>
                                        <a href="detail.php?id=' . $value['ID'] . '" class="text-decoration-none">
                                        ' . $value['TieuDe'] . '
                                        </a>
                                    </td>
                                    <td>' . $value['NgayDang'] . '</td>
                                    <td>' . ($value['KiemDuyet'] == 1 ? "Đã duyệt" : "Chưa duyệt") . '</td>
                                    <td class="text-center">
                                        <a href="edit.php?id=' . $value['ID'] . '">
                                            <i class="bi bi-pencil-square text-secondary"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a
                                            href=""
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
                                        <a href="add.php" class="text-primary fw-bold">Thêm ngay</a>
                                    </td>
                                </tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include_once '../includes/footer.php'; ?>

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

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            document.getElementById('confirmDeleteBtn').href = 'delete_handle.php?id=' + id;
        });
    });
</script>

</html>