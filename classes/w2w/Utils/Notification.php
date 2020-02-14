<?php

namespace w2w\Utils;

class Notification
{
    
    protected $errors = [];
    
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function addError(string $message)
    {
        $this->errors[] = $message;
    }
    
}
