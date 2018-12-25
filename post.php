<?php
  include("inc/header.php");
?>
<?php
 if(!isset($_GET["more"]) || $_GET["more"] == NULL){
   header("location:404.php");
 }else{
   $id = $_GET["more"];
   class selectClass{
     private $tbl_name = "tbl_post";
     private $id;

     public function id($id){
       $this->id = $id;
     }
     public function selectQuery(){
       $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
       $stmt = db::blogPrepare($sql);
       $stmt->bindParam(":id",$this->id);
       $stmt->execute();
       return $stmt->fetchAll();
     }
   }
   $queryObj = new selectClass();
   $formatObj = new FormatClass();
   $queryObj->id($id);
   $queryObj->selectQuery();
   foreach ($queryObj->selectQuery() as $value) {
     $postTitle = $value['title'];
     $postDate = $value['date'];
     $postAuthor = $value['author'];
     $postBody = $value['body'];
     $postImg = $value['img'];
     $postCat = $value['cat'];
   }
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">

				<h2><?php if(isset($postTitle)){echo $postTitle;} ?></h2>
				<h4><?php if(isset($postDate)){echo $formatObj->dateFormat($postDate);} ?> By <a href="#" style="color:blue"><?php if(isset($postAuthor)){echo $postAuthor;} ?></a></h4>
				<img width="100px" height="auto" src="admin/<?php if(isset($postImg)){echo $postImg;} ?>" alt="post image"/>
        <p><?php if(isset($postBody)){echo $postBody;}?></p>
				<div class="relatedpost clear">
					<h2>Related articles</h2>
          <?php
            class relClass{
              private $tbl_name = "tbl_post";
              private $cat;

              public function cat($postCat){
                $this->cat = $postCat;
              }
              public function relQuery(){
                $sql = "SELECT * FROM $this->tbl_name WHERE cat=:cat ORDER BY rand() LIMIT 6";
                $stmt = db::blogPrepare($sql);
                $stmt->bindParam(":cat",$this->cat);
                $stmt->execute();
                return $stmt->fetchAll();
              }
            }
            $relObj = new relClass();
            $relObj->cat($postCat);
            $relObj->relQuery();
            foreach ($relObj->relQuery($postCat) as $value) {
              $relImg = $value["img"];
              $relTiele = $value["title"];
              $relId = $value["id"];
             echo '<a href="post.php?more='.$value["id"].'"><img src="admin/'.$value["img"].'" alt="" /></a>';
            }
          ?>
				</div>
	</div>
</div>
	<?php
}
	 include("inc/sidebar.php");
	 include("inc/footer.php");
	?>
