<div class="container">
    <section>
        <div>
            <img src="<?= e(get_media_cover_img($cover_img)) ?>">
            <span class="placement-button">
                <?php
                if ($stock !== 0):
                    ?> <button class="btn btn-primary louer">Emprunter</button> <?php
                else: ?>
                    <div class="message">Désolé ! Ce livre n'est plus disponible en stock.</div>

                <?php endif; ?>
            </span>

        </div>
        <div class="textfield">
            <div class="titlefield">
                <h1><?php e($title); ?></h1>
            </div>
            <div class="auteur">
                <p>par <?php e($author); ?> en <?php e($published_year); ?></p>
            </div>
            <p>isbn: <?php e($isbn); ?></p>
            <p>genre: <?php e($genre); ?></p>
            <p>pages: <?php e($pages); ?></p>
            <p>Resumé:</p>
            <div class="scroll-box"><?php e($summary); ?> </div>
        </div>
    </section>
</div>