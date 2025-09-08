<div>
    <p>User Info</p>
    <p>name:<?= e($name) ?></p>
    <p>email<?= e($email) ?></p>
</div>


<div>
    <p>Emprunts en cour:</p>
    <?php
    if ($has_borrow_current):
        ?>
        <table>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date d'emprunt</th>
                <th>Temps avant retour</th>
                <th>Rendre</th>
            </tr>
            <?php foreach ($borrow_current_info as $elem): ?>
                <tr>
                    <td><?= e($elem["title"]) ?></td>
                    <td><?= e($elem["type"]) ?></td>
                    <td><?= e($elem["start"]) ?></td>
                    <td><?= e("TODO DATE RETOUR") ?></td>
                    <td>
                        <button popovertarget="my-popover-<?php e($elem["media_id"]); ?>"
                            class="btn btn-primary">Retour</button>
                    </td>
                </tr>

                <div class="format-button" popover id="my-popover-<?php e($elem["media_id"]); ?>">Confirmer le retour ?
                    <p><?= e($elem["title"]) ?></p>
                    <div class="espacement">
                        <form action="<?= url("media/return") ?>" method="post">
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
    <p>Historique des emprunts:</p>
    <?php
    if ($has_borrow_history):
        ?>
        <table>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date d'emprunt</th>
                <th>Date de retour</th>
            </tr>
            <?php foreach ($borrow_history_info as $elem): ?>
                <tr>
                    <td><?= e($elem["title"]) ?></td>
                    <td><?= e($elem["type"]) ?></td>
                    <td><?= e($elem["start"]) ?></td>
                    <td><?= e("TODO DATE RETOUR") ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p>Aucun Historique d'Emprunt</p>
    <?php endif ?>
</div>