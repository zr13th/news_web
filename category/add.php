<?php
require_once '../config/db.php';
$requireAdmin = true;
require_once '../admin/check_auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chủ đề - Thêm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

</head>

<body>
    <div class="container">
        <?php include_once '../includes/navbar.php'; ?>
        <div class="card mt-4">
            <div class="card-header">
                Thêm chủ đề
            </div>
            <div class="card-body">
                <form action="add_handle.php" method="post" class="needs-validation" novalidate>
                    <div class="mb-2">
                        <label for="TenChuDe">Tên chủ đề</label>
                        <input type="text" class="form-control" id="TenChuDe" name="TenChuDe" required />
                        <div class="invalid-feedback">Tên chủ đề không được bỏ trống.</div>
                    </div>
                    <button type="submit" class="btn btn-warning mt-2"><i class="bi bi-floppy"></i> Thêm vào CSDL</button>
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