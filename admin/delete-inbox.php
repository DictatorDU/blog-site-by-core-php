<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>
        <a href="inbox.php"><img src="img/icons8-go-back-55.png" alt=""></a>
        <div class="block">
          <?php
           if(isset($_GET["delete_from_inbox"]) && $_GET["delete_from_inbox"] != NULL){
               $id = $_GET["delete_from_inbox"];
               class deleteClassMsg{
                 private $tbl_name = "tbl_contact";
                 private $id;
                 public function id($id){
                   $this->id = $id;
                 }
                 public function delSmsQuery(){
                   $sql = "DELETE FROM $this->tbl_name WHERE id=:id";
                   $stmt = db::blogPrepare($sql);
                   $stmt->bindValue(":id",$this->id);
                   return $stmt->execute();
                 }
               }
              $delMsgObj = new deleteClassMsg();
              $delMsgObj->id($id);
              $delMsgObj->delSmsQuery();
              if($delMsgObj->delSmsQuery()){
                echo "<script>window.location = 'inbox.php?inbox';</script>";
              }
           }elseif(isset($_GET["delete_from_seen"]) && $_GET["delete_from_seen"] != NULL){
               $id = $_GET["delete_from_seen"];
               class deleteClassMsg{
                 private $tbl_name = "tbl_contact";
                 private $id;
                 public function id($id){
                   $this->id = $id;
                 }
                 public function delSmsQuery(){
                   $sql = "DELETE FROM $this->tbl_name WHERE id=:id";
                   $stmt = db::blogPrepare($sql);
                   $stmt->bindValue(":id",$this->id);
                   return $stmt->execute();
                 }
               }
              $delMsgObj = new deleteClassMsg();
              $delMsgObj->id($id);
              $delMsgObj->delSmsQuery();
              if($delMsgObj->delSmsQuery()){
                echo "<script>window.location = 'inbox.php?seen';</script>";
              }
            }else{
              echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
           }
          ?>
      </div>
   </div>
</div>
<?php include("inc/footer.php");?>
