<?php

namespace w2w\DAO\PDO;

use w2w\DAO\DAOFactory;

/**
 *
 */
class PDODAOFactory extends DAOFactory
{

    public function getArtistDAO()
    {
        return new PDOArtistDAO();
    }

    public function getAuthenticationTokenDAO()
    {
        return new AuthenticationTokenDAO();
    }

    public function getCategoryDAO()
    {
        return new CategoryDAO();
    }

    public function getMessageDAO()
    {
        return new MessageDAO();
    }

    public function getMovieActorDAO()
    {
        return new MovieActorDAO();
    }

    public function getMovieDAO()
    {
        return new MovieDAO();
    }

    public function getMovieDirectorDAO()
    {
        return new MovieDirectorDAO();
    }

    public function getMovieTagDAO()
    {
        return new MovieTagDAO();
    }

    public function getRatingDAO()
    {
        return new RatingDAO();
    }

    public function getReportDAO()
    {
        return new ReportDAO();
    }

    public function getReviewDAO()
    {
        return new ReviewDAO();
    }

    public function getRoleDAO()
    {
        return new PDORoleDAO();
    }

    public function getTagDAO()
    {
        return new TagDAO();
    }

    public function getUserDAO()
    {
        return new PDOUserDAO();
    }
    
}
