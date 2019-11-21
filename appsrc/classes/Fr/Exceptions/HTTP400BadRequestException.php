<?php
namespace Fr\Exceptions;

class HTTP400BadRequestException extends HTTPClientErrorException {

    protected $statusCode = 400;
    protected $statusText = 'Bad Request';

}
