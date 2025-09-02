<div class="container">

    <section>
        <div><img src="<?php e($cover_path); ?>"></div>


        <div class="textfield">
            <div class="titlefield">
                <h1><?php e($title); ?></h1>
            </div>
            <div class="blabla">
                <p>par <?php e($author); ?> en <?php e($published_year); ?></p>
            </div>


            <p>isbn: <?php e($isbn); ?></p>
            <p>genre: <?php e($genre); ?></p>
            <p>pages: <?php e($pages); ?></p>
            <p>Resumé:</p>


            <div class="scroll-box"><?php e($summary); ?> </div>


        </div>
    </section>
    <span class="zen">

        <?php
        if ($stock !== 0):
            ?> <button>rent</button> <?php
        else: ?>
            <button>sorry, this book is currently unavailable</button>

        <?php endif; ?>
    </span>





</div>