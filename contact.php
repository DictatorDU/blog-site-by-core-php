<?php
  include("inc/header.php");
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<h2>Contact us</h2>
        <?php
         if(isset($_POST['msgSub'])){
           $f_name = $formatObj->validation($_POST['firstname']);
           $l_name = $formatObj->validation($_POST['lastname']);
           $email = $formatObj->validation($_POST['email']);
           $msg = $formatObj->validation($_POST['msg']);

           $exprationName = "/^([a-zA-Z]+.{5})?([ ])*([a-zA-Z ])+$/";
           if(empty($f_name)){
             echo "<span style='color:red'>First Name can not be empty..</span>";
           }elseif(empty($l_name)){
             echo "<span style='color:red'>Last Name can not be empty..</span>";
           }elseif(empty($email)){
             echo "<span style='color:red'>Email can not be empty..</span>";
           }elseif(empty($msg)){
             echo "<span style='color:red'>Message can not be empty..</span>";
           }elseif(!preg_match($exprationName,$f_name)){
             echo "<span style='color:red'>Invalid First Name..</span>";
           }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
             echo "<span style='color:red'>Invalid Email Address..</span>";
           }else{
             class insertMsgClass{
               private $tbl_name = "tbl_contact";
               private $f_name;
               private $l_name;
               private $email;
               private $msg;
               public function f_name($f_name){
                 $this->f_name = $f_name;
               }
               public function l_name($l_name){
                 $this->l_name = $l_name;
               }
               public function email($email){
                 $this->email = $email;
               }
               public function msg($msg){
                 $this->msg = $msg;
               }
               public function insertQuery(){
                 $sql = "INSERT INTO $this->tbl_name(first_name,last_name,email,msg) VALUES(:f_name,:l_name,:email,:msg)";
                 $stmt = db::blogPrepare($sql);
                 $stmt->bindValue(":f_name",$this->f_name);
                 $stmt->bindValue(":l_name",$this->l_name);
                 $stmt->bindValue(":email",$this->email);
                 $stmt->bindValue(":msg",$this->msg);
                 return $stmt->execute();
               }
             }
             $msgObj = new insertMsgClass();
             $msgObj->f_name($f_name);
             $msgObj->l_name($l_name);
             $msgObj->email($email);
             $msgObj->msg($msg);
             $result = $msgObj->insertQuery();
             if($result){
               echo "<h2 style='color:green'>Your message has benn sent...</h2>";
             }else{
               echo "<h4 style='color:red'>Something went wrong...</h4>";
             }
           }
         }
        ?>
			<form action="" method="post">
				<table>
				<tr>
					<td>Your First Name:</td>
					<td>
					<input type="text" name="firstname" value="<?php if(isset($f_name)){echo $f_name;}?>"/>
					</td>
				</tr>
				<tr>
					<td>Your Last Name:</td>
					<td>
					<input type="text" name="lastname" value="<?php if(isset($l_name)){echo $l_name;}?>"/>
					</td>
				</tr>

				<tr>
					<td>Your Email Address:</td>
					<td>
					<input type="email" name="email" value="<?php if(isset($email)){echo $email;}?>"/>
					</td>
				</tr>
				<tr>
					<td>Your Message:</td>
					<td>
					<textarea name="msg"><?php if(isset($msg)){echo $msg;}?></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" name="msgSub" value="Submit"/>
					</td>
				</tr>
		</table>
	<form>
 </div>
</div>
<?php
 include("inc/sidebar.php");
 include("inc/footer.php");
?>
