<section>
    <h1><?php e($title); ?></h1>
    <p>by <?php e($author); ?> in <?php e($published_year); ?></p>
    <p>isbn: <?php e($isbn); ?></p>
    <p>genre: <?php e($genre); ?></p>
    <p>pages: <?php e($pages); ?></p>
    <p>Summary:</p>
    <p><?php e($summary); ?> </p>



    <?php
    if ($stock !== 0):
        ?> <button>rent</button> <?php
    else: ?>
        <button>sorry, this book is currently unavailable</button>

    <?php endif; ?>
</section>