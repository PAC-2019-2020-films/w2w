<?php

namespace w2w\DAO;

/**
 * DAO = class responsible for CRUD on an entity
 * 
 * DAO definition :
 * « The DAO design pattern originated in Sun's Java Blueprints. [..] 
 * A DAO defines an interface to persistence operations (CRUD and finder methods)
 * relating to a particular persistence entity ; it advises you 
 * to group together code that relates to persistence of that entity. » 
 * (Bauer C. & King G., Java Persistence with Hibernate, Manning, 2007, p. 709.)
 *
 */
interface GenericDAO
{

    public function find($key);

    public function findAll();

    public function save($object);
    
    public function update($object);

    public function delete($object);
    
}
