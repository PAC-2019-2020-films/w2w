<?php if (is_array($categories)) : ?>
    <div class="container-fluid row">
        <?php foreach ($categories as $category) : ?>
            <div class="col-md-3 mb-5 pt-5 text-center" style="height: 250px;">
                <a href="/movies.php?category=<?php echo escape($category->getId()); ?>"> <!-- lien -->
                    <img class="categories_img" src="/uploads/<?php echo escape($category->getId()); ?>.jpg" alt="<?php echo escape($category->getName()); ?>">
                    <p class="categories_text"><?php echo escape($category->getName()); ?></p></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>