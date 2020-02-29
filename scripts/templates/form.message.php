<?php

$params = ["firstName", "lastName", "email", "content"];
foreach ($params as $param) {
    if (! isset($$param)) $$param = null;
}


?>


<div class="container">
    <form action="/message.php" method="post">
        <div class="form-group">
            <label for="lastName">Nom :</label>
            <input type="text" name="lastName" id="lastName" value="<?php echo escape($lastName); ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="firstName">Prénom :</label>
            <input type="text" name="firstName" id="firstName" value="<?php echo escape($firstName); ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?php echo escape($email); ?>" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="content">Message :</label>
            <textarea name="content" id="content" cols="80" rows="10" placeholder="" class="form-control"><?php echo escape($content); ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary tn-lg tn-block mt-3 form-control">Envoyer</button>
        </div>
    </form>
</div>
