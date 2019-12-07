<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\TagDAO;
use w2w\Model\Tag;

class DoctrineTagDAO extends DoctrineGenericDAO implements TagDAO
{

    /**
     * @param string $name
     * @return bool|Tag
     */
    public function findByName(string $name)
    {
    }

}
