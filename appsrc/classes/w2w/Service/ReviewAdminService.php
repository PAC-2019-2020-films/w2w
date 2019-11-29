<?php


namespace w2w\Service;


use w2w\DAO\ReviewDAO;

class ReviewAdminService extends ReviewUserService
{
    
    private $reviewDAO;

    /**
     * ReviewAdminService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->reviewDAO = new ReviewDAO();
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public function deleteReviewAdmin(int $id)
    {
        $review = $this->getReviewById($id);

        /*
        * TODO : CHECK Project requirements || with product owner
            * Admin can delete Anyone's review so we do not check for ownership
            * Should any other constraints be added though?
            * (example : admin can only delete if review has been reported)
        */
        return $this->reviewDAO->deleteReview($review);

        /*
        * TODO : UPDATE USER RATING
        */
    }


}