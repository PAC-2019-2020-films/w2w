<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\CategoryDAO;
use w2w\Model\Category;

class DoctrineCategoryDAO extends DoctrineGenericDAO implements CategoryDAO
{

    public function __construct()
    {
        parent::__construct(Category::class);
    }

    public function findByName(string $name): ?Category
    {
        return $this->findOneBy("name", $name);
    }

}
