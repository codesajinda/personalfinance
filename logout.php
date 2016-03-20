<?php	
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');

  	if(isset($_POST['btnLogout'])){
  		UserHelper::Logout();
   	}
?>