<?php

class SessionHelper
{
	public static function GetSession($key) {
        return unserialize($_SESSION[$key]);
    }

    public static function SetSession($key, $value) {
        $_SESSION[$key] = serialize($value);
    }

    public static function ClearSession($key) {
        $_SESSION[$key] = "";
    }

    public static function RedirectToLogin(){ 
      SessionHelper::ClearSession('user');
      header("Location: " .  $_SESSION['siteUrl'] . 'index.php');
    }
}


?>