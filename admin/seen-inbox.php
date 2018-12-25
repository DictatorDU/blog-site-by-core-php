<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">
    <div class="box round first grid">
        <div class="block">
          <?php
          if(isset($_GET["seen"]) && $_GET["seen"] != NULL){
              $id = $_GET["seen"];
              $status = 1;
              class seenClass{
                private $tbl_name = "tbl_contact";
                private $id;
                private $status;
                public function id($id){
                  $this->id = $id;
                }
                public function status($status){
                  $this->status = $status;
                }

                public function seenQuery(){
                  $sql = "UPDATE $this->tbl_name SET status=:status WHERE id=:id";
                  $stmt = db::blogPrepare($sql);
                  $stmt->bindValue(":status",$this->status);
                  $stmt->bindValue(":id",$this->id);
                  return $stmt->execute();
                }
              }
              $seenObj = new seenClass();
              $seenObj->id($id);
              $seenObj->status($status);
              $seenObj->seenQuery();
              if($seenObj->seenQuery()){
                echo "<script>window.location='inbox.php?inbox';</script>";
              }
          }else{
            echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
          }
          ?>
       </div>
     </div>
</div>
<?php
unset($_SESSION['successDeletePage']);
?>
<?php include("inc/footer.php");?>
