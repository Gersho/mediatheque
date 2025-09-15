<?php 
include VIEW_PATH . '/search-bar/search-bar.php' ?>
<!-- tabindex on this page has to take into account that
        flash messages uses tabindex 1
        search bar uses tabindex 2
        pagination uses tabindex 9 -->
<div class="media-container">
    <?php if (count($medias) > 0): ?>
        <?php foreach ($medias as $media): ?>
            <?php $available = $media['stock'] > 0 ? '' : 'unavailable'; ?>
            <div class="media-tile <?= $available ?>">
                <div class="media-tile-genre-cover">
                    <h2><?= strtoupper($media['type']) ?></h2>
                    <a class="media-tile-cover-title" href="<?= get_media_url($media['id'], $media['type']) ?>">
                        <img src="<?= get_media_cover_img($media['cover_img']) ?>" alt="cover">
                        <p tabindex="3" title="<?php e($media['title']) ?>"><?php e(crop_string($media['title'], 35)) ?></p>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun résultat</p>
    <?php endif; ?>
</div>
<?php include_once VIEW_PATH . '/medias/pagination.php' ?>