<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">

<div class="box round first grid">
<h2>Add New Post</h2>
<div class="block">
<?php
 if(isset($_POST["submit"])){
   $userID = session::get('userID');
   $author = session::get('username');
   $title = $_POST["title"];
   $catagory = $_POST["catagory"];
   $permitted = array('jpg','jpeg','png','gif');
   $file_name = $_FILES["image"]["name"];
   $file_size = $_FILES["image"]["size"];
   $tmp_name = $_FILES["image"]["tmp_name"];
   $div = explode('.',$file_name);
   $file_exe = strtolower(end($div));
   $unique = substr(md5(time()),0,10).".".$file_exe;
   $unique_name = "uploads/".$unique;
   $text = $_POST["text"];

  class selectCatId{
    private $tbl_name = "tbl_cat";
    private $catagory;
    public function catagory($catagory){
      $this->catagory = $catagory;
    }
    public function cat_id_query(){
      $sql = "SELECT * FROM $this->tbl_name WHERE name=:catagory";
      $stmt = db::blogPrepare($sql);
      $stmt->bindParam(":catagory",$this->catagory);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $catagoryselectObj = new selectCatId();
  $catagoryselectObj->catagory($catagory);
  $catagoryResult = $catagoryselectObj->cat_id_query();
  foreach ($catagoryResult as $value) {
    $catagoryID = $value["id"];
 }

   if(empty($title)){
     $emptyTitle = "<span style='color:red'>Empty title field</span>";
   }elseif (empty($catagory)) {
     $emptyCat = "<span style='color:red'>Empty Catagory field</span>";
   }elseif(empty($file_name)){
    $emptyInser = "<span style='color:red'>Please select a picture</span>";
   }elseif ($file_size>103690) {
    $shortSize = "<span style='color:red'>File size should be less than 100 KB</span>";
   }elseif (in_array($file_exe,$permitted) === false) {
    $permit = "<span style='color:red'>You can uplode only ".implode(', ',$permitted)."</span>";
   }elseif (empty($text)) {
   $emptyText = "<span style='color:red'>Empty Text field</span";
 }else{
   move_uploaded_file($tmp_name,$unique_name);
   class insertPost{
     private $tbl_name = "tbl_post";
     private $userID;
     private $author;
     private $title;
     private $catagoryID;
     private $unique_name;
     private $text;

     public function userID($userID){
       $this->userID = $userID;
     }
     public function author($author){
       $this->author = $author;
     }
     public function title($title){
       $this->title = $title;
     }
     public function catagoryID($catagoryID){
       $this->catagoryID = $catagoryID;
     }
     public function file_name($unique_name){
       $this->file_name = $unique_name;
     }
     public function text($text){
       $this->text = $text;
     }
     public function insertQuery(){
       $sql = "INSERT INTO $this->tbl_name(user_id,cat,title,body,img,author) VALUES(:userID,:catID,:title,:txt,:file_name,:author)";
       $stmt = db::blogPrepare($sql);
       $stmt->bindParam(":userID",$this->userID);
       $stmt->bindParam(":catID",$this->catagoryID);
       $stmt->bindParam(":title",$this->title);
       $stmt->bindParam(":file_name",$this->file_name);
       $stmt->bindParam(":author",$this->author);
       $stmt->bindParam(":txt",$this->text);
       return $stmt->execute();
     }
   }//End of the insert class
   $insert_post_onj = new insertPost();
   $insert_post_onj->userID($userID);
   $insert_post_onj->author($author);
   $insert_post_onj->title($title);
   $insert_post_onj->catagoryID($catagoryID);
   $insert_post_onj->file_name($unique_name);
   $insert_post_onj->text($text);
   $result = $insert_post_onj->insertQuery();
   if($result){
     echo "Inserted data";
   }else{
     echo "Something went wrong";
   }
 }//end of the validation code
 }//end of the getting data
?>
<form action="" method="post" enctype="multipart/form-data">
<table class="form">
  <tr>
      <td>
        <br>
          <label>Title</label>
      </td>
      <td>
          <?php
           if(isset($emptyTitle)){echo $emptyTitle;}
           echo "<br />";
          ?>
          <input name='title' type="text" value="<?php if(isset($title)){echo $title;}?>" class="medium" />
      </td>
  </tr>
  <tr>
      <td>
        <br>
          <label>Category</label>
      </td>
      <td>
        <?php
         if(isset($emptyCat)){echo $emptyCat;}
         echo "<br />";
        ?>
          <select id="select" name="catagory">
            <option value="">Select Catagory</option>
            <?php
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
  <tr>
      <td>
        <br>
          <label>Upload Image</label>
      </td>
      <td>
          <?php
           if(isset($emptyInser)){echo $emptyInser;}
           if(isset($shortSize)){echo $shortSize;}
           if(isset($permit)){echo $permit;}
           echo "<br />";
          ?>
          <input value="<?php if(isset($file_name)){echo $file_name;}?>" name="image" type="file" />
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
          <textarea name="text" class="tinymce"><?php if(isset($text)){echo $text;}?></textarea>
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
