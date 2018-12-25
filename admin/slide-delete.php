<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
      <?php if(session::get("role") == 1){?>
        <h2></h2>
        <div class="block">
           <?php
           if(isset($_GET["delete-slide"]) && $_GET["delete-slide"] != NULL){
             $id = $_GET["delete-slide"];
             class selectClass{
               private $tbl_name = "tbl_slider";
               private $id;

               public function id($id){
                 $this->id = $id;
               }
               public function selectQuery(){
                 $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
                 $stmt = db::blogPrepare($sql);
                 $stmt->bindParam(":id",$this->id);
                 $stmt->execute();
                 return $stmt->fetchAll();
               }
             }
             $selectObj = new selectClass();
             $selectObj->id($id);
             $resultSelect = $selectObj->selectQuery();
             foreach ($resultSelect as $value) {
               $imgName = $value["img"];
             }
             class delClass{
               private $tbl_name = "tbl_slider";
               private $id;
               public function id($id){
                 $this->id = $id;
               }
               public function delQuery(){
                 $sql = "DELETE FROM $this->tbl_name WHERE id=:id";
                 $stmt = db::blogPrepare($sql);
                 $stmt->bindParam(":id",$this->id);
                 return $stmt->execute();
               }
             }
             $slideDelObj = new delClass();
             $slideDelObj->id($id);
             $result = $slideDelObj->delQuery();
             if($result){
               unlink($imgName);
               $_SESSION["delsliderSuc"] = 1;
               echo "<script>window.location='slide-list.php?list';</script>";
             }else{
               echo "Something went wrong..";
             }
           }else{
             echo "Error";
           }
           ?>
         <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
        </div>
    </div>
</div>
<?php include("inc/footer.php");?>
