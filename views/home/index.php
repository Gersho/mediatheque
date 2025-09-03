<div class="search-container-wrapper">
    <form class="search-container" method="GET">
        <label for="title" hidden>Rechercher par titre</label>
        <input class="search-input" type="text" id="title" name="title" placeholder="Rechercher">
        <label for="type" hidden>Catégories</label>
        <select name="type" id="type">
            <option value="">Catégories</option>
            <option value="Movie">Films</option>
            <option value="Book">Livres</option>
            <option value="Game">Jeux</option>
        </select>
        <label for="genre" hidden>Genres</label>
        <select name="genre" id="genre">
            <option value="">Genres</option>
            <?php foreach (get_genre_values() as $genre): ?>
                <option value="<?= $genre ?>"><?= $genre ?></option>
            <?php endforeach; ?>
        </select>
        <div class="checkbox-container">
            <label for="available">Disponible</label>
            <input class="checkbox" type="checkbox" id="available" name="available">
        </div>
        <button class="search-btn" type="submit"></button>
    </form>
</div>
<div class="media-container">
    <?php foreach ($medias as $media): ?>
        <?php $available = $media['stock'] > 0 ? '' : 'unavailable'; ?>
        <div class="media-tile <?= $available ?>">
            <div class="media-tile-genre-cover">
                <h2><?= strtoupper($media['type']) ?></h2>
                <a class="media-tile-cover-title" href="<?= get_media_url($media['id'], $media['type']) ?>">
                    <img src="<?= get_media_cover_img($media['cover_img']) ?>" alt="cover">
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