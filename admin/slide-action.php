<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">
    <div class="box round first grid">
      <?php if(session::get("role") == 1){?>
        <h2>Action</h2>
        <div class="block">
           <?php
           if(isset($_GET["action-slide"]) && $_GET["action-slide"] != NULL){
             $id = $_GET["action-slide"];
             if(isset($_POST["submit"])){
               $title = $_POST["slide-title"];
               $permitted = array('jpg','jpeg','png','gif');
               $file_name = $_FILES["slider"]["name"];
               $tmp_name = $_FILES["slider"]["tmp_name"];
               $file_size = filesize($tmp_name) *.0009765625;
               $div = explode('.',$file_name);
               $file_exe = strtolower(end($div));
               $unique = substr(md5(time()),0,10).".".$file_exe;
               $unique_name = "uploads/slideshow/".$unique;

               class selectFileClass{
                 private $tbl_name = "tbl_slider";
                 private $id;
                 public function id($id){
                   $this->id = $id;
                 }
                 public function selectQuery(){
                   $sql = "SELECT * FROM $this->tbl_name WHERE id=:id LIMIT 1";
                   $stmt = db::blogPrepare($sql);
                   $stmt->bindParam(":id",$this->id);
                   $stmt->execute();
                   return $stmt->fetchAll();
                 }
               }
               $selectObj = new selectFileClass();
               $selectObj->id($id);
               $selectResult = $selectObj->selectQuery();
               foreach ($selectResult as $value) {
                 $insertedImg = $value["img"];
               }
               if(!empty($file_name)){
                 if(empty($title)){
                   echo "Empty title field";
                 }elseif($file_size > 100){
                   echo "File should be less than 100 kb..";
                 }elseif(in_array($file_exe,$permitted) === false){
                   echo "<span style='color:red'>You can uplode only ".implode(', ',$permitted)."</span>";
                 }else{
                 move_uploaded_file($tmp_name,$unique_name);
                 class upimgfillClass{
                   private $tbl_name = "tbl_slider";
                   private $id;
                   private $title;
                   private $file;
                   public function id($id){
                     $this->id = $id;
                   }
                   public function title($title){
                     $this->title = $title;
                   }
                   public function file($unique_name){
                     $this->file = $unique_name;
                   }
                   public function upQuery(){
                     $sql = "UPDATE $this->tbl_name SET title=:title,img=:file WHERE id=:id";
                     $stmt = db::blogPrepare($sql);
                     $stmt->bindParam(":id",$this->id);
                     $stmt->bindParam(":title",$this->title);
                     $stmt->bindParam(":file",$this->file);
                     return $stmt->execute();
                   }
                 }
                 $notEmptyFileObj = new upimgfillClass();
                 $notEmptyFileObj->id($id);
                 $notEmptyFileObj->title($title);
                 $notEmptyFileObj->file($unique_name);
                 $presentFile = $notEmptyFileObj->upQuery();
                 if($presentFile){
                   $_SESSION['presentFile'] = 1;
                   echo "<script>window.location='slide-list.php?list';</script>";
                   if(!empty($insertedImg)){
                      unlink($insertedImg);
                  }
                 }
               }
            }else{
              if(empty($title)){
                echo "Empty title field";
              }else{
              class uptitleClass{
                private $tbl_name = "tbl_slider";
                private $id;
                private $title;
                public function id($id){
                  $this->id = $id;
                }
                public function title($title){
                  $this->title = $title;
                }
                public function upQuery(){
                  $sql = "UPDATE $this->tbl_name SET title=:title WHERE id=:id";
                  $stmt = db::blogPrepare($sql);
                  $stmt->bindParam(":id",$this->id);
                  $stmt->bindParam(":title",$this->title);
                  return $stmt->execute();
                }
              }
              $notEmptyFileObj = new uptitleClass();
              $notEmptyFileObj->id($id);
              $notEmptyFileObj->title($title);
              $absentFile = $notEmptyFileObj->upQuery();
              if($absentFile){
                $_SESSION['absentFile'] = 1;
                echo "<script>window.location='slide-list.php?list';</script>";
              }
            }
             }
            }
           }else{ echo "<script>index.php</script>";}
           ?>
         <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
        </div>
    </div>
</div>
<?php include("inc/footer.php");?>
