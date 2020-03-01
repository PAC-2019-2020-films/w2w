<?php

$id = isset($id) ? $id : null;
$message = isset($message) ? $message : null;
$action = isset($action) ? $action : null;
$method = isset($method) ? $method : "post";
$submitLabel = "Supprimer";
?>

<div class="container">
    <?php if ($message) : ?>
    <h5><?php echo escape($message); ?></h5>
    <?php endif; ?>
    <form action="<?php echo escape($action); ?><?php if ($id) : ?>?id=<?php echo escape($id); ?><?php endif; ?>" method="<?php echo escape($method); ?>">
        <?php if ($id) : ?>
        <div>
            <input type="hidden" id="id" name="id" value="<?php echo escape($id); ?>"/> 
        </div>
        <?php endif; ?>
        <div>
            <input type="hidden" id="confirm" name="confirm" value="confirm"/>
        </div>
        <div class="form-group">
        </div>
        <div class="form-group">
            <input type="submit" value="<?php echo escape($submitLabel); ?>" class="btn btn-primary form-control"/>
        </div>
    </form>
</div>
