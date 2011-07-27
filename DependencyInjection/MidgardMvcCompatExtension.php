<?php
namespace Midgard\MvcCompatBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Resource\FileResource;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class MidgardMvcCompatExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('compat.xml');

        $rootDir = realpath($configs[0]['root']);
        if (!is_dir($rootDir)) {
            throw new \InvalidArgumentException(sprintf('Midgard MVC component directory "%s" not found, check your configuration.', $rootDir));
        }

        $container->setParameter('midgard.mvccompat.root', $rootDir);

    }
}
