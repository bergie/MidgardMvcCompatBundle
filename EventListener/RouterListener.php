<?php
namespace Midgard\MvcCompatBundle\EventListener;

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

        //$request->attributes->set('midgardmvc_node', \midgardmvc_core::get_instance()->hierarchy->get_node_by_path($request->getPathInfo()));
    }
}
