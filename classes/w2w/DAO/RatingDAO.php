<?php

namespace w2w\DAO;

use w2w\Model\Rating;

interface RatingDAO extends GenericDAO
{

    /**
     * @param string $name
     * @return bool|Rating
     */
    public function findByName(string $name);

    /**
     * @param int $value
     * @return bool|Rating
     */
    public function findByValue(int $value);

}
