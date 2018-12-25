<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<?php
if(!isset($_GET["delete"]) || $_GET["delete"] == NULL){
  echo "";
}else{
  $id = $_GET["delete"];
  class deleteClass{
    private $tbl_name = "tbl_cat";
    private $id;
    public function id($id){
      $this->id = $id;
    }
    public function deleteQuery(){
      $sql = "DELETE FROM $this->tbl_name WHERE id=:id";
      $stmt = db::blogPrepare($sql);
      $stmt->bindParam(":id",$this->id);
      return $stmt->execute();
    }
  }
  $deleteObj = new deleteClass();
  $deleteObj->id($id);
  $deleteObj->deleteQuery();
  if($deleteObj->deleteQuery()){
    $_SESSION["deletedSuccess"] = 1;
  }
}
if(isset($_SESSION["deletedSuccess"])){
  echo "<script>window.location = 'catlist.php';</script>";
  $_SESSION['successDeleted'] = 1;
}
?>
