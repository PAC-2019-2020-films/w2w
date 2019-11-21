<?php
namespace w2w\Model;

class Role
{

    protected $id;
    protected $name;
    protected $description;
    
    public function __construct($id = null, $name = null, $description =null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function __toString()
    {
        return sprintf("Role#%d (name='%s', description='%s')", 
            $this->id,
            $this->name,
            $this->description
        );
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
}
