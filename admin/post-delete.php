<?php include("inc/header.php");?>
<?php include("inc/sidebar.php");?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Post Delete</h2>
        <div class="block">
<?php
 if(isset($_GET["delete"]) && $_GET["delete"] != NULL){
   $id = $_GET["delete"];
  class deletepicClass{
    private $tbl_name = "tbl_post";
    private $id;
    public function id($id){
      $this->id = $id;
    }
    public function deletepic(){
      $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
      $stmt = db::blogPrepare($sql);
      $stmt->bindParam(":id",$this->id);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $deletepicObj = new deletepicClass();
  $deletepicObj->id($id);
  $imgname = $deletepicObj->deletepic();
  foreach ($imgname as $value) {
    $user_id = $value["user_id"];
    $unlinkImg = $value["img"];
  }
if(session::get("role") == 1 || session::get("userID") == $user_id){
  if(isset($unlinkImg)){
  unlink($unlinkImg);
}
  class deleteClass{
    private $tbl_name = "tbl_post";
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
  $deleteClassObj = new deleteClass();
  $deleteClassObj->id($id);
  $result = $deleteClassObj->deleteQuery();
  if($result){
    echo "<script>window.location='postlist.php';</script>";
    $_SESSION['deleteccessPost'] = 1;
  }
}else{
   echo "<strong><p style='color:red;font-size:50px;line-height:20px;'>Error</p></strong><p style='font-size:25px;line-height:20px;'>Access Denied..!!</p>";
 }
}//else{
//  echo "<script>window.location='postlist.php';</script>";
//}
?>
</div>
</div>
</div>
<?php include("inc/footer.php");?>
