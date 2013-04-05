<?php

use Locomotive\Tools;

define('LOCOMOTIVE_PATH', dirname(__FILE__) . '/');
define('LOCOMOTIVE_CORE_PATH', LOCOMOTIVE_PATH . 'core/');

require LOCOMOTIVE_CORE_PATH . 'exceptions.php';

//use Locomotive\Tools;
// Importing interfaces
require LOCOMOTIVE_CORE_PATH . 'web_interface.php';
define('LOCOMOTIVE_INTERFACES_PATH', LOCOMOTIVE_CORE_PATH . 'interfaces/');
foreach (glob(LOCOMOTIVE_INTERFACES_PATH . '*.php') as $filename) {
    require $filename;
}

// Importing tools
require LOCOMOTIVE_CORE_PATH . 'tool.php';
define('LOCOMOTIVE_TOOLS_PATH', LOCOMOTIVE_CORE_PATH . 'tools/');
foreach (glob(LOCOMOTIVE_TOOLS_PATH . '*.php') as $filename) {
    require $filename;
}

/**
 * Main class of Steam Locomotive library
 */
class Locomotive
{

    /**
     * @param string $api_key Steam API key from http://steamcommunity.com/dev/apikey/
     */
    function __construct($api_key)
    {
        $GLOBALS['api_key'] = $api_key;

        // Defining interfaces
        foreach (glob(LOCOMOTIVE_INTERFACES_PATH . '*.php') as $filename) {
            $filename = str_replace(LOCOMOTIVE_INTERFACES_PATH, '', $filename);
            $interface_name = substr($filename, 0, -4);
            $class = '\\Locomotive\\WebInterfaces\\' . $interface_name;
            $this->$interface_name = new $class();
        }

        $this->tools = new LocomotiveTools();
    }

}

class LocomotiveTools
{

    public function __construct()
    {
        // Defining tools
        foreach (glob(LOCOMOTIVE_TOOLS_PATH . '*.php') as $filename) {
            $filename = str_replace(LOCOMOTIVE_TOOLS_PATH, '', $filename);
            $tool_name = substr($filename, 0, -4);
            $class = '\\Locomotive\\Tools\\' . $tool_name;
            $this->$tool_name = new $class();
        }
    }

}