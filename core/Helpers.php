<?php
namespace Core;

class Helpers {
    public static function dnd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

    public static function currentPage() {
        $currentPage = $_SERVER['REQUEST_URI'];
        if($currentPage == PROOT || $currentPage == PROOT.'home/index') {
            $currentPage = PROOT . 'home';
        }
        return $currentPage;
    }

    public static function getObjectProperties($obj){
        return get_object_vars($obj);
    }

    public static function formatConfirmationMessage($token, $user) {
        $message = "";
        if (php_uname('s') == 'Linux') {
            $message = "
             <html>
                <head>
                    <title>Camagru confirmation email</title>
                </head>
                <body>
                    <h1>Y'ello {$user->first_name} {$user->last_name}</h1> <br />
                    <h4>Please click on the following link to verify your email: </h4> <br />
                    <a href=\"http://127.0.0.1:8080/camagru/register/verify/{$user->username}/{$token}\">Confirm EmailVerification</a>
                    <br />
                    <h6>Regards</h6>
                    <h6>Camagru Holdings</h6>
                </body>
             </html>
            ";
        } else {
            $message = "
             <html>
                <head>
                    <title>Camagru confirmation email</title>
                </head>
                <body>
                    <h3>Y'ello {$user->first_name} {$user->last_name}</h3>
                    <h4>Please click on the following link to verify your email:
                        <a href=\"localhost/camagru/register/verify/{$user->username}/{$token}\">Confirm EmailVerification</a>
                    </h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
                </body>
            </html>
            ";
        }
        return $message;
    }

    public static function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getHeaders() {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: pmalope@student.wethinkcode.co.za";
        return $headers;
    }
}