<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
        <div class="grid_10">

            <div class="box round first grid">
                <h2>Change Password</h2>
                <div class="block">
                  <?php
                   if(isset($_POST["submit"])){
                     $oldPass = $_POST["oldPass"];
                     $newPass = $_POST["newPass"];
                     $confirmPass = $_POST["confirmPass"];
                     $id = session::get('userID');
                     $email = session::get('email');
                     class passchkClass{
                       private $tbl_name = "tbl_admin";
                       private $id;
                       private $email;
                       public function id($id){
                         $this->id = $id;
                       }
                       public function email($email){
                         $this->email = $email;
                       }
                       public function selectPass(){
                         $sql = "SELECT * FROM $this->tbl_name WHERE id=:id AND email=:email LIMIT 1";
                         $stmt = db::blogPrepare($sql);
                         $stmt->bindParam(":id",$this->id);
                         $stmt->bindParam(":email",$this->email);
                         $stmt->execute();
                         return $stmt->fetchAll();
                       }
                     }
                     $passChkObj = new passchkClass();
                     $passChkObj->id($id);
                     $passChkObj->email($email);
                     $oldPassResult = $passChkObj->selectPass();
                     foreach ($oldPassResult as $value) {
                        $oldPassword = $value["password"];
                     }
                     if(empty($oldPass)){
                       $emptyOldPass = "<span style='color:red;'>Old password field empty</span>";
                     }elseif($oldPass != $oldPassword){
                       $notMatch = "<span style='color:red;'>Old password not match</span>";
                     }elseif(empty($newPass)){
                       $emptyNew = "<span style='color:red;'>New password can not empty</span>";
                     }elseif(strlen($newPass)<8){
                       $srtPass = "<span style='color:red;'>Password should be at least eight character.</span>";
                     }elseif(empty($confirmPass)){
                       $emptyConPass = "<span style='color:red;'>Confirm password can not be empty</span>";
                     }elseif($newPass != $confirmPass){
                       $newNotCon = "<span style='color:red;'>New password and Confirm password not match</span>";
                     }elseif($oldPassword == $newPass){
                       $newOldMatch = "<span style='color:red;'>Please inser a new password</span>";
                     }else{
                       class upPassClass{
                         private $tbl_name = "tbl_admin";
                         private $id;
                         private $email;
                         private $password;

                         public function id($id){
                           $this->id = $id;
                         }
                         public function email($email){
                           $this->email = $email;
                         }
                         public function password($newPass){
                           $this->password = $newPass;
                         }
                         public function upQuery(){
                           $sql = "UPDATE $this->tbl_name SET password=:password WHERE id=:id AND email=:email";
                           $stmt = db::blogPrepare($sql);
                           $stmt->bindParam(":password",$this->password);
                           $stmt->bindParam(":id",$this->id);
                           $stmt->bindParam(":email",$this->email);
                           return $stmt->execute();
                         }
                       }
                       $upPassObj = new upPassClass();
                       $upPassObj->id($id);
                       $upPassObj->email($email);
                       $upPassObj->password($newPass);
                       $upPassObj->upQuery();
                       if($upPassObj->upQuery()){
                         echo "<h3 style='color:green'>You have successfully change your password</h3>";
                       }else{
                         echo "<h3 style='color:red'>Something went wrong</h3>";
                       }
                     }
                 }
                  ?>
                 <form action="" method="post">
                    <table class="form">
                      <tr>
                        <td></td>
                        <td>
                          <?php if(isset($emptyOldPass)){echo $emptyOldPass;}?>
                          <?php if(isset($notMatch)){echo $notMatch;}?>
                        </td>
                      </tr>
                        <tr>
                            <td>
                                <label>Old Password</label>
                            </td>
                            <td>
                                <input type="password" value="<?php if(isset($oldPass)){echo $oldPass;}?>" name="oldPass" class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                            <?php if(isset($emptyNew)){echo $emptyNew;}?>
                            <?php if(isset($srtPass)){echo $srtPass;}?>
                          </td>
                        </tr>
					            	 <tr>
                            <td>
                                <label>New Password</label>
                            </td>
                            <td>
                                <input type="password" value="<?php if(isset($newPass)){echo $newPass;}?>" name="newPass" class="medium" />
                            </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                            <?php if(isset($emptyConPass)){echo $emptyConPass;}?>
                            <?php if(isset($newNotCon)){echo $newNotCon;}?>
                            <?php if(isset($newOldMatch)){echo $newOldMatch;}?>
                          </td>
                        </tr>
					            	 <tr>
                            <td>
                                <label>Confirm Password</label>
                            </td>
                            <td>
                                <input type="password" value="<?php if(isset($confirmPass)){echo $confirmPass;}?>" name="confirmPass" class="medium" />
                            </td>
                        </tr>
						            <tr>
                            <td>
                            </td>
                            <td>
                                <input type="submit" name="submit" Value="Update" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include("inc/footer.php");?>
