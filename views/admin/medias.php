<div class="show-card">
    <a href="medias">
        <h1>Panneau de contrôle des médias</h1>
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
            <tbody>
                <?php foreach ($medias as $media): ?>
                    <tr>
                        <td class="text-white"><?= $media['id'] ?></td>
                        <td class="text-white"><?= $media['stock'] ?></td>
                        <td class="text-white"><?= $media['type'] ?></td>
                        <td><a href="<?= get_media_url($media['id'], $media['type']) ?>"><?= $media['title'] ?></a></td>
                        <td><a class="btn btn-primary btn-full" href="<?= get_edit_url($media['id'], $media['type']) ?>">Modifier</a></td>
                        <td>
                            <button popovertarget="my-popover-<?= $media['id'] ?>" class="btn btn-full btn-alert">Supprimer</button>
                        </td>


                        <!-- Modal popover -->
                        <div class="format-button" popover id="my-popover-<?= $media['id'] ?>">Confirmer la suppression ?
                            <div class="espacement">
                                <form action="<?= url("admin/delete_media") ?>" method="post">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <button class="yes" name="id" value="<?php e($media['id']); ?>">OUI</button>
                                </form>
                                <form action="" method="get">
                                    <button class="no" name="no">NON</button>
                                </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php include_once VIEW_PATH . '/medias/pagination.php' ?>

    </div>
</div>