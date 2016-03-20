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
    $availableSavingCategories = '';
    $savingReports = '';

    if($loggedUser != null){
      $categoryManager = new CategoryManager();     
      $categories = $categoryManager->GetAllCategories($loggedUser->GetUserID());       
      $availableSavingCategories = json_encode(GetSavingCategoryNames($categories));      
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

    if ((isset($_POST["hdnReport"]) && !empty($_POST["hdnReport"]))){
        $postdata = json_decode($_POST['hdnReport'], true);     
        $from = $postdata['From'];
        $to = $postdata['To'];
        $categoryID =  $postdata['Category']['CategoryID'];
        $reportManager = new ReportManager();
        $reports = $reportManager->GetSavingsCategoryDateRange($loggedUser->GetUserID(), $from, $to, $categoryID);
        if($reports != null){
            if(count($reports) > 0){ 
              $savingReports = json_encode($reports);          
              $message = "Successfully generated the report";
              $success = true;
            }
            else{              
              $message = "Could not find any savings within the given range";
              $success = true;
            }
        }
        else{
          $message = "Failed to generate report. Check if you already have Savings.";
          $success = false;
        }
    }
?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo $message; ?>', success: '<?php echo $success; ?>'},        
        savingCategories:'<?php echo $availableSavingCategories;?>',
        savingReportData:'<?php echo $savingReports;?>',
    });
</script> 
<div layout-md="column" layout-lg="column" ng-controller="ReportController as Report">
  <div flex>
    <form id="frmSavingReport" name="frmSavingReport" action="" method="post" ng-submit="Report.submitForm(frmSavingReport, $event)" novalidate>
      <input type="hidden" id="hdnReport" name="hdnReport" value="{{Report.savingReport}}" /> 
      <div flex>
       <h5 class="md-title">Saving Report</h5>
        <md-datepicker id="dtFrom" name="dtFrom" md-placeholder="From" ng-model="Report.savingReport.From" ng-required="true" ng-change="Report.dateFromSavingChanged()">
       	</md-datepicker>  
        <span ng-show="frmSavingReport.dtFrom.$error.required" class="required">Date from is required.</span>
       	<md-datepicker id="dtTo" name="dtTo" md-placeholder="To" md-min-date="Report.savingReport.From" ng-model="Report.savingReport.To" ng-required="true">
       	</md-datepicker> 
        <span ng-show="frmSavingReport.dtTo.$error.required" class="required">Date to is required.</span>
       	<md-input-container class="md-block">
  	        <md-select id="cmbCategory" name="cmbCategory"  placeholder="Select Category"  ng-model="Report.savingReport.Category" ng-required="true">
  	          <md-option ng-repeat="savingCategory in Report.savingCategories" ng-value="savingCategory">
  	            {{savingCategory.CategoryName}}
  	          </md-option>
  	        </md-select>
            <div ng-messages="frmSavingReport.cmbCategory.$error" ng-show="true">
              <div ng-message="required">Category is required.</div>
            </div>
          </md-input-container>
        	<md-button type="submit" class="md-raised md-primary">Generate</md-button> 
      </div>
    </form>
  </div>
  <div flex ng-if="Report.savingReportData.length > 0">    
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
            Saving Name
          </th>
          <th>
            Saving Description
          </th>
          <th>
            Saving Date
          </th>
          <th>
            Amount
          </th>
        </tr>
      </thead>
      <tbody>
         <tr ng-repeat="reportData in Report.savingReportData">
          <td>
            {{reportData.CategoryName}}
          </td>
          <td>
            {{reportData.SavingName}}
          </td>
          <td>
            {{reportData.SavingDescription}}
          </td>
          <td>
            {{reportData.SavingDate}}
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