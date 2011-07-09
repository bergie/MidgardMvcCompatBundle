<?php
namespace Midgard\MvcCompatBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Midgard\MvcCompatBundle\DependencyInjection\ControllerResolverPass;

class MidgardMvcCompatBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ControllerResolverPass());
    }
}
