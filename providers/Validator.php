<?php

namespace App\Providers;

class Validator
{

    private $errors = array(); // Array to store validation errors
    private $key; // Field key
    private $value; // Field value
    private $name; // Display name for the field

    // Set the field for validation
    public function field($key, $value, $name = null)
    {
        $this->key = $key; // Store the field key
        $this->value = $value; // Store the field value
        // If no name is provided, use the key with the first letter capitalized
        if ($name == null) {
            $this->name = ucfirst($key);
        } else {
            $this->name = ucfirst($name);
        }
        return $this;
    }

    // Validate if the field is required (non-empty)
    public function required()
    {
        if (empty($this->value)) {
            $this->errors[$this->key] = "$this->name est obligatoire."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is a valid email address
    public function email()
    {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "$this->name doit être une adresse courriel valide."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is less than the max length
    public function max($length)
    {
        if (strlen($this->value) > $length) {
            $this->errors[$this->key] = "$this->name doit contenir moins de $length caractères."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is greater than or equal to the min length
    public function min($length)
    {
        if (strlen($this->value) < $length) {
            $this->errors[$this->key] = "$this->name doit contenir au moins $length caractères."; // Add error message
        }
        return $this;
    }

    // Validate if the field value is a number
    public function number()
    {
        if (!empty($this->value) && !is_numeric($this->value)) {
            $this->errors[$this->key] = "$this->name doit être un nombre."; // Add error message
        }
        return $this;
    }

    // Validate if its unique
    public function unique($model)
    {
        // Cant validate if the value is empty
        if (empty($this->value)) {
            return $this;
        }

        // Get the relative model class name
        $model = 'App\\Models\\' . $model;
        $model = new $model;
        $unique = $model->unique($this->key, $this->value);
        if ($unique) {
            $this->errors[$this->key] = "$this->name doit être unique.";
        }
        return $this;
    }

    public function uniqueUpdate($model, $excludeId = null)
    {
        // Cant validate if the value is empty
        if (empty($this->value)) {
            return $this;
        }

        // Get the relative model class name
        $model = 'App\\Models\\' . $model;
        $model = new $model;
        $unique = $model->uniqueUpdate($this->key, $this->value, $excludeId);
        if (!$unique) {
            $this->errors[$this->key] = "$this->name doit être unique.";
        }
        return $this;
    }


    public function file($fieldName, array $file)
    {
        $this->currentField = $fieldName;
        $this->currentValue = $file;

        return $this; // Return $this to allow method chaining  
    }

    //Validate if the file is uploaded becuase it is required
    public function requiredFile()
    {
        if (!isset($this->currentValue['tmp_name']) || !is_uploaded_file($this->currentValue['tmp_name'])) {
            $this->errors[$this->currentField] = "$this->currentField est obligatoire.";
        }
        return $this;
    }

    // Validate if the file is too large
    public function maxSizeFile($maxBytes)
    {
        if ($this->currentValue['size'] > $maxBytes) {
            $this->errors[$this->currentField] = "Le fichier est trop volumineux. Maximum : " . ($maxBytes / 1024 / 1024) . "MB."; //Converts bytes to MB
        }
        return $this;
    }

    // Validate if the file type is allowed
    public function allowedTypesFile(array $types)
    {
        if (!in_array($this->currentValue['type'], $types)) {
            $this->errors[$this->currentField] = "Type de fichier non autorisé. Seuls : " . implode(', ', $types);
        }
        return $this;
    }

    public function maxDimensionsFile($maxWidth, $maxHeight)
    {
        $info = getimagesize($this->currentValue['tmp_name']);
        if ($info === false) {
            $this->errors[$this->currentField] = "Le fichier n'est pas une image valide.";
        } else {
            if ($info[0] > $maxWidth || $info[1] > $maxHeight) {
                $this->errors[$this->currentField] = "Image trop grande. Max {$maxWidth}x{$maxHeight}px.";
            }
        }
        return $this;
    }


    public function higherThan($minValue)
    {
        if (!empty($this->value) && is_numeric($this->value) && $this->value <= $minValue) {
            $this->errors[$this->key] = "$this->name doit être supérieur à $minValue.";
        }
        return $this;
    }





    // Check if there are any validation errors
    public function isSuccess()
    {
        if (empty($this->errors)) // Return true if no errors
            return true;
    }

    // Get all validation errors
    public function getErrors()
    {
        if (!$this->isSuccess()) // If there are errors, return them
            return $this->errors;
    }
}
