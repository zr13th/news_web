<?php
require_once '../config/db.php';
$requireEditor = true;
require_once '../admin/check_auth.php';

$id = $_GET['id'];

$sql = 'SELECT * FROM tbl_baiviet WHERE ID = :ID';
$cmd = $conn->prepare($sql);
$cmd->bindValue(':ID', $id);
$cmd->execute();
$result = $cmd->fetch();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sửa bài viết - iNews</title>
    <link rel="shortcut icon" href="images/premium.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>

        <div class="card mt-3">
            <h5 class="card-header">Sửa bài viết</h5>
            <div class="card-body">
                <form action="edit_handle.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                    <input type="text" name="ID" value="<?php echo $result['ID']; ?>" hidden />
                    <div class="mb-3">
                        <label for="MaChuDe" class="form-label">Chủ đề</label>
                        <select class="form-select" id="MaChuDe" name="MaChuDe" required>
                            <option value="">-- Chọn --</option>
                            <?php
                            $sql = 'SELECT * FROM tbl_chude';
                            $cmd = $conn->prepare($sql);
                            $cmd->execute();
                            $categories = $cmd->fetchAll();

                            foreach ($categories as $category) {
                                echo '<option value="' . $category['ID'] . '"' . ($category['ID'] == $result['MaChuDe'] ? 'selected' : '') . '>' . $category['TenChuDe'] . '</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Chưa chọn chủ đề.</div>
                    </div>
                    <div class="mb-3">
                        <label for="TieuDe" class="form-label">Tiêu đề bài viết</label>
                        <input type="text" class="form-control" id="TieuDe" name="TieuDe" required value="<?php echo $result['TieuDe'] ?>" />
                        <div class="invalid-feedback">Tiêu đề bài viết không được bỏ trống.</div>
                    </div>
                    <div class="mb-3">
                        <label for="TomTat" class="form-label">Tóm tắt</label>
                        <textarea class="form-control" id="TomTat" name="TomTat" required>
                            <?php echo $result['TomTat'] ?>
                        </textarea>
                        <div class="invalid-feedback">Tóm tắt không được bỏ trống.</div>
                    </div>
                    <div class="mb-3">
                        <label for="NoiDung" class="form-label">Nội dung bài viết</label>
                        <textarea class="form-control" id="NoiDung" name="NoiDung" required>
                            <?php echo $result['NoiDung'] ?>
                        </textarea>
                        <div class="invalid-feedback">Nội dung bài viết không được bỏ trống.</div>
                    </div>
                    <div class="mb-3">
                        <label for="HinhAnh" class="form-label">Ảnh bìa</label>
                        <input type="file" class="form-control" id="HinhAnh" name="HinhAnh" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-floppy"></i> Cập nhật</button>
                </form>
            </div>
        </div>

        <?php include_once '../includes/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/ckeditor5/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#NoiDung'), {
            licenseKey: '',
        }).then(editor => {
            window.editor = editor;
        }).catch(error => {
            console.error(error);
        });

        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <script>

    </script>
</body>

</html>