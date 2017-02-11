<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class SavingDataAccess extends DataAccess{

	public function __construct(){}

	public function Create($params){			
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `saving` (`SavingName`, `SavingDescription`, `SavingDate`, `Amount`, `CategoryID`, `UserID`, `IsActive`) VALUES(\'%s\', \'%s\', \'%s\', %f, %u, %u, %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]), $connection->real_escape_string($params[4]), $connection->real_escape_string($params[5]),  $connection->real_escape_string($params[6]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `saving`";		
		return $this->ExecuteQuery();
	}

	public function Update(){
		$this->query = "UPDATE `saving` SET `SavingName`='%s', `SavingDescription`='%s',  `SavingDate`='%s', `CategoryID`=%i, `UserID`=%i, `IsActive`=%b WHERE `SavingID`=%i";
		$this->params = ['Test', 'Test Description', '10/10/2009', 1, 1, 1];
		return $this->ExecuteQuery();
	}

	public function Delete(){
		$this->query = "DELETE FROM `saving` WHERE `SavingID`=%i";
		$this->params = [1];
		return $this->ExecuteQuery();
	}

	public function GetSavingsByCategoryAndUserID($params){
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT `saving`.`SavingName`, `saving`.`SavingDescription`, `saving`.`SavingDate`, `saving`.`Amount`, `category`.`CategoryID` FROM `saving` INNER JOIN `user` ON `saving`.`UserID` = `user`.`UserID` INNER JOIN `category` ON `saving`.`CategoryID` = `category`.`CategoryID` WHERE `user`.`UserID` = %u AND `user`.`IsActive` = 1 AND `saving`.`IsActive` = 1 AND `category`.`CategoryID`= %u AND `category`.`IsActive` = 1', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1])); 
		return $this->ExecuteQuery();
	}

	public function GetSavingsByUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT * FROM `saving` INNER JOIN `user` ON `saving`.`UserID` = `user`.`UserID` WHERE `saving`.`IsActive` = 1  AND `user`.`UserID` = %u AND `user`.`IsActive` = 1', $connection->real_escape_string($params[0])); 
		return $this->ExecuteQuery();
	}
}

?>