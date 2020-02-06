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
                <option></option>
                <?php foreach ($categories as $category) : ?>
                <option<?php if ($category->getid() == $category_id) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($category->getId()); ?>"><?php echo escape($category->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <input type="submit" value="<?php echo escape($submitLabel); ?>"/>
        </div>
    </div>
</form>


