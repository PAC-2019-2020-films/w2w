<?php
namespace Fr\Exceptions;

class HTTP404NotFoundException extends HTTPClientErrorException {

    protected $statusCode = 404;
    protected $statusText = 'Not Found';

}
