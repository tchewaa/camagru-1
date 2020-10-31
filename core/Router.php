<?php


class Router {

    public static function route($url) {
        //controller
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) . 'Controller': DEFAULT_CONTROLLER . 'Controller';
        $controller_name = str_replace('Controller', '', $controller);
        array_shift($url);

        //action
        $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action': 'indexAction';
        $action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
        array_shift($url);

        //acl check
        $grantAccess = self::hasAccess($controller_name, $action_name);;

        if (!$grantAccess) {
            $controller = ACCESS_RESTRICTED . 'Controller';
            $controller_name = ACCESS_RESTRICTED;
            $action = 'indexAction';
        }

        //params
        $queryParams = $url;

        $dispatch = new $controller($controller_name, $action);

        if (method_exists($controller, $action)) {
            call_user_func([$dispatch, $action], $queryParams);
        } else {
            die('That method does not exist in the controller \"' . $controller_name . '\"');
        }
    }

    public static function redirect($location) {
        if (!headers_sent()) {
            header('Location:'.PROOT.$location);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.PROOT.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
            echo '</noscript>';
            exit();
        }
    }

    public static function hasAccess($controller_name, $action_name = 'index') {
        $acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
        $acl = json_decode($acl_file, true);
        $current_user_acls = ['Guest'];
        $grantAccess = false;

        if (Session::exists(CURRENT_USER_SESSION_NAME)) {
            $current_user_acls[] = "LoggedIn";
            foreach (Users::currentUser()->acls() as $acl) {
                $current_user_acls[] = $acl;
            }
        }

        foreach ($current_user_acls as $level) {
            if (array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])) {
                if (in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])) {
                    $grantAccess = true;
                    break;
                }
            }
        }

        foreach ($current_user_acls as $level) {
            $denied = $acl[$level]['denied'];
            if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
                $grantAccess = false;
                break;
            }
        }

        return $grantAccess;
    }

    public static function getMenu($menu) {
        $menuArray = [];
        $menuFile = file_get_contents(ROOT . DS . 'app' . DS . $menu . '.json');
        $acl = json_decode($menuFile, true);
        foreach ($acl as $key => $value) {
            if (is_array($value)) {
                $sub_menu = [];
                foreach ($value as $k => $v) {
                    if ($k == 'separator' && !empty($sub_menu)) {
                        $sub_menu[$k] = '';
                        continue;
                    } else if ($finalVal = self::get_link($v)) {
                        $sub_menu[$k] = $finalVal;
                    }
                }
                if (!empty($sub_menu)) {
                    $menuArray[$key] = $sub_menu;
                }
            } else {
                if ($finalVal = self::get_link($value)) {
                    $menuArray[$key] = $finalVal;
                }
            }
        }
        return $menuArray;
    }

    //FIXME not showing tools menu
    private static function get_link($val) {
        if (preg_match('/https?:\/\//', $val) == 1) {
            return $val;
        } else {
            $urlArray = explode('/', $val);
            $controller_name = ucwords($urlArray[0]);
            $action_name = (isset($urlArray[1])) ? $urlArray[1] : '';
            if (self::hasAccess($controller_name, $action_name)) {
                return PROOT . $val;
            }
            return false;
        }
    }
}