<?php


namespace w2w\Service;


use w2w\DAO\ReviewDAO;
use \w2w\Model\Review;

class ReviewUserService extends ReviewPublicService
{

    private $movieService;
    private $ratingService;
    private $reviewDAO;

    /**
     * ReviewUserService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->movieService = new MoviePublicService();
        $this->ratingService = new RatingPublicService();
        $this->reviewDAO = new ReviewDAO();
    }

    /**
     * @param array $reviewArray
     * @return bool|int
     */
    public function addReview(array $reviewArray)
    {
        $review = $this->reviewDAO->reviewObjectBinder($reviewArray);

//        Ensure that linked movie exists
        if ($this->movieService->getMovieByIdBarebone($review->getMovie()->getId())) {
//        Ensure that linked rating exists
            if ($this->ratingService->getRatingById($review->getRating()->getId())) {
                //        Insert the review
                return $this->reviewDAO->insertReview($review);
            }
        }

        /*
        * TODO : UPDATE USER RATING
        */

        return false;

    }

    /**
     * @param array $reviewArray
     * @return bool|int
     */
    public function editReview(array $reviewArray)
    {
        $review = $this->reviewDAO->reviewObjectBinder($reviewArray);

//        Ensure that linked movie exists
        if ($this->movieService->getMovieByIdBarebone($review->getMovie()->getId())) {
//        Ensure that linked rating exists
            if ($this->ratingService->getRatingById($review->getRating()->getId())) {
//        Insert the review
                return $this->reviewDAO->updateReview($review);
            }
        }


        /*
        * TODO : UPDATE USER RATING
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public function deleteReview(int $id)
    {
        $review = $this->getReviewById($id);

//      Ensure that the targeted review is owned by the user
        /*
        * TODO : Update $_SESSION once SessionHandler is implemented
        */
        if ($_SESSION['uid'] === $review->getUser()->getId()) {
            return $this->reviewDAO->deleteReview($review);
        }


        /*
        * TODO : UPDATE USER RATING
        */
        return false;
    }


}