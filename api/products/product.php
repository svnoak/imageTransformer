<?php
$source = scandir("/customers/0/6/4/akukoworld.com/httpd.www/images/products/zalando");
$reference = scandir("/customers/0/6/4/akukoworld.com/httpd.www/images/products/stadium");

function deleteExtension($val)
{
    return explode(".",$val)[0];
}


$newSource = array_map('deleteExtension', $source);
$neRef = array_map('deleteExtension', $reference);
$diff = array_diff($newSource, $neRef);

$filtered = [];

foreach( $diff as $item ){
    $index = array_search($item, $newSource);
    $filtered[] = $source[$index];
}

foreach( $filtered as $item) {
    echo $item . "<br>";
}