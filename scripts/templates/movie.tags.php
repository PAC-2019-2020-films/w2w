<?php
/*
 Liste des tags
 */
?>
<ul class="movie-tags list-inline">
    <?php foreach ($movie->getTags() as $tag) : ?>
        <li class="list-inline-item"><a href="#" class="movie-tag"><?php echo escape($tag->getName()); ?></a></li>
    <?php endforeach; ?>

</ul>