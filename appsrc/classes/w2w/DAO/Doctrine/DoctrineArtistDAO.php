<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\ArtistDAO;
use w2w\Model\Artist;

class DoctrineArtistDAO extends DoctrineGenericDAO implements ArtistDAO
{

    public function __construct()
    {
        parent::__construct(Artist::class);
    }

    public function findByName(string $name)
    {
        return $this->findBy($name, "name");
    }

}
