<?php
namespace Midgard\MvcCompatBundle\Templating;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference as BaseTemplateReference;

class TemplateReference extends BaseTemplateReference
{
    public function getPath()
    {
        return sprintf('@%s/templates/%s.xhtml', $this->get('bundle'), $this->get('name'));
    }
}
