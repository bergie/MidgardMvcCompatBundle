<?php
class midgardmvc_core
{
    private static $instance = null;

    public function get_instance()
    {
        if (!self::$instance)
        {
            self::$instance = new midgardmvc_core();
        }

        return self::$instance;
    }
}
