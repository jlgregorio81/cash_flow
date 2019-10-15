<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//nome do arquivo: autoload.php

define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);

function myAutoload($className) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $file = ROOT_PATH . $path . '.php';
    if (is_file($file)) {
        require_once($file);
    }
}

spl_autoload_register('myAutoload');


