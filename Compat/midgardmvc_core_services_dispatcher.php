<?php
class midgardmvc_core_services_dispatcher
{
    public function generate_url($route, $args, $intent)
    {
        return '';
    }


    public function get_mgdschema_classes($include_views = false)
    {
        static $mgdschemas = array();
        if (isset($mgdschemas[$include_views]))
        {
            return $mgdschemas[$include_views];
        }

        $mgdschemas[$include_views] = array();

        // Get the classes from PHP5 reflection
        $re = new ReflectionExtension('midgard2');
        $classes = $re->getClasses();
        foreach ($classes as $refclass)
        {
            $parent_class = $refclass->getParentClass();
            if (!$parent_class)
            {
                continue;
            }

            if ($parent_class->getName() == 'midgard_object')
            {
                $mgdschemas[$include_views][] = $refclass->getName();
                continue;
            }

            if ($include_views)
            {
                if ($parent_class->getName() == 'midgard_view')
                {
                    $mgdschemas[$include_views][] = $refclass->getName();
                }
            }
        }
        return $mgdschemas[$include_views];
    }
}
