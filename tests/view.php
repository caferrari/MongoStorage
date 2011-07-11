<?php

namespace CarlosFerrari\Mongo;

require_once '../src/CarlosFerrari/Mongo/LazyConnection.php';
require_once '../src/CarlosFerrari/Mongo/Storage.php';

$host = 'mongodb://arqd11.secom.to.gov.br:27017';
$options = array(); //array('replicaSet' => 'myReplicaSet')

$connection = new LazyConnection($host, $options);
$grid = new Storage($connection, 'testCollection');

for ($x=1; $x<=3; $x++){
    $file = $grid->pull((int)$x);
    if (!$file) continue;
    echo "<img src='render.php?id={$x}' width='300' /> ";
}
