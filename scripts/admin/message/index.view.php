<?php
    
checkAdmin();

?>

    <!-- *************** FLASHBAG *************** -->
    <div class="flashBag">
        <?php
            \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    <!-- *************** END FLASHBAG *************** -->
    


    <div class="container-fluid user_list">
        <h2>Liste des messages non traités</h2>
        <table id="untreated_message_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($untreated) && is_array($untreated)) : ?>
                    <?php foreach ($untreated as $message) : ?>
                        <tr>
                            <td scope="row" class="cat_id">
                                <p><?php echo escape($message->getId()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getFirstName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getLastName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getEmail()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getCreatedAt()->format("Y-m-d H:i:s")); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><a href="/admin/message/edit.php?id=<?php echo escape($message->getId()); ?>"><i class="fas fa-edit"></i></a></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    
    </div>


    <div class="container-fluid user_list">
        <h2>Liste des messages traités</h2>
        <table id="treated_message_list" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($treated) && is_array($treated)) : ?>
                    <?php foreach ($treated as $message) : ?>
                        <tr>
                            <td scope="row" class="cat_id">
                                <p><?php echo escape($message->getId()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getFirstName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getLastName()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getEmail()); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><?php echo escape($message->getCreatedAt()->format("Y-m-d H:i:s")); ?></p>
                            </td>
                            <td class="cat_description">
                                <p><a href="/admin/message/edit.php?id=<?php echo escape($message->getId()); ?>"><i class="fas fa-edit"></i></a></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    
    </div>





<?php
    
    /* ****************** DATATABLES ****************** */
?>
    <!-- 
    <script>
        $(document).ready(function () {
            $('#message_list').DataTable({
                /*"columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false}
                ],
                "order": [[1, "asc"]]
                */
            });
        });
    
    </script>
    -->
<?php
/* ****************** END DATATABLES ****************** */


