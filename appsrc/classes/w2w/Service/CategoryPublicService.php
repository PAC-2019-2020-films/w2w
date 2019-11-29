<?php
    
    
    namespace w2w\Service;
    
    
    use w2w\DAO\CategoryDAO;
    use \w2w\Model\Category;
    
    class CategoryPublicService extends PublicService
    {
        protected $categoryDAO;
        /**
         * CategoryPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->categoryDAO = new CategoryDAO();
        }
        
        /**
         * getAllCategories
         * @return Category[]
         */
        public function getAllCategories()
        {
            return $this->categoryDAO->selectAllCategories();
        }
        
        /**
         * @param int $id
         * @return Category
         */
        public function getCategoryById(int $id)
        {
            return $this->categoryDAO->selectCategoryById($id);
        }
        
        /**
        * getCategoryByName
        * @param string $name
        * @return bool|Category
        */
        public function getCategoryByName(string $name)
        {
            return $this->categoryDAO->selectCategoryByName($name);
        }
    }