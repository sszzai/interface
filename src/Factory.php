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
    public static function make($name, array $config=[])
    {
        $key = md5($name);
        if(!isset(self::$instances[$key])){
            self::$instances[$key] = new $name($config);
        }
        return self::$instances[$key];
    }

}
