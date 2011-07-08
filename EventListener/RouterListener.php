<?php
namespace ...

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RouterListener
{
    public function onCoreRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
            return;
        }

        $request->attributes->set('midgardmvc_subrequest', HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType());

        $request->attributes->set('midgardmvc_node', \midgardmvc_core::get_instance()->hierarchy->get_node_by_path($request->getPathInfo()));

        // TODO: We need Midgard-compatible request object to do this
        $routes = \midgardmvc_core::get_instance()->component->get_routes($request);
        $argv_str = preg_replace('%/{2,}%', '/', '/' . implode('/', $reques
t->get_arguments()) . '/');

        $query = $request->query->all();
        foreach ($routes as $route)
        {
            $matches = $route->check_match($argv_str, $query);
            if (!is_null($matches))
            {
                $matched_routes[$route->id] = $matches;
            }
        }

        if (!$matched_routes)
        {
            return;
        }

        $matched_routes = array_reverse($matched_routes);
        foreach ($matched_routes as $route_id => $arguments) {
            $request->attributes->set('_controller', "\{$routes[$route_id]->controller}::{$request->getMethod()}_{$route->action}");
            $request->attributes->set('_route', $routes[$route_id]);
            // NOTE: For now we only execute first matching route
            break;
        }
    }
}
