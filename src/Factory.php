<?php
/**
 * @date 2021/12/17 15:37
 * @copyright 小码科技
 */
namespace Sszzai;

use App\Log\Log;
use Sszzai\Service\Alert;

/**
 * Class Factory.
 *
 * @method Alert
 * @method Log
 */
class Factory
{

    private static $instances = [];

    /**
     * @param string $name
     * @param array  $config
     */
    public static function make($name, array $config)
    {
        if(!isset(self::$instances[$name])){
            $name = ucfirst($name);
            $application = "\\Sszzai\\Service\\{$name}";
            self::$instances[$name] =  new $application($config);
        }
        return self::$instances[$name];
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
