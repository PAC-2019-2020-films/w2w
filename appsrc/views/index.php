
<p>Welcome to w2w (index page).</p>



<?php if (isset($movies) && is_array($movies)) : ?>
<ol>
    <?php foreach ($movies as $movie) : ?>
    <li>
        <a href=""><?php echo $this->escape($movie); ?></a>
        <img src="" alt=""/>
        <ul>
            <li> catégorie : 
                 <span title="<?php echo $this->escape($movie->getCategory()->getDescription()); ?>"><?php echo $this->escape($movie->getCategory()->getName()); ?></span>
            </li>
            <li> tags : 
                <?php foreach ($movie->getTags() as $item) : ?>
                <span title="<?php echo $this->escape($item->getDescription()); ?>">[<?php echo $this->escape($item->getName()); ?>]</span>
                <?php endforeach; ?>
            </li>
            <li> réalistaeurs : 
                <?php foreach ($movie->getDirectors() as $item) : ?>
                <span>[<?php echo $this->escape($item->getFirstName()); ?> <?php echo $this->escape($item->getLastName()); ?>]</span>
                <?php endforeach; ?>
            </li>
            <li> acteurs : 
                <?php foreach ($movie->getActors() as $item) : ?>
                <span>[<?php echo $this->escape($item->getFirstName()); ?> <?php echo $this->escape($item->getLastName()); ?>]</span>
                <?php endforeach; ?>
            </li>
        </ul>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($tags) && is_array($tags)) : ?>
<ol>
    <?php foreach ($tags as $tag) : ?>
    <li>
        <a href=""><?php echo $this->escape($tag); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>



<?php if (isset($categories) && is_array($categories)) : ?>
<ol>
    <?php foreach ($categories as $category) : ?>
    <li>
        <a href=""><?php echo $this->escape($category); ?></a>
    </li>
    <?php endforeach; ?>
</ol>
<?php endif; ?>
