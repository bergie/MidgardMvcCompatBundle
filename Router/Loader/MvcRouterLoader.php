<?php

namespace Midgard\MvcCompatBundle\Router\Loader;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Yaml\Yaml;

class MvcRouterLoader extends FileLoader
{
    public function supports($resource, $type = null)
    {
        if ($type != 'midgardmvc') {
            return false;
        }

        if (!is_string($resource)) {
            return false;
        }

        if (!file_exists("{$resource}/manifest.yml")) {
            return false;
        }

        return true;
    }

    public function load($file, $type = null)
    {
        $component = basename($file);
        $path = $this->locator->locate("{$file}/manifest.yml");

        $manifest = Yaml::parse($path);

        $collection = new RouteCollection();
        $collection->addResource(new FileResource($path));

        if (!is_array($manifest) || !isset($manifest['routes'])) {
            throw new \InvalidArgumentException(sprintf('The manifest file "%s" must contain routes.', $file));
        }

        foreach ($manifest['routes'] as $routeId => $route)
        {
            // Normalize route pattern to Symfony format
            $route['path'] = str_replace('{$', '{', $route['path']);

            $defaults = array(
                'midgardmvc_component' => $component,
                'midgardmvc_controller' => $route['controller'],
                'midgardmvc_action' => $route['action']
            );
            $reqs = array();
            $options = array();

            $route = new Route($route['path'], $defaults, $reqs, $options);
            $collection->add($routeId, $route);
        }

        return $collection;
    }
}
