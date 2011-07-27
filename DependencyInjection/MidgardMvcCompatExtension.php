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
    private $rootDir = '';

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('compat.xml');

        $this->rootDir = realpath($configs[0]['root']);
        if (!is_dir($this->rootDir)) {
            throw new \InvalidArgumentException(sprintf('Midgard MVC component directory "%s" not found, check your configuration.', $this->rootDir));
        }

        $container->setParameter('midgard.mvccompat.root', $this->rootDir);

        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($className)
    {
        $components = scandir($this->rootDir, -1);
        foreach ($components as $component)
        {
            $componentLength = strlen($component);
            if (substr($className, 0, $componentLength) != $component)
            {
                continue;
            }
            return $this->autoloadFromComponent($component, substr($className, $componentLength));
        }
    }

    private function autoloadFromComponent($component, $className)
    {
        if (empty($className)) {
            $path = $this->rootDir . "/{$component}/interface.php";
        } else {
            $path = $this->rootDir . "/{$component}" . str_replace('_', '/', $className) . '.php';
        }
        
        if (!file_exists($path)) {
            return;
        }
        
        require($path);
    }
}
