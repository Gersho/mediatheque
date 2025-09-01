<section>
    <h1><?php e($title); ?></h1>
    <p>by <?php e($editor); ?> on <?php e($plateform); ?></p>
    <p>genre: <?php e($genre); ?></p>
    <p>pegi: <?php e($pegi); ?></p>
    <p><?php e($description); ?> </p>

    <?php
    if ($stock !== 0):
        ?> <button>rent</button> <?php
    else: ?>
        <button>sorry, this game is currently unavailable</button>

    <?php endif; ?>
</section>