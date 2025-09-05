<div class="container">
    <section>
        <div>
            <img src="<?= e(get_media_cover_img($cover_img)) ?>">
            <span class="placement-button">
                <?php
                if ($stock !== 0):
                    ?>


                    <button popovertarget="my-popover" class="btn btn-primary louer">Emprunter</button>
                    <?php
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
            <p>genre: <?php e($genre); ?></p>
            <p>certification: <?php e($certification); ?></p>
            <p>synopsis: </p>
            <div class="scroll-box"><?php e($synopsis); ?> </div>
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