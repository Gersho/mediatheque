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

    <?php include VIEW_PATH . '/search-bar/search-bar.php' ?>

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
                        <td><a class="btn btn-primary margin-1" href="<?= get_edit_url($media['id'], $media['type']) ?>">Modifier</a></td>


                        <td>
                            <form action="<?= url('admin/delete_media') ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="id" value="<?= $media['id'] ?>">
                                <input type="hidden" name="redirect" value="admin/medias">
                                <button type="submit" class="btn btn-alert">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>

        <?php include_once VIEW_PATH . '/medias/pagination.php' ?>

    </div>
</div>