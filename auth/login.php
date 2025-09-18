<?php
require_once '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập - iNews</title>
    <link rel="shortcut icon" href="images/premium.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>

        <div class="d-flex justify-content-center">
            <div class="card mt-5 col col-5">
                <h5 class="card-header">Đăng nhập</h5>
                <div class="card-body">
                    <form action="login_handle.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="TenDangNhap" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="TenDangNhap" name="TenDangNhap" required />
                            <div class="invalid-feedback">Tên đăng nhập không được bỏ trống.</div>
                        </div>
                        <div class="mb-3">
                            <label for="MatKhau" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="MatKhau" name="MatKhau" required />
                            <div class="invalid-feedback">Mật khẩu không được bỏ trống.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-fill-add"></i> Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>

        <?php include_once '../includes/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
</body>

</html>