<?php


//var_dump(file_get_contents("php://input"));
//$_POST = json_decode(file_get_contents("php://input"), true);
//var_dump($_POST);
//sendJSON($_POST);
//var_dump(file_get_contents("php://input"));
//$products = json_decode($_POST["body"]);

//$imagesLinks = createImageNamesArray($products);

//sendJSON($products);


function getImageNames($product){
    $images = scandir("./products/zalando/");

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

function sendJSON($data){
    header('Content-Type: application/json');
    $json = json_encode($data, JSON_PRETTY_PRINT);
    http_response_code(200);
    echo $json;
}

function getAllFiles(){
    $directory = __DIR__.'/products/original';
    $files = scandir($directory);

    foreach( $files as $filename ){
        echo "$filename<br>";
    }
}

getAllFiles();


phpinfo();