<?php

namespace App\Controllers;

use App\Providers\View;
use App\Providers\Auth; 

class UserController {
    public function profileIndex() {
        Auth::session(); // Ensure the user is authenticated
        return View::render('profile');
    }
}