<?php


class Input {
 public static function sanitize($dirty) {
     return htmlentities($dirty, ENT_QUOTES, "UTF-8");
 }

 public static function get($input) {
     if (isset($_POST[$input])) {
         return FormHelper::sanitize($_POST[$input]);
     } elseif (isset($_GET[$input])) {
         return FormHelper::sanitize($_GET[$input]);
     }
 }
}