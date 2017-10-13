<?php

class Config
{
    private static $data;

    /**
     * @param string $file
     * @throws Exception
     */
    static public function load()
    {
        $dotenv = new Dotenv\Dotenv( dirname( __DIR__ )  );
        $dotenv->load();
    }
}
