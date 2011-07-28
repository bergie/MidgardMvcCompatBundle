<?php
use Symfony\Component\HttpKernel\Exception\HttpException;

class midgardmvc_exception extends Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct($code, $message);
    }

    public function getHttpCode()
    {
        return $this->getStatusCode();
    }
}
