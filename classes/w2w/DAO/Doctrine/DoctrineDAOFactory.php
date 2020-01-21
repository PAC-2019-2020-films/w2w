<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\DAOFactory;

/**
 *
 */
class DoctrineDAOFactory extends DAOFactory
{

    public function getArtistDAO()
    {    return new DoctrineArtistDAO();
    }

    public function getAuthenticationTokenDAO()
    {    return new DoctrineAuthenticationTokenDAO();
    }

    public function getCategoryDAO()
    {    return new DoctrineCategoryDAO();
    }

    public function getMessageDAO()
    {    return new DoctrineMessageDAO();
    }

    public function getMovieActorDAO()
    {    return new DoctrineMovieActorDAO();
    }

    public function getMovieDAO()
    {    return new DoctrineMovieDAO();
    }

    public function getMovieDirectorDAO()
    {    return new DoctrineMovieDirectorDAO();
    }

    public function getMovieTagDAO()
    {    return new DoctrineMovieTagDAO();
    }

    public function getRatingDAO()
    {    return new DoctrineRatingDAO();
    }

    public function getReportDAO()
    {    return new DoctrineReportDAO();
    }

    public function getReviewDAO()
    {    return new DoctrineReviewDAO();
    }

    public function getRoleDAO()
    {    return new DoctrineRoleDAO();
    }

    public function getTagDAO()
    {    return new DoctrineTagDAO();
    }

    public function getUserDAO()
    {    return new DoctrineUserDAO();
    }
    
}
