<?php

function autoloadClass($class){
    $class = str_replace('\\','/',$class);
    if(is_file(NCS_APP_CORE.'class/' . $class . '.class.php')){
        include NCS_APP_CORE.'class/' . $class . '.class.php';
    }
    if(is_file(NCS_APP_CORE.'class/' . $class . '.php')){
        include NCS_APP_CORE.'class/' . $class . '.php';
    }

}
function autoloadLibs($class){
    $class = str_replace('\\','/',$class);
    if(is_file(NCS_APP_LIBS . $class . '.class.php')){
        include NCS_APP_LIBS . $class . '.class.php';
        echo NCS_APP_LIBS . $class . '.class.php';
    }
    if(is_file(NCS_APP_LIBS . $class . '.php')){
        include NCS_APP_LIBS . $class . '.php';
    }

}

spl_autoload_register('autoloadClass',false);
spl_autoload_register('autoloadLibs',false);
