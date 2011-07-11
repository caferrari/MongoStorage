<?php

namespace CarlosFerrari\Mongo;

$id = @$_GET['id'];
if (!is_numeric($id)) die('I need a parameter id with the fileId');

require_once '../src/CarlosFerrari/Mongo/LazyConnection.php';
require_once '../src/CarlosFerrari/Mongo/Storage.php';

$host = 'mongodb://arqd11.secom.to.gov.br:27017';
$options = array(); //array('replicaSet' => 'myReplicaSet')

$connection = new LazyConnection($host, $options);
$grid = new Storage($connection, 'testCollection');

$file = $grid->pull((int)$id);

header("Content-Type: {$file->file['content_type']}");
echo $file->getBytes();
