<?php

namespace CarlosFerrari\Mongo;
require_once 'connect.php';
for ($x=1; $x<=3; $x++){
    $file = $grid->pull((int)$x);
    if (!$file) continue;
    echo "<img src='render.php?id={$x}' width='300' /> ";
}
