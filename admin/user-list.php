<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>User List</h2>
        <div class="block">
          <?php
          if(session::get("role") == 1){
          if(isset($_GET["delete"]) && $_GET["delete"] != NULL){
          $id = $_GET["delete"];
          class deleteClass{
            private $tbl_name = "tbl_admin";
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
          if ($result) {
            echo "<script>window.location='user-list.php';</script>";
          }
        }
      }
        ?>

           <table class="data display datatable" id="example">
           <thead>
             <tr>
               <th width='5%' style="text-align:center;">No.</th>
               <th width='12%' style="text-align:center;">Username</th>
               <th width='12%' style="text-align:center;">Email</th>
               <th width='40%' style="text-align:center;">Title</th>
               <th width='10%' style="text-align:center;">Post</th>
               <?php if(session::get("role") == 1){?>
               <th width='10%' style="text-align:center;">Action</th>
             <?php } ?>
             </tr>
            </thead>
            <?php
            class userClass{
              private $tbl_name = "tbl_admin";
              public function selectQuery(){
                $sql = "SELECT * FROM $this->tbl_name";
                $stmt = db::blogPrepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
              }
            }
            $userObj = new userClass();
            $userObj->selectQuery();
            $i = 0;
            foreach ($userObj->selectQuery() as $value) {
              $i++;
              ?>
              <tr>
               <td style="text-align:center;"><?php echo $i;?></td>
               <td><?php echo $value["username"];?></td>
               <td><?php echo $value["email"];?></td>
               <td><?php echo $objFormat->adminPanelTxtShort($value["details"]);?></td>
               <td style="text-align:center;"><?php
               if($value["role"] == 1){
                 echo "Admin";
               }elseif($value["role"] == 2){
                   echo "Author";
               }elseif($value["role"] == 3){
                   echo "Editor";
               }
               ?></td>
               <?php if(session::get("role") == 1){?>
               <td style="text-align:center;"><a href="user-list.php?delete=<?php echo $value["id"];?>">Delete</a></td>
             <?php } ?>
             </tr>
      <?php } ?>
           </table>
        </div>
    </div>
</div>
<script type="text/javascript">
      $(document).ready(function () {
          setupLeftMenu();
          $('.datatable').dataTable();
		setSidebarHeight();
      });
  </script>
<?php include("inc/footer.php");?>
