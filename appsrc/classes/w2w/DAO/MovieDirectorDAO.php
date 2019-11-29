<?php


namespace w2w\DAO;


use w2w\Model\Artist;
use w2w\Model\Movie;

class MovieDirectorDAO extends BaseDAO
{
    private $table = 'movies_directors';
    private $tableArtist = 'artists';
    private $tableMovie = 'movies';

    private $artistDAO;

    /**
     * MovieDirectorDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->artistDAO = new ArtistDAO();
    }

    /**
     * @param Artist $artist
     * @return bool
     */
    public function isMovieDirectorByArtist(Artist $artist)
    {
        $sql = "
                SELECT {$this->table}.fk_movie_id,
                        {$this->table}.fk_artist_id
                FROM {$this->table}
                WHERE {$this->table}.fk_artist_id = :id
        ";

        $condition = [':id' => $artist->getId()];
        $dataType = 1;
        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result) && isset($result[0])) {
            return true;
        }
        return false;

    }


    /**
     * @param Movie $movie
     * @return bool|Artist[]
     */
    public function selectMovieDirectorsByMovie(Movie $movie)
    {
        $movieDirectors = [];

        $sql = "
                SELECT {$this->tableMovie}.id AS movieId,
                       {$this->table}.fk_movie_id, 
                       {$this->table}.fk_artist_id, 
                       {$this->tableArtist}.id, 
                       {$this->tableArtist}.last_name, 
                       {$this->tableArtist}.first_name
                FROM {$this->tableMovie}
                    LEFT JOIN {$this->table} 
                            ON {$this->tableMovie}.id = {$this->table}.fk_movie_id
                    LEFT JOIN {$this->tableArtist} 
                            ON {$this->table}.fk_artist_id={$this->tableArtist}.id
                WHERE {$this->tableMovie}.id = :id;
        ";

        $condition = [':id' => $movie->getId()];
        $dataType = 1;
        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            foreach ($result as $director) {
                array_push($movieDirectors, $this->artistDAO->artistObjectBinder($director));
            }
            return $movieDirectors;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Artist $director
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovieDirector(Artist $director, Movie $movie)
    {
        $data = [
            "fk_movie_id" => [$movie->getId(), 1],
            "fk_artist_id" => [$director->getId(), 1]
        ];

        $result = $this->insert($this->table, $data);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Artist $director
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieDirectorByMovie(Artist $director, Movie $movie)
    {
        $condition = "
                {$this->table}.fk_movie_id = :id
            AND {$this->table}.fk_artist_id = :idBis
            ";

        $result = $this->delete($this->table, $condition, $movie->getId(), $director->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Artist $director
     * @return bool|int
     */
    public function deleteMovieDirector(Artist $director)
    {
        $condition = "
            {$this->table}.fk_artist_id = :id
            ";

        $result = $this->delete($this->table, $condition, $director->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


}