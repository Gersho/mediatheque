<h3 class="text-white">Nombre total de médias dans la base de données : <?= get_media_count() ?></h3>
<h4 class="text-white">Dont <?=get_books_count() ?> livres</h4>
<h4 class="text-white">Dont <?= get_movies_count() ?> films</h4>
<h4 class="text-white">Dont <?= get_games_count() ?> jeux</h4>
<div class="auth-container">
    <a href="<?= url('admin/medias') ?>" class="btn btn-primary margin-1">Médias</a>
    <a href="<?= url('admin/users') ?>" class="btn btn-primary margin-1">Utilisateurs</a>
    <a href="<?= url('admin/borrows') ?>" class="btn btn-primary margin-1">Emprunts en cours</a>
    <a href="<?= url('admin/history') ?>" class="btn btn-primary margin-1">Historique des emprunts</a>
</div>
