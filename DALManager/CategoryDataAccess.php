<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class CategoryDataAccess extends DataAccess{
	public function Create($params){		
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `category` (`UserID`, `CategoryTypeID`, `CategoryName`, `IsActive`) VALUES(%u, %u, \'%s\', %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `category`";	
		return $this->ExecuteQuery();
	}

	public function Update($params){
		$this->query = "UPDATE `category` SET `CategoryName`='%s', `IsActive`=%b WHERE `CategoryID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function Delete($params){
		$this->query = "UPDATE `category` SET `IsActive`=%b WHERE `CategoryID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}
	public function GetByCategoryID($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('SELECT * FROM `category` WHERE `category`.`CategoryID` = %u AND `category`.`IsActive` = 1', $connection->real_escape_string($params));			
		return $this->ExecuteQuery();
	}

	public function GetAllCategories($params){
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('SELECT `category`.`CategoryID`,`category`.`CategoryName`, `category`.`CategoryTypeID` FROM `category` INNER JOIN `user` ON `user`.`UserID` = `category`.`UserID` WHERE ((`user`.`UserID`= %u && `user`.`IsActive`= 1) && (`category`.`IsActive`= 1))',	$connection->real_escape_string($params[0]));			
		return $this->ExecuteQuery();
	}
}
?>