<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:26
     */
    
    namespace w2w\Service;
    
    
    use w2w\DAO\ArtistDAO;
    use w2w\DAO\CategoryDAO;
    use w2w\DAO\MessageDAO;
    use w2w\DAO\MovieDAO;
    use w2w\DAO\RatingDAO;
    use w2w\DAO\ReviewDAO;
    use w2w\DAO\RoleDAO;
    use w2w\DAO\TagsDAO;
    use w2w\DAO\UserDAO;
    use w2w\Model\Review;

    class BaseService
    {
    
        /**
         * BaseService constructor.
         */
        public function __construct()
        {
        }
    }