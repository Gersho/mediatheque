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
<div popover id="my-popover">Are you sure ?

    <form action="<?= url("media/borrow") ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <button name="id" value="<?php e($media_id); ?>">YES</button>
    </form>
    <form action="" method="get">
        <button name="id" value="<?php e($media_id); ?>">NO</button>
    </form>
</div>