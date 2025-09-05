<?php
//TODO move this function
function get_edit_url(int $id, string $type)
{
    return url("admin/edit_$type?id=$id");
}
?>
<div class="show-card">
    <a href="medias">
        <h1 class="page-title">Panneau de contrôle des médias</h1>
    </a>
    <div class="flex">
        <a href="add_book" class="btn btn-primary margin-1">Ajouter un livre</a>
        <a href="add_movie" class="btn btn-primary margin-1">Ajouter un film</a>
        <a href="add_game" class="btn btn-primary margin-1">Ajouter un jeu</a>
        <div class="media-container"></div>
    </div>

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

        <table>
            <thead>
                <tr>
                    <th class="text-white">ID</th>
                    <th class="text-white">Stock</th>
                    <th class="text-white">Type</th>
                    <th class="text-white">Titre</th>

                </tr>
            </thead>
            <?php foreach ($medias as $media): ?>
                <tbody>
                    <tr>
                        <td class="text-white"><?= $media['id'] ?></td>
                        <td class="text-white"><?= $media['stock'] ?></td>
                        <td class="text-white"><?= $media['type'] ?></td>
                        <td><a href="<?= get_media_url($media['id'], $media['type']) ?>"><?= $media['title'] ?></a></td>
                        <td><a class="btn btn-primary" href="<?= get_edit_url($media['id'], $media['type']) ?>">Edit</a></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>


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
    </div>
</div>