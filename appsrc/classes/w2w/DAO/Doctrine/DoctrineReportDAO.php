<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\ReportDAO;
use w2w\Model\Report;
use DateTime;
use w2w\Model\Review;
use w2w\Model\User;

class DoctrineReportDAO extends DoctrineGenericDAO implements ReportDAO
{

    /**
     * @param DateTime $date
     * @return bool|Report[]
     */
    public function findByDate(DateTime $date)
    {
    }

    /**
     * @param bool $treated
     * @return bool|Report[]
     */
    public function findByTreated(bool $treated)
    {
    }

    /**
     * @param User $user
     * @return bool|Report[]
     */
    public function findByUser(User $user)
    {
    }

    /**
     * @param Review $review
     * @return bool|Report[]
     */
    public function findByReview(Review $review)
    {
    }

}
