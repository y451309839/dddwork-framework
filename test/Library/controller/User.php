<?php

namespace Test\Library\Controller;

use Huizi\Dddwork\Framework\Annotation\GetMapping;
use Huizi\Dddwork\Framework\Annotation\PostMapping;
use Huizi\Dddwork\Framework\Annotation\RestController;


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
