<?php
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php');            
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');
    require_once($_SESSION['documentRoot'] .'/BLLManager/CategoryManager.php');    
    require_once($_SESSION['documentRoot'] .'/BLLManager/ReportManager.php');

    $loggedUser = UserHelper::Authenticate();
    $message = '';  
    $success = '';   
    $availableExpenseCategories = '';
    $expenseReports = '';

    if($loggedUser != null){
      $categoryManager = new CategoryManager();
      $categories = $categoryManager->GetAllCategories($loggedUser->GetUserID());       
      $availableExpenseCategories = json_encode(GetExpenseCategoryNames($categories));
    }

    function GetExpenseCategoryNames($categories){
        $expenseCategories = [];
        for ($i=0; $i < count($categories); $i++) {       
          if($categories[$i]->GetCategoryType()  == CategoryType::Expense){
              $expenseCategories[] = $categories[$i];
          }
        }       
        return $expenseCategories;
    }

    if ((isset($_POST["hdnReport"]) && !empty($_POST["hdnReport"]))){
        $postdata = json_decode($_POST['hdnReport'], true);     
        $from = $postdata['From'];
        $to = $postdata['To'];
        $categoryID =  $postdata['Category']['CategoryID'];
        $reportManager = new ReportManager();
        $reports = $reportManager->GetExpensesCategoryDateRange($loggedUser->GetUserID(), $from, $to, $categoryID);
        if($reports != null){
            if(count($reports) > 0){              
              $expenseReports = json_encode($reports);
              $message = "Successfully generated the report";
              $success = true;
            }
            else{              
              $message = "Could not find any expenses within the given range";
              $success = true;
            }
        }
        else{
          $message = "Failed to generate report. Check if you already have Expenses.";
          $success = false;
        }
    }
?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo $message; ?>', success: '<?php echo $success; ?>'},        
        expenseCategories:'<?php echo $availableExpenseCategories;?>',
        expenseReportData:'<?php echo $expenseReports;?>',
    });
</script> 
<div layout-md="column" layout-lg="column" ng-controller="ReportController as Report">
  <div flex>
    <form id="frmExpenseReport" name="frmExpenseReport" action="" method="post" ng-submit="Report.submitForm(frmExpenseReport, $event)" novalidate>
      <input type="hidden" id="hdnReport" name="hdnReport" value="{{Report.expenseReport}}" /> 
      <div flex>
       <h5 class="md-title">Expense Report</h5>
        <md-datepicker id="dtFrom" name="dtFrom" md-placeholder="From" ng-model="Report.expenseReport.From" ng-required="true" ng-change="Report.dateFromExpenseChanged()">
       	</md-datepicker>  
        <span ng-show="frmExpenseReport.dtFrom.$error.required" class="required">Date from is required.</span>
       	<md-datepicker id="dtTo" name="dtTo" md-placeholder="To" md-min-date="Report.expenseReport.From" ng-model="Report.expenseReport.To" ng-required="true">
       	</md-datepicker> 
        <span ng-show="frmExpenseReport.dtTo.$error.required" class="required">Date to is required.</span>
       	<md-input-container class="md-block">
  	        <md-select id="cmbCategory" name="cmbCategory"  placeholder="Select Category"  ng-model="Report.expenseReport.Category" ng-required="true">
  	          <md-option ng-repeat="expenseCategory in Report.expenseCategories" ng-value="expenseCategory">
  	            {{expenseCategory.CategoryName}}
  	          </md-option>
  	        </md-select>
            <div ng-messages="frmExpenseReport.cmbCategory.$error" ng-show="true">
              <div ng-message="required">Category is required.</div>
            </div>
          </md-input-container>
        	<md-button type="submit" class="md-raised md-primary">Generate</md-button> 
      </div>
    </form>
  </div>
  <div flex ng-if="Report.expenseReportData.length > 0">   
    <div flex="30">
     <md-card>
      <md-card-title>
        <md-card-title-text>
          <span class="md-headline">Total Amount</span>
          <span class="md-subhead">{{Report.totalAmount}}</span>
        </md-card-title-text>       
    </md-card>   
    </div> 
    <table cellpadding="0" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>
            Category Name
          </th>
          <th>
            Expense Name
          </th>
          <th>
            Expense Description
          </th>
          <th>
            Expense Date
          </th>
          <th>
            Amount
          </th>
        </tr>
      </thead>
      <tbody>
         <tr ng-repeat="reportData in Report.expenseReportData">
          <td>
            {{reportData.CategoryName}}
          </td>
          <td>
            {{reportData.ExpenseName}}
          </td>
          <td>
            {{reportData.ExpenseDescription}}
          </td>
          <td>
            {{reportData.ExpenseDate}}
          </td>
          <td>
            {{reportData.Amount}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>