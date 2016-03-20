<?php
require_once($_SESSION['documentRoot'] . '/DALManager/ExpenseDataAccess.php');
require_once($_SESSION['documentRoot'] . '/DALManager/SavingDataAccess.php');
require_once($_SESSION['documentRoot'] . '/DALManager/CategoryDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/Custom/ExpenseReport.php');
require_once($_SESSION['documentRoot'] . '/Objects/Custom/SavingReport.php');

class WidgetManager{
	private $expenseDataAccess;
	private $categoryDataAccess;
	private $savingDataAccess;
	
	public function __construct(){
		$this->expenseDataAccess = new ExpenseDataAccess();	
		$this->categoryDataAccess = new CategoryDataAccess();	
		$this->savingDataAccess = new SavingDataAccess();
	}

	public function GetWidgetData($userID){
		$expensesAndSavings = array();
		$params = array($userID);		
		$expenseRows = $this->expenseDataAccess->GetExpensesByUserID($params);	
		if ($expenseRows->num_rows > 0) {
			$expenses = array();
		    while($expenseRow = $expenseRows->fetch_assoc()) {	  
	        	$expense = new ExpenseReport();
				$expense->ExpenseName = $expenseRow['ExpenseName']; 
				$expense->ExpenseDescription = $expenseRow['ExpenseDescription'];
				$expense->ExpenseDate = $expenseRow['ExpenseDate'];		
				$expense->Amount = $expenseRow['Amount'];	
				$categoryRows = $this->categoryDataAccess->GetByCategoryID($expenseRow['CategoryID']);
				if ($categoryRows->num_rows > 0) {
					while($categoryRow = $categoryRows->fetch_assoc()) {
						$expense->CategoryName  = $categoryRow['CategoryName'];
					}
				}		
				$expenses[] = $expense;				
		    }

		    $expensesAndSavings[] = $expenses;
		 }

		$savingRows = $this->savingDataAccess->GetSavingsByUserID($params);	
		if ($savingRows->num_rows > 0) {
			$savings = array();
		    while($savingRow = $savingRows->fetch_assoc()) {
	        	$saving = new SavingReport();
				$saving->SavingName = $savingRow['SavingName']; 
				$saving->SavingDescription = $savingRow['SavingDescription'];
				$saving->SavingDate = $savingRow['SavingDate'];
				$saving->Amount = $savingRow['Amount'];	
				$categoryRows = $this->categoryDataAccess->GetByCategoryID($savingRow['CategoryID']);
				if ($categoryRows->num_rows > 0) {
					while($categoryRow = $categoryRows->fetch_assoc()) {
						$saving->CategoryName  = $categoryRow['CategoryName'];
					}
				}					
				$savings[] = $saving;				
		    }

			$expensesAndSavings[] = $savings;
		 }

		return $expensesAndSavings;
	}

}


?>