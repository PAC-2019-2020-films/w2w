<?php

namespace w2w\Service;

use \w2w\Model\Artist;
use \w2w\DAO\ArtistDAO;

class ArtistPublicService extends BaseService
{
    
    /**
     * ArtistPublicService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * getAllArtists
     * @return Artist[]
     */
    public function getAllArtists()
    {
        return $this->getArtistDAO()->findAll();
    }
    
    /**
     * getArtistById
     * @param int $id
     * @return Artist
     */
    public function getArtistById(int $id)
    {
        return $this->getArtistDAO()->find($id);
    }
    
    /**
     * getArtistsByName
     * @param string $name
     * @return Artist[]
     */
    public function getArtistsByName(string $name)
    {
        return $this->getArtistDAO()->findByName($name);
    }
    

    
}
