<?php

namespace App\Controllers;

use App\Providers\View;

// This controller handles the home page rendering
class HomeController
{
    public function index()
    {
        return View::render('index');
        // Clear any previous success messages a change here !!!!!!!!!!
        if (isset($_SESSION['success'])) {
            unset($_SESSION['success']);
        }
    }
}
