<?php
require_once '../config/db.php';
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
                Thông báo
            </div>
            <div class="card-body">
                <div class="alert alert-success"><?php echo $message; ?><a href="/" class="alert alert-link">.Quay lại</a>
                </div>
            </div>
        </div>
        <?php include_once '../includes/footer.php'; ?>

    </div>

</body>

</html>