<?php 
require_once($_SESSION['documentRoot'] . '/DALManager/ExpenseDataAccess.php');
require_once($_SESSION['documentRoot'] . '/DALManager/CategoryDataAccess.php');
require_once($_SESSION['documentRoot'] . '/DALManager/SavingDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/Custom/ExpenseReport.php');
require_once($_SESSION['documentRoot'] . '/Objects/Custom/SavingReport.php');

class ReportManager{
	private $expenseDataAccess;
	private $categoryDataAccess;
	private $savingDataAccess;
	
	public function __construct(){
		$this->expenseDataAccess = new ExpenseDataAccess();	
		$this->categoryDataAccess = new CategoryDataAccess();	
		$this->savingDataAccess = new SavingDataAccess();
	}

	public function GetExpensesCategoryDateRange($userID, $from, $to, $categoryID){
		$expenseReports = null;	
		$params = array($userID, $categoryID);		
		$rows = $this->expenseDataAccess->GetExpensesByCategoryAndUserID($params);	
		if ($rows->num_rows > 0) {
			$expenseReports = array();
		    while($row = $rows->fetch_assoc()) {
		        $dbDate = date('Y-m-d', strtotime($row['ExpenseDate']));
		        $fromDate = date('Y-m-d', strtotime($from));
		        $toDate = date('Y-m-d', strtotime($to));

		    	if($dbDate >= $fromDate  && $dbDate <= $toDate){
		        	$expenseReport = new ExpenseReport();
					$expenseReport->ExpenseName = $row['ExpenseName']; 
					$expenseReport->ExpenseDescription = $row['ExpenseDescription'];
					$expenseReport->ExpenseDate = $row['ExpenseDate'];
					$expenseReport->Amount = $row['Amount'];
					$categoryRows = $this->categoryDataAccess->GetByCategoryID($row['CategoryID']);
					if ($categoryRows->num_rows > 0) {
						while($categoryRow = $categoryRows->fetch_assoc()) {
							$expenseReport->CategoryName  = $categoryRow['CategoryName'];
						}
					}
					$expenseReports[] = $expenseReport;
				}
		    }
		 }

		return $expenseReports;
	}

	public function GetSavingsCategoryDateRange($userID, $from, $to, $categoryID){
		$savingReports = null;	
		$params = array($userID, $categoryID);		
		$rows = $this->savingDataAccess->GetSavingsByCategoryAndUserID($params);	
		if ($rows->num_rows > 0) {
			$savingReports = array();
		    while($row = $rows->fetch_assoc()) {
		        $dbDate = date('Y-m-d', strtotime($row['SavingDate']));
		        $fromDate = date('Y-m-d', strtotime($from));
		        $toDate = date('Y-m-d', strtotime($to));

		    	if($dbDate >= $fromDate  && $dbDate <= $toDate){
		        	$savingReport = new SavingReport();
					$savingReport->SavingName = $row['SavingName']; 
					$savingReport->SavingDescription = $row['SavingDescription'];
					$savingReport->SavingDate = $row['SavingDate'];
					$savingReport->Amount = $row['Amount'];
					$categoryRows = $this->categoryDataAccess->GetByCategoryID($row['CategoryID']);
					if ($categoryRows->num_rows > 0) {
						while($categoryRow = $categoryRows->fetch_assoc()) {
							$savingReport->CategoryName  = $categoryRow['CategoryName'];
						}
					}
					$savingReports[] = $savingReport;
				}
		    }
		 }

		return $savingReports;
	}
}
?>