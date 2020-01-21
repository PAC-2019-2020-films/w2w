<?php

namespace w2w\DAO;

use w2w\Model\Tag;

interface TagDAO extends GenericDAO
{

    /**
     * @param string $name
     * @return bool|Tag
     */
    public function findByName(string $name);

}
