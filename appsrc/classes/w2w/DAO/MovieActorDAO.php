<?php
    
    
    namespace w2w\DAO;
    
    
    use w2w\Model\Artist;
    use w2w\Model\Movie;
    
    class MovieActorDAO extends BaseDAO
    {
        private $table = 'movies_actors';
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
         * @param Movie $movie
         * @return bool|Artist[]
         */
        public function selectMovieActorsByMovie(Movie $movie)
        {
            $movieActors = [];
            
            $sql         = "
                SELECT {$this->tableMovie}.id AS movieId,
                       {$this->table}.fk_movie_id, 
                       {$this->table}.fk_artist_id, 
                       {$this->tableArtist}.id, 
                       {$this->tableArtist}.last_name, 
                       {$this->tableArtist}.first_name
                FROM {$this->tableMovie}
                    LEFT JOIN {$this->table} 
                            ON {$this->tableMovie}.id = {$this->table}.id
                    LEFT JOIN {$this->tableArtist} 
                            ON {$this->table}.fk_artist_id={$this->tableArtist}.id
                WHERE {$this->tableMovie}.id = :id;
        ";
            
            $condition = [':id' => $movie->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $actor) {
                    array_push($movieDirectors, $this->artistDAO->artistObjectBinder($actor));
                }
                return $movieActors;
            }
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
        /**
         * @param Artist $actor
         * @param Movie $movie
         * @return bool|int
         */
        public function insertMovieActor(Artist $actor, Movie $movie)
        {
            $data = [
                "fk_movie_id"  => [$movie->getId(), 1],
                "fk_artist_id" => [$actor->getId(), 1]
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
         * @param Artist $actor
         * @param Movie $movie
         * @return bool|int
         */
        public function deleteMovieActor(Artist $actor, Movie $movie)
        {
            $condition = "{$this->table}.fk_movie_id = :id AND {$this->table}.fk_artist_id = :idBis";
            
            $result = $this->delete($this->table, $condition, $movie->getId(), $actor->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
    }