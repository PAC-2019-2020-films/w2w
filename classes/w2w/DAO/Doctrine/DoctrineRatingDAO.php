<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\RatingDAO;
use w2w\Model\Rating;

class DoctrineRatingDAO extends DoctrineGenericDAO implements RatingDAO
{

    public function __construct()
    {
        parent::__construct(Rating::class);
    }

    /**
     * @param string $name
     * @return bool|Rating
     */
    public function findByName(string $name): ?Rating
    {
        return $this->findOneBy("name", $name);
    }

    /**
     * @param int $value
     * @return bool|Rating
     */
    public function findByValue(int $value): ?Rating
    {
        return $this->findOneBy("value", $value);
    }

}
