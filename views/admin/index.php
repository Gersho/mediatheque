    <h4 class="data-container text-white">Nombre total de médias dans la base de données : <?= get_media_count() ?></h4>
    <h4 class="data-container text-white">Dont <?=get_books_count() ?> livres</h4>
    <h4 class="data-container text-white">Dont <?= get_movies_count() ?> films</h4>
    <h4 class="data-container text-white">Dont <?= get_games_count() ?> jeux</h4>
<div class="data-container">
    <a href="<?= url('admin/medias') ?>" class="btn btn-primary margin-1">Médias</a>
    <a href="<?= url('admin/users') ?>" class="btn btn-primary margin-1">Utilisateurs</a>
    <a href="<?= url('admin/history') ?>" class="btn btn-primary margin-1">Historique des emprunts</a>
</div>