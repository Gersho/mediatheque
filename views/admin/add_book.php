<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p>Ajouter un livre</p>
        </div>
        
        <form method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required 
                       placeholder="Titre du livre">
            </div>
            
            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du livre</option>
                    <option value="action">Action</option>
                    <option value="comedy">Comedie</option>
                    <option value="documentary">Documentaire</option>
                    <option value="drama">Drame</option>
                    <option value="fantasy">Fantaisie</option>
                    <option value="horror">Horreur</option>
                    <option value="musical">Musical</option>
                    <option value="mystery">Mystère</option>
                    <option value="romance">Romance</option>
                    <option value="science fiction">Science Fiction</option>
                    <option value="thriller">Suspense</option>
                    <option value="western">Western</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required
                       placeholder="Stock" min="1">
            </div>
            
            <div class="form-group">
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" required
                       placeholder="Auteur">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" required
                        placeholder="ISBN" min="0">
            </div>
            
            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" required
                        placeholder="Nombre de pages" min="1" max="9999">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                        placeholder="Date de publication" min="1900">
            </div>

            <div class="form-group">
                <label for="summary">Résumé</label>
                <textarea id="summary" name="summary" required
                        placeholder="Résumé du livre"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
        </form>
        
    </div>
</div> 