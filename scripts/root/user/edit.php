<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\User;
#use \w2w\Utils\FlashManager;


checkRoot();

$id = param("id");

$daoFactory = DAOFactory::getDAOFactory();
$userDAO = $daoFactory->getUserDAO();
$user = $userDAO->find($id);
$roleDAO = $daoFactory->getRoleDAO();
$roles = $roleDAO->findAll();

if (! $user instanceof User) {
    redirectWarning("http://w2w.localhost/admin/", "User not found (#$id)");
}


?>

<form action="/root/user/update.php" method="post" style="margin:25px;max-width:480px">
    <input type="hidden" id="id" name="id" value="<?php echo escape($user->getId()); ?>"/>

    <label for="userName">Nom d'utilisateur :</label>
    <input type="text" id="userName" name="UserName" value="<?php echo escape($user->getUserName()); ?>" disabled class="form-control"/>
    
    <label for="role">Role :</label>
    <select id="role" name="role" class="form-control">
        <?php foreach ($roles as $role) : ?>
        <option value="<?php echo escape($role->getId()); ?>" 
            <?php if ($role->getId() == $user->getRole()->getId()) : ?>
            selected="selected"
            <?php endif; ?>
            ><?php echo escape($role->getName()); ?></option>
        <?php endforeach; ?>
    </select>
    
    <input type="submit" value="Update role"/>
</form>
