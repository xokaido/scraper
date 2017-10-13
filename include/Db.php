<?php

class Db
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * @param string $source
     * @return \PDO
     * @throws Exception
     */
    public static function get($source = 'default')
    {
        if (!isset(self::$instances[ $source ])) {

            $pdo = new \PDO(
                getenv( 'DSN' ),
                getenv( 'DB_USER' ),
                getenv( 'DB_PASS' ),
                [
                    \PDO::ATTR_PERSISTENT => true,
//                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
//                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET session sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'"
                ]
            );
            self::$instances[ $source ] = $pdo;
        }
        return self::$instances[ $source ];
    }
}
