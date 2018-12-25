<?php
  include("inc/header.php");
?>
<?php
  if(isset($_POST["submit"])){
    $searchValue = $_POST["search"];

    class searchClass{
      private $tbl_name = "tbl_post";
      //private $search;

      public function searcgQuery($searchValue){
        $sql = "SELECT * FROM $this->tbl_name WHERE title LIKE '%$searchValue%' OR body LIKE '%$searchValue%'";
        $stmt = db::blogPrepare($sql);
        $stmt->bindParam(":search",$this->searchValue);
        $stmt->execute();
        return $stmt->fetchAll();
      }
    }
    $searchObj = new searchClass();
    $formatObj = new FormatClass();
    $result = $searchObj->searcgQuery($searchValue);
    if($result){
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="samepost clear">
        <?php
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
      <?php } ?>
      </div>
  </div>
    <?php
  }else{echo "<script>window.location='404.php';</script>";}
}else{echo "<script>window.location='404.php';</script>";}
  	 include("inc/sidebar.php");
  	 include("inc/footer.php");
  	?>
