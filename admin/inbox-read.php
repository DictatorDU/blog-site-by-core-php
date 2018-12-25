<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>
        <a href="inbox.php?inbox"><img src="img/icons8-go-back-55.png" alt=""></a>
        <div class="block">
        <?php
          if(isset($_GET["inbox"]) && $_GET["inbox"] != NULL){
            $id = $_GET["inbox"];
        ?>
          <?php
            class showMsgClass{
              private $tbl_name = "tbl_contact";
              private $id;
              public function id($id){
                $this->id = $id;
              }
              public function showMsgQuery(){
                $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
                $stmt = db::blogPrepare($sql);
                $stmt->bindValue(":id",$this->id);
                $stmt->execute();
                return $stmt->fetchAll();
              }
            }
            $selectMsgObj = new showMsgClass();
            $selectMsgObj->id($id);
            $showResult = $selectMsgObj->showMsgQuery();
            if($showResult){
              foreach ($showResult as $value) {
                $msgId = $value['id'];
                ?>
              <p><?php
                 echo '<strong>'.$value['first_name'].' ';
                 echo $value['last_name'].'</strong><br />';
                 echo $value['email'].'<br />';
                 echo $objFormat->dateFormat($value['date']).'<br /><br />';
                 echo '<p style="text-align:justify">'.$value['msg'].'</p><br />';
                 ?>
              </p>
           <?php
         }
           }else{
             echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Something went wrong..!!</h3>";
           }?>
         <form class="" action="" method="post">
           <div class="">
             <h4>Reply</h4><br>
             <span>Subjec</span><br>
             <input type="text" name="subject" value=""><br>
             <span style="margin-top:10px;">Reply text</span><br>
             <textarea name="name" rows="3" cols="50"></textarea><br>
             <input type="submit" name="" value="Send">
           </div>
         </form>
       <?php }else{
             echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
           }
           ?>
        </div>
     </div>
 </div>
 <?php include("inc/footer.php");?>
