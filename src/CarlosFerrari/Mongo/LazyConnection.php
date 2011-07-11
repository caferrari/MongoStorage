<?php

namespace CarlosFerrari\Mongo;

use \Mongo;
use \MongoGridFs;

class LazyConnection
{

    private $connected = false;
    private $server;
    private $options;
    private $mongo;
    
    public function __construct($server, $options = array()){
        $this->server = $server;
        $this->options = $options;
    }
    
    public function isConnected(){
        return $this->connected;
    }
    
    public function connect(){
        if (!$this->isConnected())
            $this->mongo = new Mongo($this->server, $this->options);
        return $this->connected = true;;
    }
    
    public function getGridFs($collection, $prefix = 'fs'){
        $this->connect();
        return new MongoGridFS($this->mongo->$collection, $prefix);
    }
}
