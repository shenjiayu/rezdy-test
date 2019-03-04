<?php

namespace App\Actions;

use Slim\Container;

abstract class Action
{
    protected $ci;

    public function __construct(Container $ci)
    {
        $this->ci = $ci;
    }
    
}
