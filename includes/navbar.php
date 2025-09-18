<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/"><i class="bi bi-cup-hot-fill"></i> Mới nhất</a>
                </li>
                <?php
                if (isset($_SESSION['ID'])) {
                    if ($_SESSION['QuyenHan'] == 1) {

                ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-kanban-fill"></i> Quản lý
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/category"><i class="bi bi-tags-fill"></i> Chủ đề</a></li>
                                <li><a class="dropdown-item" href="/post"><i class="bi bi-sticky-fill"></i> Bài viết</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/user"><i class="bi bi-people-fill"></i> Người dùng</a></li>
                            </ul>
                        </li>

                    <?php
                    } else if ($_SESSION['QuyenHan'] == 1 || $_SESSION['QuyenHan'] == 2) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-kanban-fill"></i> <?php echo $_SESSION['HoVaTen'] ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/post/add.php"><i class="bi bi-tags-fill"></i> Viết bài</a></li>
                                <li><a class="dropdown-item" href="/post/myPosts.php"><i class="bi bi-sticky-fill"></i> Bài của tôi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/changePass"><i class="bi bi-people-fill"></i> Đổi mật khẩu</a></li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/auth/logout_handle.php"><i class="bi bi-cup-hot-fill"></i> Đăng xuất</a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/auth/login.php"><i class="bi bi-cup-hot-fill"></i> Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/auth/register.php"><i class="bi bi-cup-hot-fill"></i> Đăng ký</a>
                    </li>
                <?php
                }
                ?>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>