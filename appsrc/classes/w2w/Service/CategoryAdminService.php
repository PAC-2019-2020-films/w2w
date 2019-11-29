<?php
    
    
    namespace w2w\Service;
    
    use w2w\Model\Artist;
    use w2w\Model\Category;
    
    class CategoryAdminService extends CategoryPublicService
    {
    
        /**
         * CategoryAdminService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
        * addCategory
        * @param Category $category
        * @return bool
        */
        public function addCategory(Category $category)
        {
            return $this->categoryDAO->insertCategory($category);
        }
        
        /**
        * updateCategory
        * @param Category $category
        * @return bool
        */
        public function updateCategory(Category $category)
        {
            return $this->categoryDAO->updateCategory($category);
        }
        
        /**
        * deleteCategory
        * @param Category $category
        * @return bool
        */
        public function deleteCategory(Category $category)
        {
            return $this->categoryDAO->deleteCategory($category);
        }
        
    }