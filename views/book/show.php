<div class="container">
    <section>
        <div>
            <img src="<?= e(get_media_cover_img($cover_img)) ?>">
            <span class="placement-button">
                <?php
                if ($stock !== 0 && !$already_rented):
                    ?>
                    <button popovertarget="confirm-popover" class="btn btn-primary louer">Emprunter</button>
                    <?php
                elseif ($already_rented): ?>
                    <div class="message">Vous louez deja ce media.</div>
                <?php else: ?>
                    <div class="message">Désolé ! Ce livre n'est plus disponible en stock.</div>
                <?php endif; ?>
            </span>

        </div>
        <div class="textfield">
            <div class="titlefield">
                <h1><?= e($title); ?></h1>
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

<!-- Modal popover -->
<div class="confirm-popover" popover="hint" id="confirm-popover">
    <div class="confirm-container">
        <div class="confirm-title">Confirmer l'emprunt ?</div>
        <div class="confirm-buttons">
            <form action="<?= url("media/borrow") ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <button class="btn btn-primary" name="id" value="<?php e($media_id); ?>">OUI</button>
            </form>
            <button class="btn btn-alert" popovertarget="confirm-popover" popovertargetaction="hide">NON</button>
        </div>
    </div>
</div>