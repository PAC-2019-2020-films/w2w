<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:31
     */
    
    namespace w2w\DAO;
    
    
    use w2w\Model\Artist;
    use w2w\Model\Category;
    use w2w\Model\Movie;
    use w2w\Model\Rating;
    use w2w\Model\Tag;
    use DateTime;
    
    class MovieDAO extends BaseDAO
    {
        private $table = 'movies';
        private $tableCategories = 'categories';
        private $tableReviews = 'reviews';
        private $tableRating = 'ratings';
        private $tableTags = 'tags';
        private $tableMovieTags = 'movies_tags';
        
        private $categoryDAO;
        private $reviewDAO;
        private $movieTagsDAO;
        private $movieDirectorDAO;
        private $movieActorDAO;
        private $ratingDAO;
        
        /**
         * MovieDAO constructor.
         */
        public function __construct(ReviewDAO $reviewDAO = null)
        {
            parent::__construct();
            $this->categoryDAO = new CategoryDAO();
            
            if (!$reviewDAO) {
                $this->reviewDAO = new ReviewDAO($this);
            } else {
                $this->reviewDAO = $reviewDAO;
            }
            
            $this->movieTagsDAO     = new MovieTagsDAO();
            $this->movieDirectorDAO = new MovieDirectorDAO();
            $this->movieActorDAO    = new MovieActorDAO();
            $this->ratingDAO        = new RatingDAO();
        }
        
        /**
         * Binds a PDO::fetchAll result row to a new Movie Object
         * @param array $movieArray
         * @return bool|Movie $movie
         */
        public function movieObjectBinder(array $movieArray)
        {
            if (isset($movieArray['id']) && isset($movieArray['title']) && isset($movieArray['fk_category_id'])) {
                
                $movie = new Movie(
                    $movieArray['id'],
                    $movieArray['title'],
                    $this->categoryDAO->selectCategoryById($movieArray['fk_category_id'])
                );
                
                if ($movieArray['description']) {
                    $movie->setDescription($movieArray['description']);
                }
                
                if ($movieArray['year']) {
                    $movie->setYear($movieArray['year']);
                }
                
                if ($movieArray['poster']) {
                    $movie->setPoster($movieArray['poster']);
                }
                
                if ($movieArray['fk_admin_review.id']) {
                    $movie->setReviewAdmin($this->reviewDAO->selectReviewById($movieArray['fk_admin_review.id']));
                }
                
                if ($movieArray['fk_rating_id']) {
                    $movie->setRating($this->ratingDAO->selectRatingById($movieArray['fk_rating_id']));
                }

//            Fetch, instantiate and add tags to the Movie Object
                $movieTags = $this->movieTagsDAO->selectMovieTagsByMovie($movie);
                
                if ($movieTags) {
                    foreach ($movieTags as $movieTag) {
                        $movie->addTag($movieTag);
                    }
                }

//            Fetch, instantiate and add directors to the Movie Object
                $movieDirectors = $this->movieDirectorDAO->selectMovieDirectorsByMovie($movie);
                
                if ($movieDirectors) {
                    foreach ($movieDirectors as $movieDirector) {
                        $movie->addDirector($movieDirector);
                    }
                }

//            Fetch, instantiate and add actors to the Movie Object
                $movieActors = $this->movieActorDAO->selectMovieActorsByMovie($movie);
                
                if ($movieActors) {
                    foreach ($movieActors as $movieActor) {
                        $movie->addActor($movieActor);
                    }
                }
                
                return $movie;
            } else {
                return false;
            }
        }
        
        /**
         * selectMovieByIdBarebone
         * @param int $id
         * @return bool|Movie
         */
        public function selectMovieByIdBarebone(int $id)
        {
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.title,
                       {$this->table}.fk_category_id,
                FROM {$this->table}
                WHERE {$this->table}.id = :id
        ";
            
            $condition = [':id' => $id];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->movieObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
        /**
         * @return bool|Movie[]
         */
        public function selectAllMovies()
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                ORDER BY {$this->table}.year DESC;  
        ";
            
            $result = $this->select($sql);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param int $id
         * @return bool|Movie
         */
        public function selectMovieById(int $id)
        {
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id,
                       {$this->table}.fk_admin_review.id,
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.id = :id
        ";
            
            $condition = [':id' => $id];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->movieObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Category $category
         * @return bool|Movie[]
         */
        public function selectMoviesByCat(Category $category)
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.fk_category_id = :category
        ";
            
            $condition = [':category' => $category->getId()];
            $dataType  = 1;
            
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Tag $tag
         * @return bool|Movie[]
         */
        public function selectMoviesByTag(Tag $tag)
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->tableTags}.id, 
                       {$this->tableMovieTags}.fk_tag_id, 
                       {$this->tableMovieTags}.fk_movie_id, 
                       {$this->table}.id, 
                       {$this->table}.title,  
                       {$this->table}.description,  
                       {$this->table}.year,  
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->tableTags}
                    LEFT JOIN {$this->tableMovieTags} 
                            ON {$this->tableTags}.id = {$this->tableMovieTags}.fk_tag_id
                    LEFT JOIN {$this->table} 
                            ON {$this->table}.id = {$this->tableMovieTags}.fk_movie_id
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->tableTags}.id = :id;
       ";
            
            $condition = [':id' => $tag->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Rating $rating
         * @return bool|array
         */
        public function selectMoviesByRating(Rating $rating)
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.fk_rating_id = :rating
        ";
            
            $condition = [':rating' => $rating->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param string $keyword
         * @return bool|array
         */
        public function selectMoviesBySearch(string $keyword)
        {
            $movies = [];
            
            $needle = "%$keyword%";
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.title LIKE :needle
                            OR {$this->table}.description LIKE :needle
                ORDER BY {$this->table}.year DESC;  
        ";
            
            $condition = [':needle' => $keyword];
            
            $result = $this->select($sql, $condition);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @return bool|array
         */
        public function selectLastFiveMovies()
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                ORDER BY {$this->table}.id DESC
                LIMIT 5;  
        ";
            
            $result = $this->select($sql);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @return bool|Movie[]
         */
        public function selectBestFiveMovies()
        {
            /**
             * TODO : SELECT BEST FIVE MOVIES
             */
            return false;
        }
        
        /**
         * @param Artist $director
         * @return bool|Movie[]
         */
        public function selectMoviesByDirector(Artist $director)
        {
            /**
             * TODO : SELECT MOVIES BY DIRECTOR
             */
            return false;
        }
        
        /**
         * @param Artist $actor
         * @return bool|Movie[]
         */
        public function selectMoviesByActor(Artist $actor)
        {
            
            /**
             * TODO : SELECT MOVIES BY ACTOR
             */
            return false;
        }
        
        /**
         * @param DateTime $date
         * @return bool|array
         */
        public function selectMoviesByYear(DateTime $date)
        {
            $movies = [];
            
            $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.year = :date
                ORDER BY {$this->table}.title;  
        ";
            
            $condition = [':date', $date];
            $dataType  = 2;
            
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $movie) {
                    array_push($movies, $this->movieObjectBinder($movie));
                }
                return $movies;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
        /**
         * @param Movie $movie
         * @return bool|int
         */
        public function insertMovie(Movie $movie)
        {
            $data = [
                'title'              => [$movie->getTitle(), 2],
                'description'        => [$movie->getDescription(), 2],
                'year'               => [$movie->getYear(), 1], // !!!! WARNING YEAR IS IN INT (wut?) in the DB while $movie->getYear() is DATETIME !!!!
                /*
                * TODO : update DB year field type
                */
                'poster'             => [$movie->getPoster(), 2],
                'fk_category_id'     => [$movie->getCategory()->getId(), 1],
                'fk_admin_review_id' => [$movie->getReviewAdmin()->getId(), 1],
                'fk_rating_id'       => [$movie->getRating()->getId(), 1]
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
         * @param Movie $movie
         * @return bool|int
         */
        public function updateMovie(Movie $movie)
        {
            $data = [
                'title'              => [$movie->getTitle(), 2],
                'description'        => [$movie->getDescription(), 2],
                'year'               => [$movie->getYear(), 1], // !!!! WARNING YEAR IS IN INT (wut?) in the DB while $movie->getYear() is DATETIME !!!!
                /*
                * TODO : update DB year field type
                */
                'poster'             => [$movie->getPoster(), 2],
                'fk_category_id'     => [$movie->getCategory()->getId(), 1],
                'fk_admin_review_id' => [$movie->getReviewAdmin()->getId(), 1],
                'fk_rating_id'       => [$movie->getRating()->getId(), 1]
            ];
            
            $condition = "{$this->table}.id = :id";
            
            $result = $this->update($this->table, $data, $condition, $movie->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            return false;
        }
        
        /**
         * @param Movie $movie
         * @return bool|int
         */
        public function deleteMovie(Movie $movie)
        {
            $condition = "{$this->table}.id = :id";
            
            $result = $this->delete($this->table, $condition, $movie->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
    }