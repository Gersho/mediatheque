<div class="media-container">
    <?php foreach ($medias as $media): ?>
        <div class="media-tile">
            <div class="media-tile-genre-cover">
                <h2><?= strtoupper($media['type']) ?></h2>
                <a class="media-tile-cover-title" href="<?= get_media_url($media['id'], $media['type']) ?>">
                    <img src="<?= BASE_URL . '/assets/images/test.jpg' ?>" alt="cover">
                    <p><?php e($media['title']) ?></p>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pagination">
    <?php if ($current_page > 1): ?>
        <?php $link = url();
        if ($current_page > 2) {
            $link .= "?page=" . $current_page - 1;
        }
        ?>
        <a class="pagination-btn" href=" <?= $link ?>">❮</a>
    <?php else: ?>
        <div class="pagination-btn hide">❮</div>
    <?php endif; ?>
    <?php if ($current_page < $pages): ?>
        <?php $link = url() . "?page=" . $current_page + 1; ?>
        <a class="pagination-btn" href=" <?= $link ?>">❯</a>
    <?php else: ?>
        <div class="pagination-btn hide">❯</div>
    <?php endif; ?>

</div>