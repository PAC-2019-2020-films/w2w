<?php
    
    
    namespace w2w\Service;
    
    
    use w2w\Model\Movie;

    class MovieAdminService extends MoviePublicService
    {
    
        /**
         * MovieAdminService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
        * addMovie
        * @param Movie $movie
        * @return bool
        */
        public function addMovie(Movie $movie)
        {
            return $this->movieDAO->insertMovie($movie);
        }
        
        /**
        * updateMovie
        * @param Movie $movie
        * @return bool
        */
        public function updateMovie(Movie $movie)
        {
            return $this->movieDAO->updateMovie($movie);
        }
        
    }