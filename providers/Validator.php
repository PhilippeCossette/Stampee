<?php
namespace App\Providers;

class Validator {

    private $errors = array(); // Array to store validation errors
    private $key; // Field key
    private $value; // Field value
    private $name; // Display name for the field

    // Set the field for validation
    public function field($key, $value, $name=null){
        $this->key = $key; // Store the field key
        $this->value = $value; // Store the field value
        // If no name is provided, use the key with the first letter capitalized
        if($name == null){
            $this->name = ucfirst($key);
        }else{
            $this->name = ucfirst($name);
        }
        return $this;
    }

    // Validate if the field is required (non-empty)
    public function required(){
        if(empty($this->value)){
            $this->errors[$this->key] = "$this->name est obligatoire."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is a valid email address
    public function email(){
    if(!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)){
        $this->errors[$this->key] = "$this->name doit être une adresse courriel valide."; // Add error message
    }
    return $this;
    }

    // Validate if the field value is less than the max length
    public function max($length){
        if(strlen($this->value) > $length){
            $this->errors[$this->key] = "$this->name doit contenir moins de $length caractères."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is greater than or equal to the min length
    public function min($length){
        if(strlen($this->value) < $length){
            $this->errors[$this->key] = "$this->name doit contenir au moins $length caractères."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is a number
    public function number(){
        if(!empty($this->value) && !is_numeric($this->value)){
            $this->errors[$this->key] = "$this->name doit être un nombre."; // Add error message
        }
        return $this;
    }
    
    // Validate if its unique
    public function unique($model){
        // Cant validate if the value is empty
        if (empty($this->value)) {
            return $this;
        }

        // Get the relative model class name
        $model = 'App\\Models\\'.$model;
        $model = new $model;
        $unique = $model->unique($this->key, $this->value);
        if($unique){
            $this->errors[$this->key]="$this->name doit être unique.";
        }
        return $this;
    }

    // Check if there are any validation errors
    public function isSuccess(){
        if(empty($this->errors)) // Return true if no errors
            return true;
    }

    // Get all validation errors
    public function getErrors(){
        if(!$this->isSuccess()) // If there are errors, return them
        return $this->errors;
    }

}
?>
