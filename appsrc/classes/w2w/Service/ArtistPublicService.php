<?php
    
    
    namespace w2w\Service;
    
    
    use \w2w\Model\Artist;
    
    use \w2w\DAO\ArtistDAO;
    
    class ArtistPublicService extends BaseService
    {
        private $artistDAO;
        
        /**
         * ArtistPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->artistDAO = new ArtistDAO();
            
        }
        
        
        /**
         * getAllArtists
         * @return Artist[]
         */
        public function getAllArtists()
        {
            return $this->artistDAO->selectAllArtists();
        }
        
        /**
         * getArtistById
         * @param int $id
         * @return Artist
         */
        public function getArtistById(int $id)
        {
            return $this->artistDAO->selectArtistById($id);
        }
        
        /**
         * getArtistsByName
         * @param string $name
         * @return Artist[]
         */
        public function getArtistsByName(string $name)
        {
            return $this->artistDAO->selectArtistsByName($name);
        }
        
        /**
         * addArtist
         * @param Artist $artist
         * @return bool
         * TODO : move to Admin service (only here for testing purposes)
         */
        public function addArtist(Artist $artist)
        {
            return $this->artistDAO->insertArtist($artist);
        }
        
        /**
        * editArtist
        * @param Artist $artist
        * @return
        */    
        public function editArtist(Artist $artist)
        {
            /**
            * TODO : addartist
            */
        }
        
        /**
         * removeArtist
         * @param Artist $artist
         * @return bool
         *  TODO : move to Admin service (only here for testing purposes)
         */
        public function removeArtist(Artist $artist)
        {
            return $this->artistDAO->deleteArtist($artist);
        }
        
    }