<?php 
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php');   
    require_once($_SESSION['documentRoot'] .'/BLLManager/ExpenseManager.php');        
    require_once($_SESSION['documentRoot'] .'/BLLManager/SavingManager.php');   
    require_once($_SESSION['documentRoot'] .'/BLLManager/CategoryManager.php');  
    require_once($_SESSION['documentRoot'] .'/Objects/User.php');    
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');
    require_once($_SESSION['documentRoot']. '/Objects/CategoryType.php');


    $loggedUser = UserHelper::Authenticate();

    $message = '';   
    $availableSavingCategories = '';
    $availableExpenseCategories = '';
    $success='';

    if($loggedUser != null){
      $categoryManager = new CategoryManager();
      $categories = $categoryManager->GetAllCategories($loggedUser->GetUserID());
      $availableSavingCategories = json_encode(GetSavingCategoryNames($categories));
      $availableExpenseCategories = json_encode(GetExpenseCategoryNames($categories));
    }

    if(isset($_POST['hdnExpense']) && !empty($_POST["hdnExpense"])){      
      $postdata = json_decode($_POST['hdnExpense'], true);
      $date =  new DateTime($postdata['ExpenseDate']);
      $expenseDate = $date->format('Y-m-d');
      $expense = new Expense();
      $expense->SetExpenseName($postdata['ExpenseName']);
      $expense->SetDescription($postdata['ExpenseDescription']);
      $expense->SetDate($expenseDate);
      $expense->SetAmount($postdata['Amount']);
      $expense->SetCategoryID($postdata['ExpenseCategory']['CategoryID']);
      $expense->SetUserID($loggedUser->GetUserID());
      $expense->SetIsActive(true);
      $expenseManager = new ExpenseManager();
      $success = $expenseManager->CreateExpense($expense);
      if($success){
          $message = "Successfully added";
      }
      else{
          $message = "Failed to add";
      }
    }

    if(isset($_POST['hdnSaving']) && !empty($_POST["hdnSaving"])){
      $postdata = json_decode($_POST['hdnSaving'], true); 
      $date =  new DateTime($postdata['SavingDate']);
      $savingDate = $date->format('Y-m-d');
      $saving = new Saving();
      $saving->SetSavingName($postdata['SavingName']);
      $saving->SetDescription($postdata['SavingDescription']);      
      $expense->SetAmount($postdata['Amount']);
      $saving->SetDate($savingDate);
      $saving->SetCategoryID($postdata['SavingCategory']['CategoryID']);
      $saving->SetUserID($loggedUser->GetUserID());
      $saving->SetIsActive(true);
      $savingManager = new SavingManager();
      $success = $savingManager->CreateSaving($saving);
      if($success){
          $message = "Successfully added";
      }
      else{
          $message = "Failed to add";
      }
    }
 
    function GetSavingCategoryNames($categories){
        $savingCategories = [];
        for ($i=0; $i < count($categories); $i++) {       
          if($categories[$i]->GetCategoryType() == CategoryType::Saving){
              $savingCategories[] = $categories[$i];
          }
        }       
        return $savingCategories;
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
?>  
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        savingCategories:'<?php echo $availableSavingCategories;?>',
        expenseCategories:'<?php echo $availableExpenseCategories;?>',
        message: {message:'<?php echo $message;?>', success: '<?php echo $success;?>'},
    });
</script> 
<div layout-md="row" layout-lg="row" ng-controller="MainController as Main">
  <form id="frmExpense" name="frmExpense" action="" method="post" flex ng-submit="Main.submitForm(frmExpense, $event)" novalidate>
    <input type="hidden" id="hdnExpense" name="hdnExpense" value="{{Main.expense}}" /> 
    <div flex>
     <h5 class="md-title">Add Expense</h5>
      <md-input-container class="md-block">    
        <label for="expenseName">Expense Name:</label>
        <input id="txtExpenseName" name="txtExpenseName" ng-model="Main.expense.ExpenseName" ng-required="true" />        
        <div ng-messages="frmExpense.txtExpenseName.$error" ng-show="true">
          <div ng-message="required">Expense Name is required.</div>
        </div>
      </md-input-container>
      <md-input-container class="md-block">
        <label for="expenseDescription">Description:</label>
        <textarea id="expenseDescription" ng-model="Main.expense.ExpenseDescription" placeholder="Description"></textarea>
      </md-input-container>        
      <md-datepicker id="dtExpenseDate" name="dtExpenseDate" md-placeholder="Select Date" ng-model="Main.expense.ExpenseDate" ng-required="true">
     </md-datepicker>  
      <div ng-show="frmExpense.dtExpenseDate.$error.required" class="required">Date is required.</div>  
      <md-input-container class="md-block">    
        <label for="txtExpenseAmount">Amount:</label>
        <input type="number" id="txtExpenseAmount" name="txtExpenseAmount" ng-model="Main.expense.Amount" ng-required="true" />        
        <div ng-messages="frmExpense.txtExpenseAmount.$error" ng-show="true">
          <div ng-message="required">Amount is required.</div>
        </div>
      </md-input-container>
      <md-input-container class="md-block">
        <md-select id="cmbExpenseCategory" name="cmbExpenseCategory" placeholder="Select Category" ng-model="Main.expense.ExpenseCategory" ng-required="true">
          <md-option ng-repeat="expenseCategory in Main.expenseCategories" ng-value="expenseCategory">
            {{expenseCategory.CategoryName}}
          </md-option>
        </md-select>
        <div ng-messages="frmExpense.cmbExpenseCategory.$error" ng-show="true">
          <div ng-message="required">Category is required.</div>
        </div>
      </md-input-container>
      <md-button type="submit" class="md-raised md-primary" ng-disabled="frmExpense.$invalid">Add Expense</md-button> 
    </div>
  </form>
  <form id="frmSaving" name="frmSaving" action="" method="post" flex ng-submit="Main.submitForm(frmSaving, $event)" novalidate>
    <input type="hidden" id="hdnSaving" name="hdnSaving" value="{{Main.saving}}" />  
    <div flex> 
       <h5 class="md-title">Add Saving</h5>
          <md-input-container class="md-block">
            <label for="savingName">Saving Name:</label>        
            <input id="txtSavingName" name="txtSavingName" ng-model="Main.saving.SavingName" ng-required="true"/>
            <div ng-messages="frmSaving.txtSavingName.$error" ng-show="true">
              <div ng-message="required">Saving Name is required.</div>
            </div>
          </md-input-container>
          <md-input-container class="md-block">
            <label for="savingDescription">Description:</label>
            <textarea id="savingDescription" ng-model="Main.saving.SavingDescription" placeholder="Description"></textarea>
          </md-input-container>
          <md-datepicker id="dtSaving" name="dtSaving" ng-model="Main.saving.SavingDate" md-placeholder="Select Date" ng-required="true">
          </md-datepicker> 
          <div ng-show="frmSaving.dtSaving.$error.required" class="required">Date is required.</div>  
          <md-input-container class="md-block">    
            <label for="txtSavingAmount">Amount:</label>
            <input type="number" id="txtSavingAmount" name="txtSavingAmount" ng-model="Main.saving.Amount" ng-required="true" />        
            <div ng-messages="frmExpense.txtSavingAmount.$error" ng-show="true">
              <div ng-message="required">Amount is required.</div>
            </div>
          </md-input-container>  
          <md-input-container class="md-block">
            <md-select id="cmbSaving" name="cmbSaving"  placeholder="Select Category"  ng-model="Main.saving.SavingCategory" ng-required="true">
              <md-option ng-repeat="savingCategory in Main.savingCategories" ng-value="savingCategory">
                {{savingCategory.CategoryName}}
              </md-option>
            </md-select>
            <div ng-messages="frmSaving.cmbSaving.$error" ng-show="true">
              <div ng-message="required">Category is required.</div>
            </div>
          </md-input-container>
         <md-button type="submit" class="md-raised md-primary" ng-disabled="frmSaving.$invalid">Add Saving</md-button>
    </div>
  </form>
</div>
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>

        

