<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p><?=$data['action']?> un livre</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du livre" value="<?php if (isset($entries['title'])) echo $entries['title'];?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option>Genre du livre</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'action') echo 'selected';?> value="action">Action</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'comedy') echo 'selected';?> value="comedy">Comedie</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'documentary') echo 'selected';?> value="documentary">Documentaire</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'drama') echo 'selected';?> value="drama">Drame</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'fantasy') echo 'selected';?> value="fantasy">Fantaisie</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'horror') echo 'selected';?> value="horror">Horreur</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'musical') echo 'selected';?> value="musical">Musical</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'mystere') echo 'selected';?> value="mystery">Mystère</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'romance') echo 'selected';?> value="romance">Romance</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'science fiction') echo 'selected';?> value="science fiction">Science Fiction</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'thriller') echo 'selected';?> value="thriller">Suspense</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'western') echo 'selected';?> value="western">Western</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" min="1" value="<?php if (isset($entries['stock'])) echo $entries['stock'];?>">
            </div>

            <div class="form-group">
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" required placeholder="Auteur" value="<?php if (isset($entries['author'])) echo $entries['author'];?>">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" required placeholder="ISBN" min="0" value="<?php if (isset($entries['isbn'])) echo $entries['isbn'];?>">
            </div>

            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" required placeholder="Nombre de pages" min="1" max="9999" value="<?php if (isset($entries['pages'])) echo $entries['pages'];?>">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900" value="<?php if (isset($entries['title'])) echo $entries['published_year'];?>">
            </div>

            <div class="form-group">
                <label for="summary">Résumé</label>
                <textarea id="summary" name="summary" required placeholder="Résumé du livre" maxlength="3000" autocomplete="on"><?php if (isset($entries['summary'])) echo $entries['summary'];?></textarea>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                <?=$data['action']?>
            </button>
        </form>

    </div>
</div>