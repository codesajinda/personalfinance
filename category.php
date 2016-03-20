<?php
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php');            
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');    
    require_once($_SESSION['documentRoot'] .'/Objects/CategoryType.php');   
    require_once($_SESSION['documentRoot'] .'/Objects/Category.php');  
    require_once($_SESSION['documentRoot'] .'/BLLManager/ReportManager.php');
    require_once($_SESSION['documentRoot'] .'/BLLManager/CategoryManager.php');

    $loggedUser = UserHelper::Authenticate();
    $categoryManager = new CategoryManager();
    $message = '';  
    $success = '';   
    $availableCategories = '';

    if($loggedUser != null){
      $availableCategories = GetAllCategories($categoryManager, $loggedUser );
    }    

    if ((isset($_POST["hdnCategory"]) && !empty($_POST["hdnCategory"]))){
        $postdata = json_decode($_POST['hdnCategory'], true); 
        $category = new Category();
        $category->SetUserID($loggedUser->GetUserID());
        $category->SetCategoryName($postdata['CategoryName']);
        $category->SetCategoryType($postdata['CategoryType']['key']);
        $category->SetIsActive(1);
        $success = $categoryManager->CreateCategory($category);
        if($success){
          $message = "Successfully added";
          $availableCategories = GetAllCategories($categoryManager, $loggedUser);
        }
        else{
            $message = "Failed to add";
        }
    }

    function GetAllCategories($categoryManager, $loggedUser){      
      $categories = $categoryManager->GetAllCategories($loggedUser->GetUserID());       
      return json_encode(GetCategoriesWithCategoryTypes($categories));
    }

    function GetCategoriesWithCategoryTypes($categories)
    {
      $categoriesWithCategoryTypes = [];
      for ($i=0; $i < count($categories) ; $i++) { 
        $category = $categories[$i];
        $category->SetCategoryType(GetCategoryType($category->GetCategoryType()));
        $categoriesWithCategoryTypes[] = $category;
      }
      return $categoriesWithCategoryTypes;
    }

    function GetCategoryType($categoryType){
      $categoryTypeName = '';
      switch ($categoryType) {
        case CategoryType::Saving:
          $categoryTypeName = 'Saving';
          break;
        case CategoryType::Expense:
          $categoryTypeName = 'Expense';
          break;
        default:
          break;
      }
      return $categoryTypeName;
    }
?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo $message; ?>', success: '<?php echo $success; ?>'},        
        categories:'<?php echo $availableCategories;?>',
    });
</script> 
<div layout-md="column" layout-lg="column" ng-controller="CategoryController as Category">
  <div flex>
    <form id="frmCategory" name="frmCategory" action="" method="post" ng-submit="Report.submitForm(frmExpenseReport, $event)" novalidate>
      <input type="hidden" id="hdnCategory" name="hdnCategory" value="{{Category.category}}" />
      <div flex>
       <h5 class="md-title">Category</h5>
          <md-input-container class="md-block">    
            <label for="categoryName">Category Name:</label>
            <input id="txtCategoryName" name="txtCategoryName" ng-model="Category.category.CategoryName" ng-required="true" />        
            <div ng-messages="frmCategory.txtCategoryName.$error" ng-show="true">
              <div ng-message="required">Category Name is required.</div>
            </div>
          </md-input-container>
          <md-input-container class="md-block">
            <md-select id="cmbCategory" name="cmbCategory"  placeholder="Select Category Type"  ng-model="Category.category.CategoryType" ng-required="true">
              <md-option ng-repeat="categoryType in Category.categoryTypes" ng-value="categoryType">
                {{categoryType.value}}
              </md-option>
            </md-select>
            <div ng-messages="frmCategory.cmbCategory.$error" ng-show="true">
              <div ng-message="required">Category Type is required.</div>
            </div>
          </md-input-container>
        	<md-button type="submit" class="md-raised md-primary">Create</md-button> 
      </div>
    </form>
  </div>
  <div flex ng-if="Category.categories.length > 0">    
    <table cellpadding="0" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>
            Category Name
          </th>  
          <th>
            Category Type
          </th>        
        </tr>
      </thead>
      <tbody>
         <tr ng-repeat="category in Category.categories">
          <td>
            {{category.CategoryName}}
          </td>
          <td>
            {{category.CategoryType}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>