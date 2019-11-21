<?php
namespace Fr\Exceptions;

class HTTP403ForbiddenException extends HTTPClientErrorException {

    protected $statusCode = 403;
    protected $statusText = 'Forbidden';

}
