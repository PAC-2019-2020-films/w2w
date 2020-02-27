
<?php if (is_array($ratings)) : ?>
<ul>
    <?php foreach ($ratings as $rating) : ?>
    <li><a href="/movies.php?rating=<?php echo escape($rating->getId()); ?>"><?php echo escape($rating->getName()); ?> : <p><?php echo escape($rating->getDescription()); ?></p></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
