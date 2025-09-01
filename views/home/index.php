<div>
    <div class="search-container">
        <form method="GET">
            <input type="text" id="title" name="title" placeholder="Rechercher">
            <input type="submit">
        </form>
    </div>
</div>
<div class="media-container">
    <?php foreach ($medias as $media): ?>
        <?php $available = $media['stock'] > 0 ? '' : 'unavailable'; ?>
        <div class="media-tile <?= $available ?>">
            <div class="media-tile-genre-cover">
                <h2><?= strtoupper($media['type']) ?></h2>
                <a class="media-tile-cover-title" href="<?= get_media_url($media['id'], $media['type']) ?>">
                    <img src="<?= get_media_cover_path($media['cover_path']) ?>" alt="cover">
                    <p><?php e($media['title']) ?></p>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pagination">
    <?php if ($current_page > 1): ?>
        <?php $link = get_page_url($current_page - 1) ?>
        <a class="pagination-btn" href=" <?= $link ?>">❮</a>
    <?php else: ?>
        <div class="pagination-btn hide">❮</div>
    <?php endif; ?>
    <?php if ($current_page < $pages): ?>
        <?php $link = get_page_url($current_page + 1) ?>
        <a class="pagination-btn" href=" <?= $link ?>">❯</a>
    <?php else: ?>
        <div class="pagination-btn hide">❯</div>
    <?php endif; ?>

</div>