<!-- tabindex on this page has to take into account that
        flash messages uses tabindex 1
        pagination uses tabindex 9 -->

<div class="user-page">
    <div class="table-container">
        <h2 tabindex="2">Emprunts en cours</h2>
        <?php
        if ($has_borrow_current): ?>
            <table class="user-table">
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Date d'emprunt</th>
                    <th>Retour prévu</th>
                </tr>
                <?php foreach ($borrow_current_info as $elem): ?>
                    <tr>
                        <td tabindex="2" data-label="Titre"><?= e($elem["title"]) ?></td>
                        <td data-label="Type"><?= e($elem["type"]) ?></td>
                        <td tabindex="2" title="Date d'emprunt" data-label="Date d'emprunt">
                            <?= e(format_date($elem["start"], $format = 'd/m/Y')) ?>
                        </td>
                        <td tabindex="2" title="Retour prévu" data-label="Retour prévu"><?= $elem["estimated_return"] ?></td>
                        <td class="no-label">
                            <button tabindex="2" popovertarget="confirm-popover-<?php e($elem["media_id"]); ?>"
                                class="btn btn-alert return">Retour</button>
                            <div class="confirm-popover" popover="hint" id="confirm-popover-<?= $elem['media_id'] ?>">
                                <div class="confirm-container">
                                    <div tabindex="3" class="confirm-title">Confirmer le retour ?</div>
                                    <div class="confirm-buttons">
                                        <form action="<?= url("media/return") ?>" method="post">
                                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                            <button tabindex="3" class="btn btn-primary" type="submit" name="id"
                                                value="<?= $elem["media_id"] ?>">OUI</button>
                                        </form>
                                        <button tabindex="3" class="btn btn-alert"
                                            popovertarget="confirm-popover-<?= $elem['media_id'] ?>"
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


    <div class="table-container">
        <h2 tabindex="2">Historique des emprunts</h2>
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
                        <td tabindex="2" data-label="Titre"><?= $elem["title"] ?></td>
                        <td data-label="Type"><?= e($elem["type"]) ?></td>
                        <td tabindex="2" title="Date d'emprunt" data-label="Date d'emprunt">
                            <?= e(format_date($elem["start"], $format = 'd/m/Y')) ?>
                        </td>
                        <td tabindex="2" title="Date de retour" data-label="Date de retour">
                            <?= e(format_date($elem["return_date"], $format = 'd/m/Y')) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
            <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
        <?php else: ?>
            <p>Aucun Historique d'Emprunt</p>
        <?php endif ?>
    </div>
</div>