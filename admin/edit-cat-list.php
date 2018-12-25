<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<?php if(session::get("role") == 1 || session::get("role") == 3){ ?>
<div class="grid_10">
    <div class="box round first grid">
      <h2>Change Category</h2>
     <div class="block copyblock">
      <?php
       if(!isset($_GET["cat_id"]) || $_GET["cat_id"] == NULL){
         echo "<script>window.location = 'catlist.php';</script>";
       }else{
         $id = $_GET["cat_id"];

         if(isset($_POST['update'])){
           $catname = $_POST["addCat"];

         class editcatClass{
           private $tbl_name = "tbl_cat";
           private $id;
           public function id($id){
             $this->id = $id;
           }
           public function catname($catname){
             $this->catname = $catname;
           }
           public function editcatUpdate(){
             $sql = "UPDATE $this->tbl_name SET name=:catname WHERE id=:id";
             $stmt = db::blogPrepare($sql);
             $stmt->bindParam(":catname",$this->catname);
             $stmt->bindParam(":id",$this->id);
             return $stmt->execute();
           }
         }
         $editClssObj = new editcatClass();
         $editClssObj->id($id);
         $editClssObj->catname($catname);
         $updateResult = $editClssObj->editcatUpdate();
         if($updateResult){
           echo "<script>window.location = 'catlist.php';</script>";
           $_SESSION['successEdit'] = 1;
         }
       }
       class editselectClass{
         private $tbl_name = "tbl_cat";
         private $id;
         public function id($id){
           $this->id = $id;
         }
         public function editselectQuery(){
           $sql = "SELECT * FROM $this->tbl_name WHERE id=:id LIMIT 1";
           $stmt = db::blogPrepare($sql);
           $stmt->bindParam(":id",$this->id);
           $stmt->execute();
           return $stmt->fetchAll();
         }
       }//End of the select class
       $edit_Select_Obj = new editselectClass();
       $edit_Select_Obj->id($id);
       $result = $edit_Select_Obj->editselectQuery();
       foreach ($result as $value) {
          $catValue  = $value["name"];
       }//End of the loop

         ?>
         <form action="" method="post">
            <table class="form">
            <tr>
                <td>
                    <input type="text" name="addCat" value="<?php if(isset($catValue)){echo $catValue;} ?>" class="medium" />
                </td>
            </tr>
             <tr>
                <td>
                    <input type="submit" name="update" Value="Save" />
                </td>
            </tr>
            </table>
            </form>
        </div>
      <?php } ?>
    </div>
</div>
<?php
}else{
  echo "<script>window.location='index.php';</script>";
}
?>
<?php include("inc/footer.php");?>
