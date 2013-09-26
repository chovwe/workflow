<?php  
// Global Settings
/**
 * Global default timezone settings
 */
date_default_timezone_set('UTC');

// Physical
defined('ROOT')     ? NULL: define('ROOT', 'C:' .DIRECTORY_SEPARATOR. 'wamp' .DIRECTORY_SEPARATOR. 'www' .DIRECTORY_SEPARATOR. 'hdi');
defined('CLASSES')  ? NULL: define('CLASSES', ROOT .DIRECTORY_SEPARATOR. 'calls' .DIRECTORY_SEPARATOR. 'classes');
defined('INCLUDES') ? NULL: define('INCLUDES', ROOT .DIRECTORY_SEPARATOR. 'calls' .DIRECTORY_SEPARATOR. 'includes');
defined('PLUGINS')  ? NULL: define('PLUGINS', ROOT .DIRECTORY_SEPARATOR. 'calls' .DIRECTORY_SEPARATOR. 'plugins' .DIRECTORY_SEPARATOR. 'picture_plugins');
defined('UPLOADS')  ? NULL: define('UPLOADS', ROOT .DIRECTORY_SEPARATOR. 'calls' .DIRECTORY_SEPARATOR. 'uploads');

// Virtual
defined('THUMB_PATH') ? NULL: define('THUMB_PATH', '../calls/uploads/pictures/thumbs/');

function __autoload($class_name)
{//
    $class_name = strtolower($class_name);
    $path = CLASSES .DIRECTORY_SEPARATOR. "{$class_name}.php";
    if(file_exists($path)) {
        require_once($path);
    } else {
        //echo realpath(__DIR__);
        die("The file <b>{$class_name}.php</b> could not be found.");
    }
}
?>