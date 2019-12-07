<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\ArtistDAO;

class DoctrineArtistDAO extends DoctrineGenericDAO implements ArtistDAO
{

    public function findByName(string $name)
    {
        return $this->findBy($name, "name");
    }

}
