<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>Post</h2>
        <div class="block">
          <?php
            if(isset($_GET["view_post"]) && $_GET["view_post"] != NULL){
              $id = $_GET["view_post"];
          ?>
            <?php
              class showMsgClass{
                private $tbl_name = "tbl_post";
                private $id;
                public function id($id){
                  $this->id = $id;
                }
                public function showMsgQuery(){
                  $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
                  $stmt = db::blogPrepare($sql);
                  $stmt->bindValue(":id",$this->id);
                  $stmt->execute();
                  return $stmt->fetchAll();
                }
              }
              $selectMsgObj = new showMsgClass();
              $selectMsgObj->id($id);
              $showResult = $selectMsgObj->showMsgQuery();
              if($showResult){
                foreach ($showResult as $value) {
                  $msgId = $value['id'];
                  ?>
                <p><?php
                   echo $value['author'].'<br />';
                   echo $objFormat->dateFormat($value['date']).'<br />';
                   echo "<img src='".$value["img"]."' alt='' />";
                   echo '<p style="text-align:justify">'.$value['body'].'</p><br />';
                   ?>
                </p>
             <?php
           }
             }else{
               echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Something went wrong..!!</h3>";
             }
           }else{
             echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
           }?>
        </div>
    </div>
</div>
<?php
?>
<?php include("inc/footer.php");?>
