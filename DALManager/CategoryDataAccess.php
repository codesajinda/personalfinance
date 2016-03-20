<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class CategoryDataAccess extends DataAccess{
	public function Create($params){		
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `Category` (`UserID`, `CategoryTypeID`, `CategoryName`, `IsActive`) VALUES(%u, %u, \'%s\', %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `Category`";	
		return $this->ExecuteQuery();
	}

	public function Update($params){
		$this->query = "UPDATE `Category` SET `CategoryName`='%s', `IsActive`=%b WHERE `CategoryID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function Delete($params){
		$this->query = "UPDATE `Category` SET `IsActive`=%b WHERE `CategoryID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}
	public function GetByCategoryID($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('SELECT * FROM `Category` WHERE `Category`.`CategoryID` = %u AND `Category`.`IsActive` = 1', $connection->real_escape_string($params[0]));			
		return $this->ExecuteQuery();
	}

	public function GetAllCategories($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('SELECT `Category`.`CategoryID`,`Category`.`CategoryName`, `Category`.`CategoryTypeID` FROM `Category` INNER JOIN `User` ON `User`.`UserID` = `Category`.`UserID` WHERE ((`User`.`UserID`= %u && `User`.`IsActive`= 1) && (`Category`.`IsActive`= 1))',	$connection->real_escape_string($params[0]));			
		return $this->ExecuteQuery();
	}
}
?>