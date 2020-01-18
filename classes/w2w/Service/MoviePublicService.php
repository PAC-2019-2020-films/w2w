<?php
    
    
    namespace w2w\Service;
    
    use DateTime;

    use w2w\DAO\MovieDAO;
    use \w2w\Model\Artist;
    use \w2w\Model\Category;
    use \w2w\Model\Movie;
    use \w2w\Model\Rating;
    use \w2w\Model\Tag;
    
    class MoviePublicService extends PublicService
    {
        
        protected $movieDAO;
        /**
         * MoviePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->movieDAO = new MovieDAO();
        }
        
        /**
         * getAllMovies
         * @return Movie[]
         */
        public function getAllMovies()
        {
            return $this->movieDAO->selectAllMovies();
        }
        
        
        /**
         * getMovieById
         * @param int $id
         * @return Movie
         */
        public function getMovieById(int $id)
        {
            return $this->movieDAO->selectMovieById($id);
        }
        
        /**
         * @param int $id
         * @return Movie
         */
        public function getMovieByIdBarebone(int $id)
        {
            return $this->movieDAO->selectMovieByIdBarebone($id);
        }
        
        /**
         * getMoviesByCat
         * @param $category Category
         * @return Movie[]
         */
        public function getMoviesByCat(Category $category)
        {
            return $this->movieDAO->selectMoviesByCat($category);
        }
        
        /**
         * getMoviesByTag
         * @param $tag Tag
         * @return Movie[]
         */
        public function getMoviesByTag(Tag $tag)
        {
            return $this->movieDAO->selectMoviesByTag($tag);
        }
        
        /**
         * getMoviesByRating
         * @param Rating $rating
         * @return Movie[]
         */
        public function getMoviesByRating(Rating $rating)
        {
            return $this->movieDAO->selectMoviesByRating($rating);
        }
        
        /**
         * getMoviesBySearch
         * @param string $keyword
         * @return Movie[]
         */
        public function getMoviesBySearch(string $keyword)
        {
            return $this->movieDAO->selectMoviesBySearch($keyword);
        }
        
        /**
         * getLastFiveMovies
         * @return Movie[]
         */
        public function getLastFiveMovies()
        {
            return $this->movieDAO->selectLastFiveMovies();
        }
        
        /**
         * getBestFiveMovies
         * @return Movie[]
         */
        public function getBestFiveMovies()
        {
            return $this->movieDAO->selectBestFiveMovies();
        }
        
        /**
         * getMoviesByDirector
         * @param Artist $director
         * @return Movie[]
         */
        public function getMoviesByDirector(Artist $director)
        {
            /**
             * TODO : GET MOVIES BY DIRECTOR
             */
            $movieByDirector = [];
            return $movieByDirector;
        }
        
        /**
         * getMoviesByActor
         * @param Artist $actor
         * @return Movie[]
         */
        public function getMoviesByActor(Artist $actor)
        {
            
            /**
             * TODO : GET MOVIES BY ACTOR
             */
            $movieByActor = [];
            return $movieByActor;
        }
        
        /**
         * getMoviesByYear
         * @param DateTime $date
         * @return Movie[]
         */
        public function getMoviesByYear(DateTime $date)
        {
            return $this->movieDAO->selectMoviesByYear($date);
        }
        
    }