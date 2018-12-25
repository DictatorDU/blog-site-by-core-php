<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">
<div class="box round first grid">
<h2>Update Site Title and Description</h2>
<div class="block sloginblock">
  <?php
  class selectClass{
    private $tbl_name = "tbl_slogan";
    public function selectQuery(){
      $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
      $stmt = db::blogPrepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $selectObj = new selectClass();
  $selectResult = $selectObj->selectQuery();
  foreach ($selectResult as $selectValue) {
    $imgName = $selectValue["logo"];
  ?>
  <?php
    if(isset($_POST["submit"])){
      $web_name = $_POST["title"];
      $slogan = $_POST["slogan"];
      $permitted = array('jpg','jpeg','png','gif');
      $file_name = $_FILES["logo"]["name"];
      $file_size = $_FILES["logo"]["size"];
      $tmp_name = $_FILES["logo"]["tmp_name"];
      $div = explode('.',$file_name);
      $file_exe = strtolower(end($div));
      $unique = substr(md5(time()),0,10).".".$file_exe;
      $unique_name = "uploads/theam-icon/".$unique;

      if(!empty($file_name)){
      if(empty($web_name)){
        $emptyweb_name = "Empty title field";
      }elseif(empty($slogan)){
        $emptySlogan = "Slogan field is empty";
      }elseif(empty($file_name)){
        $emptylogp = "Empty Logo field";
      }elseif($file_size>103690){
        $bigSizeLogo = "Logo size should be less than 100kb";
      }elseif(in_array($file_exe,$permitted) === false){
        $permit = "<span style='color:red'>You can uplode only ".implode(', ',$permitted)."</span>";
      }else{
        move_uploaded_file($tmp_name,$unique_name);
        class updatecontentFairs{
          private $tbl_name = "tbl_slogan";
          private $web_name;
          private $slogan;
          private $file_name;

          public function web_name($web_name){
            $this->web_name = $web_name;
          }
          public function slogan($slogan){
            $this->slogan = $slogan;
          }
          public function file_name($unique_name){
            $this->file_name = $unique_name;
          }
          public function updatequery(){
            $sql = "UPDATE $this->tbl_name SET web_name=:web_name,slogan=:slogan,logo=:file_name";
            $stmt = db::blogPrepare($sql);
            $stmt->bindParam(":web_name",$this->web_name);
            $stmt->bindParam(":slogan",$this->slogan);
            $stmt->bindParam(":file_name",$this->file_name);
            return $stmt->execute();
          }
        }
        $updatefObj = new updatecontentFairs();
        $updatefObj->web_name($web_name);
        $updatefObj->slogan($slogan);
        $updatefObj->file_name($unique_name);
        $uploadfresult = $updatefObj->updatequery();
        if($uploadfresult){
          echo "<script>window.location='titleslogan.php';</script>";
          unlink($imgName);
          echo "<h4 style='color:green'>You have successfully updated</h4>";
        }else{
          echo "<h4 style='color:red'>Something went wrong..</h4>";
        }
      }
  }else{
      if(empty($web_name)){
        $emptyweb_name = "Empty title field";
      }elseif(empty($slogan)){
        $emptySlogan = "Slogan field is empty";
      }else{
      class updateSecondClass{
        private $tbl_name = "tbl_slogan";
        private $web_name;
        private $slogan;
        private $fileName;
        public function web_name($web_name){
          $this->web_name = $web_name;
        }
        public function slogan($slogan){
          $this->slogan = $slogan;
        }
        public function fileName($imgName){
          $this->fileName = $imgName;
        }
        public function updateQuerySecond(){
          $sql = "UPDATE $this->tbl_name SET web_name=:web_name,slogan=:slogan,logo=:fileName";
          $stmt = db::blogPrepare($sql);
          $stmt->bindParam(":web_name",$this->web_name);
          $stmt->bindParam(":slogan",$this->slogan);
          $stmt->bindParam(":fileName",$this->fileName);
          return $stmt->execute();
        }
      }//End of the class
      $secondObj = new updateSecondClass();
      $secondObj->slogan($slogan);
      $secondObj->web_name($web_name);
      $secondObj->fileName($imgName);
      $secondResult = $secondObj->updateQuerySecond();
      if($secondResult){
        echo "<script>window.location='titleslogan.php';</script>";
        echo "<h4 style='color:green'>You have successfully updated</h4>";
      }else{
        echo "<h4 style='color:red'>Something went wrong..</h4>";
      }
    }//End of the validation
    }//End of the conditation 'if file field empty'
  }//end of the getting data
  ?>

<form action="" method="post" enctype="multipart/form-data">
  <table class="form">
      <tr>
          <td>
              <label>Website Title</label>
          </td>
          <td>
              <input type="text" value="<?php echo $selectValue["web_name"];?>" name="title" class="medium" />
          </td>
      </tr>
    	 <tr>
          <td>
              <label>Website Slogan</label>
          </td>
          <td>
              <input type="text" value="<?php echo $selectValue["slogan"];?>" name="slogan" class="medium" />
          </td>
      </tr>
      <tr>
        <td></td>
        <td> <img src="<?php echo $selectValue["logo"];?>" alt=""></td>
      </tr>
    	 <tr>
          <td>
              <label>Web logo</label>
          </td>
          <td>
              <input type="file" name="logo" value="">
          </td>
      </tr>
    	 <tr>
          <td>
          </td>
          <td>
              <input type="submit" name="submit" Value="Update" />
          </td>
      </tr>
  </table>
  </form>
</div>
</div>
</div>
<?php } ?>
<?php include("inc/footer.php");?>
