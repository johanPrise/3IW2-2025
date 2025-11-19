<?php
namespace App\Controller;

use App\Helper\Errors;

class Base
{
    public function index(): void
    {
        $errors = new Errors();
        $errors->helloWorld();
    }

    public function contact(): void
    {
        echo "Base contact";
    }

    public function portfolio(): void
    {
        echo "Base portfolio";
    }


}