<div class="user-page">
    <h1>Gestion des utilisateurs</h1>
    <!-- TODO stats: total of borrows, average borrow per months?, average late return per months? -->
    <table class="user-table">
        <thead>
            <?php foreach ($fields as $field): ?>
                <th><?= $field ?></th>
            <?php endforeach; ?>
            <th>Emprunts en cours</th>
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
                        $popover_id = "popover_" . $user["id"];
                        ?>
                        <div class="borrow_count_and_detail_btn">
                            <?php if ($borrow_count > 0): ?>
                                <button class="btn btn-primary" popovertarget="<?= $popover_id ?>"><?= $borrow_count ?></button>
                            <?php else: ?>
                                <p><?= $borrow_count ?></p>
                            <?php endif; ?>
                        </div>
                        <?php $borrows = get_borrows_details_by_user($user["id"]); ?>
                        <div id="<?= $popover_id ?>" class="borrow-list" popover>
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
                                                <td><button type="submit" class="btn btn-delete">Rendre</button></td>
                                            </form>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <?php if ($user['id'] != current_user_id()): ?>
                        <form action="<?= url("admin/delete_user") ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="redirect" value="admin/users">
                            <td><button type="submit" class="btn btn-delete">Supprimer</button></td>
                        </form>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
</div>