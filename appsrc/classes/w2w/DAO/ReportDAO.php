<?php


namespace w2w\DAO;


use w2w\Model\Report;
use DateTime;
use w2w\Model\Review;
use w2w\Model\User;

class ReportDAO extends BaseDAO
{
    private $table = 'reports';
    private $userDAO;
    private $reviewDAO;

    /**
     * ReportDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
        $this->reviewDAO = new ReviewDAO();
    }
    
    /**
     * @param array $reportArray
     * @return bool|Report
     */
    public function reportObjectBinder(array $reportArray)
    {
        if (isset($reportArray['id']) && isset($reportArray['message']) && isset($reportArray['created_at']) && isset($reportArray['treated']) && isset($reportArray['fk_user_id']) && isset($reportArray['fk_review_id'])) {
            $report = new Report(
                $reportArray['id'],
                $reportArray['message'],
                $reportArray['created_at'],
                $reportArray['treated'],
                $this->userDAO->selectUserById($reportArray['fk_user_id']),
                $this->reviewDAO->selectReviewById($reportArray['fk_review_id'])
            );
            
            return $report;
            
        } else {
            return false;
        }
    }


    /**
     * @return bool|array
     */
    public function selectAllReports()
    {
        $reports = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message,
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;
                ";

        $result = $this->select($sql);

        if (is_array($result)) {
            foreach ($result as $report) {
                array_push($reports, $this->reportObjectBinder($report));
            }
            return $reports;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|Report
     */
    public function selectReportById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.id = :id;
                ";

        $condition = [':id' => $id];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);

        if (is_array($result)) {
            return $this->reportObjectBinder($result[0]);
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param DateTime $date
     * @return bool|Report[]
     */
    public function selectReportsByDate(DateTime $date)
    {
        $reports = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.id = :date
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':date' => $date];
        $dataType = 2;

        $result = $this->select($sql, $condition, $dataType);
    
        if (is_array($result)) {
            foreach ($result as $report) {
                array_push($reports, $this->reportObjectBinder($report));
            }
            return $reports;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param bool $treated
     * @return bool|Report[]
     */
    public function selectReportsByTreated(bool $treated)
    {
        $reports = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.treated = :treated
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':treated' => $treated];
        $dataType = 5;

        $result = $this->select($sql, $condition, $dataType);
    
        if (is_array($result)) {
            foreach ($result as $report) {
                array_push($reports, $this->reportObjectBinder($report));
            }
            return $reports;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param User $user
     * @return bool|Report[]
     */
    public function selectReportsByUser(User $user)
    {
        $reports = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.fk_user_id = :userId
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':userId' => $user->getId()];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);
    
        if (is_array($result)) {
            foreach ($result as $report) {
                array_push($reports, $this->reportObjectBinder($report));
            }
            return $reports;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Review $review
     * @return bool|Report[]
     */
    public function selectReportsByReview(Review $review)
    {
        $reports = [];
        
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.fk_review_id = :reviewId
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':reviewId' => $review->getId()];
        $dataType = 1;

        $result = $this->select($sql, $condition, $dataType);
    
        if (is_array($result)) {
            foreach ($result as $report) {
                array_push($reports, $this->reportObjectBinder($report));
            }
            return $reports;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Report $report
     * @return bool|int
     */
    public function insertReport(Report $report)
    {
        $data = [
            'message' => [$report->getMessage(), 2],
            'created_at' => [$report->getCreatedAt(), 2],
            'treated' => [$report->isTreated(), 5],
            'fk_user_id' => [$report->getUser()->getId(), 1],
            'fk_review_id' => [$report->getReview()->getId(), 1]
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
     * @param Report $report
     * @return bool|int
     */
    public function updateReport(Report $report)
    {
        $data = [
            'message' => [$report->getMessage(), 2],
            'created_at' => [$report->getCreatedAt(), 2],
            'treated' => [$report->isTreated(), 5],
            'fk_user_id' => [$report->getUser()->getId(), 1],
            'fk_review_id' => [$report->getReview()->getId(), 1]
        ];

        $condition = "{$this->table}.id = :id";

        $result = $this->update($this->table, $data, $condition, $report->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Report $report
     * @return bool|int
     */
    public function deleteReport(Report $report)
    {
        $condition = "{$this->table}.id = :id";

        $result = $this->delete($this->table, $condition, $report->getId());

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

}