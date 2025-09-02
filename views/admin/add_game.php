<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p>Ajouter un jeu</p>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du jeu" value="<?php if (isset($entries['title'])) echo $entries['title'];?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required value="<?php if (isset($entries['genre'])) echo $entries['genre'];?>">
                    <option value="">Genre du jeu</option>
                    <option value="FPS">FPS</option>
                    <option value="MMO">MMO</option>
                    <option value="MOBA">MOBA</option>
                    <option value="RPG">RPG</option>
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
                <select id="plateform" name="plateform" required value="<?php if (isset($entries['plateform'])) echo $entries['plateform'];?>">
                    <option value="">Plateforme</option>
                    <option value="PC">PC</option>
                    <option value="PlayStation">Playstation</option>
                    <option value="Xbox">Xbox</option>
                    <option value="Nintendo">Nintendo</option>
                    <option value="Mobile">Mobile</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pegi">Pegi</label>
                <select id="pegi" name="pegi" required value="<?php if (isset($entries['pegi'])) echo $entries['pegi'];?>">
                    <option value="3">3</option>
                    <option value="7">7</option>
                    <option value="12">12</option>
                    <option value="16">16</option>
                    <option value="18">18</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description"></textarea>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover">
            </div>


            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
        </form>

    </div>
</div>