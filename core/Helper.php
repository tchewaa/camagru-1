<?php
namespace Core;

use App\Models\Users;

class Helper {
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

    public static function formatForgotPasswordMessage($token, $user) {
        $message = "";
        if (php_uname('s') == 'Linux') {
            $message = "
             <html>
                <head>
                    <title>Camagru Forgot Password</title>
                </head>
                <body>
                    <h3>Y'ello {$user->username}</h3> <br />
                    <h4>Did you forgot your password? No worries, just follow the link: </h4> <br />
                    <a href=\"http://127.0.0.1:8080/camagru/login/resetPassword/{$user->username}/{$token}\">Reset password</a>
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
                    <title>Camagru Forgot Password</title>
                </head>
                <body>
                    <h3>Y'ello {$user->username}</h3>
                    <h4>Did you forgot your password? No worries, just follow the link:
                        <a href=\"http://localhost/camagru/login/resetPassword/{$user->username}/{$token}\">Reset password</a>
                    </h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
                </body>
             </html>
            ";
        }
        return $message;
    }

    public static function formatConfirmationMessage($token, $username) {
        $message = "";
        if (php_uname('s') == 'Linux') {
            $message = "
             <html>
                <head>
                    <title>Camagru confirmation email</title>
                </head>
                <body>
                    <h3>Y'ello {$username}</h3>
                    <h4>Please click on the following link to verify your email:
                        <a href=\"http://127.0.0.1:8080/camagru/register/verify/{$username}/{$token}\">confirm email</a>
                    </h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
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
                    <h3>Y'ello {$username}</h3>
                    <h4>Please click on the following link to verify your email:
                        <a href=\"localhost/camagru/register/verify/{$username}/{$token}\">confirm email</a>
                    </h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
                </body>
            </html>
            ";
        }
        return $message;
    }

    public static function formatImageLikeMessage($imageAuthor) {
        $currentUser = Users::currentUser();
        $message = "";
        if (php_uname('s') == 'Linux') {
            $message = "
             <html>
                <head>
                    <title>Camagru confirmation email</title>
                </head>
                <body>
                    <h3>Y'ello {$imageAuthor->username}</h3>
                    <h4>{$currentUser->username} Liked your image</h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
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
                    <h3>Y'ello {$imageAuthor->username}</h3>
                    <h4>{$currentUser->username} Liked your image</h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
                </body>
             </html>
            ";
        }
        return $message;
    }

    public static function formatImageCommentMessage($imageAuthor) {
        $currentUser = Users::currentUser();
        $message = "";
        if (php_uname('s') == 'Linux') {
            $message = "
             <html>
                <head>
                    <title>Camagru confirmation email</title>
                </head>
                <body>
                    <h3>Y'ello {$imageAuthor->username}</h3>
                    <h4>{$currentUser->username} Commented on your image</h4>
                    <p>Regards</p>
                    <p>Camagru Holdings</p>
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
                    <h3>Y'ello {$imageAuthor->username}</h3>
                    <h4>{$currentUser->username} Commented your image</h4>
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

    public static function displayImages($images) {
        $html = "";
        if (isset($images)) {
            $html .= "<div class=\"row\">";
            foreach ($images as $key => $value) {
                $html .= "<div class=\"col-sm-4 thumbnail\">";
                $html .= "<span class=\"glyphicon glyphicon-remove-sign pull-right delete\" id=\"" . $value->id . "\" style=\"color:red;font-size:30px\"> </span>";
//                $html .= "<img src=\"" . $value->image_data . "\" id=\"user-image\">";
                $html .= '<img src="'. $value->image_data .'" class="images" id="user-image">';
                $html .= '</div>';
            }
            $html .= '</div>';
        }
        return $html;
    }

    public static function displayGalleryImages($images, $pageNumber, $pageCount) {
        $html = "";
        $pageIndex = $pageNumber > 1 ? $pageNumber - 1 : $pageNumber;
        $pages = [];
        $html .= '<div class="row">';
        $imageUrl = (php_uname('s') == 'Linux') ? 'http://localhost:8080/camagru/home/image/' : 'http://localhost/camagru/home/image/';
        $pageUrl = (php_uname('s') == 'Linux') ? 'http://localhost:8080/camagru/home/index/' : 'http://localhost/camagru/home/index/';
        //TODO refactor display images
        foreach($images as $image) {
            $html .= '<div class="col-lg-4">';
            //TODO refactor url
            $html .= '<a href="' . $imageUrl . $image->id . '"><img src="'. $image->image_data .'" class="images" id="'. $image->id .'"></a>';
            $html .= '</div>';

        }
        $html .= '</div>';
        //TODO refactor pagination
        $html .= '<div class="row">';
        $html .= '<div class="col-lg-12 col-lg-offset-4">';
        $html .= '<ul class="pagination">';
        while ($pageIndex <= $pageCount) {
            $pages[] = '<li><a href="' . $pageUrl .$pageIndex.'" class="pages" id="pageNumber'.$pageIndex.'">'.$pageIndex.'</a></li>';
            $pageIndex++;
        }
        $html .= '<li><a href="'. $pageUrl . 1 . '" class="pages" id="pageNumber1">Prev</a></li>';
        foreach ($pages as $page) {
            $html .= $page;
        }
        $html .= '<li><a href="'. $pageUrl . $pageNumber.'" class="pages" id="pageNumber'.$pageNumber.'">Next</a></li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    public static function displayComments($comments) {
        $html = "";
        if (isset($comments)) {
            foreach ($comments as $comment) {
                $html .= '<small>Author: '.$comment->username.' Timestamp: '.$comment->date.'</small>';
                $html .= '<p>'.$comment->content.'</p>';
            }
        }
        return $html;
    }

    public static function validationMessage($message) {
        $html = "";
        if (isset($message['upload-error'])) {
            $html .= "<div class='alert-danger'>";
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $html .= $message['upload-error'];
            $html .= "</div>";
        } elseif (isset($message['upload-success'])) {
            echo $message['upload-success'];
        }
        return $html;
    }

    public static function getImages() {
        $images = glob('app/assets/dummy/' . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $randomImages = [];
        for ($i = 0; $i < 18; $i++) {
            $temp = file_get_contents($images[$i]);
            $imageData = imagecreatefromstring($temp);
            ob_start();
            imagejpeg($imageData);
            $imageData = ob_get_clean();
            $imageData = base64_encode($imageData);
            $base64Image = 'data:image/' . 'jpeg' . ';base64,' . $imageData;
            $randomImages[$i] = $base64Image;
        }
        return $randomImages;
    }

}