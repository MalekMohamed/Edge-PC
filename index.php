<?php
/**
 * Copyright (c) 2017.  All right reserved to ConquerHub
 */

/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 14/7/2018
 * Time: 1:19 AM
 */
session_start();
ob_start();
$user_logged = $_SESSION['account'];
require 'controllers/class.controller.php';
$route = isset($_REQUEST['public/client/pages']) ? trim($_REQUEST['public/client/pages']) : '';
$account = isset($_REQUEST['public/client/pages/account']) ? trim($_REQUEST['public/client/pages/account']) : '';
$Staff = isset($_REQUEST['public/client/pages/account/Staff']) ? trim($_REQUEST['public/client/pages/account/Staff']) : '';

$route_array = array(
    'items' => 'public/client/pages',
    'home' => 'public/client/pages',
    '403' => 'public/client/pages',
    'products' => 'public/client/pages',
    'search' => 'public/client/pages',
    '404' => 'public/client/pages',
);
$files['account'] = array(
    'messages' => 'public/client/pages/account',
    'chat' => 'public/client/pages/account',
    'Logout' => 'public/client/pages/account',
    'manage-item' => 'public/client/pages/account',
    'RecoverPassword' => 'public/client/pages/account',
    'settings' => 'public/client/pages/account',
);
$files['Staff'] = array(
    'reports' => 'public/client/pages/account/Staff',
    'items' => 'public/client/pages/account/Staff',
    'accounts' => 'public/client/pages/account/Staff',
);
/* Get Account */
$account_path = !empty($files['account'][$account]) ? $files['account'][$account] . '/' : '';
if (array_key_exists($account, $files['account']) && file_exists($account_path . $account . '.php') && !empty($account)) {
    if (isset($_SESSION['account'])) {
        require_once($account_path . $account . '.php');
    } else {
        include 'public/client/pages/403.php';
    }
} elseif (!file_exists($account_path . $account . '.php') && !empty($account)) {
    include 'public/client/pages/404.php';
}
/* Get Staff */
$Staff_path = !empty($files['Staff'][$Staff]) ? $files['Staff'][$Staff] . '/' : '';
if (array_key_exists($Staff, $files['Staff']) && file_exists($Staff_path . $Staff . '.php') && !empty($Staff)) {
    if (isset($_SESSION['Staff'])) {
        require_once($Staff_path . $Staff . '.php');
    } else {
        include 'public/client/pages/403.php';
    }
} elseif (!file_exists($Staff_path . $Staff . '.php') && !empty($Staff)) {
    include 'public/client/pages/404.php';
}
/* Get Main */
 if ($account != 'Login' && empty($account) && empty($Staff)) {
     $route_path = !empty($route_array[$route]) ? $route_array[$route] . '/' : '';
     if (array_key_exists($route, $route_array) && file_exists($route_path . $route . '.php')) {
         include $route_path . $route . '.php';
     } elseif (!file_exists($route_path . $route . '.php') && !empty($route)) {
         include 'public/client/pages/404.php';
     } elseif (empty($route) && (empty($account))) {
         include 'public/client/pages/index.php';
     }
 }

require 'public/client/footer.php';
ob_end_flush();
?>