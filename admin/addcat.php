<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
        <div class="grid_10">

            <div class="box round first grid">
                <h2>Add New Category</h2>
               <div class="block copyblock">
                 <?php
                  if(isset($_POST["submit"])){
                    $addcat = $_POST["addCat"];
                    if(empty($addcat)){
                      echo "<h4 style='color:red'>Empty Catagory field</h4>";
                    }else{
                    class addCatClass{
                      private $tbl_name = "tbl_cat";
                      private $addcat;

                      public function cat($addcat){
                        $this->addcat = $addcat;
                      }

                      public function addcatlogue(){
                        $sql = "INSERT INTO $this->tbl_name(name) VALUES(:cat)";
                        $stmt = db::blogPrepare($sql);
                        $stmt->bindParam(":cat",$this->addcat);
                        return $stmt->execute();
                      }
                    }
                    $insertCatObj = new addCatClass();
                    $insertCatObj->cat($addcat);
                    $result = $insertCatObj->addcatlogue();
                    if($result){
                      echo "<script>window.location = 'catlist.php';</script>";
                      $_SESSION["addedSuccess"] = 1;
                    }else{
                      echo "<h4 style='color:red'>Something Went wrong</h4>";
                    }
                   }
                  }
                 ?>
                 <form action="" method="post">
                    <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="addCat" placeholder="Enter Category Name..." class="medium" />
                        </td>
                    </tr>
				             <tr>
                        <td>
                            <input type="submit" name="submit" Value="Save" />
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include("inc/footer.php");?>
