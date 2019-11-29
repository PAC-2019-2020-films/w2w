<?php


namespace w2w\Service;


use w2w\DAO\MovieActorDAO;
use w2w\DAO\MovieDirectorDAO;
use w2w\Model\Artist;

class ArtistAdminService extends ArtistPublicService
{

    private $movieDirectorDAO;
    private $movieActorDAO;

    /**
     * ArtistAdminService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->movieDirectorDAO = new MovieDirectorDAO();
        $this->movieActorDAO = new MovieActorDAO();
    }

    /**
     * addArtist
     * @param Artist $artist
     * @return bool
     */
    public function addArtist(Artist $artist)
    {
        return $this->artistDAO->insertArtist($artist);
    }

    /**
     * editArtist
     * @param Artist $artist
     * @return bool
     */
    public function editArtist(Artist $artist)
    {
        return $this->artistDAO->updateArtist($artist);
    }

    /**
     * removeArtist
     * @param Artist $artist
     * @return bool
     *
     * TODO : Notify user that artist link to movies will be destroyed
     */
    public function removeArtist(Artist $artist)
    {
        if ($this->movieDirectorDAO->isMovieDirectorByArtist($artist)) {
            $this->movieDirectorDAO->deleteMovieDirector($artist);
        }

        if ($this->movieActorDAO->isMovieActorrByArtist($artist)) {
            $this->movieActorDAO->deleteMovieActor($artist);
        }

        return $this->artistDAO->deleteArtist($artist);
    }

}