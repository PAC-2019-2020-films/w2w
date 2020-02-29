
<?php if (is_array($tags)) : ?>
<ul>
    <?php foreach ($tags as $tag) : ?>
    <li><a href="/movies.php?tag=<?php echo escape($tag->getId()); ?>"><?php echo escape($tag->getName()); ?> : <p><?php echo escape($tag->getDescription()); ?></p></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
