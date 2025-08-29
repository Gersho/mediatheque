<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <p>Ajouter un film</p>
        </div>

        <form method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required
                    placeholder="Titre du film">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du film</option>
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
                <label for="director">Réalisateur</label>
                <input type="text" id="director" name="director" required
                    placeholder="Réalisateur">
            </div>

            <div class="form-group">
                <label for="duration">Durée (minutes)</label>
                <input type="number" id="duration" name="duration" required
                    placeholder="Durée" min="1" max="999">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900">
            </div>

            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea id="synopsis" name="synopsis" required
                    placeholder="Synopsis du film"></textarea>
            </div>

            <div class="form-group">
                <label for="certification">Certification</label>
                <select id="certification" name="certification" required>
                    <option value="">Certification</option>
                    <option value="Tous public">Tous publics</option>
                    <option value="-12">-12</option>
                    <option value="-16">-16</option>
                    <option value="-18">-18</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                Ajouter
            </button>
        </form>
        
    </div>
</div> 