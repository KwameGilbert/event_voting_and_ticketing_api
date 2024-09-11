<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerFactory
{
    private static $logger;

    public static function getLogger($type)
    {
        if (self::$logger === null) {
            // Create a logger instance
            self::$logger = new Logger('event_logger');

            // Add a file handler to log errors
            self::$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/'. $type.'/errors.log', Logger::ERROR));

            // Add a handler for debugging (optional)
            self::$logger->pushHandler(new StreamHandler(__DIR__ .'/../logs/' . $type . '/debug.log', Logger::DEBUG));
        }

        return self::$logger;
    }
}
