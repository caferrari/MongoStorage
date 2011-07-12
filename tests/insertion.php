<?php

namespace CarlosFerrari\Mongo;

require_once 'connect.php';

for($i=1; $i<=3; $i++){
    $grid->push("library/{$i}.jpg", $i);
}

header('location: view.php');
