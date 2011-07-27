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

    public function boot()
    {
        $this->rootDir = $this->container->getParameter('midgard.mvccompat.root');

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
