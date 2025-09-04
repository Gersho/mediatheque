<div class="user-page">
    <h1>Gestion des utilisateurs</h1>
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
                    <?php foreach ($user as $value): ?>
                        <td><?php e($value) ?></td>
                    <?php endforeach; ?>
                    <td>

                        <table class="user-table">
                            <thead>

                                <th>Title</th>
                                <th>Borrow date</th>
                                <th>Expected return</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Test</td>
                                    <td>Test</td>
                                    <td>Test</td>
                                </tr>
                                <tr>
                                    <td>alibaba</td>
                                    <td>21/10/2021</td>
                                    <td>1 day</td>
                                </tr>
                                <tr>
                                    <td>Marvel super hero</td>
                                    <td>21/10/2021</td>
                                    <td>retard de 12 jours</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td><button type="submit" class="btn btn-delete">Delete</button></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>