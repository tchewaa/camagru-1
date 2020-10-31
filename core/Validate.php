<?php


class Validate {
    private $_passed = false;
    private $_errors = [];
    private $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    //TODO go through this method line by line
    public function check($source, $items = [], $csrfCheck = false) {
        $this->_errors = [];
        if ($csrfCheck) {
            $csrfPass = FormHelper::checkToken($source['csrf_token']);
            if (!isset($source['csrf_token']) || !$csrfPass) {
                $this->addError(['Something has gone wrong','csrf_token']);
            }
        }
        foreach ($items as $item => $rules) {
            $item = FormHelper::sanitize($item);
            $display = $rules['display'];
            foreach ($rules as $rule => $rule_value) {
                $value = FormHelper::sanitize(trim($source[$item]));

                if ($rule === 'required' && empty($value)) {
                    $this->addError(["{$display} is required", $item]);
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError(["{$display} must be a minimum of {$rule_value} characters.", $item]);
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError(["{$display} must be a maximum of {$rule_value} characters.", $item]);
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $matchDisplay = $items[$rule_value]['display'];
                                $this->addError(["{$matchDisplay} and {$display} must match.", $item]);
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = ?", [$value]);
                            if ($check->count()) {
                                $this->addError(["{$display} already exists. Please choose another {$display}.", $item]);
                            }
                            break;
                        case 'unique_update':
                            $temp = explode(',', $rule_value);
                            $table = $temp[0];
                            $id = $temp[1];
                            $query = $this->_db->query("SELECT * FROM {$table} WHERE 'id' != ? AND {$item} = ?", [$id,$value]);
                            if ($query->count()) {
                                $this->addError(["{$display} already exists. Please choose another {$display}.", $item]);
                            }
                            break;
                        case 'valid_email': {
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError(["{$display} must be a valid email address.", $item]);
                            }
                        }
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    public function addError($error) {
        $this->_errors[] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

    // FIXME remove the jQuery and use vanilla javascript
    public function displayErrors() {
        $html = '<ul>';
        foreach ($this->_errors as $error) {
            if (is_array($error)) {
                $html .= '<li>'.$error[0].'</li>';
                $html .= '<script>
                            const p = document.getElementById("message"); 
                            p.closest("div").classList.add("alert-danger");
                          </script>';
            } else {
                $html = '<li>'.$error.'</li>';
            }
          }
        $html .= '</ul>';
        return $html;
    }
}