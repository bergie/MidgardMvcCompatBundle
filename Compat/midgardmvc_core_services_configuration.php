<?php
/**
 * Proxy Midgard MVC configuration access to Symfony2 config
 */
class midgardmvc_core_services_configuration
{
    public function get($key)
    {
        return null;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function exists($key)
    {
        return false;
    }

    public function __isset($key)
    {
        return $this->exists($key);
    }
}
