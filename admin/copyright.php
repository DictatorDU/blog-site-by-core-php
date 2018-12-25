<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">

    <div class="box round first grid">
        <h2>Update Copyright Text</h2>
        <div class="block copyblock">
          <?php
           if(isset($_POST["submit"])){
             $copyright = $_POST["copyright"];
             class copyrightClass{
               private $tbl_name = "tbl_copyright";
               private $copyright;
               public function copyright($copyright){
                 $this->copyright = $copyright;
               }
               public function copyrightQuery(){
                 $sql = "UPDATE $this->tbl_name SET copyright_txt=:copyrighttxt";
                 //$sql = "INSERT INTO $this->tbl_name(copyright_txt) VALUES(:copyrighttxt)";
                 $stmt = db::blogPrepare($sql);
                 $stmt->bindParam(":copyrighttxt",$this->copyright);
                 return $stmt->execute();
               }
             }
            $copyrightObj = new copyrightClass();
            $copyrightObj->copyright($copyright);
            $success = $copyrightObj->copyrightQuery();
            if($success){
              echo "<h4 style='color:green'>Successfully update</h4>";
            }else{
              echo "<h4 style='color:green'>Something went wrong</h4>";
            }
           }
          ?>
          <?php
          class copyrightselect{
            private $tbl_name = "tbl_copyright";
            public function copyrightQuery(){
              $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
              $stmt = db::blogPrepare($sql);
              $stmt->execute();
              return $stmt->fetchAll();
            }
          }
          $copySelectObj = new copyrightselect();
          $copySelectObj->copyrightQuery();
          foreach ($copySelectObj->copyrightQuery() as  $value) {
            $result = $value["copyright_txt"];
          }
          ?>
         <form action="" method="post">
            <table class="form">
                <tr>
                    <td>
                        <input type="text" value="<?php if(isset($result)){echo $result;}  ?>" name="copyright" class="large" />
                    </td>
                </tr>
	            	 <tr>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
<?php include("inc/footer.php");?>
