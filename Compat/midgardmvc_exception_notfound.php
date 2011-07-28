<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class midgardmvc_exception_notfound extends NotFoundHttpException
{
    public function __construct($message, $code = 404)
    {
        parent::__construct($message, null, $code);
    }

    public function getHttpCode()
    {
        return $this->getStatusCode();
    }
}
