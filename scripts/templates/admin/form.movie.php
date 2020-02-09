<?php

$action = isset($action) ? $action : "";
$method = isset($method) ? $method : "post";
$id = isset($id) ? $id : null;
$title = isset($title) ? $title : null;
$description = isset($description) ? $description : null;
$year = isset($year) ? $year : null;
$poster = isset($poster) ? $poster : null;
$submitLabel = isset($submitLabel) ? $submitLabel : "Envoyer";


$categories = isset($categories) ? $categories : [];
$category_id = isset($category_id) ? $category_id : null;

$tags = isset($tags) ? $tags : [];
$tags_selected_ids = isset($tags_selected_ids) ? $tags_selected_ids : [];

$artists = isset($artists) ? $artists : [];
$directors_selected_ids = isset($directors_selected_ids) ? $directors_selected_ids : [];
$actors_selected_ids = isset($actors_selected_ids) ? $actors_selected_ids : [];


?>

<style>
label {
    display:block;
}
</style>


<form action="<?php echo escape($action); ?>" method="<?php echo escape($method); ?>">
    <div>
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo escape($id); ?>"/> 
        </div>
        <div>
            <label for="title">Title :</label>
            <input type="text" id="title" name="title" value="<?php echo escape($title); ?>"/>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description"><?php echo escape($description); ?></textarea>
        </div>
        <div>
            <label for="year">Year :</label>
            <input type="text" id="year" name="year" value="<?php echo escape($year); ?>"/>
        </div>
        <div>
            <label for="poster">Poster :</label>
            <input type="text" id="poster" name="poster" value="<?php echo escape($poster); ?>"/>
        </div>
        <div>
            <label for="category">Category :</label>
            <select id="category" name="category">
                <?php foreach ($categories as $category) : ?>
                <option<?php if ($category->getid() == $category_id) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($category->getId()); ?>"><?php echo escape($category->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="tags">Tags :</label>
            <select id="tags" name="tags[]" multiple="multiple">
                <?php foreach ($tags as $tag) : ?>
                <option<?php if (in_array($tag->getId(), $tags_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($tag->getId()); ?>"><?php echo escape($tag->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="directors">Directors :</label>
            <select id="directors" name="directors[]" multiple="multiple">
                <?php foreach ($artists as $director) : ?>
                <option<?php if (in_array($director->getId(), $directors_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($director->getId()); ?>"><?php echo escape($director->getFirstName()); ?> <?php echo escape($director->getLastName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="actors">Actors :</label>
            <select id="actors" name="actors[]" multiple="multiple">
                <?php foreach ($artists as $actor) : ?>
                <option<?php if (in_array($actor->getId(), $actors_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($actor->getId()); ?>"><?php echo escape($actor->getFirstName()); ?> <?php echo escape($actor->getLastName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <input type="submit" value="<?php echo escape($submitLabel); ?>"/>
        </div>
    </div>
</form>


