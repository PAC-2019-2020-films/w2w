<?php if (is_array($tags)) : ?>
    <div class="container-fluid row">
        <?php foreach ($tags as $tag) : ?>
            <div class="col-md-3 mb-5 pt-5 text-center" style="height: 75px;">
                <a href="/movies.php?rating=<?php echo escape($tag->getId()); ?>"> <!-- lien -->
                    <button type="button" class="btn btn-warning" style="border-radius: 25px"><?php echo escape($tag->getName()); ?></button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


