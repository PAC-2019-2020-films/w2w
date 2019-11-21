<?php
namespace Fr;

class Response {

    public static $statuses = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => "I'm A Teapot",
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded'
    );

    protected $status = 200;
    protected $headers = array();
    protected $body;

    public function __construct($body = null, $status = 200, $headers = array()) {
        $this->body = $body;
        $this->status = $status;
        foreach ($headers as $k => $v) {
            $this->setHeader($k, $v);
        }
    }

    public function __toString() {
        return (string) $this->body;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($value) {
        $this->status = $value;
        return $this;
    }
    
    public function getHeaders() {
        return $this->headers;
    }

    public function getHeader($name) {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    public function setHeader($name, $value, $replace = true) {
        if ($replace) {
            $this->headers[$name] = $value;
        } else {
            $this->headers[] = array($name, $value);
        }
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($value) {
        $this->body = $value;
        return $this;
    }

    public function sendHeaders() {
        $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.1";
        $statusMsg = isset(static::$statuses[$this->status]) ? static::$statuses[$this->status] : null;
        header("{$protocol} {$this->status} {$statusMsg}");
        foreach ($this->headers as $name => $value) {
            if (is_string($name)) {
                header("{$name}: {$value}", true);
            } elseif (is_int($name) && is_array($value) && count($value) >= 2) {
                header("{$value[0]}: {$value[1]}", true);
            }
        }
        return $this;
    }
    
    public function send($sendHeaders = true) {
        if ($sendHeaders) {
            $this->sendHeaders();
        }
        if ($this->body) {
            echo $this->body;
        }
    }
    
    public function profilingExec($startExecTime, $startExecMemUsage) {
        $execTime = microtime(true) - $startExecTime;
        $execMemUsage = memory_get_peak_usage() - $startExecMemUsage;
        $this->setBody(str_replace(
                array('{exec_time}', '{exec_mem_usage}'),
                array(round($execTime, 4), round($execMemUsage / pow(1024, 2), 3)),
                $this->getBody()
        ));
    }
    
    public static function forge($body = null, $status = 200, $headers = array()) {
        $response = new static($body, $status, $headers);
        return $response;
    }

}
