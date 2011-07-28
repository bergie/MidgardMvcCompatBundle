<?php
namespace Midgard\MvcCompatBundle\Templating;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateNameParser as BaseTemplateNameParser;
use Symfony\Component\Templating\TemplateReferenceInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class TemplateNameParser extends BaseTemplateNameParser
{
    public function __construct(KernelInterface $kernel, $container)
    {
        $this->kernel = $kernel;
        $this->container = $container;
    }

    public function parse($name)
    {
        $originalReference = parent::parse($name);

        $request = $this->container->get('request');
        if ($request->attributes->has('midgardmvc_template_aliases'))
        {
            $templateAliases = $request->attributes->get('midgardmvc_template_aliases');
            if (isset($templateAliases[$originalReference->get('name')])) {
                $originalReference->set('name', $templateAliases[$originalReference->get('name')]);
            }
        }

        return new TemplateReference(
            $originalReference->get('bundle'), 
            $originalReference->get('controller'),
            $originalReference->get('name'),
            $originalReference->get('format'),
            $originalReference->get('engine')
        );
    }
}
