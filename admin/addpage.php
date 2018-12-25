<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">

<div class="box round first grid">
<h2>Add New Pages</h2>
<div class="block">
<?php
 if(isset($_POST["submit"])){
   $pageName = ucfirst($_POST["name"]);
   $text = $_POST["text"];

  if(empty($pageName)){
     $emptypageName= "<span style='color:red'>Empty Page field</span>";
     }elseif (empty($text)) {
     $emptyText = "<span style='color:red'>Empty Text field</span";
     }else{
     class pageInertClass{
       private $tbl_name = "tbl_page";
       private $pageName;
       private $text;

       public function pageName($pageName){
         $this->pageName = $pageName;
       }
       public function text($text){
         $this->text = $text;
       }
       public function inertPageQuery(){
         $sql = "INSERT INTO $this->tbl_name(name,body) VALUES(:pageName,:text)";
         $stmt = db::blogPrepare($sql);
         $stmt->bindParam(":pageName",$this->pageName);
         $stmt->bindParam(":text",$this->text);
         return $stmt->execute();
       }
     }
     $pageInsertObj = new pageInertClass();
     $pageInsertObj->pageName($pageName);
     $pageInsertObj->text($text);
     $insertResult = $pageInsertObj->inertPageQuery();
     if($insertResult){
       echo "<h4 style='color:green'>You have successfully created ".$pageName." page</h4>";
     }else{
       echo "<h4 style='color:red'>Something went wrong..</h4>";
     }
  }//end of the validation code
}//end of the getting data
?>
<form action="" method="post">
<table class="form">
  <tr>
      <td>
        <br>
          <label>Page Name</label>
      </td>
      <td>
          <?php
           if(isset($emptypageName)){echo $emptypageName;}
           echo "<br />";
          ?>
          <input name='name' type="name" value="" class="medium" />
      </td>
  </tr>
  <tr>
      <td style="vertical-align: top; padding-top: 9px;">
          <br>
          <label>Content</label>
      </td>
      <td>
        <?php
         if(isset($emptyText)){echo $emptyText;}
         echo "<br />";
        ?>
          <textarea name="text" class="tinymce"></textarea>
      </td>
  </tr>
<tr>
      <td></td>
      <td>
          <input type="submit" name="submit" Value="Post" />
      </td>
  </tr>
</table>
</form>
</div>
</div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
  setupTinyMCE();
  setDatePicker('date-picker');
  $('input[type="checkbox"]').fancybutton();
  $('input[type="radio"]').fancybutton();
});
</script>
<script type="text/javascript">
$(document).ready(function () {
  setupLeftMenu();
setSidebarHeight();
});
</script>
<!-- /TinyMCE -->
<?php include("inc/footer.php");?>
