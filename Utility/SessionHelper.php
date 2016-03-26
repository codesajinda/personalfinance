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
      print_r("<h4>Please login by going to</h4><a href=".$_SESSION['siteUrl'] . 'index.php'.">login</a>");
      exit;
    }

    public static function IsSessionSet($key){
        return $_SESSION[$key] != null;
    }
}


?>