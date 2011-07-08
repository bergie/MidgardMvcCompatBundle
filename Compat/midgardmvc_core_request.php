<?php

use Symfony\Component\HttpFoundation\Request;

class \midgardmvc_core_request
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function resolve_node($path)
    {
        $this->set_node(null);
    }

    public function set_node($node)
    {
    }

    public function get_node()
    {
    }

    public function get_path()
    {
        $this->request->getPathInfo();
    }

    public function get_component_chain()
    {
    }

    public function add_component_to_chain($component, $prepend=false)
    {
    }

    public function set_component($component)
    {
    }

    public function get_component()
    {
    }

    public function get_route()
    {
    }

    public function set_arguments(array $argv)
    {
        foreach ($argv as $argument => $value)
        {
            $this->request->attributes->set($argument, $value);
        }
    }

    public function get_arguments()
    {
        return $this->request->attributes->all();
    }

    public function isset_data_item($key)
    {
    }

    public function get_data_item($key)
    {
    }

    public function is_subrequest()
    {
        return $this->request->attributes('midgardmvc_subrequest');
    }

    public function set_subrequest()
    {
        $this->request->attributes('midgardmvc_subrequest', true);
    }

    public function
}
