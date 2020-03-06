<?php
    
checkAdmin();

?>
    <div class="header-dasboard ">
        <div>
            <h1 class="small text-uppercase">Dashboard</h1>
            <h2 class="h4 font-weight-normal">Liste des messages</h2>
        </div>

    </div>
    <div class="bg-white movie_list p-4">
    <h3 class="h6 font-weight-normal">Liste des messages non traités</h3>
        <hr/>
    <!-- *************** FLASHBAG *************** -->
    <div class="flashBag">
        <?php
            \w2w\Utils\Utils::echoMessage();
        ?>
    </div>
    <!-- *************** END FLASHBAG *************** -->

        <table id="untreated_message_list" class="table table-striped mb-3">
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

        <h3 class="h6 font-weight-normal my-4">Liste des messages traités</h3>
        <hr/>
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
    <script>
        $(document).ready(function () {
            $('#untreated_message_list').DataTable({
            });
            $('#treated_message_list').DataTable({
            });
        });
    
    </script>
<?php
/* ****************** END DATATABLES ****************** */


