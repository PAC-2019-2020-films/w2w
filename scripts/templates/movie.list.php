<?php
/**
*Work In Progress - Affichage de la liste des films
 */

?>

<li>
    <a href="/movie.php?id=<?php echo escape($movie->getId()); ?>"><?php echo escape($movie); ?></a>
    <img src="" alt=""/>
    <ul>
        <li> catégorie :
            <span title="<?php echo escape($movie->getCategory()->getDescription()); ?>"><?php echo escape($movie->getCategory()->getName()); ?></span>
        </li>
        <li> tags :
            <?php foreach ($movie->getTags() as $item) : ?>
                <span title="<?php echo escape($item->getDescription()); ?>">[<?php echo escape($item->getName()); ?>]</span>
            <?php endforeach; ?>
        </li>
        <li> réalistaeurs :
            <?php foreach ($movie->getDirectors() as $item) : ?>
                <span>[<?php echo escape($item->getFirstName()); ?> <?php echo escape($item->getLastName()); ?>]</span>
            <?php endforeach; ?>
        </li>
        <li> acteurs :
            <?php foreach ($movie->getActors() as $item) : ?>
                <span>[<?php echo escape($item->getFirstName()); ?> <?php echo escape($item->getLastName()); ?>]</span>
            <?php endforeach; ?>
        </li>
    </ul>
</li>
