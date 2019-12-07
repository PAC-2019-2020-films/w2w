<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\RatingDAO;
use w2w\Model\Rating;

class DoctrineRatingDAO extends DoctrineGenericDAO implements RatingDAO
{

    /**
     * @param string $name
     * @return bool|Rating
     */
    public function findByName(string $name)
    {
    }

    /**
     * @param int $value
     * @return bool|Rating
     */
    public function findByValue(int $value)
    {
    }

}
