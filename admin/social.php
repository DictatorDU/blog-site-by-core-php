<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">
<div class="box round first grid">
<h2>Update Social Media</h2>
<div class="block">
  <?php
   if(isset($_POST["socialSub"])){
     $facebook = $objFormat->validation($_POST["facebook"]);
     $twitter = $objFormat->validation($_POST["twitter"]);
     $linkedin = $objFormat->validation($_POST["linkedin"]);
     $googleplus = $objFormat->validation($_POST["googleplus"]);
     if(empty($facebook)){
       echo "<span style='color:red'>Facebook field can not be empty</span>";
     }elseif(empty($twitter)){
       echo "<span style='color:red'>Twitter field can not be empty</span>";
     }elseif(empty($linkedin)){
       echo "<span style='color:red'>linkedin field can not be empty</span>";
     }elseif(empty($googleplus)){
       echo "<span style='color:red'>googleplus field can not be empty</span>";
     }elseif(!filter_var($facebook, FILTER_VALIDATE_URL)){
       echo "<span style='color:red'>Invalid Facebook URL Addres</span>";
     }elseif(!filter_var($twitter, FILTER_VALIDATE_URL)){
       echo "<span style='color:red'>Invalid twitter URL Addres</span>";
     }elseif(!filter_var($linkedin, FILTER_VALIDATE_URL)){
       echo "<span style='color:red'>Invalid LinkedIn URL Addres</span>";
     }elseif(!filter_var($googleplus, FILTER_VALIDATE_URL)){
       echo "<span style='color:red'>Invalid google+ URL Addres</span>";
     }else{
        class updateSocial{
          private $tbl_name = "tbl_social_media";
          private $facebook;
          private $twitter;
          private $linkedin;
          private $googleplus;

          public function facebook($facebook){
            $this->facebook = $facebook;
          }
          public function twitter($twitter){
            $this->twitter = $twitter;
          }
          public function linkedin($linkedin){
            $this->linkedin = $linkedin;
          }
          public function googleplus($googleplus){
            $this->googleplus = $googleplus;
          }
          public function updateSocileQuery(){
            $sql = "UPDATE $this->tbl_name SET face_book=:facebook,twitter=:twitter,linkedIn=:linkedin,google_plus=:googleplus";
            $stmt = db::blogPrepare($sql);
            $stmt->bindParam(":facebook",$this->facebook);
            $stmt->bindParam(":twitter",$this->twitter);
            $stmt->bindParam(":linkedin",$this->linkedin);
            $stmt->bindParam(":googleplus",$this->googleplus);
            return $stmt->execute();
          }
        }
        $socialUpObj = new updateSocial();
        $socialUpObj->facebook($facebook);
        $socialUpObj->twitter($twitter);
        $socialUpObj->linkedin($linkedin);
        $socialUpObj->googleplus($googleplus);
        $socialUpObj->updateSocileQuery();
        if($socialUpObj->updateSocileQuery()){
          echo "<h4 style='color:green'>You Have Successfully Update</h4>";
        }else{
          echo "<h4 style='color:red'>Somtething went wrong..</h4>";
        }
     }
   }
  ?>
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
<form action="" method="post">
<table class="form">
    <tr>
        <td>
            <label>Facebook</label>
        </td>
        <td>
            <input type="text" name="facebook" value="<?php echo $selectedSocial["face_book"];?>" placeholder="Facebook link.." class="medium" />
        </td>
    </tr>
     <tr>
        <td>
            <label>Twitter</label>
        </td>
        <td>
            <input type="text" name="twitter" value="<?php echo $selectedSocial["twitter"];?>" placeholder="Twitter link.." class="medium" />
        </td>
    </tr>
     <tr>
        <td>
            <label>LinkedIn</label>
        </td>
        <td>
            <input type="text" name="linkedin" value="<?php echo $selectedSocial["linkedIn"];?>" placeholder="LinkedIn link.." class="medium" />
        </td>
    </tr>
     <tr>
        <td>
            <label>Google Plus</label>
        </td>
        <td>
            <input type="text" name="googleplus" value="<?php echo $selectedSocial["google_plus"];?>" placeholder="Google Plus link.." class="medium" />
        </td>
    </tr>
     <tr>
        <td></td>
        <td>
            <input type="submit" name="socialSub" Value="Update" />
        </td>
    </tr>
</table>
</form>
</div>
</div>
<?php } ?>
<?php include("inc/footer.php");?>
