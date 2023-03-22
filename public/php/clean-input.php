<?php
function trimAndClean($dataString){
    $dataString = trim($dataString);
    $dataString = htmlspecialchars($dataString);
    return $dataString;
}