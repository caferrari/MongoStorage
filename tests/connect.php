<?php

namespace CarlosFerrari\Mongo;

require_once '../library/CarlosFerrari/Mongo/LazyConnection.php';
require_once '../library/CarlosFerrari/Mongo/Storage.php';

$host = 'mongodb://127.0.0.1'; // My replicaSet Arbiter
$options = array('replicaSet' => 'arquivo');

$connection = new LazyConnection($host, $options);
$grid = new Storage($connection, 'testCollection');
