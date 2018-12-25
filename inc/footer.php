<div class="footersection templete clear">
  <div class="footermenu clear">
  <ul>
    <li><a href="index.php">Home</a></li>
    <?php
    class footerPageClass{
      private $tbl_name = "tbl_page";
      public function selectQuery(){
        $sql = "SELECT * FROM $this->tbl_name ORDER BY name ASC LIMIT 8";
        $stmt = db::blogPrepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }
    }
    $MenuClassObj = new footerPageClass();
    $resultManu = $MenuClassObj->selectQuery();
    if($resultManu){
     foreach ($resultManu as $Manu) {
       ?>
      <li><a id="" href="pages.php?page=<?php echo $Manu['id'];?>"><?php echo $Manu["name"];?></a></li>
    <?php
     }
   }else{
     echo "<script>window.location='404.php';</script>";
   }
     ?>
    <li><a href="contact.php">Contact</a></li>
  </ul>
  </div>
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
    $copyrightResult = $value["copyright_txt"];
  }
  ?>
  <p><?php if(isset($copyrightResult)){echo $copyrightResult;}  ?></p>
</div>
<div class="fixedicon clear">
  <?php
    class selectSocialClassTwo{
      private $tbl_name = "tbl_social_media";
      public function socialMediaSelect(){
        $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
        $stmt = db::blogPrepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }
    }
  $socialSelectObj = new selectSocialClassTwo();
  foreach ($socialSelectObj->socialMediaSelect() as $selectedSocial) {
  ?>
  <a href="<?php echo $selectedSocial["face_book"];?>" target="_blank"><img src="images/fb.png" alt="Facebook"/></a>
  <a href="<?php echo $selectedSocial["twitter"];?>" target="_blank"><img src="images/tw.png" alt="Twitter"/></a>
  <a href="<?php echo $selectedSocial["linkedIn"];?>" target="_blank"><img src="images/in.png" alt="LinkedIn"/></a>
  <a href="<?php echo $selectedSocial["google_plus"];?>" target="_blank"><img src="images/gl.png" alt="GooglePlus"/></a>
<?php } ?>
</div>
<script type="text/javascript" src="js/scrolltop.js"></script>
</body>
</html>
