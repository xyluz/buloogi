<?php
//define my class path
define('CLASS_DIR', '../class/');
//add defined path to include path
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
//set the autoload class extension
spl_autoload_extensions('.class.php');
//perfom default autoload without parameters
spl_autoload_register();
