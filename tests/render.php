<?php

namespace CarlosFerrari\Mongo;

$id = @$_GET['id'];
if (!is_numeric($id)) die('I need a parameter id with the fileId');

require_once 'connect.php';

$file = $grid->pull((int)$id);

header("Content-Type: {$file->file['content_type']}");
echo $file->getBytes();
