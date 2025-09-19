<?php
include_once '../config/db.php';
$requireAdmin = true;
require_once '../admin/check_auth.php';

$id = $_GET['id'];

$sql = 'SELECT * FROM tbl_nguoidung WHERE ID = :ID';
$cmd = $conn->prepare($sql);
$cmd->bindValue(':ID', $id);
$cmd->execute();
$result = $cmd->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Người dùng - Sửa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

</head>

<body>
    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>
        <div class="card mt-4">
            <div class="card-header">
                Cập nhật người dùng
            </div>
            <div class="card-body">
                <form action="edit_handle.php" method="post" class="needs-validation" novalidate>
                    <input type="text" name="ID" value="<?php echo $result['ID']; ?>" hidden />

                    <div class="mb-2">
                        <label for="HoVaTen">Tên người dùng</label>
                        <input type="text" class="form-control" id="HoVaTen" name="HoVaTen" required value="<?php echo $result['HoVaTen'] ?>" />
                        <div class="invalid-feedback">Tên người dùng không được bỏ trống.</div>
                    </div>
                    <div class="mb-2">
                        <label for="TenDangNhap">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="TenDangNhap" name="TenDangNhap" required value="<?php echo $result['TenDangNhap'] ?>" />
                        <div class="invalid-feedback">Tên đăng nhập không được bỏ trống.</div>
                    </div>
                    <div class="mb-2">
                        <label for="MatKhau">Mật khẩu</label>
                        <input type="password" class="form-control" id="MatKhau" name="MatKhau" placeholder="Bỏ trống nếu không có thay đổi" />
                        <div class="invalid-feedback">Mật khẩu không được bỏ trống.</div>
                    </div>
                    <div class="mb-2">
                        <label for="XacNhanMatKhau">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="XacNhanMatKhau" name="XacNhanMatKhau" placeholder="Bỏ trống nếu không có thay đổi" />
                        <div class="invalid-feedback">Xác nhận mật khẩu không được bỏ trống.</div>
                    </div>
                    <div class="mb-2">
                        <label for="QuyenHan">Quyền Hạn</label>
                        <select class="form-select" id="QuyenHan" name="QuyenHan" required>
                            <option value="">--Chọn--</option>
                            <option value="1" <?php echo ($result['QuyenHan'] == 1 ? 'selected' : ''); ?>>Quản trị viên</option>
                            <option value="2" <?php echo ($result['QuyenHan'] == 2 ? 'selected' : ''); ?>>Người viết tin</option>
                            <option value="3" <?php echo ($result['QuyenHan'] == 3 ? 'selected' : ''); ?>>Độc giả</option>
                        </select>
                        <div class="invalid-feedback">Chưa chọn quyền hạn.</div>
                    </div>
                    <div class="mb-2">
                        <input type="checkbox" class="form-check-input" id="KhoaTaiKhoan" name="KhoaTaiKhoan" <?php echo ($result['Khoa'] == 1 ? 'checked' : ''); ?> />
                        <label for="KhoaTaiKhoan">Khóa tài khoản</label>
                    </div>
                    <button type="submit" class="btn btn-warning mt-2"><i class="bi bi-floppy"></i> Cập nhật</button>
                </form>
            </div>
        </div>
        <?php include_once '../includes/footer.php'; ?>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

</html>