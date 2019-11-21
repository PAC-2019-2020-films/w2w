<?php
namespace Fr\Exceptions;

class HTTP410GoneException extends HTTPClientErrorException {

    protected $statusCode = 410;
    protected $statusText = 'Gone';

}
