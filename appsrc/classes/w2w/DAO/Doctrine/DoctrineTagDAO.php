<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\TagDAO;
use w2w\Model\Tag;

class DoctrineTagDAO extends DoctrineGenericDAO implements TagDAO
{

    public function __construct()
    {
        parent::__construct(Tag::class);
    }

    /**
     * @param string $name
     * @return bool|Tag
     */
    public function findByName(string $name) : ?Tag
    {
        return $this->findOneBy("name", $name);
    }

}
