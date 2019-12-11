<?php

namespace w2w\DAO;

interface ArtistDAO extends GenericDAO
{

    public function findByFirstNameAndLastName(string $firstName, string $lastName);

}
