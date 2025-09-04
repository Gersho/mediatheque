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