<?php

namespace w2w\DAO;

use w2w\Model\Report;
use DateTime;
use w2w\Model\Review;
use w2w\Model\User;

interface ReportDAO extends GenericDAO
{

    /**
     * @param DateTime $date
     * @return bool|Report[]
     */
    public function findByDate(DateTime $date);

    /**
     * @param bool $treated
     * @return bool|Report[]
     */
    public function findByTreated(bool $treated);

    /**
     * @param User $user
     * @return bool|Report[]
     */
    public function findByUser(User $user);

    /**
     * @param Review $review
     * @return bool|Report[]
     */
    public function findByReview(Review $review);

}
