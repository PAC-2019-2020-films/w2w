<?php
namespace Fr\Exceptions;

class HTTP401UnauthorizedException extends HTTPClientErrorException {

    protected $statusCode = 401;
    protected $statusText = 'Unauthorized';

}
