<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
        <div class="grid_10">
           <?php
            if(session::get("role") != 1){
              echo "<script>window.location='index.php';</script>";
            }
           ?>
            <div class="box round first grid">
                <h2>Add User</h2>
               <div class="block copyblock">
                 <?php
                  if(isset($_POST["submit"])){
                    $username = $objFormat->validation($_POST['username']);
                    $email = $objFormat->validation($_POST['email']);
                    $password = $objFormat->validation($_POST['password']);
                    $role = $objFormat->validation($_POST['role']);

                    class mailChkClass{
                      private $db_tbl = "tbl_admin";
                      public $email;

                      public function emailCK($email){
                        $this->email = $email;
                      }
                      public function emailQuery(){
                        $sql = "SELECT email FROM $this->db_tbl WHERE email=:email";
                        $stmt=db::blogPrepare($sql);
                        $stmt->bindParam(":email",$this->email);
                        $stmt->execute();
                        if($stmt->rowCount()>0){
                          return true;
                        }else{
                          return false;
                        }
                      }
                    }
                    $emailChakObj = new mailChkClass();
                    $emailChakObj->emailCK($email);

                    if(empty($username)){
                      echo "<h4 style='color:red'>Empty username</h4>";
                    }elseif(empty($email)){
                      echo "<h4 style='color:red'>Empty email field</h4>";
                    }elseif($emailChakObj->emailQuery() == true){
                      echo "<h4 style='color:red'>The Email address already exits..</h4>";
                    }elseif(empty($password)){
                      echo "<h4 style='color:red'>Empty password field</h4>";
                    }elseif(empty($role)){
                      echo "<h4 style='color:red'>Empty role field</h4>";
                    }else{
                    class adduserClass{
                      private $tbl_name = "tbl_admin";
                      private $username;
                      private $email;
                      private $password;
                      private $role;

                      public function username($username){
                        $this->username = $username;
                      }
                      public function email($email){
                        $this->email = $email;
                      }
                      public function password($password){
                        $this->password = $password;
                      }
                      public function role($role){
                        $this->role = $role;
                      }

                      public function adduserQuery(){
                        $sql = "INSERT INTO $this->tbl_name(username,email,role,password) VALUES(:username,:email,:role,:password)";
                        $stmt = db::blogPrepare($sql);
                        $stmt->bindParam(":username",$this->username);
                        $stmt->bindParam(":email",$this->email);
                        $stmt->bindParam(":role",$this->role);
                        $stmt->bindParam(":password",$this->password);
                        return $stmt->execute();
                      }
                    }
                    $insertCatObj = new adduserClass();
                    $insertCatObj->username($username);
                    $insertCatObj->email($email);
                    $insertCatObj->password($password);
                    $insertCatObj->role($role);
                    $result = $insertCatObj->adduserQuery();
                    if($result){
                      echo "<h4 style='color:green'>You have successfully added.</h4>";
                    }
                   }
                  }
                 ?>
                 <form action="" method="post">
                    <table class="form">
                    <tr>
                      <td>
                        <label>Username</label>
                      </td>
                        <td>
                            <input type="text" name="username" class="medium" />
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Email</label>
                      </td>
                        <td>
                            <input type="text" name="email" class="medium" />
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Password</label>
                      </td>
                        <td>
                            <input type="password" name="password" class="medium" />
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Role</label>
                      </td>
                        <td>
                            <select class="" name="role">
                              <option value="">Select Role</option>
                              <option value="1">Admin</option>
                              <option value="2">Author</option>
                              <option value="3">Editor</option>
                            </select>
                        </td>
                    </tr>
				             <tr>
                       <td></td>
                        <td>
                            <input type="submit" name="submit" Value="Create" />
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include("inc/footer.php");?>
