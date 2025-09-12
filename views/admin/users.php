<div class="user-page">
    <h1>Gestion des utilisateurs</h1>
    <table class="user-table">
        <thead>
            <?php foreach ($fields as $field): ?>
                <th><?= $field ?></th>
            <?php endforeach; ?>
            <th>Emprunts en cours</th>
            <th>Stats</th>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <?php foreach ($user as $field => $value): ?>
                        <?php if ($field === "created_at"): ?>
                            <td><?= format_date($value) ?></td>
                        <?php else: ?>
                            <td><?php e($value) ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td>
                        <?php
                        $borrow_count = get_borrow_count_by_user_id($user["id"]);
                        $borrow_popover_id = "borrow_popover_" . $user["id"];
                        ?>
                        <div class="borrow_count_and_detail_btn">
                            <?php if ($borrow_count > 0): ?>
                                <button class="btn btn-primary" popovertarget="<?= $borrow_popover_id ?>"><?= $borrow_count ?></button>
                                <!-- Popover of the user borrow list -->
                                <div id="<?= $borrow_popover_id ?>" class="borrow-list" popover>
                                    <?php $borrows = get_borrows_details_by_user($user["id"]); ?>
                                    <p>Liste d'emprunts de <?php e($user['name']) ?></p>
                                    <table class="user-table">
                                        <thead>
                                            <th>Media id</th>
                                            <th>Type</th>
                                            <th>Titre</th>
                                            <th>Date d'emprunt</th>
                                            <th>Date de Retour Attendue</th>
                                            <th>Forcer le retour</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($borrows as $borrow): ?>
                                                <?php $estimated_return = get_estimated_return_date($borrow['start']); ?>
                                                <tr>
                                                    <td><?php e($borrow['media_id']) ?></td>
                                                    <td><?php e($borrow['type']) ?></td>
                                                    <td><?php e($borrow['title']) ?></td>
                                                    <td><?= format_date($borrow['start']) ?></td>
                                                    <td><?php e($estimated_return) ?></td>
                                                    <form action="<?= url("admin/force_return") ?>" method="post">
                                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <input type="hidden" name="media_id" value="<?= $borrow['media_id'] ?>">
                                                        <input type="hidden" name="redirect" value="admin/users">
                                                        <td><button type="submit" class="btn btn-alert">Rendre</button></td>
                                                    </form>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p><?= $borrow_count ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php $stats_popover_id = "stats_popover_" . $user["id"]; ?>
                        <button class="btn btn-primary" popovertarget="<?= $stats_popover_id ?>">Voir</button>
                        <!-- Popover of the user stats -->
                        <div id="<?= $stats_popover_id ?>" class="borrow-list" popover>
                            <p>Statistiques de <?php e($user['name']) ?></p>
                            <table class="user-table">
                                <thead>
                                    <th>Total d'emprunts</th>
                                    <th>Taux de retard (%)</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_borrow = get_total_borrow_count_by_user_id($user['id']);
                                    $total_late_return = get_late_return_total_by_user_id($user['id']);
                                    $late_ret_percent = $total_borrow > 0 ? round($total_late_return * 100 / $total_borrow) : 0;
                                    ?>
                                    <tr>
                                        <td><?= $total_borrow ?></td>
                                        <td><?= $late_ret_percent ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <?php if ($user['id'] != current_user_id()): ?>
                        <form action="<?= url("admin/delete_user") ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="redirect" value="admin/users">
                            <td><button type="submit" class="btn btn-alert">Supprimer</button></td>
                        </form>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
</div>