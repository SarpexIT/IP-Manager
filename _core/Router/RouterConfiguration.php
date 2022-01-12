<?php
/**
 * IP-Manager - RouterConfiguration.php
 * Copyright (c) 2022 Sarpex IT Services
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file RouterConfiguration.php
 * @date 12.01.2022 21:09
 *
 * @copyright (c) the author(s)
 * @author Sarpex IT Services <info@sarpex.eu> (2022–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

namespace SarpexIT\IPManager\Router;

class RouterConfiguration
{
    /**
     * @var array $routes Router routes
     */
    private array $routes = [];

    /**
     * Gets all configured routes as array
     * @return array Currently configured routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Overwrites existing routes with routes from array
     * @param array $routes Array including new routes
     */
    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * Adds a route to the Router configuration
     * @param string $route Route to set
     * @param string $resourcePath Path to resource
     * @return bool Returns true if successfully set
     */
    public function addRoute(string $route, string $resourcePath): bool
    {
        if (array_key_exists($route, $this->routes)) {
            return false;
        }
        $this->routes[$route] = $resourcePath;
        return true;
    }

    /**
     * Adds multiple routes to the configuration
     * @param array $routes Array including new routes
     * @return bool Returns true if all routes were successfully set. False if one or more routes failed
     */
    public function addRoutes(array $routes): bool
    {
        if (empty($routes)) return false;
        $rslt = [];
        foreach ($routes as $route => $resourcePath) {
            $rslt[] = $this->addRoute($route, $resourcePath);
        }
        return !in_array(false, $rslt);
    }

    /**
     * Deletes an existing route from Router configuration
     * @param string $route Route to delete
     * @return bool Returns true if successfully deleted
     */
    public function deleteRoute(string $route): bool
    {
        if (!array_key_exists($route, $this->routes)) return false;
        unset($this->routes[$route]);
        return true;
    }

}