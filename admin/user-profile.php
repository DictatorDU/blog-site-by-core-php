<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
        <h2>User profile</h2>
        <div class="block">
        <?php
        $role = session::get('role');
        $sessionID = session::get("id");
          class profleinfoClass{
            private $tbl_name = "tbl_admin";
            private $role;
            private $sessionID;

            public function role($role){
              $this->role = $role;
            }
            public function sessionID($sessionID){
              $this->sessionID = $sessionID;
            }
            public function proInfoQuery(){
              $sql = "SELECT * FROM $this->tbl_name WHERE role=:role AND id=:sessionID";
              $stmt = db::blogPrepare($sql);
              $stmt->bindValue(":role",$this->role);
              $stmt->bindValue(":sessionID",$this->sessionID);
              $stmt->execute();
              return $stmt->fetchAll();
            }
          }
          $profleinfoObj = new profleinfoClass();
          $profleinfoObj->role($role);
          $profleinfoObj->sessionID($sessionID);
          $showResult = $profleinfoObj->proInfoQuery();
          foreach ($showResult as $value) {
            $response = $value["role"];
          ?>
          <h3><?php
          if($response == 1){
            echo "Admin";
          }
          if($response == 2){
            echo "Author";
          }
          if($response == 3){
            echo "Editor";
          }
          ?></h3>
          <span><?php echo $value["username"];?>Edit</span><br>
          <span><?php echo $value["email"];?>Edit</span><br><br>
          <p style="text-align:justify"><?php echo $value["details"];?></p>
          <?php } ?>
        </div>
    </div>
</div>
<?php
 unset($_SESSION['successDeletePage']);
?>
<?php include("inc/footer.php");?>
