<?php
/**
 * 
 * Pour l'enrichissement des select multiple :
 * 
 * https://www.jqueryscript.net/form/Dual-List-Box-Plugin-jQuery-Multi.html
 * - ajout /assets/css/multi.min.css
 * - ajout /assets/css/multi.min.css
 * + leur inclusion dans le layout
 * 
 */ 



$yearMin = 1895;
$yearMax = 1 + (int) date('Y'); 
 
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


# pour test fonctionnel :
if (FR_DEBUG) array_push($categories, new \w2w\Model\Category(7897978, "Bidon"));

?>


<style>
/* effet de bord avec règle pour ".header" dans "single.css" : */
.multi-wrapper .header {
    height:auto;
}
</style>

<div class="container">
    <div class="light-bg p-4 my-4">
        <p class="text-right">
            <a href="/admin/" class="btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Retourner au dashboard</a>
        </p>
        <h2 class="h3">Ajouter / Modifier un film</h2>
        <span class="line-title"><hr></span>
    <form action="<?php echo escape($action); ?>" style="max-width: 700px" method="<?php echo escape($method); ?>" enctype="multipart/form-data" >
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo escape($id); ?>"/> 
        </div>
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?php echo escape($title); ?>" class="form-control form-control-sm"/>
            <small class="form-text text-muted">Veuillez entrer un titre unique.</small>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea id="description" name="description" class="form-control"><?php echo escape($description); ?></textarea>
        </div>
        <div class="form-group">
            <label for="category">Categorie :</label>
            <select id="category" name="category" class="form-control form-control-sm">
                <option value=""></option>
                <?php foreach ($categories as $category) : ?>
                <option<?php if ($category->getid() == $category_id) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($category->getId()); ?>"><?php echo escape($category->getName()); ?></option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Veuillez choisir une catégorie.</small>
        </div>
        <div class="form-group">
            <label for="year">Année de sortie :</label>
            <input type="number" min="<?php echo escape($yearMin); ?>" max="<?php echo escape($yearMax); ?>" id="year" name="year" value="<?php echo escape($year); ?>" class="form-control form-control-sm"/>
            <small class="form-text text-muted">Veuillez entrer une année entre <?php echo escape($yearMin); ?> et <?php echo escape($yearMax); ?>, ou laisser vide.</small>
        </div>
        <hr/>
        <h4 class="h6">Affiche du film</h4>
        <span class="line-title"><hr></span>

        <div class="form-group">
            <label for="poster">Affiche :</label>
            <input type="text" id="poster" name="poster" value="<?php echo escape($poster); ?>" class="form-control form-control-sm"/>
            <small class="form-text text-muted">Veuillez entrer le nom de base sous lequel seront sauvegardées les affiches uploadées.</small>
        </div>
        <p class="font-weight-bold">Miniature (170x255px)</p>
        <div class="form-group custom-file">

            <label for="poster-file-thumbnail" class="custom-file-label">Ajouter une miniature</label>
            <input type="file" id="poster-file-thumbnail" name="poster-file-thumbnail" class="form-control-file custom-file-input"/>
        </div>
        <p class="my-3 font-weight-bold">Affiche moyenne (350x525px)</p>
        <div class="form-group custom-file">
            <label for="poster-file-medium" class="custom-file-label">Ajouter une affiche moyenne</label>
            <input type="file" id="poster-file-medium" name="poster-file-medium" class="form-control-file custom-file-input"/>
        </div>
        <p class="my-3 font-weight-bold">Grande affiche (1920x640px)</p>
        <div class="form-group custom-file">
            <label for="poster-file-big" class="custom-file-label">Ajouter une grande affiche</label>
            <input type="file" id="poster-file-big" name="poster-file-big" class="form-control-file custom-file-input"/>
        </div>
        <hr/>
        <h4 class="h6">Informations supplémentaires</h4>
        <span class="line-title"><hr></span>

        <div class="form-group">
            <label for="tags">Tags :</label>
            <select class="multi" id="tags" name="tags[]" multiple="multiple" class="orm-control">
                <?php foreach ($tags as $tag) : ?>
                <option<?php if (in_array($tag->getId(), $tags_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($tag->getId()); ?>"><?php echo escape($tag->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="directors">Réalisateurs :</label>
            <select class="multi" id="directors" name="directors[]" multiple="multiple" class="form-control">
                <?php foreach ($artists as $director) : ?>
                <option<?php if (in_array($director->getId(), $directors_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($director->getId()); ?>"><?php echo escape($director->getFirstName()); ?> <?php echo escape($director->getLastName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="actors">Acteurs :</label>
            <select class="multi" id="actors" name="actors[]" multiple="multiple" class="form-control">
                <?php foreach ($artists as $actor) : ?>
                <option<?php if (in_array($actor->getId(), $actors_selected_ids)) : ?> selected="selected"<?php endif; ?> value="<?php echo escape($actor->getId()); ?>"><?php echo escape($actor->getFirstName()); ?> <?php echo escape($actor->getLastName()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="<?php echo escape($submitLabel); ?>" class="btn btn-primary form-control"/>
        </div>
    </form>
    </div>
</div>


