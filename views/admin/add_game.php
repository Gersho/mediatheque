<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p><?= $data['action'] ?> un jeu</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du jeu" value="<?php if (isset($entries['title'])) echo $entries['title'];?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du jeu</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'FPS') echo 'selected';?> value="FPS">FPS</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'MMO') echo 'selected';?> value="MMO">MMO</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'MOBA') echo 'selected';?> value="MOBA">MOBA</option>
                    <option <?php if (isset($entries['genre']) && $entries['genre'] === 'RPG') echo 'selected';?> value="RPG">RPG</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" min="1" value="<?php if (isset($entries['stock'])) echo $entries['stock'];?>">
            </div>

            <div class="form-group">
                <label for="editor">Éditeur</label>
                <input type="text" id="editor" name="editor" required placeholder="Éditeur" value="<?php if (isset($entries['editor'])) echo $entries['editor'];?>">
            </div>

            <div class="form-group">
                <label for="plateform">Plateforme</label>
                <select id="plateform" name="plateform" required>
                    <option value="">Plateforme</option>
                    <option <?php if (isset($entries['plateform']) && $entries['plateform'] === 'PC') echo 'selected';?> value="PC">PC</option>
                    <option <?php if (isset($entries['plateform']) && $entries['plateform'] === 'Playstation') echo 'selected';?> value="PlayStation">Playstation</option>
                    <option <?php if (isset($entries['plateform']) && $entries['plateform'] === 'Xbox') echo 'selected';?> value="Xbox">Xbox</option>
                    <option <?php if (isset($entries['plateform']) && $entries['plateform'] === 'Nintendo') echo 'selected';?> value="Nintendo">Nintendo</option>
                    <option <?php if (isset($entries['plateform']) && $entries['plateform'] === 'Mobile') echo 'selected';?> value="Mobile">Mobile</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pegi">Pegi</label>
                <select id="pegi" name="pegi" required value="<?php if (isset($entries['pegi'])) echo $entries['pegi'];?>">
                    <option value="pegi">Pegi</option>
                    <option <?php if (isset($entries['pegi']) && $entries['pegi'] === '3') echo 'selected';?> value="3">3</option>
                    <option <?php if (isset($entries['pegi']) && $entries['pegi'] === '7') echo 'selected';?> value="7">7</option>
                    <option <?php if (isset($entries['pegi']) && $entries['pegi'] === '12') echo 'selected';?> value="12">12</option>
                    <option <?php if (isset($entries['pegi']) && $entries['pegi'] === '16') echo 'selected';?> value="16">16</option>
                    <option <?php if (isset($entries['pegi']) && $entries['pegi'] === '18') echo 'selected';?> value="18">18</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description"><?php if (isset($entries['description'])) echo $entries['description'];?></textarea>
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