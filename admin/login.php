<?php
include("lib/session.php");
session::init();
session::chkSessionStared();
?>
<?php include("lib/db-connection/db.php");?>
<?php
include("lib/format.php");
$objFormat = new FormatClass();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<?php
  class slogan{
    private $tbl_name = "tbl_slogan";
    public function sloganQuery(){
      $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
      $stmt = db::blogPrepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $sloganObj = new slogan();
  $result = $sloganObj->sloganQuery();
  foreach($result as $value){
    $web_nameName = $value["web_name"];
    $logo = $value["logo"];
  } ?>
  <title>Login-<?php if(isset($web_nameName)){echo $web_nameName;}?></title>
  <link rel="icon" href="<?php if(isset($logo)){echo $logo;}?>">
  <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
    <?php
       if(isset($_POST["submit"])){
         $email = $objFormat->validation($_POST["email"]);
         $password = $_POST["password"];

         class chkInput{
           private $tbl_name = "tbl_admin";
           private $email;
           public function emailFun($email){
             $this->email = $email;
           }
           public function emailChkquery(){
             $sql = "SELECT email FROM $this->tbl_name WHERE email=:email";
             $stmt = db::blogPrepare($sql);
             $stmt->bindParam(':email',$this->email);
             $stmt->execute();
             if($stmt->rowCount()>0){
               return true;
             }else{
               return false;
             }
           }
           public function passChkquery(){
             $sql = "SELECT * FROM $this->tbl_name WHERE email=:email";
             $stmt = db::blogPrepare($sql);
             $stmt->bindParam(':email',$this->email);
             $stmt->execute();
             return $stmt->fetchAll();
           }
         }//end of the input class

         $chkInputObj = new chkInput();//Obj of chk username and password
         $chkInputObj->emailFun($email);
         $chK_email_result = $chkInputObj->emailChkquery();
         $passResult = $chkInputObj->passChkquery();
         foreach ($passResult as $value) {
           $chK_pass_result = $value["password"];
         }
         if(empty($email)){
           $email = "<span style='color:red'>Empty Email</span>";
         }elseif($chK_email_result == false){
           $notFoundUser = "<span style='color:red'>Email not found</span>";
         }elseif(empty($password)){
           $emptyPass = "<span style='color:red'>Empty Password</span>";
         }elseif($chK_pass_result != $password){
           $notFoundPass = "<span style='color:red'>Password not match</span>";
         }else{
           class loginClass{
             private $tbl_name = "tbl_admin";
             private $email;
             private $password;

             public function getUseremail($email){
               $this->email = $email;
             }
             public function getPassword($password){
               $this->password = $password;
             }

             public function loginQuery(){
               $sql = "SELECT * FROM $this->tbl_name WHERE email=:email AND password=:password LIMIT 1";
               $stmt = db::blogPrepare($sql);
               $stmt->bindParam(":email",$this->email);
               $stmt->bindParam(":password",$this->password);
               $stmt->execute();
               $resutl = $stmt->fetch(PDO::FETCH_OBJ);
               return $resutl;
               if($resutl){
                 session::init();
               }
             }
           }//End of the login in class

           $loginObj = new loginClass();
           $loginObj->getUseremail($email);
           $loginObj->getPassword($password);

           $loginResult = $loginObj->loginQuery();
           if($loginResult){
             session::init();
             session::set('login',true);
             session::set('userID',$loginResult->id);
             session::set('name',$loginResult->name);
             session::set('email',$loginResult->email);
             session::set('role',$loginResult->role);
             session::set('username',$loginResult->username);
             header("location:index.php");
           }else{
             $_SESSION["loginFail"] = 1;
             session::sessionDestroy();
             header("location:login.php");
           }
         }
       }
    ?>
		<form action="" method="post">
			<h1>Admin Login</h1>
			<div style="float:left;margin-left:12px;margin-bottom:2px;">
				<?php
          if(isset($emptyuserEmail)){echo $emptyuserEmail;}
          elseif(isset($notFoundUser)){echo $notFoundUser;}
        ?>
			</div>
			<div>
				<input type="text" <?php if(isset($email)){echo "value='".$email."'";}else{echo "placeholder='Email'";}?> name="email"/>
			</div>
      <div style="float:left;margin-left:10px;margin-bottom:2px;">
        <?php
          if(isset($emptyPass)){echo $emptyPass;}
          elseif(isset($notFoundPass)){echo $notFoundPass;}
        ?>
      </div>
			<div>
				<input <?php if(isset($password)){echo "value='".$password."'";}else{echo "placeholder='Password'";}?> type="password" name="password"/>
			</div>
			<div>
				<input type="submit" name="submit" value="Log in" />
			</div>

		</form><!-- form -->
		<div class="button">
			<a href="forget-pass.php">Forgotten Password</a>
    </div>
		<div class="button">
			<a href="#"><?php if(isset($web_nameName)){echo $web_nameName;}?></a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
