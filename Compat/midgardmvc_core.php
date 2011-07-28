<?php
class midgardmvc_core
{
    private static $instance = null;

    private function load_service($service)
    {
        $serviceFile = __DIR__ . "/midgardmvc_core_services_{$service}.php";
        if (!file_exists($serviceFile)) {
            throw new InvalidArgumentException("Service {$service} not installed");
        }
        require $serviceFile;

        $serviceImplementation = "midgardmvc_core_services_{$service}";
        $this->$service = new $serviceImplementation();
    }

    public function __get($key)
    {
        $this->load_service($key);
        return $this->$key;
    }

    public function get_instance()
    {
        if (!self::$instance)
        {
            self::$instance = new midgardmvc_core();
        }

        return self::$instance;
    }
}
