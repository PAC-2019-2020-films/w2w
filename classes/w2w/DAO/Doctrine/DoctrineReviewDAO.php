<?php
    
    namespace w2w\DAO\Doctrine;
    
    use w2w\DAO\ReviewDAO;
    use w2w\Model\Movie;
    use w2w\Model\Review;
    use w2w\Model\User;
    
    class DoctrineReviewDAO extends DoctrineGenericDAO implements ReviewDAO
    {
        
        public function __construct()
        {
            parent::__construct(Review::class);
        }
        
        /**
         * @param Movie $movie
         * @return bool|Review[]
         */
        public function findByMovie(Movie $movie)
        {
            return $movie->getReviews();
        }
        
        /**
         * @param User $user
         * @return bool|Review[]
         */
        public function findByUser(User $user)
        {
            return $user->getReviews();
        }
        
        public function findByUserAndMovie(User $user, Movie $movie)
        {
    
            $dql = sprintf("SELECT r FROM %s r  WHERE r.movie=:movId AND r.user=:uid", Review::class);
            $query = $this->getEntityManager()->createQuery($dql)->setParameter("movId", $movie->getId())->setParameter("uid", $user->getId());
            
            return $query->getResult();
            
//            $qb = $this->getEntityManager()->createQueryBuilder();
        
        }
        
    }
