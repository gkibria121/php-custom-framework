<?php


declare(strict_types=1);


namespace Framework\Exceptions;

use Exception;

class RouteNotFound extends Exception
{

    public function __construct(public array $data = [])
    {
        $this->message = "Route Not Found!";
    }
}
