<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<?php if(session::get("role") == 1 || session::get("role") == 3){ ?>
<?php
if(isset($_GET['edit_two']) && $_GET["edit_two"] != NULL){
  $id = $_GET["edit_two"];
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
   foreach ($result as $editValue) {
      $aftereditedimg = $editValue["img"];
      $user_id = $editValue["user_id"];
      if(session::get("role") == 1 || session::get("userID") == $user_id){

?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update post</h2>
        <div class="block">
<?php

if(isset($_POST["update"])){
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

  class imgUnlinkClass{
    private $tbl_name = "tbl_post";
    private $id;
    public function id($id){
      $this->id = $id;
    }
    public function selectImg(){
      $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
      $stmt = db::blogPrepare($sql);
      $stmt->bindValue(":id",$this->id);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $imgselectObj = new imgUnlinkClass();
  $imgselectObj->id($id);
  $imgName = $imgselectObj->selectImg();
  foreach ($imgName as $Imgvalue) {
   $imgResult = $Imgvalue["img"];
  }
  if(!empty($file_name)){
     if(empty($title)){
      $emptyTitle = "<span style='color:red'>Empty title field</span>";
     }elseif (empty($catagory)) {
      $emptyCat = "<span style='color:red'>Empty Catagory field</span>";
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
      private $id;
      private $author;
      private $title;
      private $catagoryID;
      private $unique_name;
      private $text;

      public function id($id){
        $this->id = $id;
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
        $sql = "UPDATE $this->tbl_name SET title=:title,cat=:catID,body=:txt,img=:file_name,author=:author WHERE id=:id";
        $stmt = db::blogPrepare($sql);
        $stmt->bindParam(":id",$this->id);
        $stmt->bindParam(":catID",$this->catagoryID);
        $stmt->bindParam(":title",$this->title);
        $stmt->bindParam(":file_name",$this->file_name);
        $stmt->bindParam(":author",$this->author);
        $stmt->bindParam(":txt",$this->text);
        return $stmt->execute();
      }
     }//End of the insert class
     $insert_post_onj = new insertPost();
     $insert_post_onj->id($id);
     $insert_post_onj->author($author);
     $insert_post_onj->title($title);
     $insert_post_onj->catagoryID($catagoryID);
     $insert_post_onj->file_name($unique_name);
     $insert_post_onj->text($text);
     $result = $insert_post_onj->insertQuery();
     if($result){
       if(!empty($imgResult)){
         unlink($imgResult);
       }
      $_SESSION["successupdatepost"] = 1;
      echo "<script>window.location = 'postlist.php'</script>";
     }else{
      echo "<h3 style='color:red'>Something went wrong</h3>";
     }
     }//end of the validation code
}else{
     if(empty($title)){
       $emptyTitle = "<span style='color:red'>Empty title field</span>";
     }elseif (empty($catagory)) {
       $emptyCat = "<span style='color:red'>Empty Catagory field</span>";
     }elseif (empty($text)) {
     $emptyText = "<span style='color:red'>Empty Text field</span";
     }else{
     class insertPostlseeimg{
       private $tbl_name = "tbl_post";
       private $id;
       private $author;
       private $title;
       private $catagoryID;
       private $imgResult;
       private $text;

       public function id($id){
         $this->id = $id;
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
       public function imgResult($imgResult){
         $this->imgResult = $imgResult;
       }
       public function text($text){
         $this->text = $text;
       }
       public function insertQuery(){
         $sql = "UPDATE $this->tbl_name SET title=:title,cat=:catID,body=:txt,img=:file_name,author=:author WHERE id=:id";
         $stmt = db::blogPrepare($sql);
         $stmt->bindParam(":id",$this->id);
         $stmt->bindParam(":catID",$this->catagoryID);
         $stmt->bindParam(":title",$this->title);
         $stmt->bindParam(":file_name",$this->imgResult);
         $stmt->bindParam(":author",$this->author);
         $stmt->bindParam(":txt",$this->text);
         return $stmt->execute();
       }
     }//End of the insert class
     $insert_post_obj = new insertPostlseeimg();
     $insert_post_obj->id($id);
     $insert_post_obj->author($author);
     $insert_post_obj->title($title);
     $insert_post_obj->catagoryID($catagoryID);
     $insert_post_obj->imgResult($imgResult);
     $insert_post_obj->text($text);
     $result = $insert_post_obj->insertQuery();
     if($result){
       $_SESSION["successupdatepost"] = 1;
       echo "<script>window.location = 'postlist.php'</script>";
     }else{
       echo "<h3 style='color:red'>Something went wrong</h3>";
     }
   }//end of the validation code when empty file
}
}//end of the getting data

?>
</div>
</div>
</div>
<?php
}else{ echo "<script>window.location = 'postlist.php'</script>";}
}
}
?>
<?php
}else{
  echo "<script>window.location='index.php';</script>";
}
?>
<?php include("inc/footer.php");?>
