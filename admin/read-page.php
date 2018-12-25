<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">

<div class="box round first grid">
<h2>Update Page</h2>
<div class="block">
<?php
if(isset($_GET['pageId']) && $_GET["pageId"] != NULL){
  $id = $_GET["pageId"];
?>
<?php
  if(isset($_POST["delete"])){
    class deletePageClass{
      private $tbl_name = "tbl_page";
      private $id;
      public function id($id){
        $this->id = $id;
      }
      public function deleteQuery(){
        $sql = "DELETE FROM $this->tbl_name WHERE id=:id";
        $stmt = db::blogPrepare($sql);
        $stmt->bindParam(":id",$this->id);
        return $stmt->execute();
      }
    }
    $deletePageObj = new deletePageClass();
    $deletePageObj->id($id);
    $deletePageObj->deleteQuery();
    if($deletePageObj->deleteQuery()){
      echo "<script>alert('Page deleted successfully..')</script>";
      echo "<script>window.location = 'index.php';</script>";
    }else{
      echo "<h4 style='color:red'>Something went wrong....</h4>";
    }
  }
  if(isset($_POST["update"])){
    $pageName = $_POST["pageName"];
    $text = $_POST["body"];

    if(empty($pageName)){
     $emptypageName= "<span style='color:red'>Empty Page field</span>";
     }elseif (empty($text)) {
     $emptyText = "<span style='color:red'>Empty Text field</span";
     }else{
     class pageUpdateClass{
       private $tbl_name = "tbl_page";
       private $id;
       private $pageName;
       private $text;

       public function id($id){
         $this->id = $id;
       }
       public function pageName($pageName){
         $this->pageName = $pageName;
       }
       public function text($text){
         $this->text = $text;
       }
       public function updatePageQuery(){
         $sql = "UPDATE $this->tbl_name SET name=:pageName,body=:text WHERE id=:id";
         $stmt = db::blogPrepare($sql);
         $stmt->bindParam(":id",$this->id);
         $stmt->bindParam(":pageName",$this->pageName);
         $stmt->bindParam(":text",$this->text);
         return $stmt->execute();
       }
     }
     $pageInsertObj = new pageUpdateClass();
     $pageInsertObj->id($id);
     $pageInsertObj->pageName($pageName);
     $pageInsertObj->text($text);
     $updateResult = $pageInsertObj->updatePageQuery();
     if($updateResult){
       echo "<h4 style='color:green'>You have successfully updated ".$pageName." page</h4>";
     }else{
       echo "<h4 style='color:red'>Something went wrong..</h4>";
     }
  }//end of the validation code
}
?>
<?php
class editPageClass{
  private $tbl_name = "tbl_page";
  private $id;
  public function id($id){
    $this->id = $id;
  }
  public function selectQuery(){
    $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
    $stmt = db::blogPrepare($sql);
    $stmt->bindValue(":id",$this->id);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
$editClassObj = new editPageClass();
$editClassObj->id($id);
$result = $editClassObj->selectQuery();
if($result){
 foreach ($result as $editValue) {
?>
<form action="" method="post">
<table class="form">
  <tr>
      <td>
        <br>
          <label>Update Page Name</label>
      </td>
      <td>
          <?php if(isset($emptyTitle)){echo $emptyTitle;}?>
          <br>
          <input name='pageName' type="text" value="<?php echo $editValue["name"]; ?>" class="medium" />
      </td>
  </tr>
  <tr>
      <td style="vertical-align: top; padding-top: 9px;">
          <br>
          <label>Content</label>
      </td>
      <td>
        <?php if(isset($emptyText)){echo $emptyText;} ?>
        <br>
        <textarea name="body" class="tinymce"><?php if(isset($text)){echo $text;}else{ echo $editValue["body"];}?></textarea>
      </td>
  </tr>
<tr>
      <td></td>
      <td>
          <input type="submit" name="update" Value="Change" />
          <input onclick="return confirm('Are you sure to delete your page??')" type="submit" name="delete" Value="Delete" />
      </td>
  </tr>
</table>
</form>
<?php
}
}else{
echo "<span><span style='font-size:35px;color:red;'><strong>Error 404 <br /></strong></span><span style='font-size:35px'>Not found data <img src='img/icons8-crying-35.png' alt='' /><img src='img/icons8-crying-35.png' alt='' /> </span></span>";
}//End of the read data query
?>
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
<?php }else{ echo "<script>window.location='postlist.php'</script>";} ?>
<?php include("inc/footer.php");?>
