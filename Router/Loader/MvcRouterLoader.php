<?php

namespace Midgard\MvcCompatBundle\Router\Loader;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Yaml\Yaml;

class MvcRouterLoader extends Loader
{
    private $rootDir = '';

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function supports($resource, $type = null)
    {
        if ($type != 'midgardmvc') {
            return false;
        }

        if (!is_string($resource)) {
            return false;
        }

        $path = "{$this->rootDir}/{$resource}/manifest.yml"; 
        if (!file_exists($path)) {
            return false;
        }

        return true;
    }

    public function load($component, $type = null)
    {
        $path = "{$this->rootDir}/{$component}/manifest.yml";

        $manifest = Yaml::parse($path);

        $collection = new RouteCollection();
        $collection->addResource(new FileResource($path));

        if (!is_array($manifest) || !isset($manifest['routes'])) {
            throw new \InvalidArgumentException(sprintf('The manifest file "%s" must contain routes.', $path));
        }

        foreach ($manifest['routes'] as $routeId => $route)
        {
            // Normalize route pattern to Symfony format
            $route['path'] = str_replace('{$', '{', $route['path']);

            if (!isset($route['template_aliases'])) {
                $route['template_aliases'] = array();
            }

            $defaults = array(
                'midgardmvc_component' => $component,
                'midgardmvc_controller' => $route['controller'],
                'midgardmvc_action' => $route['action'],
                'midgardmvc_template_aliases' => $route['template_aliases'],
            );
            $reqs = array();
            $options = array();

            $route = new Route($route['path'], $defaults, $reqs, $options);
            $collection->add($routeId, $route);
        }

        return $collection;
    }
}
