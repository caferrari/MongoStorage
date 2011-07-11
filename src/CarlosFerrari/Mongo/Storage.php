<?php

namespace CarlosFerrari\Mongo;

use \RuntimeException;

class Storage 
{
    private $connection;
    private $collection;
    private $prefix;

    public function __construct(LazyConnection $connection, $collection, $prefix = 'fs'){
        $this->connection = $connection;
        $this->collection = $collection;
        $this->prefix = $prefix;
    }

    private function gridFs(){
        return $this->connection->getGridFs($this->collection, $this->prefix);
    }

    public function remove($id){
        return $this->gridFs()->remove(array('_id' => $id), array('safe' => 1));
    }

    public function push($fileName, $id, $options = array(), $safe = 1){
        if (!file_exists($fileName)) throw new RuntimeException("file '$fileName' not found");
        $this->remove($id);
        $options['content_type'] = mime_content_type($fileName);
        $options['_id'] = $id;
        $options['filename'] = null;
        $this->gridFs()->storeFile($fileName, $options, $safe);
    }
    
    public function pull($id){
        return $this->gridFs()->findOne(array('_id' => $id));
    }
}
