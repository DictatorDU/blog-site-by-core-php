<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
      <style media="screen">
        #testId{
          background-color:#E6F0F3;
          width:1119px;
          height:35px;
          margin:-10px;
          border-radius: 5px 5px 0px 0px;
        }
        #testId h3{
          display: inline;
        }
        #testId h3 a{
          padding: 0px 10px 15px 10px;
        }
        #active{
          color:#204562;
          background: #FFFFFF;
        }
      </style>
      <?php if(session::get("role") == 1){?>
      <?php if(isset($_GET["add-slider"])){?>
      <div id="testId"><h3><a id="active" href="slider.php?add-slider">New Slide</a></h3><h3><a href="slide-list.php?list">Slide list</a><h3></div>
        <div class="block">
          <?php
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
            if(empty($title)){
              echo "Empty title field";
            }elseif($file_size > 100){
              echo "File should be less than 100 kb..";
            }elseif(in_array($file_exe,$permitted) === false){
              echo "<span style='color:red'>You can uplode only ".implode(', ',$permitted)."</span>";
            }else{
            move_uploaded_file($tmp_name,$unique_name);
            class insertSlide{
              private $tbl_name = "tbl_slider";
              private $title;
              private $unique_name;

              public function title($title){
                $this->title = $title;
              }

              public function file_name($unique_name){
                $this->file_name = $unique_name;
              }

              public function insertQuery(){
                $sql = "INSERT INTO $this->tbl_name(title,img) VALUES(:title,:file_name)";
                $stmt = db::blogPrepare($sql);
                $stmt->bindParam(":title",$this->title);
                $stmt->bindParam(":file_name",$this->file_name);
                return $stmt->execute();
              }
            }
            $slideInserObj = new insertSlide();
            $slideInserObj->title($title);
            $slideInserObj->file_name($unique_name);
            $result = $slideInserObj->insertQuery();
            if($result){
              echo "<h1 style='color:green'>Slider inserted successfully...</h1>";
            }else{
              echo "<h1 style='color:red'>Something went wrong...</h1>";
            }
           }
          }
          ?>
           <form class="" action="" method="post" enctype="multipart/form-data">
             <table class="form">
               <tr>
                 <td>Slide title</td>
                 <td>
                   <input type="text" name="slide-title"  class="medium" value="">
                 </td>
               </tr>
               <tr>
                 <td><br>
                   Slider
                 </td>
                 <td>
                   <span style="color:green">(960px * 260px recomended for your slide image)</span><br>
                   <input type="file" name="slider" value="">
                 </td>
               </tr>
               <tr>
                 <td></td>
                 <td>
                   <input type="submit" name="submit" value="Update">
                 </td>
               </tr>
             </table>
           </form>
      <?php }else{
        echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
      } ?>
    <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
    </div>
</div>
<?php include("inc/footer.php");?>
