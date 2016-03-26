<?php 
 require_once($_SESSION['documentRoot'] .'/BLLManager/UserManager.php');   
class UserHelper
{
	public static function Authenticate() {
		$loggedUser = null;
		$user = SessionHelper::GetSession('user');
	    if($user != null){
	      $userManager = new UserManager();
	      $loggedUser = $userManager->GetUser($user->GetUsername(), $user->GetPassword());
	      if($loggedUser != null)
	      {
    		return $loggedUser;
	      }
	      else
	      {        
	        SessionHelper::RedirectToLogin();
	      }
	    }
	    else{
		      SessionHelper::RedirectToLogin();
	    }
    }

    public static function Logout() {
		SessionHelper::RedirectToLogin();
    }

}
?>