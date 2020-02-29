
<?php if (is_array($categories)) : ?>
<ul>
    <?php foreach ($categories as $category) : ?>
    <li><a href="/movies.php?category=<?php echo escape($category->getId()); ?>"><?php echo escape($category->getName()); ?> : <p><?php echo escape($category->getDescription()); ?></p></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
