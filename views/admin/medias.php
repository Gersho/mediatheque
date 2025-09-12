<div class="show-card">
    <a href="medias">
        <h1>Gestion des médias</h1>
    </a>
    <div class="flex">
        <a href="add_book" class="btn btn-primary margin-1">Ajouter un livre</a>
        <a href="add_movie" class="btn btn-primary margin-1">Ajouter un film</a>
        <a href="add_game" class="btn btn-primary margin-1">Ajouter un jeu</a>
    </div>

    <?php include VIEW_PATH . '/search-bar/search-bar.php' ?>
    <table class="user-table">
        <thead>
            <th class="text-white">ID</th>
            <th class="text-white">Stock</th>
            <th class="text-white">Type</th>
            <th class="text-white">Titre</th>
        </thead>
        <tbody>
            <?php foreach ($medias as $media): ?>
                <tr>
                    <td class="text-white"><?= $media['id'] ?></td>
                    <td class="text-white"><?= $media['stock'] ?></td>
                    <td class="text-white"><?= $media['type'] ?></td>
                    <td><a href="<?= get_media_url($media['id'], $media['type']) ?>"><?= $media['title'] ?></a></td>
                    <td><a class="btn btn-primary" href="<?= get_edit_url($media['id'], $media['type']) ?>">Modifier</a></td>
                    <td><button popovertarget="my-popover-<?= $media['id'] ?>" class="btn btn-alert">Supprimer</button></td>
                </tr>
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

                    <?php endforeach; ?>
        </tbody>
    </table>
    <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
</div>
</div>