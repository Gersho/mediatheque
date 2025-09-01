<div class="search-container-wrapper">
    <form class="search-container" method="GET">
        <label for="title" hidden>Rechercher par titre</label>
        <input class="search-input" type="text" id="title" name="title" placeholder="Rechercher">
        <label for="type">Catégories</label>
        <select name="type" id="type">
            <option value="">Toutes</option>
            <option value="Movie">Films</option>
            <option value="Book">Livres</option>
            <option value="Game">Jeux</option>
        </select>
        <label for="genre">Genres</label>
        <select name="genre" id="genre">
            <option value="">Tout</option>
            <option value="Drama">Drama</option>
            <option value="Action">Action</option>
            <option value="Action">FPS</option>
        </select>
        <label for="available">Disponible</label>
        <input type="checkbox" id="available" name="available">
        <input type="submit">
    </form>
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