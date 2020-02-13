<div class="container">

<form action="" method="post" id="profileForm">
    
    <div class="form-group input-group">
        <label for="username" class=""> Mon nom d'utilisateur : </label>
        <input name="username" class="form-control" placeholder="Username" type="text" id="username" value="<?=$user->getUserName()?>">
    </div>
    
    <div class="form-group input-group">
        <label for="email"> Mon email : </label>
        <input name="email" class="form-control" placeholder="Email" type="email" id="email" value="<?=$user->getEmail()?>">
    </div>
    
    <div class="form-group input-group">
        <label for="firstName"> Mon nom : </label>
        <input name="firstName" class="form-control" placeholder="mon nom" type="text" id="firstName" value="<?=$user->getFirstName()?>">
    </div>
    <div class="form-group input-group">
        <label for="lastName"> Mon prenom : </label>
        <input name="lastName" class="form-control" placeholder="mon prénom" type="text" id="lastName" value="<?=$user->getLastName()?>">
    </div>
    <div class="form-group input-group">
        <label> Compte créé le : <?=$user->getCreatedAt()->format("Y-m-d")?> </label>
    </div>
    <div class="form-group input-group">
        <label> Nombre de critiques publiées : <?=$user->getNumberReviews()?>  </label>
    </div>
 
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block" value="Mettre à jour mes informations"/>
    </div>


</form>

<form action="">
    
    
    <div class="form-group">
        <input type="password" placeholder="nouveau mot de pass" class="form-control"/>
    </div>
    <div class="form-group">
        <input type="password" placeholder="confirmer nouveau mot de passe" class="form-control"/>
    </div>
    
    <div class="form-group">
        <input type="password" placeholder="Entrez votre mot de passe actuel" class="form-control"/>
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block" value="Modifier mon mot de passe"/>
    </div>
</form>

</div>