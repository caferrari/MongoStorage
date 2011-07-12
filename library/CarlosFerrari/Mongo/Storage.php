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

/**
 * LICENSE
 *
 * Copyright (c) 2009-2011, Carlos André Ferrari
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright notice,
 *       this list of conditions and the following disclaimer in the documentation
 *       and/or other materials provided with the distribution.
 *
 *     * Neither the name of Carlos André Ferrari nor the names of its
 *       contributors may be used to endorse or promote products derived from this
 *       software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
