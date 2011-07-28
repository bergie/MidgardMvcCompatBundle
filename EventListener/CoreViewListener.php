<?php
namespace Midgard\MvcCompatBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

class CoreViewListener
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function filterResponse(GetResponseForControllerResultEvent $event)
    {
        if ($event->hasResponse()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->attributes->has('midgardmvc_compat_controller')) {
            return;
        }

        $controller = $request->attributes->get('midgardmvc_compat_controller');

        $viewName = sprintf('%s:%s:%s.%s.%s',
            $request->attributes->get('midgardmvc_component'),
            $request->attributes->get('midgardmvc_controller'),
            'content',
            'html',
            'midgardmvc'
        );

        $vars = array();
        $vars['current_component'] = $controller->data;
        $vars[$request->attributes->get('midgardmvc_component')] = $controller->data;
        $vars['request'] = $controller->request;

        $content = $this->container->get('templating')->render($viewName, $vars);
        $response = new Response($content);

        $event->setResponse($response);
    }
}
