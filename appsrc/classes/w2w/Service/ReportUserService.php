<?php


namespace w2w\Service;


use \w2w\DAO\ReportDAO;
use \w2w\Model\Report;

use DateTime;
use \w2w\Model\Review;
use \w2w\Model\User;

class ReportUserService extends UserService
{
    private $userService;
    private $reviewService;
    private $reportDAO;

    /**
     * ReportUserService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserPublicService();
        $this->reviewService = new ReviewPublicService();
        $this->reportDAO = new ReportDAO();

    }

    
    
    /**
    * @return bool|Report[]
    */
    public function getAllReports()
    {
        return $this->reportDAO->selectAllReports();
    }

    /**
    * getReportById
    * @param int $id
    * @return bool|Report
    */
    public function getReportById(int $id)
    {
        return $this->reportDAO->selectReportById($id);
    }

    /**
    * getReportsByDate
    * @param DateTime $date
    * @return bool|Report[]
    */
    public function getReportsByDate(DateTime $date)
    {
        return $this->reportDAO->selectReportsByDate($date);
    }
    
    /**
    * getReportsByTreated
    * @param bool $treated
    * @return bool|Report[]
    */
    public function getReportsByTreated(bool $treated)
    {
        return $this->reportDAO->selectReportsByTreated($treated);
    }
    
    /**
    * getReportByUser
    * @param User $user
    * @return bool|Report[]
    */
    public function getReportByUser(User $user)
    {
        return $this->reportDAO->selectReportsByUser($user);
    }
    
    /**
    * getReportByReview
    * @param Review $review
    * @return bool|Report[]
    */
    public function getReportByReview(Review $review)
    {
        return $this->reportDAO->selectReportsByReview($review);
    }
    
    

}