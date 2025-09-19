<?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <!-- First -->
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?page=1<?= $currentTopic ? '&topic=' . $currentTopic : '' ?>#posts">
                    «
                </a>
            </li>

            <!-- Prev -->
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?page=<?= $page - 1 ?><?= $currentTopic ? '&topic=' . $currentTopic : '' ?>#posts">
                    ‹ Prev
                </a>
            </li>

            <!-- Numbers -->
            <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);

            if ($start > 1) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }

            for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?><?= $currentTopic ? '&topic=' . $currentTopic : '' ?>#posts">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor;

            if ($end < $totalPages) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            ?>

            <!-- Next -->
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?page=<?= $page + 1 ?><?= $currentTopic ? '&topic=' . $currentTopic : '' ?>#posts">
                    Next ›
                </a>
            </li>

            <!-- Last -->
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="?page=<?= $totalPages ?><?= $currentTopic ? '&topic=' . $currentTopic : '' ?>#posts">
                    »
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>