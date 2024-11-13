<?php

namespace Test\Library\Controller;

use Huizi\Dddwork\Annotation\GetMapping;
use Huizi\Dddwork\Annotation\PostMapping;
use Huizi\Dddwork\Value\Annotation\RestController;

#[RestController('/users')]
class User
{
    
    #[PostMapping("/sessions")]
    public function login()
    {

    }

    #[GetMapping("/infos/{id}")]
    public function info()
    {

    }
}
