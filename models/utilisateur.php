<?php

namespace App\Models;

use App\Models\CRUD;
use App\Models\Utilisateur;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class Utilisateur extends CRUD
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $fillable = ['nom_utilisateur', 'email', 'mot_de_passe'];


    public function createUser($nom, $email, $motDePasse)
    {
        $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

        $data = [
            'nom_utilisateur' => $nom,
            'email' => $email,
            'mot_de_passe' => $hashedPassword
        ];

        return $this->insert($data);
    }

    public function checkUser($username, $password)
    {
        $user = $this->unique('nom_utilisateur', $username);
        if ($user) {
            if (password_verify($password, $user['mot_de_passe'])) {
                session_regenerate_id(); // Regenerate session ID to prevent session fixation

                $_SESSION['user_id'] = $user['id']; // Store user ID in session 
                $_SESSION['nom_utilisateur'] = $user['nom_utilisateur']; // Store username in session
                $_SESSION['email'] = $user['email']; // Store password hash in session
                $_SESSION['finger_print'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']); // Store fingerprint in session
                return true; // Authentication successful
            } else {
                return false; // Incorrect password
            }
        } else {
            return false; // User not found
        }
    }

    public function updateUserData($id, $nom, $email, $motDePasse = null)
    {
        $data = [
            'nom_utilisateur' => $nom,
            'email' => $email
        ];

        if (!empty($motDePasse)) {
            $data['mot_de_passe'] = password_hash($motDePasse, PASSWORD_DEFAULT);
        }

        return $this->update($data, $id);
    }

    public function deleteUserAccount($id)
    {
        return $this->delete($id);
    }
}
