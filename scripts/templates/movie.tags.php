<?php
/*
 Liste des tags
 */
?>
<ul class="movie-tags p-0">
    <?php foreach ($movie->getTags() as $tag) : ?>
        <li class="list-inline-item"><a href="/movies.php?tag=<?php echo escape($tag->getId()); ?>" class="movie-tag"><?php echo escape($tag->getName()); ?></a></li>
    <?php endforeach; ?>

</ul>
