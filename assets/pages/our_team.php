<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Welcome on what to watch</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/nav_foot_li.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
</head>

<body>

<!-- start of NavBar-->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/scripts/templates/include/navbar.php') ?>
<!-- end of NavBar -->

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/assets/img/teamwork.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-caption our_team">
            OUR TEAM
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- début de Dominique -->
        <div class="col-md-3 team_col   ">
            <img class="team_photo" src="/assets/img/team/dominique_anceau.jpg" alt="Dominique">
        </div>
        <div class="col-md-9 team_col team_font">
            <h1>Dominique ANCEAU</h1>
            <h3>
                scrum master <br>
                <p>
                <u>spécialiste en :</u><br>
                HTML - CSS
                </p>
            </h3>
        </div>
        <!-- fin de dominique -->

        <!-- début de Laura -->
        <div class="col-md-3 team_col">
            <img class="team_photo" src="/assets/img/team/laura_roost.jpg" alt="laura">
        </div>
        <div class="col-md-9 team_col team_font">
            <h1>Laura ROOST</h1>
            <h3>
                Designer <br>
                <p>
                    <u>spécialiste en :</u><br>
                    HTML - CSS - PHP - JavaScript
                </p>
            </h3>
        </div>
        <!-- fin de laura -->

        <!-- début de Xavier -->
        <div class="col-md-3 team_col">
            <img class="team_photo" src="/assets/img/team/xavier_ronveau.jpg" alt="xavier">
        </div>
        <div class="col-md-9 team_font team_col">
            <h1>Xavier RONVEAU</h1>
            <h3>
                product owner <br>
                <p>
                    <u>spécialiste en :</u><br>
                    HTML - CSS - PHP - PYTHON - IA - JAVA
                </p>
            </h3>
        </div>
        <!-- fin de xavier -->

        <!-- début de Julien  -->
        <div class="col-md-3 team_col">
            <img class="team_photo" src="/assets/img/team/julien_fastre.jpg" alt="julien">
        </div>
        <div class="col-md-9 team_font team_col">
            <h1>Julien FASTRÉ</h1>
            <h3>
                Symfony guy <br>
                <p>
                    <u>spécialiste en :</u><br>
                    HTML - CSS - PHP - JAVA - SQL - Symfony - JavaScript
                </p>
            </h3>
        </div>
        <!-- fin de Julien -->

        <!-- début de Mikael  -->
        <div class="col-md-3 team_col">
            <img class="team_photo" src="/assets/img/team/mickael.jpg" alt="julien">
        </div>
        <div class="col-md-9 team_font team_col">
            <h1>Mikaël</h1>
            <h3>
                DB guy <br>
                <p>
                    <u>spécialiste en :</u><br>
                    HTML - CSS - PHP - JAVA - SQL - Symfony
                </p>
            </h3>
        </div>
        <!-- fin de mikael -->

        <!-- début de camol -->
        <div class="col-md-3 team_col">
            <img class="team_photo" src="/assets/img/team/olivier_camus.jpg" alt="julien">
        </div>
        <div class="col-md-9 team_font team_col">
            <h1>Olivier CAMUS</h1>
            <h3>
                guy <br>
                <p>
                    <u>spécialiste en :</u><br>
                    HTML - CSS
                </p>
            </h3>
        </div>
        <!-- fin de camol -->
    </div>

</div>


<!-- start of Footer -->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/scripts/templates/include/footer.php') ?>
<!-- end of footer -->
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
