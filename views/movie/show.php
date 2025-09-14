<div class="container">
    <section>
        <div class="center-box">
            <img src="<?= e(get_media_cover_img($cover_img)) ?>">
            <span class="placement-button">
                <?php

                if ($stock !== 0 && !$already_rented):
                    ?>
                    <button tabindex="3" popovertarget="confirm-popover" class="btn btn-primary louer">Emprunter</button>
                    <?php
                elseif ($already_rented): ?>
                    <div tabindex="3" class="message">Vous louez deja ce media.</div>
                <?php else: ?>
                    <div tabindex="3" class="message">Désolé ! Ce film n'est plus disponible en stock.</div>
                <?php endif; ?>
            </span>

        </div>
        <div class="textfield">
            <div class="titlefield">
                <h1 tabindex="1"><?= e($title) ?></h1>
            </div>
            <div class="auteur">
                <p tabindex="4">par <?php e($director); ?> en <?php e($published_year); ?></p>
            </div>
            <p tabindex="4">durée: <?php e($duration); ?></p>
            <p tabindex="4">genre: <?php e($genre); ?></p>
            <p tabindex="4">certification: <?php e($certification); ?></p>
            <p tabindex="2">synopsis: </p>
            <div tabindex="2" class="scroll-box"><?php e($synopsis); ?> </div>
        </div>
    </section>
</div>

<!-- Modal popover -->
<div class="confirm-popover" popover="hint" id="confirm-popover">
    <div class="confirm-container">
        <div tabindex="4" class="confirm-title">Confirmer l'emprunt ?</div>
        <div class="confirm-buttons">
            <form action="<?= url("media/borrow") ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <button tabindex="4" class="btn btn-primary" name="id" value="<?php e($media_id); ?>">OUI</button>
            </form>
            <button tabindex="4" class="btn btn-alert" popovertarget="confirm-popover"
                popovertargetaction="hide">NON</button>
        </div>
    </div>
</div>