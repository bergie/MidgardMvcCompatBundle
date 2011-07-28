<?php
namespace Midgard\MvcCompatBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

require __DIR__.'/../Compat/midgardmvc_core_request.php';
require __DIR__.'/../Compat/midgardmvc_core.php';

class ControllerResolver implements ControllerResolverInterface
{
    private $parent;

    public function __construct(ControllerResolverInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getController(Request $request)
    {
        if (!$request->attributes->has('midgardmvc_component')) {
            // Not a Midgard MVC request, pass to parent
            return $this->parent->getController($request);
        }

        $controller_class = $request->attributes->get('midgardmvc_controller');

        // Decorate request
        $requestCompat = new \midgardmvc_core_request($request);

        $controller = new $controller_class($requestCompat);
        $controller->data = array();

        // Pass the controller instance to request so our view listener
        // can get it
        $request->attributes->set('midgardmvc_compat_controller', $controller);

        return array($controller, strtolower($request->getMethod()) . '_' . $request->attributes->get('midgardmvc_action'));
    }

    public function getArguments(Request $request, $controller)
    {
        if (!$request->attributes->has('midgardmvc_component')) {
            // Not a Midgard MVC request, pass to parent
            return $this->parent->getArguments($request, $controller);
        }

        return array(
            $request->attributes->all()
        );
    }
}
