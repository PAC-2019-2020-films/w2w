<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\CategoryDAO;
use w2w\Model\Category;
use w2w\Model\Movie;
use w2w\Utils\Utils;

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

    public function getAllCategories($currentPage = 1, $limit = 5)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()->select('c')->from(Category::class, 'c')->orderBy('c.name', 'ASC');
        $query = $qb->getQuery();

        $paginator = Utils::paginate($query, $currentPage, $limit);

        return $paginator;
    }



}
