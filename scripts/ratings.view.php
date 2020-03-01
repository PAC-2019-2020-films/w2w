<?php if (is_array($ratings)) : ?>
    <div class="container-fluid row">
        <?php foreach ($ratings as $rating) : ?>
            <div class="col-md-3 mb-5 pt-5 text-center" style="height: 250px;">
                <a href="/movies.php?rating=<?php echo escape($rating->getId()); ?>"> <!-- lien -->
                    <img class="categories_img" src="/uploads/rating_<?php echo escape($rating->getId()); ?>.jpg" alt="<?php echo escape($rating->getName()); ?>">
                    <p class="categories_text"><?php echo escape($rating->getName()); ?></p></a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>