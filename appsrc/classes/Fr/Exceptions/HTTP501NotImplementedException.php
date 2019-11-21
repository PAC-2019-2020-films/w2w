<?php
namespace Fr\Exceptions;

class HTTP501NotImplementedException extends HTTPServerErrorException {

    protected $statusCode = 501;
    protected $statusText = 'Not Implemented';

}
