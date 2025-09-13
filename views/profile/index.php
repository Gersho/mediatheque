<div class="user-page">
    <div>
        <h2>Emprunts en cours</h2>
        <?php
        if ($has_borrow_current): ?>
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
                            <button popovertarget="confirm-popover-<?php e($elem["media_id"]); ?>"
                                class="btn btn-alert return">Retour</button>
                            <div class="confirm-popover" popover="hint" id="confirm-popover-<?= $elem['media_id'] ?>">
                                <div class="confirm-container">
                                    <div class="confirm-title">Confirmer le retour ?</div>
                                    <div class="confirm-buttons">
                                        <form class="btn btn-primary" action="<?= url("media/return") ?>" method="post">
                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                            <button type="submit" name="id" value="<?= $elem["media_id"] ?>">OUI</button>
                                        </form>
                                        <button class="btn btn-alert" popovertarget="confirm-popover-<?= $elem['media_id'] ?>"
                                            popovertargetaction="hide">NON</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php else: ?>
            <p>Aucun emprunt en cours</p>
        <?php endif ?>
    </div>


    <div>
        <h2>Historique des emprunts</h2>
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