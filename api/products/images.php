<?php

require_once "../../include/functions.php";

if( $_SERVER["REQUEST_METHOD"] == "GET" ){

    function getImageNames($product){
        $images = scandir("../../products/zalando");

        $res = array_filter($images, function ($image) use ($product) {
            return preg_match("/^$product/", $image);
            //return (preg_grep( "/^$product/g", $image) !== false);
        });

        return $res;
    }

    function createImageNamesArray($products){
        $imageArray = [];
        foreach($products as $product){
            $imageArray[$product] = getImageNames($product);
        }

        return $imageArray;
    }

    function getAllFiles(){
        $directory = '../../products/zalando';
        $allFiles = scandir($directory);
        $files = array_slice($allFiles, 2);

        sendJSON($files);
    }

    getAllFiles();
}

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $data = json_decode(file_get_contents("php://input"), true);

    $images = $data["images"];
    $settings = $data["settings"];
    $channel = $settings["channel"];
    $background = $settings["background"];
    $extension = $settings["extension"];
    $height = $settings["height"];
    $width = $settings["width"];
    $maxSize = $settings["maxSize"];

    $basePath = '../../products/';
    if( ! file_exists($basePath . $channel ) ){
        mkdir( $basePath . $channel );
    }

    $error = [];

    foreach( $images as $image ){
        $result = createImage($image, $channel, $background, $extension, $height, $width, $maxSize);
        if( ! $result ){
            $error[] = $image;
        }
    }

    if ( count($error) > 0 ) {
        sendJSON($error, 200);
    } else{
        sendJSON("All images successfully created");
    }
}
