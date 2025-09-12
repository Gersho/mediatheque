<h4 class="data-container text-white">Nombre total de médias dans la base de données : <?= get_media_count() ?></h4>
<h4 class="data-container text-white">Dont <?= get_books_count() ?> livres</h4>
<h4 class="data-container text-white">Dont <?= get_movies_count() ?> films</h4>
<h4 class="data-container text-white">Dont <?= get_games_count() ?> jeux</h4>
<div class="data-container">
    <a href="<?= url('admin/medias') ?>" class="btn btn-primary margin-1">Médias</a>
    <a href="<?= url('admin/users') ?>" class="btn btn-primary margin-1">Utilisateurs</a>
</div>
    <!-- user-table -->
     <!-- tableau de la liste des retards -->
<div class="user-page">
    <table class="user-table">
        <h1>Liste des retards</h1>
        <thead>
            <tr>
                
                <th>Titre du medias</th>
                <th>Nom de l'utilisateur</th>
                <th>Date d'emprunt</th>
                <th>Date de retour prévu</th>
            </tr>
            
        </thead>
        <tbody>
            <?php foreach ($list as $elem): ?>
                
                    <tr>
                        <td><?= e($elem["title"]) ?></td>
                        <td><?= e($elem["name"]) ?></td>
                        <td><?= e(format_date($elem["start"], $format = 'd/m/Y')) ?></td>
                        <td> <?= e(get_estimated_return_date($elem['start'])); ?></td>

                    </tr>
                    <?php endforeach; ?>
                    </tbody>

    </table>    <!-- $list = Liste des retards -->
</div>