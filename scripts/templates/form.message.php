<?php

$params = ["firstName", "lastName", "email", "content"];
foreach ($params as $param) {
    if (! isset($$param)) $$param = null;
}


?>


<form action="/message.php" method="post" style="margin:25px;max-width:480px">

    <label for="lastName">Nom :</label>
    <input type="text" name="lastName" id="lastName" value="<?php echo escape($lastName); ?>" class="form-control"/>

    <label for="firstName">Prénom :</label>
    <input type="text" name="firstName" id="firstName" value="<?php echo escape($firstName); ?>" class="form-control"/>

    <label for="email">Email :</label>
    <input type="text" name="email" id="email" value="<?php echo escape($email); ?>" class="form-control"/>

    <label for="content">Message :</label>
    <textarea name="content" id="content" cols="80" rows="10" placeholder="" class="form-control"><?php echo escape($content); ?></textarea>

    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Envoyer</button>

</form>
