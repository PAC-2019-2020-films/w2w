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
                <th scope="col">Film</th>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col">Traité</th>
                <th scope="col">Editer</th>
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
                            <p>
                                <a href="http://w2w.localhost/movie.php?id=<?php echo escape($report->getReview()->getMovie()->getId()); ?>#<?php echo escape($report->getReview()->getId()); ?>"><?php echo escape($report->getReview()->getId()); ?></a>
                            </p>
                        </td>
                        <td class="report_movieId">
                            <p>
                                <a href="http://w2w.localhost/movie.php?id=<?php echo escape($report->getReview()->getMovie()->getId()); ?>"><?php echo escape($report->getReview()->getMovie()->getTitle()); ?>
                            </p>
                        </td>
                        <td class="report_message">
                            <p><?php echo escape($report->getMessage()); ?></p>
                        </td>
                        <td class="report_date">
                            <p><?php echo escape($report->getCreatedAt()->format('Y-m-d')); ?></p>
                        </td>
                        <td class="report_treated">
                            <?php if (!$report->isTreated()) {
                                echo "<p><i class='fa fa-times'></i></p>";
                            } else {
                                echo "<p><i class='fa fa-check'></i></p>";
                            } ?>
                        </td>
                        <td class="report_treated">
                            <?php if (!$report->isTreated()) {
                                ?>
                                <p class='setTreated'
                                   data-target="#modal-treat-report"
                                   data-toggle="modal"
                                   data-reportid="<?php echo escape($report->getId()); ?>"
                                   data-reportistreated="0">
                                    Marquer comme traité.
                                </p>
                                <?php
                            } else {
                                ?>
                                <p class='setTreated'
                                   data-target="#modal-treat-report"
                                   data-toggle="modal"
                                   data-reportid="<?php echo escape($report->getId()); ?>"
                                   data-reportistreated="1">
                                    Marquer comme non traité.
                                </p>
                                <?php
                            } ?>

                        </td>


                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ****************** Treat Report confirm box ****************** -->
    <div class="modal fade" id="modal-treat-report" tabindex="-1" role="dialog"
         aria-labelledby="modal-treat-report"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="treatReporttitle">Rapport traité/non traité</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <form action="report-edit.php" method="post" id="treatReportForm"
                          enctype="multipart/form-data">
                        <div>
                            <input type="hidden" id="confirm" name="confirm" value="confirm"/>
                            <label for="treatReportSubmit" class="submitTreatedLabel">Marquer ce rapport comme traité?</label>
                            <input id="treatReportSubmit" type="submit" class="btn btn-primary submitReportTreated" value="Confirmer ?"
                                   data-dismiss="modal"/>
                            <button class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ****************** END Treat Report confirm box ****************** -->

    <script>
        $(document).ready(function () {
            $('#report_list').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false},
                ],
                "order": [[3, "asc"]]
            });
        });
    </script>
<?php

