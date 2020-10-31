<?php


class FormHelper {
    public static function inputBlock ($type, $lable, $name, $value = '', $inputAttributes = [], $divAttributes = []) {
        $divString = self::stringifyAttributes($divAttributes);
        $inputString = self::stringifyAttributes($inputAttributes);
        $html = '<div'.$divString.'>';
        $html .= '<label for="'.$name.'">'.$lable.'</lable>';
        $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value"'.$value.'"'.$inputString.' />';
        $html .= '</div>' ;
        return $html;
    }

    public static function submitTag($buttonText, $inputAttributes = []) {
        $inputString = self::stringifyAttributes($inputAttributes);
        $html = '<input type="submit" value="'.$buttonText.'"'.$inputString.' />';
        return $html;
    }

    public static function submitBlock($buttonText, $inputAttributes=[], $divAttributes=[]) {
        $divString = self::stringifyAttributes($divAttributes);
        $inputString = self::stringifyAttributes($inputAttributes);
        $html = '<div'.$divString.'>';
        $html .= '<input type="submit" value"'.$buttonText.'"'.$inputString.' />';
        $html .= '</div>' ;
        return $html;
    }

    public static function stringifyAttributes($attributes) {
        $string = '';
        foreach ($attributes as $key => $val) {
            $string .= ' ' . $key . '="' . $val . '"';
        }
        return $string;
    }

    public static function generateToken() {
        $token = base64_encode(openssl_random_pseudo_bytes(32));
        Session::set('csrf_token', $token);
        return $token;
    }

    public static function checkToken($token) {
        return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
    }

    public static function csrfInput() {
        return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generateToken().'" />';
    }

    public static function sanitize($dirty) {
        return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }

    public static function posted_values($post) {
        $clean_array = [];
        foreach ($post as $key => $value) {
            $clean_array[$key] = sanitize($value);
        }
        return $clean_array;
    }
}