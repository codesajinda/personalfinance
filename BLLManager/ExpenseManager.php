<?php
require_once($_SESSION['documentRoot'] . '/BLLManager/BaseManager.php');
require_once($_SESSION['documentRoot'] . '/DALManager/ExpenseDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/Expense.php');
class ExpenseManager extends BaseManager{	
	private $dataAccess;

	public function __construct(){
		$this->dataAccess = new ExpenseDataAccess();		
		parent::__construct($this->dataAccess);
	}

	public function CreateExpense($expense){
		$success = false;

		if($expense != null)
		{			
			$params = array($expense->GetExpenseName(), $expense->GetDescription(), $expense->GetDate(), $expense->GetAmount(), $expense->GetCategoryID(), $expense->GetUserID(), $expense->GetIsActive());		
			$success = $this->dataAccess->Create($params);		
		}

		return $success;
	}
}

?>
