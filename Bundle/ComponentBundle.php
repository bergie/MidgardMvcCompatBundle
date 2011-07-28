<?php
namespace Midgard\MvcCompatBundle\Bundle;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;

class ComponentBundle extends ContainerAware implements BundleInterface
{
    private $name = '';
    private $parent = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function boot()
    {
    }

    public function shutdown()
    {
    }

    public function build(ContainerBuilder $container)
    {
    }

    public function getContainerExtension()
    {
        return null;
    }

    public function getParent()
    {
        // TODO: Get parent component
        return null;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNamespace()
    {
        return '\\';
    }

    public function getPath()
    {
        return $this->container->getParameter('midgard.mvccompat.root') . "/{$this->name}";
    }
}
