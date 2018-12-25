<?php
 include("db-connection/db.php");
 include("helpers/format.php");
 $formatObj = new FormatClass();
?>
<!DOCTYPE html>
<html>
<head>
  <?php include("script/meta.php");?>
  <?php include("script/css.php");?>
  <?php include("script/js.php");?>
</head>

<body>
	<div class="headersection templete clear">
		<a href="">
			<div class="logo">
				<a href="index.php"><img src="admin/<?php if(isset($logo)){echo $logo;}?>" alt="Logo"/></a>
				<h2><?php if(isset($web_name)){echo $web_name;} ?></h2>
				<p><?php if(isset($slogan)){echo $slogan;}?></p>
			</div>
		</a>
		<div class="social clear">
			<div class="icon clear">
        <?php
          class selectSocialClass{
            private $tbl_name = "tbl_social_media";
            public function socialMediaSelect(){
              $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
              $stmt = db::blogPrepare($sql);
              $stmt->execute();
              return $stmt->fetchAll();
            }
          }
        $socialSelectObj = new selectSocialClass();
        foreach ($socialSelectObj->socialMediaSelect() as $selectedSocial) {
        ?>
				<a href="<?php echo $selectedSocial["face_book"];?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="<?php echo $selectedSocial["twitter"];?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="<?php echo $selectedSocial["linkedIn"];?>" target="_blank"><i class="fa fa-linkedin"></i></a>
				<a href="<?php echo $selectedSocial["google_plus"];?>" target="_blank"><i class="fa fa-google-plus"></i></a>
      <?php } ?>
			</div>
			<div class="searchbtn clear">
			<form action="search.php" method="post">
				<input type="text" name="search" placeholder="Search keyword..."/>
				<input type="submit" name="submit" value="Search"/>
			</form>
			</div>
		</div>
	</div>
  <div class="navsection templete">
  	<ul>
      <?php
      $path = $_SERVER['SCRIPT_FILENAME'];
      $c_page = basename($path,".php");
      ?>
  		<li><a
        <?php if($c_page == "index"){echo "id='active'";}?>
         id="" href="index.php">Home</a></li>
      <?php
      class ShowPageClass{
        private $tbl_name = "tbl_page";
        public function selectQuery(){
          $sql = "SELECT * FROM $this->tbl_name ORDER BY name ASC LIMIT 8";
          $stmt = db::blogPrepare($sql);
          $stmt->execute();
          return $stmt->fetchAll();
        }
      }
      $MenuClassObj = new ShowPageClass();
      $resultManu = $MenuClassObj->selectQuery();
      if($resultManu){
       foreach ($resultManu as $Manu) {
         ?>
        <li><a
          <?php
          if(isset($_GET["page"]) && $_GET["page"] ==  $Manu['id']){
            echo "id='active'";
          }
          ?>
          href="pages.php?page=<?php echo $Manu['id'];?>"><?php echo $Manu["name"];?></a></li>
      <?php
       }
     }else{
       echo "<script>window.location='404.php';</script>";
     }
       ?>
       <li><a
         <?php if($c_page == "contact"){echo "id='active'";}?>
           href="contact.php">Contact</a></li>
  	</ul>
  </div>
