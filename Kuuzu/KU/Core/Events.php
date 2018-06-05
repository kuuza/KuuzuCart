<?php
/**
 * Kuuzu Cart
 *
 * @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
 */

namespace Kuuzu\KU\Core;

use Kuuzu\KU\Core\{
    DirectoryListing,
    KUUZU
};

class Events
{
    protected static $data = [];

    public static function getWatches(string $event = null): array
    {
        if (isset($event)) {
            if (isset(static::$data[$event])) {
                return static::$data[$event];
            }

            return [];
        }

        return static::$data;
    }

    public static function watch(string $event, $function)
    {
        static::$data[$event][] = $function;
    }

    public static function fire(string $event, ...$params)
    {
        if (isset(static::$data[$event])) {
            foreach (static::$data[$event] as $f) {
                call_user_func($f, ...$params);
            }
        }
    }

    public static function scan()
    {
        $paths = [
            'Core',
            'Custom'
        ];

        $site = KUUZU::getSite();

        foreach ($paths as $path) {
            if (file_exists(KUUZU::BASE_DIRECTORY . $path . '/Site/' . $site . '/Module/Event')) {
                $modules = new DirectoryListing(KUUZU::BASE_DIRECTORY . $path . '/Site/' . $site . '/Module/Event');
                $modules->setIncludeFiles(false);

                foreach ($modules->getFiles() as $module) {
                    $files = new DirectoryListing($modules->getDirectory() . '/' . $module['name']);
                    $files->setIncludeDirectories(false);
                    $files->setCheckExtension('php');

                    foreach ($files->getFiles() as $file) {
                        if (($path == 'Custom') && file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/' . $site . '/Module/Event/' . $module['name'] . '/' . $file['name'])) {
                            // custom module already loaded through autoloader
                            continue;
                        }

                        $class = 'Kuuzu\\KU\\Core\\Site\\' . $site . '\\Module\\Event\\' . $module['name'] . '\\' . substr($file['name'], 0, strrpos($file['name'], '.'));

                        if (is_subclass_of($class, 'Kuuzu\\KU\\Core\\Module\\EventAbstract')) {
                            $e = new $class();

                            foreach ($e->getWatches() as $event => $fire) {
                                foreach ($fire as $f) {
                                    static::watch($event, $f);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
