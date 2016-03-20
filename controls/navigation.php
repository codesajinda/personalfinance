<form layout="column" id="frmLogout" name="frmLogout" action="<?php echo $_SESSION['siteUrl'] .'logout.php'?>" method="post">
<md-menu-bar>
  <?php   
    echo HtmlHelper::BuildNavigation();
    echo HtmlHelper::LogoutButton();   
 ?>
</md-menu-bar>

</form>