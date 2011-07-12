<?php

namespace CarlosFerrari\Mongo;

use \Mongo;
use \MongoGridFs;
use \Exception;

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
    
    /**
        Is there any master?
    */
    private function hasMaster(){
        $hosts = $this->mongo->getHosts();
        foreach ($hosts as $host)
            if ($host['state'] == 1) return true;
        return false;
    }
    
    public function connect(){
        if (!$this->isConnected()){
            $attemps = 0;
            while (!$this->connected && $attemps <= 10){
                $attemps++;
                try{
                    $this->mongo = new Mongo($this->server, $this->options);
                    // we need to connect do the arbiter/server and one of
                    // the hosts must to be a Master server
                    if ($this->mongo && $this->hasMaster()){
                        return $this->connected = true;
                    }
                } catch (Exception $e) { }
                usleep(200000);
            }
            throw new Exception("Database connection failed");
        }
        return $this->connected;
    }
    
    public function getGridFs($collection, $prefix = 'fs'){
        $this->connect();
        return new MongoGridFS($this->mongo->$collection, $prefix);
    }
}
