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
    if(isset($_POST["recover_email"])){
    function validation($data){
      $data = trim($data);
      $data = htmlspecialchars($data);
      return $data;
    }
     $email = validation($_POST["email"]);
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
     $mailChkResult = $emailChakObj->emailQuery();
     if(empty($email)){
       $emptyuserEmail = "<h4 style='color:red;'>Empty Email address..</h4>";
     }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
       $invalidEmail = "<h4 style='color:red;'>Invalid Email address</h4>";
     }elseif($mailChkResult == false){
       $notFoundMail = "<h4 style='color:red;'>Email address not found..</h4>";
     }else{
       class selectClass{
         private $tbl_name = "tbl_admin";
         private $email;
         public function email($email){
           $this->email = $email;
         }
         public function selectQuery(){
           $sql = "SELECT * FROM $this->tbl_name WHERE email=:email LIMIT 1";
           $stmt = db::blogPrepare($sql);
           $stmt->bindParam(":email",$this->email);
           $stmt->execute();
           return $stmt->fetchAll();
         }
       }
      $readObj = new selectClass();
      $readObj->email($email);
      $readResult = $readObj->selectQuery();
      foreach ($readResult as $value) {
        $username = $value["username"];
        $email = $value["email"];
        $id = $value["id"];
      }
      $txt = substr($email,0,5);
      $rand = rand(1111111,9999999);
      $newPass = "$txt$rand";
      class updatePassClass{
        private $tbl_name = "tbl_admin";
        private $id;
        private $password;
        private $email;
        public function id($id){
          $this->id = $id;
        }
        public function password($newPass){
          $this->password = $newPass;
        }
        public function email($email){
          $this->email = $email;
        }
        public function upPassQuery(){
          $sql = "UPDATE $this->tbl_name SET password=:password WHERE email=:email AND id=:id";
          $stmt = db::blogPrepare($sql);
          $stmt->bindParam(":password",$this->password);
          $stmt->bindParam(":email",$this->email);
          $stmt->bindParam(":id",$this->id);
          return $stmt->execute();
        }
      }
      $upPassObj = new updatePassClass();
      $upPassObj->id($id);
      $upPassObj->email($email);
      $upPassObj->password($newPass);
      $passUpResult = $upPassObj->upPassQuery();
      if($passUpResult){
        $subject = "Password Recover";
        $from = "asdfgalamin@gmail.com";
        $headers = "From:$from\n";
        $headers .= 'MIME-Version: 1.0';
        $headers .= 'Content-type: text/html; charset=iso-8859-1';
        $message = "Username is ".$username.". Your new pasword is ".$newPass." Please visit our web site. Thank you.";

       $sendMail = mail($email,$subject,$message,$headers);
       if($sendMail){
         echo "Please cheack your email to new password..";
       }else{
         echo "Something went wrong..";
       }
      }
     }
  }
    ?>
		<form action="" method="post">
			<h1>Admin Login</h1>
			<div style="float:left;margin-left:12px;margin-bottom:2px;">
				<?php
          if(isset($emptyuserEmail)){echo $emptyuserEmail;}
          if(isset($invalidEmail)){echo $invalidEmail;}
          if(isset($notFoundMail)){echo $notFoundMail;}
        ?>
			</div>
			<div>
				<input type="text" <?php if(isset($email)){echo "value='".$email."'";}else{echo "placeholder='Email'";}?> name="email"/>
			</div>
			<div>
				<input type="submit" name="recover_email" value="Send Email" />
			</div>

		</form><!-- form -->
		<div class="button">
			<a href="login.php">Log in</a>
    </div>
		<div class="button">
			<a href="#"><?php if(isset($web_nameName)){echo $web_nameName;}?></a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
