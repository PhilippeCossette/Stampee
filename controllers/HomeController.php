<?php

namespace App\Controllers;

use App\Providers\View;

// This controller handles the home page rendering
class HomeController
{
    public function index()
    {
        return View::render('index');
    }
}
