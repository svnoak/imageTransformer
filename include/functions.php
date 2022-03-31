<?php
function sendJSON($message, $statusCode = "200") {
    //is used whenever something is successful 
    // or goes wrong. exits the code

    header("Content-Type: application/json");
    http_response_code($statusCode);
    $jsonMessage = json_encode($message);

    echo($jsonMessage);
}

function createImage($targetfile, $targetdir, $bgColor, $extension, $height, $width, $maxSize){

    # grab the remote image url
    $basePath = '/customers/0/6/4/akukoworld.com/httpd.www/images/products/';
    $sourcePath = 'original/';
    $url = $basePath . $sourcePath . $targetfile;
    //$imgUlr = "file:///home/kim/Documents/Programming/php_snippets/image.jpg";
    # create new ImageMagick object
    $im = new Imagick($url);
    
    # remove extra white space
    //$im->clipImage(false);
    
    $pixel = $im->getImagePixelColor(1,1);
    $reference = $im->getImagePixelColor(10,1);

     if( $pixel == $reference ){
        $tmpColor = "rgb(255,0,255)";

        # convert white background to transparent
        $im->floodFillPaintImage($tmpColor, 3000, $pixel, 0 , 0, false);
        $im->transparentPaintImage($tmpColor, 0, 10, false);
    }
   
    $im->trimImage(0);

    $imageWidth = intval($maxSize);
    $imageHeight = intval($maxSize) / intval($width) * intval($height);

    $im->scaleImage($imageHeight, $imageWidth, true);


    $output = new Imagick();
    $output->newImage($imageWidth, $imageHeight, $bgColor);
    $output->compositeImage($im, Imagick::COMPOSITE_DEFAULT, (((($output->getImageWidth()) - ($im->getImageWidth())))/2), (((($output->getImageHeight()) - ($im->getImageHeight())))/2));
    

    $exploded = explode(".", $targetfile);
    $targetfile = $exploded[0];
    
    # set resulting image format as png
    $output->setImageFormat($extension);
    
    # set header type as PNG image
    //header('Content-Type: image/png');
    
    # output the new image
    //echo $output->getImageBlob();

    $result = $output->writeImage($basePath . $targetdir . "/" . $targetfile . "." . $extension);
    if( $result ){
        return true;
    } else{
        return $targetfile;
    }
}
