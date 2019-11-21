<?php

namespace Fr\Log;

use \Psr\Log\LoggerInterface;
use \Psr\Log\LogLevel;

class Logger implements \Psr\Log\LoggerInterface
{
	
	const EMERGENCY_VALUE = 8;
    const ALERT_VALUE     = 7;
    const CRITICAL_VALUE  = 6;
    const ERROR_VALUE     = 5;
    const WARNING_VALUE   = 4;
    const NOTICE_VALUE    = 3;
    const INFO_VALUE      = 2;
    const DEBUG_VALUE     = 1;

	protected $level = 2;
	
	protected static $logger;


	public static function getInstance()
	{
		if (! self::$logger) {
			self::$logger = new static();
		}
		return self::$logger;
	}
	
	public function __construct() 
	{
	}
	
	public function setLogLevel($level)
	{
		if (is_int($level)) {
			$this->level = $level;
		} elseif (is_string($level)) {
			$this->level = $this->string2integer($level);
		}
		return $this;
	}
	
	public function getLogLevel()
	{
		return $this->level;
	}
	
	public function string2integer($level)
	{
		switch ($level) {
			case LogLevel::EMERGENCY: return self::EMERGENCY_VALUE;
			case LogLevel::ALERT: return self::ALERT_VALUE;
			case LogLevel::CRITICAL: return self::CRITICAL_VALUE;
			case LogLevel::ERROR: return self::ERROR_VALUE;
			case LogLevel::WARNING: return self::WARNING_VALUE;
			case LogLevel::NOTICE: return self::NOTICE_VALUE;
			case LogLevel::INFO: return self::INFO_VALUE;
			case LogLevel::DEBUG: return self::DEBUG_VALUE;
			default: return false;
		}
	}
	
	
	
	
	
    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function emergency($message, array $context = array())
    {
		$this->log(LogLevel::EMERGENCY, $message, $context);
	}

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = array())
    {
		$this->log(LogLevel::ALERT, $message, $context);
	}
    

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = array())
    {
		$this->log(LogLevel::CRITICAL, $message, $context);
	}

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = array())
    {
		$this->log(LogLevel::ERROR, $message, $context);
	}

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = array())
    {
		$this->log(LogLevel::WARNING, $message, $context);
	}

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = array())
    {
		$this->log(LogLevel::NOTICE, $message, $context);
	}

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = array())
    {
		$this->log(LogLevel::INFO, $message, $context);
	}

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = array())
    {
		$this->log(LogLevel::DEBUG, $message, $context);
	}

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
		//echo sprintf("level=%d, min=%d", $this->string2integer($level), $this->level);
		if ($this->string2integer($level) >= $this->level) {
			echo sprintf("<%s-%s> %s\n", date("H:i:s"), strtoupper($level), $message);
		}
	}
	
}
