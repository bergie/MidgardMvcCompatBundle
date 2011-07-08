<?php
namespace Midgard\MvcCompatBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

class CoreViewListener
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    private $templating;

    public function __construct($templating)
    {
        $this->templating = $templating;
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

        \midgardmvc_core::get_instance()->templating->template($request);
        $response = new Response(\midgardmvc_core::get_instance()->templating->display($request, true));
        $event->setResponse($response);
    }
}
