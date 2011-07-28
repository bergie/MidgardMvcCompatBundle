<?php
namespace Midgard\MvcCompatBundle\Bundle;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

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

    public function registerCommands(Application $application)
    {
        if (!$dir = realpath($this->getPath().'/bin')) {
            return;
        }

        $finder = new Finder();
        $finder->files()->name('*command.php')->in($dir);

        foreach ($finder as $file) {
            $r = new \ReflectionClass("\\{$this->getName()}_bin_".$file->getBasename('.php'));
            if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()) {
                $application->add($r->newInstance());
            }
        }
    }
}
