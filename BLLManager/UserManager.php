<?php
require_once($_SESSION['documentRoot'] . '/BLLManager/BaseManager.php');
require_once($_SESSION['documentRoot'] . '/DALManager/UserDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/User.php');
require_once($_SESSION['documentRoot'] . '/Utility/Constant.php');
require_once($_SESSION['documentRoot'] . '/Utility/ps_encrypt.php');

class UserManager extends BaseManager{	

	private $dataAccess;

	public function __construct(){
		$this->dataAccess = new UserDataAccess();		
		parent::__construct($this->dataAccess);
	}

	public function Login($username, $password){
		$user = null;		
	    $encrypt = new PS_Encrypt();
	    $encrypt->setKey(Constant::SECRET_KEY);

		if($username != null && $password != null)
		{
			$params = array($username);	
			$rows = $this->dataAccess->GetUserByUsername($params);
			if ($rows->num_rows > 0) {
			    while($row = $rows->fetch_assoc()) {
			    	$decrypted = trim($encrypt->decrypt($row['Password']));
			        if($username == $row['Username'] && $password == $decrypted){
			        	$user = new User();	
			        	$user->SetUserID($row['UserID']);
						$user->SetUsername($row['Username']); 
						$user->SetPassword($row['Password']);
			        }
			    }
			} 
		}
		return $user;
	}

	public function GetUser($username, $password){
		$user = null;
	    $encrypt = new PS_Encrypt();
	    $encrypt->setKey(Constant::SECRET_KEY);

		if($username != null && $password != null)
		{
			$params = array($username);					
			$rows = $this->dataAccess->GetUserByUsername($params);
			if ($rows->num_rows > 0) {
			    while($row = $rows->fetch_assoc()) {			    	
			    	$decrypted = trim($encrypt->decrypt($row['Password']));
			    	$password = trim($encrypt->decrypt($password));
			        if($username == $row['Username'] && $password == $decrypted){
			        	$user = new User();	
			        	$user->SetUserID($row['UserID']);
						$user->SetUsername($row['Username']); 
						$user->SetPassword($row['Password']);
						$user->SetIsActive($row['IsActive']);
			        }
			    }
			} 
		}
		return $user;
	}

	public function CreateUser($user){
		$success = false;
	    $encrypt = new PS_Encrypt();
	    $encrypt->setKey(Constant::SECRET_KEY);

		if($user != null)
		{			
			$params = array($user->GetUsername(), $encrypt->encrypt($user->GetPassword()), $user->GetIsActive());		
			$success = $this->dataAccess->Create($params);		
		}

		return $success;
	}
}
?>