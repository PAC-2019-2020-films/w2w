<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$messageDAO = $daoFactory->getMessageDAO();
$message = $messageDAO->find($id);

if (! $message) {
    redirectWarning("/admin/", "Message non trouv (#$id)");
}

?>

<style>
    .message {
        margin:20px;padding:5px;
        border:inset 1px #000;
        max-width:480px;
    }
</style>

<h2>Message de <?php echo escape($message->getFirstName()); ?> <?php echo escape($message->getLastName()); ?></h2>

<div>
    Date : <?php echo escape($message->getCreatedAt()->format("d/m/Y H:i:s")); ?>
    <br/>
    Email : <a href="mailto://<?php echo escape($message->getEmail()); ?>"><?php echo escape($message->getEmail()); ?></a>
    <br/>
    Message :
    <blockquote class="message"><?php echo escape($message->getContent()); ?></blockquote>
</div>


<?php if ($message->isTreated()) : ?>
<div>Message traité.</div>
<?php else : ?>
<form action="/admin/message/update.php" method="post" style="margin:25px;max-width:480px">
    <input type="hidden" id="id" name="id" value="<?php echo escape($message->getId()); ?>"/>
    <input type="submit" value="Marquer comme traité"/>
</form>
<?php endif ; ?>

