<?php
 class User{
	private $userID = -1;
	private $username;
	private $password;
	private $isActive = false;

	public function GetUserID(){
		return $this->userID;
	}

	public function SetUserID($userID){
		$this->userID = $userID;
	}

	public function GetUsername(){
		return $this->username;
	}

	public function SetUsername($username){
		$this->username = $username;
	}

	public function GetPassword(){
		return $this->password;
	}

	public function SetPassword($password){
		$this->password = $password;
	}

	public function GetIsActive(){
		return $this->isActive;
	}

	public function SetIsActive($isActive){
		$this->isActive = $isActive;
	}

}				

?>