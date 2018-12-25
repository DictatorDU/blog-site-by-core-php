<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
      <?php if(session::get("role") == 1){?>
        <h2>Manage Slide</h2>
        <a href="slide-list.php?list"><img src="img/icons8-go-back-55.png" alt=""></a>
        <div class="block">
           <?php
           if(isset($_GET["slide-edit"]) && $_GET["slide-edit"] != NULL){
             $id = $_GET["slide-edit"];
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
               $titleSelect = $value["title"];
               $selectImg = $value["img"];
            }//End of the select data?>
            <form class="" action="slide-action.php?action-slide=<?php echo $id;?>" method="post" enctype="multipart/form-data">
              <table class="form">
                <tr>
                  <td>Slide title</td>
                  <td>
                    <input type="text" name="slide-title"  class="medium" value="<?php if(isset($titleSelect)){echo $titleSelect;}?>">
                  </td>
                </tr>
                <tr>
                  <td><br><br>
                    Slider
                  </td>
                  <td><br>
                    <img width="300px" src="<?php if(isset($selectImg)){echo $selectImg;}?>" alt=""><br>
                    <span style="color:green">(960px * 260px recomended for your slide image)</span><br><br>
                    <input type="file" name="slider" value="">
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <input type="submit" name="submit" value="Change">
                  </td>
                </tr>
              </table>
            </form>
          <?php } ?>
        <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
        </div>
    </div>
</div>
<?php
?>
<?php include("inc/footer.php");?>
