<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Redis extends BaseConfig
{
    public $host;
    public $port;
    public $password;
    public $database; 

    public function __construct()
    {
        parent::__construct();
        
        /* 
        $this->host     = env('redis.default.hostname');
        $this->port     = env('redis.default.port');
        $this->password = env('redis.default.password');
        $this->database = env('redis.default.database');
        */

        $this->host     = '127.0.0.1';
        $this->port     = 6379;
        $this->password = null;
        $this->database = 0;
    }
}
