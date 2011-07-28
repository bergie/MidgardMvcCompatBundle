<?php
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class midgardmvc_exception_unauthorized extends AccessDeniedHttpException
{
    public function __construct($message, $code = 401)
    {
        parent::__construct($message, null, $code);
    }
}
