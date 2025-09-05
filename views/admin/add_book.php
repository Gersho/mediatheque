<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p><?=$data['action']?> un livre</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du livre" value="<?php if (isset($entries['title'])) echo htmlspecialchars( $entries['title']);?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option>Genre du livre</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Action') echo 'selected';?> value="Action">Action</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Comedy') echo 'selected';?> value="Comedy">Comedie</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Documentary') echo 'selected';?> value="Documentary">Documentaire</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Drama') echo 'selected';?> value="Drama">Drame</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Fantasy') echo 'selected';?> value="Fantasy">Fantaisie</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Horror') echo 'selected';?> value="Horror">Horreur</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Musical') echo 'selected';?> value="Musical">Musical</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Mystere') echo 'selected';?> value="Mystery">Mystère</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Romance') echo 'selected';?> value="Romance">Romance</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Science Fiction') echo 'selected';?> value="Science Fiction">Science Fiction</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Thriller') echo 'selected';?> value="Thriller">Suspense</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'Western') echo 'selected';?> value="Western">Western</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" min="1" value="<?php if (isset($entries['stock'])) echo htmlspecialchars( $entries['stock']);?>">
            </div>

            <div class="form-group">
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" required placeholder="Auteur" value="<?php if (isset($entries['author'])) echo htmlspecialchars( $entries['author']);?>">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" required placeholder="ISBN" value="<?php if (isset($entries['isbn'])) echo htmlspecialchars( $entries['isbn']);?>">
            </div>

            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" required placeholder="Nombre de pages" min="1" max="9999" value="<?php if (isset($entries['pages'])) echo htmlspecialchars( $entries['pages']);?>">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900" value="<?php if (isset($entries['published_year'])) echo htmlspecialchars( $entries['published_year']);?>">
            </div>

            <div class="form-group">
                <label for="summary">Résumé</label>
                <textarea id="summary" name="summary" required placeholder="Résumé du livre" maxlength="3000" autocomplete="on"><?php if (isset($entries['summary'])) echo htmlspecialchars( $entries['summary']);?></textarea>
            </div>

            <div class="form-group">
                <label for="cover_img">Upload cover</label>
                <input type="file" id="cover_img" name="cover_img">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                <?=$data['action']?>
            </button>
        </form>

    </div>
</div>