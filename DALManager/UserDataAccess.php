<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class UserDataAccess extends DataAccess{

	public function __construct(){}

	public function Create($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `User` (`Username`, `Password`, `IsActive`) VALUES(\'%s\', \'%s\', %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `User`";	
		return $this->ExecuteQuery();
	}

	public function Update($params){
		$this->query = "UPDATE `User` SET `Password`='%s', `IsActive`=%b WHERE `UserID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function Delete($params){
		$this->query = "UPDATE `User` SET `IsActive`=%b WHERE `UserID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function GetUserByUsername($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('SELECT * FROM `User` WHERE (`Username`=\'%s\')',	$connection->real_escape_string($params[0]));	
		return $this->ExecuteQuery();
	}
}
?>