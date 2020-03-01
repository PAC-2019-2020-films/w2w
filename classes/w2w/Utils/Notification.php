<?php

namespace w2w\Utils;

class Notification
{
    
    protected $errors = [];
    protected $warnings = [];
    
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
    
    public function hasWarnings()
    {
        return count($this->warnings) > 0;
    }
    
    public function getWarnings()
    {
        return $this->warnings;
    }
    
    public function addWarning(string $message)
    {
        $this->warnings[] = $message;
    }
    
}
