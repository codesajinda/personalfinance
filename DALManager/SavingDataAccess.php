<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class SavingDataAccess extends DataAccess{

	public function __construct(){}

	public function Create($params){			
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `Saving` (`SavingName`, `SavingDescription`, `SavingDate`, `Amount`, `CategoryID`, `UserID`, `IsActive`) VALUES(\'%s\', \'%s\', \'%s\', %d, %u, %u, %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]), $connection->real_escape_string($params[4]), $connection->real_escape_string($params[5]),  $connection->real_escape_string($params[6]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `Saving`";		
		return $this->ExecuteQuery();
	}

	public function Update(){
		$this->query = "UPDATE `Saving` SET `SavingName`='%s', `SavingDescription`='%s',  `SavingDate`='%s', `CategoryID`=%i, `UserID`=%i, `IsActive`=%b WHERE `SavingID`=%i";
		$this->params = ['Test', 'Test Description', '10/10/2009', 1, 1, 1];
		return $this->ExecuteQuery();
	}

	public function Delete(){
		$this->query = "DELETE FROM `Saving` WHERE `SavingID`=%i";
		$this->params = [1];
		return $this->ExecuteQuery();
	}

	public function GetSavingsByCategoryAndUserID($params){
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT `Saving`.`SavingName`, `Saving`.`SavingDescription`, `Saving`.`SavingDate`, `Saving`.`Amount`, `Category`.`CategoryID` FROM `Saving` INNER JOIN `User` ON `Saving`.`UserID` = `User`.`UserID` INNER JOIN `Category` ON `Saving`.`CategoryID` = `Category`.`CategoryID` WHERE `User`.`UserID` = %u AND `User`.`IsActive` = 1 AND `Saving`.`IsActive` = 1 AND `Category`.`CategoryID`= %u AND `Category`.`IsActive` = 1', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1])); 
		return $this->ExecuteQuery();
	}

	public function GetSavingsByUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT * FROM `Saving` INNER JOIN `User` ON `Saving`.`UserID` = `User`.`UserID` WHERE `Saving`.`IsActive` = 1  AND `User`.`UserID` = %u AND `User`.`IsActive` = 1', $connection->real_escape_string($params[0])); 
		return $this->ExecuteQuery();
	}
}

?>