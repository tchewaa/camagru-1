<?php


namespace Core\Validators;


use Core\Helpers;

class PasswordValidator extends CustomValidator {

    public function runValidation() {
        // TODO: Implement runValidation() method.
        $pass = true;
        $value = $this->_model->{$this->field};
        $uppercase = preg_match('@[A-Z]@', $value);
        $lowercase = preg_match('@[a-z]@', $value);
        $number = preg_match('@[0-9]@', $value);
        $specialChars = preg_match('@[^\w]@', $value);
        if (!$value || !$uppercase || !$lowercase || !$number || !$specialChars) {
            $pass = false;
        }
        return $pass;
    }
}