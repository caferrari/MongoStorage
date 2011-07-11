<?php

namespace CarlosFerrari\Mongo;

require_once '../src/CarlosFerrari/Mongo/LazyConnection.php';
require_once '../src/CarlosFerrari/Mongo/Storage.php';

$host = 'mongodb://arqd11.secom.to.gov.br:27017';
$options = array(); //array('replicaSet' => 'myReplicaSet')

$connection = new LazyConnection($host, $options);
$grid = new Storage($connection, 'testCollection');

for($i=1; $i<=3; $i++){
    $grid->push("library/{$i}.jpg", $i);
}

header('location: view.php');
