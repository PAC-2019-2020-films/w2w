<?php

namespace w2w\DAO;

interface ArtistDAO extends GenericDAO
{

    public function findByName(string $name);

}
