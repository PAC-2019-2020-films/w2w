<?php

namespace w2w\DAO;

use \DateTime;

interface MessageDAO extends GenericDAO
{

    /**
     * @param string $name
     * @return bool|Message[]
     */
    public function findByName(string $name);
    
    /**
     * @param string $email
     * @return bool|Message[]
     */
    public function findByEmail(string $email);
    
    /**
     * @param string $keyword
     * @return bool|Message[]
     */
    public function selectMessagesByKeyword(string $keyword);
    
    /**
     * @param DateTime $date
     * @return bool|Message[]
     */
    public function findByDate(DateTime $date);
    
    /**
     * @param bool $treated
     * @return bool|Message[]
     */
    public function findByTreated(bool $treated);
    
}
