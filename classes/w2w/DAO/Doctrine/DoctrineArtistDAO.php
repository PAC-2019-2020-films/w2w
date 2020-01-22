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

    public function findByFirstNameAndLastName(string $firstName, string $lastName)
    {
        if ($em = $this->getEntityManager()) {
            return $em->getRepository($this->entityClassName)->findOneBy([
                "firstName" => $firstName,
                "lastName" => $lastName,
            ]);
        }
    }

}
