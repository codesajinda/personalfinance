<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class ExpenseDataAccess extends DataAccess{
	public function Create($params){		
		$connection = $this->Connect();
		$this->queryAndParams = sprintf('INSERT INTO `Expense` (`ExpenseName`, `ExpenseDescription`, `ExpenseDate`, `Amount`, `CategoryID`, `UserID`, `IsActive`) VALUES(\'%s\', \'%s\', \'%s\', %d, %u, %u, %b)', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1]), $connection->real_escape_string($params[2]), $connection->real_escape_string($params[3]), $connection->real_escape_string($params[4]), $connection->real_escape_string($params[5]), $connection->real_escape_string($params[6]));
		return $this->ExecuteQuery();
	}

	public function Read(){
		$this->query = "SELECT * FROM `Expense`";	
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

	public function GetExpensesByCategoryAndUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT `Expense`.`ExpenseName`, `Expense`.`ExpenseDescription`, `Expense`.`ExpenseDate`, `Expense`.`Amount`, `Category`.`CategoryID` FROM `Expense` INNER JOIN `User` ON `Expense`.`UserID` = `User`.`UserID` INNER JOIN `Category` ON `Expense`.`CategoryID` = `Category`.`CategoryID` WHERE `User`.`UserID` = %u AND `User`.`IsActive` = 1 AND `Expense`.`IsActive` = 1 AND `Category`.`CategoryID`= %u AND `Category`.`IsActive` = 1', $connection->real_escape_string($params[0]), $connection->real_escape_string($params[1])); 
		return $this->ExecuteQuery();
	}

	public function GetExpensesByUserID($params){			
		$connection = $this->Connect($params);
		$this->queryAndParams = sprintf('SELECT * FROM `Expense` INNER JOIN `User` ON `Expense`.`UserID` = `User`.`UserID` WHERE `Expense`.`IsActive` = 1  AND `User`.`UserID` = %u AND `User`.`IsActive` = 1', $connection->real_escape_string($params[0])); 
		return $this->ExecuteQuery();
	}

}
?>