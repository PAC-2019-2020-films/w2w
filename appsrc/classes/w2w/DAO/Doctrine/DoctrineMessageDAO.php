<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\MessageDAO;
use DateTime;

class DoctrineMessageDAO extends DoctrineGenericDAO implements MessageDAO
{

    /**
     * @param string $name
     * @return bool|Message[]
     */
    public function findByName(string $name)
    {
    }
    
    /**
     * @param string $email
     * @return bool|Message[]
     */
    public function findByEmail(string $email)
    {
    }
    
    /**
     * @param string $keyword
     * @return bool|Message[]
     */
    public function selectMessagesByKeyword(string $keyword)
    {
    }
    
    /**
     * @param DateTime $date
     * @return bool|Message[]
     */
    public function findByDate(DateTime $date)
    {
    }
    
    /**
     * @param bool $treated
     * @return bool|Message[]
     */
    public function findByTreated(bool $treated)
    {
    }
    
}
