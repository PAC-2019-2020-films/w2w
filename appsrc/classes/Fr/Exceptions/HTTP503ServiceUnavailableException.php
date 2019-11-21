<?php
namespace Fr\Exceptions;

class HTTP503ServiceUnavailableException extends HTTPServerErrorException {

    protected $statusCode = 503;
    protected $statusText = 'Service Unavailable';

}
