<div class="user-page">
    <div>
        <p>Emprunts en cour</p>
        <?php
        if ($has_borrow_current):
            ?>
            <table class="user-table">
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date d'emprunt</th>
                    <th>Temps avant retour</th>
                </tr>
                <?php foreach ($borrow_current_info as $elem): ?>
                    <tr>
                        <td><?= e($elem["title"]) ?></td>
                        <td><?= e($elem["type"]) ?></td>
                        <td><?= e(format_date($elem["start"], $format = 'd/m/Y')) ?></td>
                        <td><?= $elem["estimated_return"] ?></td>
                        <td>
                            <button popovertarget="my-popover-<?php e($elem["media_id"]); ?>"
                                class="btn btn-primary return">Retour</button>
                        </td>
                    </tr>

                    <div class="format-button" popover id="my-popover-<?php e($elem["media_id"]); ?>">Confirmer le retour ?
                        <div class="espacement">
                            <form action="<?= url("media/return") ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <button class="yes" name="id" value="<?php e($elem["media_id"]); ?>">OUI</button>
                            </form>
                            <form action="<?= url("user/profile") ?>" method="get">
                                <button class="no">NON</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </table>
        <?php else: ?>
            <p>Aucun emprunts en cour</p>
        <?php endif ?>
    </div>


    <div>
        <p>Historique des emprunts</p>
        <?php
        if ($has_borrow_history):
            ?>
            <table class="user-table">
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour</th>
                </tr>
                <?php foreach ($borrow_history_info as $elem): ?>
                    <tr>
                        <td><?= $elem["title"] ?></td>
                        <td><?= e($elem["type"]) ?></td>
                        <td><?= e(format_date($elem["start"], $format = 'd/m/Y')) ?></td>
                        <td><?= e(format_date($elem["return_date"], $format = 'd/m/Y')) ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
            <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
        <?php else: ?>
            <p>Aucun Historique d'Emprunt</p>
        <?php endif ?>
    </div>
</div>