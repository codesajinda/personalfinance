<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class ExpenseDataAccess extends DataAccess{
	public function Create($params){		
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `expense` (`ExpenseName`, `ExpenseDescription`, `ExpenseDate`, `Amount`, `CategoryID`, `UserID`, `IsActive`) VALUES(\'%s\', \'%s\', \'%s\', %f, %u, %u, %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]), $connection->real_escape_string($params[4]), $connection->real_escape_string($params[5]), $connection->real_escape_string($params[6]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `expense`";	
		return $this->ExecuteQuery();
	}

	public function Update($params){
		$this->query = "UPDATE `user` SET `Password`='%s', `IsActive`=%b WHERE `UserID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function Delete($params){
		$this->query = "UPDATE `user` SET `IsActive`=%b WHERE `UserID`=%i";
		$this->params = $params;
		return $this->ExecuteQuery();
	}

	public function GetExpensesByCategoryAndUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT `expense`.`ExpenseName`, `expense`.`ExpenseDescription`, `expense`.`ExpenseDate`, `expense`.`Amount`, `category`.`CategoryID` FROM `expense` INNER JOIN `user` ON `expense`.`UserID` = `user`.`UserID` INNER JOIN `category` ON `expense`.`CategoryID` = `category`.`CategoryID` WHERE `user`.`UserID` = %u AND `user`.`IsActive` = 1 AND `expense`.`IsActive` = 1 AND `category`.`CategoryID`= %u AND `category`.`IsActive` = 1', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1])); 
		return $this->ExecuteQuery();
	}

	public function GetExpensesByUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT * FROM `expense` INNER JOIN `user` ON `expense`.`UserID` = `user`.`UserID` WHERE `expense`.`IsActive` = 1  AND `user`.`UserID` = %u AND `user`.`IsActive` = 1', $connection->real_escape_string($params[0])); 
		return $this->ExecuteQuery();
	}

}
?>