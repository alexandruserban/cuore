<?php
define('CONSOLE', 1);

include_once 'index.php';

$CORE_ARGS = $argv;
switch($CORE_ARGS[1]) {    
    case 'build_model': 
        CuoreConsole::BuildModel($CORE_ARGS[2], $CORE_ARGS[3]);
    break; 
    case 'build_all_models': 
        CuoreConsole::BuildAllModels($CORE_ARGS[2]);
    break; 
}

?>
