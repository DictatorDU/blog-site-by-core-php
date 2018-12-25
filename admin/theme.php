<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
    <?php if(session::get("role") == 1){?>
        <h2>Theam</h2>
        <div class="block">
          <?php
           if(isset($_POST["submit"])){
             $theme =$_POST["theme"];
             class upThemeClass{
               private $tbl_name = "tbl_theme";
               private $theme;
               public function theme($theme){
                 $this->theme = $theme;
               }
               public function upQuery(){
                 $sql = "UPDATE $this->tbl_name SET theme=:theme";
                 $stmt = db::blogPrepare($sql);
                 $stmt->bindParam(":theme",$this->theme);
                 return $stmt->execute();
               }
             }
             $upClassObj = new upThemeClass();
             $upClassObj->theme($theme);
             $upClassObj->upQuery();
             if($upClassObj->upQuery()){
               echo "<h3 style='color:green'>You have successfully change your theme</h3>";
             }else{
               echo "<h3 style='color:red'>Something went wrong...</h3>";
             }
           }
           class checkedClass{
             private $tbl_name = "tbl_theme";
             public function selectQuery(){
               $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
               $stmt = db::blogPrepare($sql);
               $stmt->execute();
               return $stmt->fetchAll();
             }
           }
           $selectObj = new checkedClass();
           $selectObj->selectQuery();
           foreach ($selectObj->selectQuery() as $value) {
             $result = $value["theme"];
           }
          ?>
            <?php
             if(isset($_GET["theme"])){?>
               <form class="" action="" method="post">
                <input
                <?php
                if($result == "default"){
                  echo "checked ";
                }
                ?>
                type="radio" name="theme" value="default">Default <br>
                <input
                <?php
                if($result == "green"){
                  echo "checked ";
                }
                ?>
                type="radio" name="theme" value="green">Green <br>
                <input
                <?php
                if($result == "dark"){
                  echo "checked ";
                }
                ?>
                type="radio" name="theme" value="dark">Dark <br>
                <input
                <?php
                if($result == "red"){
                  echo "checked ";
                }
                ?>
                type="radio" name="theme" value="red">Red <br>
                <input style="padding:5px 10px;" type="submit" name="submit" value="Apply">
               </form>
            <?php } ?>
        </div>
      <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
      </div>
    </div>
</div>
<?php
unset($_SESSION["bg-change-success"]);
unset($_SESSION["bg-change-fail"]);
?>
<?php include("inc/footer.php");?>
