<?php
    
    
    namespace w2w\Service;
    
    
    use \w2w\Model\Artist;
    
    use \w2w\DAO\ArtistDAO;
    
    class ArtistPublicService extends BaseService
    {
        protected $artistDAO;
        
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
        

        
    }