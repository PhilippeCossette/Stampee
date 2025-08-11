<?php
namespace App\Providers;

use App\Providers\View;

class Auth {
    // Validates the session by checking a fingerprint
    static public function session(){
        if(isset($_SESSION['finger_print']) && $_SESSION['finger_print'] === md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])){
            return true; // Session is valid
        }else{
            return View::redirect('login'); // Redirect to login if invalid
        }
    }
}

?>
