<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">

<div class="box round first grid">
<h2>Update Post</h2>
<div class="block">
<?php
if(isset($_GET['edit']) && $_GET["edit"] != NULL){
  $id = $_GET["edit"];
?>
<?php
class editPostClass{
  private $tbl_name = "tbl_post";
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
$editClassObj = new editPostClass();
$editClassObj->id($id);
$result = $editClassObj->selectQuery();
if($result){
 foreach ($result as $editValue) {
    $postId = $editValue["cat"];
    $user_id = $editValue["user_id"];
    if(session::get("role") == 1 || session::get("userID") == $user_id){
?>
<form action="edit-post-two.php?edit_two=<?php echo $id ;?>" method="post" enctype="multipart/form-data">
<table class="form">
  <tr>
      <td>
        <br>
          <label>Update Title</label>
      </td>
      <td>
          <?php
           if(isset($emptyTitle)){echo $emptyTitle;}
           echo "<br />";
          ?>
          <input name='title' type="text" value="<?php echo $editValue["title"]; ?>" class="medium" />
      </td>
  </tr>
  <tr>
      <td>
        <br>
          <label>Update Catagory</label>
      </td>
      <td>
        <?php
         if(isset($emptyCat)){echo $emptyCat;}
         echo "<br />";
        ?>
          <select id="select" name="catagory">
            <?php
              class editcatClass{
                private $tbl_name = "tbl_cat";
                private $postId;

                public function postId($postId){
                  $this->postId = $postId;
                }
                public function seleceditcat(){
                  $sql = "SELECT * FROM $this->tbl_name WHERE id=:postId";
                  $stmt = db::blogPrepare($sql);
                  $stmt->bindParam(":postId",$this->postId);
                  $stmt->execute();
                  return $stmt->fetchAll();
                }
              }
            $editcatClassObj =  new editcatClass();
            $editcatClassObj->postId($postId);
            $editResultCat = $editcatClassObj->seleceditcat();
            foreach ($editResultCat as $cateditid) {
            ?>
            <option value='<?php echo $cateditid["name"];?>'><?php echo $cateditid["name"];?></option>
            <?php
          }
             class selectCat{
               private $tbl_name = "tbl_cat";

               public function cat_select_query(){
                 $sql = "SELECT * FROM $this->tbl_name";
                 $stmt = db::blogPrepare($sql);
                 $stmt->execute();
                 return $stmt->fetchAll();
               }
             }
             $catObj = new selectCat();
             $catResult = $catObj->cat_select_query();
             foreach ($catResult as $value) { ?>
               <option value="<?php echo $value["name"]; ?>"><?php echo $value["name"]; ?></option>
          <?php } ?>
          </select>
      </td>
  </tr>
  <td></td>
    <td><img height="50px" width="auto" src="<?php echo $editValue['img']; ?>" alt=""></td>
  <tr>
      <td>
        <br>
          <label>Change Image</label>
      </td>
      <td>
          <?php
           if(isset($emptyInser)){echo $emptyInser;}
           if(isset($shortSize)){echo $shortSize;}
           if(isset($permit)){echo $permit;}
           echo "<br />";
          ?>
          <input value="" name="image" type="file" />
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
          <textarea name="text" class="tinymce"><?php if(isset($text)){echo $text;}else{ echo $editValue["body"];}?></textarea>
      </td>
  </tr>
<tr>
      <td></td>
      <td>
          <input type="submit" name="update" Value="Change" />
      </td>
  </tr>
</table>
</form>
<?php
}else{
  echo "<strong><p style='color:red;font-size:50px;line-height:20px;'>Error</p></strong><p style='font-size:25px;line-height:20px;'>Access Denied..!!</p>";
}
}//end of the head loop
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
