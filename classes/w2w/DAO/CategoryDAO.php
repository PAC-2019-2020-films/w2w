<?php

namespace w2w\DAO;

use w2w\Model\Category;

interface CategoryDAO extends GenericDAO
{

    public function findByName(string $name);

}
