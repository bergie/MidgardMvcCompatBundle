<?php
namespace Midgard\MvcCompatBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

require __DIR__.'/../Compat/midgardmvc_core_request.php';

class ControllerResolver implements ControllerResolverInterface
{
    private $parent;

    public function __construct(ControllerResolverInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getController(Request $request)
    {
        if (!$request->attributes->has('midgardmvc_node')) {
            // Not a Midgard MVC request, pass to parent
            return $this->parent->getController($request);
        }

        $controller_parts = explode('::', $request->attributes->get('_controller'));
        // TODO: Copy safety checks from original ControllerResolver

        $controller_class = $controller_parts[0];

        // Decorate request
        $requestCompat = new \midgardmvc_core_request($request);

        $controller = new $controller_class($requestCompat);
        $controller->data = array();

        $request->attributes->set('midgardmvc_compat_controller', $controller);

        return array($controller, $controller_parts[1]);
    }

    public function getArguments(Request $request, $controller)
    {
        if (!$request->attributes->has('midgardmvc_node')) {
            // Not a Midgard MVC request, pass to parent
            return $this->parent->getArguments($request, $controller);
        }

        return array(
            $request->attributes->all()
        );
    }
}
