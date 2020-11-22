<?php

define('DEBUG', true);

define('DEFAULT_CONTROLLER', 'Home'); // default controller if is not specified in the URL

define ('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use this layout

define('SITE_TITLE', 'Camagru'); // this will be used if no site title is set
define('MENU_BRAND', 'Camagru');

define('PROOT', '/camagru/'); //set this to '/' for a live server

define('CURRENT_USER_SESSION_NAME', 'a1b2c3d4e5f6g7h1WeThInKcOdE8i9jbxxaa'); // session name for loggedin user
define('REMEMBER_ME_COOKIE_NAME', 'a1b2c3d4e5f6g7h1BornToCodei9jbxxaa'); // cookie name for loggedin user
define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); // time in seconds for remember me cookie to live (30 days)

define('ACCESS_RESTRICTED', 'Restricted'); // controller name for the restricted redirect

define('PAGE_SIZE', 6);