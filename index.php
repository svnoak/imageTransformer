<?php
session_start();

if( !isset($_SESSION["loggedIn"]) ){
    header( "Location: ./login.php");
}
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./include/css/style.css">
  <script src="./include/js/code.js" defer></script>
</head>
<body>
    <div class="overlay hidden">
        <div id="loading-modal" class="modal">
            <p>Processing <span id="processed">0</span> of <span id="total">0</span></p>
            <div class="loading-bar-outer">
                <div class="loading-bar-inner"></div>
                <div class="hidden">
                    <p id="done-text">Done!</p>
                    <div class="button">Close</div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <form action="" method="post" id="image-creation-form">
            <label for="backgroundColor">Channel Name</label>
            <input type="text" name="channel-name" id="channel-name" required>
            <div>
                <h2>Image settings</h2>
                <h3>
                    Ratio:
                </h3>
                <div>
                    <label for="image-height">Height</label>
                    <input type="text" name="image-height" id="image-height" required>
                </div>
                <div>
                    <label for="image-height">Width</label>
                    <input type="text" name="image-width" id="image-width" required>
                </div>
                <h3>
                    Maximum height / width
                </h3>
                <div>
                    <label for="max-size">Max Height or width</label>
                    <input type="text" name="max-size" id="max-size" required>
                </div>
            </div>
            <label for="background-color">Background color</label>
            <input type="color" name="background-color" id="background-color" required>
            <div>
                <label for="transparent-background-box">Make image background transparent</label>
                <input type="checkbox" name="transparent-background-box" id="transparent-background-box" required>
            </div>
            <div>
                <label for="extensions">Image Format</label>
                <select name="extensions" id="extensions">
                    <option value="png" selected>png</option>
                    <option value="jpg">jpg</option>
                </select>
            </div>
            <label for="singlefiles">Only create specific files</label>
            <textarea name="singlefiles" id="singlefiles" cols="30" rows="10"></textarea>
            <button type="button" id="submit-button">Create new images</button>
        </form>
    </div>
</body>
</html>