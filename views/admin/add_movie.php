<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p><?=$action?> un film</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du film" value="<?php if (isset($entries['title'])) echo $entries['title'];?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du film</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'action') echo 'selected';?> value="action">Action</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'comedy') echo 'selected';?> value="comedy">Comedie</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'documentary') echo 'selected';?> value="documentary">Documentaire</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'drama') echo 'selected';?> value="drama">Drame</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'fantasy') echo 'selected';?> value="fantasy">Fantaisie</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'horror') echo 'selected';?> value="horror">Horreur</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'musical') echo 'selected';?> value="musical">Musical</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'mystery') echo 'selected';?> value="mystery">Mystère</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'romance') echo 'selected';?> value="romance">Romance</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'science fiction') echo 'selected';?> value="science fiction">Science Fiction</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'thriller') echo 'selected';?> value="thriller">Suspense</option>
                    <option  <?php if (isset($entries['genre']) && $entries['genre'] === 'western') echo 'selected';?> value="western">Western</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" min="1" value="<?php if (isset($entries['stock'])) echo $entries['stock'];?>">
            </div>

            <div class="form-group">
                <label for="director">Réalisateur</label>
                <input type="text" id="director" name="director" required placeholder="Réalisateur" value="<?php if (isset($entries['director'])) echo $entries['director'];?>">
            </div>

            <div class="form-group">
                <label for="duration">Durée (minutes)</label>
                <input type="number" id="duration" name="duration" required placeholder="Durée" min="1" max="999" value="<?php if (isset($entries['duration'])) echo $entries['duration'];?>">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900" value="<?php if (isset($entries['published_year'])) echo $entries['published_year'];?>">
            </div>

            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea id="synopsis" name="synopsis" required placeholder="Synopsis du film"><?php if (isset($entries['synopsis'])) echo $entries['synopsis'];?></textarea>
            </div>

            <div class="form-group">
                <label for="certification">Certification</label>
                <select id="certification" name="certification" required>
                    <option value="">Certification</option>
                    <option <?php if (isset($entries['certification']) && $entries['certification'] === 'Tous publics') echo 'selected';?> value="Tous publics">Tous publics</option>
                    <option <?php if (isset($entries['certification']) && $entries['certification'] === '-12') echo 'selected';?>  value="-12">-12</option>
                    <option <?php if (isset($entries['certification']) && $entries['certification'] === '-16') echo 'selected';?>  value="-16">-16</option>
                    <option <?php if (isset($entries['certification']) && $entries['certification'] === '-18') echo 'selected';?>  value="-18">-18</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                <?=$action?>
            </button>
        </form>

    </div>
</div>