<?php
    
    
    namespace w2w\Service;
    
    
    use \w2w\DAO\TagsDAO;
    use \w2w\Model\Tag;
    
    class TagsPublicService extends BaseService
    {
        
        private $tagsDAO;
        
        /**
         * TagsPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->tagsDAO = new TagsDAO();
        }
        
        
        /**
         * getAllTags
         * @return Tag[]
         */
        public function getAllTags()
        {
            return $this->tagsDAO->selectAllTags();
        }
        
        /**
         * getTagById
         * @param int $id
         * @return Tag
         */
        public function getTagById(int $id)
        {
            return $this->tagsDAO->selectTagById($id);
        }
        
        /**
         * getTagByName
         * @param string $name
         * @return Tag
         */
        public function getTagByName(string $name)
        {
            return $this->tagsDAO->selectTagByName($name);
        }
        
        
    }