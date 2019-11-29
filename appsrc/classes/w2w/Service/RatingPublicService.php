<?php
    
    
    namespace w2w\Service;
    
    
    use w2w\DAO\RatingDAO;
    use \w2w\Model\Rating;
    
    class RatingPublicService extends PublicService
    {
        private $ratingDAO;
        /**
         * RatingPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->ratingDAO = new RatingDAO();
        }
        
        
        /**
         * getAllRatings
         * @return Rating[]
         */
        public function getAllRatings()
        {
            return $this->ratingDAO->selectAllRatings();
        }
        
        /**
         * @param int $id
         * @return Rating
         */
        public function getRatingById(int $id)
        {
            return $this->ratingDAO->selectRatingById($id);
        }
        
        /**
         * getRatingByName
         * @param string $name
         * @return Rating
         */
        public function getRatingByName(string $name)
        {
            return $this->ratingDAO->selectRatingByName($name);
        }
        
        /**
         * getRatingByValue
         * @param int $value
         * @return Rating
         */
        public function getRatingByValue(int $value)
        {
            return $this->ratingDAO->selectRatingByValue($value);
        }
        
    }