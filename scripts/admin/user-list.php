<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$userDAO = $daoFactory->getUserDAO();
$users = $userDAO->findAll();


?>

<h1>Liste des utilisateurs</h1>


<table border="1" width="100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>UserName</th>
            <th>Email</th>
            <th>Verified</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($users) && is_array($users) && count($users) > 0) : ?>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td>
                    <a href="/admin/?id=<?php echo escape($user->getId()); ?>"><?php echo escape($user->getId()); ?></a>
                </td>
                <td>
                    <a href="/admin/.php?id=<?php echo escape($user->getId()); ?>"><?php echo escape($user->getUserName()); ?></a>
                </td>
                <td>
                    <?php echo escape($user->getEmail()); ?>
                </td>
                <td>
                    <?php echo escape($user->isEmailVerified()); ?>
                </td>
                <td>
                    <?php echo escape($user->getFirstName()); ?>
                </td>
                <td>
                    <?php echo escape($user->getLastName()); ?>
                </td>
                <td>
                    <?php if ($role = $user->getRole()) echo escape($role->getName()); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </ul>
    </tbody>
</table>
<ul>
