<?php 
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php'); 
    require_once($_SESSION['documentRoot'] .'/Utility/UserHelper.php'); 
    require_once($_SESSION['documentRoot'] .'/BLLManager/WidgetManager.php'); 
    require_once($_SESSION['documentRoot'] .'/BLLManager/ReportManager.php'); 

    $loggedUser = UserHelper::Authenticate();
    $message = '';  
    $success = '';  
    $expenseSavings = ''; 
    $expenseReport = '';

    if($loggedUser != null){ 
      $widgetData = GetWidgetData($loggedUser);       
      if($widgetData != null){
          $message = 'Successfully loaded data';
          $success = true;
          $expenseSavings = json_encode($widgetData);
      }
      else{
          $message = 'Failed to load data';
          $success = false;
      }
    }

    function GetWidgetData($loggedUser){
      $widgetManager = new WidgetManager();
      $widgetData = $widgetManager->GetWidgetData($loggedUser->GetUserID());  
      return $widgetData;
    }

?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo $message; ?>', success: '<?php echo $success; ?>'},  
        expenseSavings:'<?php echo $expenseSavings;?>',
    });
</script> 
<div layout-md="row" layout-lg="row" ng-controller="WidgetController as Widget"> 
  <div ng-cloak flex>
    <md-content>
      <md-tabs md-dynamic-height md-border-bottom>
        <md-tab label="summary">
          <md-content class="md-padding">
            <h1 class="md-title">Savings and Expenses</h1>
            <div layout="row">
               <md-card flex>
                <md-card-title>
                  <md-card-title-text>
                    <span class="md-headline">Expenses</span>
                    <span class="md-display-1 red-text"><strong>{{ Widget.widgetOneExpense }}</strong></span>
                  </md-card-title-text>       
              </md-card> 
               <md-card flex>
                <md-card-title>
                  <md-card-title-text>
                    <span class="md-headline">Savings</span>
                    <span class="md-display-1" ng-class="Widget.widgetOneSavingsClass"><strong>{{ Widget.widgetOneSavings }}</strong></span>
                  </md-card-title-text>       
              </md-card>   
            </div> 
          </md-content>
        </md-tab>
        <md-tab label="monthly savings and expenses">
          <md-content class="md-padding">
            <h1 class="md-title">Monthly Savings and Expenses</h1>
            <h4>Expenses for the period {{ Widget.lastMonthDate | date : 'dd/MM/yyyy' }} - {{ Widget.todaysDate | date : 'dd/MM/yyyy' }} </h4>
            <table>
              <thead>
                <th>Category</th>
                <th>Expense Name</th>
                <th>Expense Description</th>
                <th>Amount</th>
              </thead>
              <tbody>
                <tr ng-repeat="currentMonthExpense in Widget.currentMonthExpenses" >
                  <td>{{currentMonthExpense.CategoryName}}</td>
                  <td>{{currentMonthExpense.ExpenseName}}</td>
                  <td>{{currentMonthExpense.ExpenseDescription}}</td>
                  <td class="red-text">{{currentMonthExpense.Amount}}</td>
                </tr>
              </tbody>
            </table>  
            <br/>          
            <md-divider></md-divider>
            <h4>Savings for the period {{ Widget.lastMonthDate | date : 'dd/MM/yyyy' }} - {{ Widget.todaysDate | date : 'dd/MM/yyyy' }} </h4>
            <table>              
              <thead>
                <th>Category</th>
                <th>Saving Name</th>
                <th>Saving Description</th>
                <th>Amount</th>
              </thead>
              <tbody>
                <tr ng-repeat="currentMonthSaving in Widget.currentMonthSavings" >
                  <td>{{currentMonthSaving.CategoryName}}</td>
                  <td>{{currentMonthSaving.SavingName}}</td>
                  <td>{{currentMonthSaving.SavingDescription}}</td>
                  <td class="green-text">{{currentMonthSaving.Amount}}</td>
                </tr>
              </tbody>
            </table>
            <br/>          
            <md-divider></md-divider>
            <h4>You saved : <span ng-class="Widget.widgetTwoSavingsClass">{{ Widget.expenseOrSaving }}</h4>
          </md-content>
        </md-tab>
      </md-tabs>
    </md-content>
  </div>
</div>

<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>