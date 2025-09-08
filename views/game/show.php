<!-- ● Jeux vidéo : titre, éditeur, plateforme, genre, âge minimum requis, description -->
<div class="container">
    <section>
        <div>
            <img src="<?= e(get_media_cover_img($cover_img)) ?>">
            <span class="placement-button">
                <?php
                if ($stock !== 0 && !$already_rented):
                    ?>
                    <button popovertarget="my-popover" class="btn btn-primary louer">Emprunter</button>
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
                <h1><?php e($title); ?></h1>
            </div>
            <div class="auteur">
                <p>par <?php e($editor); ?> sur <?php e($plateform); ?></p>
            </div>
            <p>genre: <?php e($genre); ?></p>
            <p>pegi: <?php e($pegi); ?></p>
            <p>description:</p>
            <div class="scroll-box"><?php e($description); ?> </div>
        </div>
    </section>
</div>

<!-- Modal popover -->
<div popover id="my-popover">Are you sure ?

    <form action="<?= url("media/borrow") ?>" method="post">
        <button name="id" value="<?php e($media_id); ?>">YES</button>
    </form>
    <form action="" method="get">
        <button name="id" value="<?php e($media_id); ?>">NO</button>
    </form>
</div>