<?php
namespace Fr\Exceptions;

class HTTP500InternalServerErrorException extends HTTPServerErrorException {

    protected $statusCode = 500;
    protected $statusText = 'Internal Server Error';

}
