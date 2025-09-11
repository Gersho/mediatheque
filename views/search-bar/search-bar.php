<div class="search-container-wrapper">
    <form class="search-container" method="GET">
        <div class="search-input-wrapper">
            <label for="title" hidden>Rechercher par titre</label>
            <input class="search-input" type="text" id="title" name="title" placeholder="Rechercher"
                value="<?= get('title') ?? '' ?>">
        </div>
        <div class="filter-wrapper">
            <label for="type" hidden>Catégories</label>
            <select name="type" id="type">
                <option value="">Catégories</option>
                <option value="Movie" <?= get('type') === 'Movie' ? 'selected' : '' ?>>Films</option>
                <option value="Book" <?= get('type') === 'Book' ? 'selected' : '' ?>>Livres</option>
                <option value="Game" <?= get('type') === 'Game' ? 'selected' : '' ?>>Jeux</option>
            </select>
            <label for="genre" hidden>Genres</label>
            <select name="genre" id="genre">
                <option value="">Genres</option>
                <?php foreach (get_genre_values() as $genre): ?>
                    <option value="<?= $genre ?>" <?= get('genre') === $genre ? 'selected' : '' ?>><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
            <div class="checkbox-container">
                <label for="available">Disponible</label>
                <input class="checkbox" type="checkbox" id="available" name="available" <?= get('available') ? 'checked' : '' ?>>
            </div>
            <button class="search-btn" type="submit"></button>
        </div>
    </form>
</div>