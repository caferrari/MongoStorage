<?php

namespace CarlosFerrari\Mongo;

require_once '../library/CarlosFerrari/Mongo/LazyConnection.php';
require_once '../library/CarlosFerrari/Mongo/Storage.php';

$host = 'mongodb://arbiter, serverA, serverB'; // My replicaSet members
$options = array('replicaSet' => 'arquivo');

$connection = new LazyConnection($host, $options);
$grid = new Storage($connection, 'testCollection');
