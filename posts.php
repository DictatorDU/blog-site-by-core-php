<?php
  include("inc/header.php");
?>
<?php
if(!isset($_GET["catagory"]) || $_GET["catagory"] == NULL){
  header("location:404.php");
}else{
  $catId = $_GET["catagory"];
 class catPostClass{
   private $tbl_name = "tbl_post";
   private $catId;

   public function catId($catId){
     $this->catId = $catId;
   }
   public function catPostQuery(){
     $sql = "SELECT * FROM $this->tbl_name WHERE cat=:cat ORDER BY id DESC";
     $stmt = db::blogPrepare($sql);
     $stmt->bindParam(":cat",$this->catId);
     $stmt->execute();
     return $stmt->fetchAll();
   }
 }
 $catPostObj = new catPostClass();
 $formatObj = new FormatClass();

 $catPostObj->catId($catId);
 $result = $catPostObj->catPostQuery();
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="samepost clear">
         <?php
         if($result){
           foreach ($result as $value) {
            ?>
                <h2><a href="post.php?more=<?php echo $value['id'] ?>"><?php echo $value["title"] ?></a></h2>
               <h4><?php echo $formatObj->dateFormat($value["title"]); ?> By <a href="#" style="color:blue"><?php echo $value["author"] ?></a></h4>
               <img src="admin/<?php echo $value["img"] ?>" alt="post image"/>
               <p><?php echo $formatObj->shortTxt($value['body']);?></p>
               <div class="readmore clear">
       					<a href="post.php?more=<?php echo $value['id'] ?>">Read More</a>
       				</div>
                <br>
        <?php }  ?>
      </div>
  </div>
    <?php
  }else{header("location:404.php");}
  }
  	 include("inc/sidebar.php");
  	 include("inc/footer.php");
  	?>
