<?php

namespace BaseApplication\Route;

use RuntimeException;

/**
 * Class PublicRoutes
 * @package BaseApplication\Route
 */
class PublicRoutes
{
    /**
     * @param $moduleConfigLocation
     * @return array
     */
    public function getPublicRoutes($moduleConfigLocation)
    {
        if (! file_exists($moduleConfigLocation)) {
            throw new RuntimeException('Invalid module config file.');
        }

        $config = require $moduleConfigLocation;
        if (! isset($config['router'])) {
            throw new RuntimeException('Router config is not defined');
        }

        if (! isset($config['router']['routes'])) {
            throw new RuntimeException('Not routes defined');
        }

        $publicRoutes = [];
        $routes = $config['router']['routes'];
        foreach ($routes as $routeName => $routeConfig) {
            if (isset($routeConfig['public']) && $routeConfig['public'] === true) {
                $publicRoutes[] = $routeName;
            }
        }

        return $publicRoutes;
    }
}
