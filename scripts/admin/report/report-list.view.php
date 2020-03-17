<?php

checkAdmin();

?>
    <div class="header-dasboard ">
        <div>
            <h1 class="small text-uppercase">Dashboard</h1>
            <h2 class="h4 font-weight-normal">Liste des plaintes</h2>
        </div>

    </div>


    <div class="bg-white movie_list p-4">
        <div class="flashBag">
            <?php
            \w2w\Utils\Utils::echoMessage();
            ?>
        </div>
            <table id="report_list" class="table table-striped text-center">
                <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Critique</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Traité</th>
                    <th scope="col">Editer</th>
                    <th scope="col">Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($reports) && count($reports) > 0) : ?>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td class="report_userName">
                                <p><?php echo escape($report->getUser()->getUserName()); ?></p>
                            </td>
                            <td class="report_reviewId">
                                <p><?php echo escape($report->getReview()->getId()); ?></p>
                            </td>
                            <td class="report_message">
                                <p><?php echo escape($report->getMessage()); ?></p>
                            </td>
                            <td class="report_date">
                                <p><?php echo escape($report->getCreatedAt()->format('Y-m-d')); ?></p>
                            </td>
                            <td class="report_treated">
                                <p><?php echo escape($report->isTreated()); ?></p>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-edit" data-target="#modal-edit-review" data-toggle="modal"></i>
                            </td>
                            <td class="text-center">
                                <i class="fa fa-trash" data-target="#modal-delete-review" data-toggle="modal"
                                   data-revid="<?php echo escape($report->getId()); ?>"></i>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#report_list').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false},
                    {"orderable": false},
                ],
                "order": [[3, "asc"]]
            });
        });
    </script>
<?php

