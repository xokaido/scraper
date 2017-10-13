<?php

class Logger
{
    /**
     * @var array
     */
    protected static $instance = [];
    private static $log_dir = 'logs';

    /**
     * @param string $name
     * @return \Monolog\Logger
     * @throws Exception
     */
    static public function get($name = 'main')
    {
        $log_dir = ( getenv( 'LOG_DIR' ) ? getenv( 'LOG_DIR' ) : self::$log_dir );
        if (!isset( self::$instance[ $name ] ) ) {
            self::$instance[ $name ] = new \Monolog\Logger( $name, [
                new \Monolog\Handler\StreamHandler( $log_dir .'/' . $name . '.log')
            ]);
        }
        return self::$instance[ $name ];
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function debug($message, array $context = [])
    {
        self::get()->addDebug($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function info($message, array $context = [])
    {
        self::get()->addInfo($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function notice($message, array $context = [])
    {
        self::get()->addNotice($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function warning($message, array $context = [])
    {
        self::get()->addWarning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function error($message, array $context = [])
    {
        self::get()->addError($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function critical($message, array $context = [])
    {
        self::get()->addCritical($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function alert($message, array $context = [])
    {
        self::get()->addAlert($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public static function emergency($message, array $context = [])
    {
        self::get()->addEmergency($message, $context);
    }
}
