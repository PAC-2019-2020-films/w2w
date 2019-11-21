<?php
namespace Fr\Exceptions;

abstract class HTTPErrorException extends Exception {
    
    protected $statusCode;
    protected $statusText;
    
    public function getStatusCode() 
    {
        return $this->statusCode;
    }

    public function getStatusText() 
    {
        return $this->statusCode;
    }

}
