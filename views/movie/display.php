<section>
    <h1><?php e($title); ?></h1>
    <p>by <?php e($director); ?> in <?php e($published_year); ?></p>
    <p>duration: <?php e($duration); ?></p>
    <p>genre: <?php e($genre); ?></p>


    <p>certification: <?php e($certification); ?></p>


    <p>Synopsis:</p>
    <p><?php e($summary); ?> </p>



    <?php
    if ($stock !== 0):
        ?> <button>rent</button> <?php
    else: ?>
        <button>sorry, this movie is currently unavailable</button>

    <?php endif; ?>
</section>