<?php

$action = isset($action) ? $action : "";
$method = isset($method) ? $method : "post";
$id = isset($id) ? $id : null;
$firstName = isset($firstName) ? $firstName : null;
$lastName = isset($lastName) ? $lastName : null;
$submitLabel = isset($submitLabel) ? $submitLabel : "Envoyer";
$title = isset($title) ? $title : null;
?>

<div class="container">
    <?php if ($title) : ?>
    <h2><?php echo escape($title); ?></h2>
    <?php endif; ?>
    <form action="<?php echo escape($action); ?><?php if ($id) : ?>?id=<?php echo escape($id); ?><?php endif; ?>" method="<?php echo escape($method); ?>">
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo escape($id); ?>"/> 
        </div>
        <div class="form-group">
            <label for="firstName">Prénom :</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo escape($firstName); ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="lastName">Nom :</label>
            <textarea id="lastName" name="lastName" class="form-control"><?php echo escape($lastName); ?></textarea>
            <small class="form-text text-muted">Veuillez entrer un nom d'artiste.</small>
        </div>
        <div class="form-group">
            <input type="submit" value="<?php echo escape($submitLabel); ?>" class="btn btn-primary form-control"/>
        </div>
    </form>
</div>


