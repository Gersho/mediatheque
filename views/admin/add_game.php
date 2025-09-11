<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p><?= $data['action'] ?> un jeu</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du jeu"
                    value="<?php if (isset($entries['title']))
                        echo htmlspecialchars($entries['title']); ?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du jeu</option>
                    <?php foreach ($data['genre_enum'] as $genre): ?>
                        <option <?php if (isset($entries['genre']) && $entries['genre'] === $genre)
                            echo 'selected'; ?>
                            value="<?= $genre ?>"><?= $genre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" min="1"
                    value="<?php if (isset($entries['stock']))
                        echo htmlspecialchars($entries['stock']); ?>">
            </div>

            <div class="form-group">
                <label for="editor">Éditeur</label>
                <input type="text" id="editor" name="editor" required placeholder="Éditeur"
                    value="<?php if (isset($entries['editor']))
                        echo htmlspecialchars($entries['editor']); ?>">
            </div>

            <div class="form-group">
                <label for="plateform">Plateforme</label>
                <select id="plateform" name="plateform" required>
                    <option value="">Plateforme</option>
                    <?php foreach ($data['plateform_enum'] as $plateform): ?>
                        <option <?php if (isset($entries['plateform']) && $entries['plateform'] === $plateform)
                            echo 'selected'; ?> value="<?= $plateform ?>"><?= $plateform ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="pegi">Pegi</label>
                <select id="pegi" name="pegi" required
                    value="<?php if (isset($entries['pegi']))
                        echo $entries['pegi']; ?>">
                    <option value="pegi">Pegi</option>
                    <?php foreach ($data['pegi_enum'] as $pegi): ?>
                        <option <?php if (isset($entries['pegi']) && $entries['pegi'] === $pegi)
                            echo 'selected'; ?>
                            value="<?= $pegi ?>"><?= $pegi ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    placeholder="Description"><?php if (isset($entries['description']))
                        echo htmlspecialchars($entries['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover_img">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                <?= $data['action'] ?>
            </button>
        </form>

    </div>
</div>