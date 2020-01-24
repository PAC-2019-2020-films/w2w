<?php

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=w2w;charset=utf8', 'w2w', 'w2w');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

?>
<?php
$select_movie_t = $bdd->prepare(
    'SELECT 
                    movies.id AS movies_id, 
                    movies.title AS movies_title,
                    movies.year AS movies_year,
                    categories.name AS category_name, 
                    ratings.description AS rating_description FROM movies 
                    INNER JOIN categories ON movies.fk_category_id = categories.id
                    INNER JOIN ratings ON movies.fk_rating_id = ratings.id
                    ORDER BY movies.id ASC' );

$select_tag_t = $bdd->prepare(
    'SELECT 
                    movies_tags.fk_movie_id AS id,
                    movies.title AS movies_title,
                    tags.name AS tags_name
                    FROM movies_tags
                    INNER JOIN movies ON movies.id = movies_tags.fk_movie_id
                    INNER JOIN tags ON tags.id = movies_tags.fk_tag_id
                    WHERE movies.id = :id'
);

$select_popular_t = $bdd->prepare(
    'SELECT
                    movies.id AS movies_id,
                    movies.title AS movies_title,
                    movies.description as movies_description
                    FROM movies
                    ORDER BY movies.id 
                    LIMIT 8'
);

$select_count_movie_t = $bdd->prepare(
    'SELECT COUNT(*) AS nbs_movies FROM movies'
);


$select_review_t = $bdd->prepare(
    'SELECT * FROM movies
                    ORDER BY id DESC
                    LIMIT 0,5'
);
    ?>