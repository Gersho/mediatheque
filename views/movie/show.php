<div class="container">
    <section>
        <div>
            <img src="<?= get_media_cover_img($cover_img) ?>">
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
                <p>en <?php e($published_year); ?> par <?php e($director); ?></p>
            </div>
            <p>durée: <?php e($duration); ?></p>
            <p>certification: <?php e($certification); ?></p>
            <p>synopsis: </p>
            <div class="scroll-box"><?php e($synopsis); ?> </div>
        </div>
    </section>
</div>