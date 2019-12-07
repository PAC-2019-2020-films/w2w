<?php
    
    
    namespace w2w\DAO\PDO;
    
    
    use w2w\Model\Movie;
    use w2w\Model\Review;
    use w2w\Model\User;
    
    class ReviewDAO extends BaseDAO
    {
        private $table = 'reviews';
        private $movieDAO;
        private $userDAO;
        private $ratingDAO;
        
        /**
         * ReviewDAO constructor.
         */
        public function __construct(MovieDAO $movieDAO = null)
        {
            parent::__construct();
            
            if (!$movieDAO) {
                $this->movieDAO = new MovieDAO($this);
            } else {
                $this->movieDAO = $movieDAO;
            }
            
            $this->userDAO   = new UserDAO();
            $this->ratingDAO = new RatingDAO();
        }
        
        /**
         * reviewObjectBinder
         * Binds a PDO::fetchAll result row to a new Review Object
         * @param array $reviewArray
         * @return bool|Review
         */
        public function reviewObjectBinder(array $reviewArray)
        {
            if (isset($reviewArray['id']) && isset($reviewArray['content']) && isset($reviewArray['created_at']) && isset($reviewArray['fk_movie_id']) && isset($reviewArray['fk_user_id']) && isset($reviewArray['fk_rating_id'])) {
                $review = new Review(
                    $reviewArray['id'],
                    $reviewArray['content'],
                    $reviewArray['created_at'],
                    $this->movieDAO->selectMovieByIdBarebone($reviewArray['fk_movie_id']),
                    $this->userDAO->selectUserById($reviewArray['fk_user_id']),
                    $this->ratingDAO->selectRatingById($reviewArray['fk_rating_id'])
                );
                
                if ($reviewArray['updated_at']) {
                    $review->setUpdatedAt($reviewArray['updated_at']);
                }
                
                return $review;
                
            } else {
                return false;
            }
        }
        
        
        /**
         * @return bool|Review[]
         */
        public function selectAllReviews()
        {
            $reviews = [];
            
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id,  
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;
                ";
            
            $result = $this->select($sql);
            
            if (is_array($result)) {
                foreach ($result as $review) {
                    array_push($reviews, $this->reviewObjectBinder($review));
                }
                return $reviews;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param int $id
         * @return bool|Review
         */
        public function selectReviewById(int $id)
        {
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
                FROM {$this->table}
                WHERE {$this->table}.id = :id;
                ";
            
            $condition = [':id' => $id];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->reviewObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Movie $movie
         * @return bool|Review[]
         */
        public function selectReviewsByMovie(Movie $movie)
        {
            $reviews = [];
            
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
                FROM {$this->table}
                WHERE {$this->table}.fk_movie_id = :movieId;
                ";
            
            $condition = [':movieId' => $movie->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $review) {
                    array_push($reviews, $this->reviewObjectBinder($review));
                }
                return $reviews;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param User $user
         * @return bool|Review[]
         */
        public function selectReviewsByUser(User $user)
        {
            $reviews = [];
            $sql     = "SELECT  {$this->table}.id,
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
                FROM {$this->table}
                WHERE {$this->table}.fk_user_id = :userId;
                ";
            
            $condition = [':userId' => $user->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $review) {
                    array_push($reviews, $this->reviewObjectBinder($review));
                }
                return $reviews;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Review $review
         * @return bool|int
         */
        public function insertReview(Review $review)
        {
            $data = [
                'content'      => [$review->getContent(), 2],
                'created_at'   => [$review->getCreatedAt(), 2],
                'updated_at'   => [$review->getUpdatedAt(), 2],
                'fk_movie_id'  => [$review->getMovie()->getId(), 1],
                'fk_user_id'   => [$review->getUser()->getId(), 1],
                'fk_rating_id' => [$review->getRating()->getId(), 1],
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
         * @param Review $review
         * @return bool|int
         */
        public function updateReview(Review $review)
        {
            $data = [
                'content'      => [$review->getContent(), 2],
                'created_at'   => [$review->getCreatedAt(), 2],
                'updated_at'   => [$review->getUpdatedAt(), 2],
                'fk_movie_id'  => [$review->getMovie()->getId(), 1],
                'fk_user_id'   => [$review->getUser()->getId(), 1],
                'fk_rating_id' => [$review->getRating()->getId(), 1],
            ];
            
            $condition = "{$this->table}.id = :id";
            
            $result = $this->update($this->table, $data, $condition, $review->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            return false;
        }
        
        /**
         * @param Review $review
         * @return bool|int
         */
        public function deleteReview(Review $review)
        {
            $condition = "{$this->table}.id = :id";
            
            $result = $this->delete($this->table, $condition, $review->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
    }
