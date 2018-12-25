<?php
  include("inc/header.php");
?>

<?php
  include("inc/slider.php");
?>
<?php
// pegenation
$per_page = 3;
if(isset($_GET["page"])){
  $page = $_GET["page"];
}else{
  $page = 1;
}
$start_from = ($page-1) * $per_page;
// pegenation
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
      <?php
        class postClass{
          private $tbl_name = "tbl_post";
          public $start_from;
          public $per_page;

          public function startFrom($start_from){
            $this->start_from = $start_from;
          }

          public function perPage($per_page){
            $this->per_page = $per_page;
          }
          public function post_select(){
          $sql = "SELECT * FROM $this->tbl_name ORDER BY id DESC LIMIT $this->start_from,$this->per_page";
          $stmt = db::blogPrepare($sql);
          $stmt->execute();
          $post = $stmt->fetchAll();
          return $post;
         }
        }

        $selectObj = new postClass();

        $selectObj->startFrom($start_from);
        $selectObj->perPage($per_page);

        $result = $selectObj->post_select();
          if($result){
          foreach ($result as $value) {
      ?>
			<div class="samepost clear">
				<h2><a href="post.php?more=<?php echo $value['id'] ?>"><?php echo $value['title'] ?></a></h2>
				<h4><?php echo $formatObj->dateFormat($value['date']); ?> By<a style="color:blue" class="" href="#"><?php echo " ".$value['author'] ?></a></h4>
				 <a href="#"><img width="100px" height="auto" src="admin/<?php echo $value['img'] ?>" alt="post image"/></a>
				<p>
          <?php echo $formatObj->shortTxt($value['body']); ?>
				</p>
				<div class="readmore clear">
					<a href="post.php?more=<?php echo $value['id'] ?>">Read More</a>
				</div>
			</div>
      <?php
        }
      //pegenation
      class rowCountClass{
        private $tbl_name = "tbl_post";
        public function query(){
          $sql  = "SELECT * FROM $this->tbl_name";
          $stmt = db::blogPrepare($sql);
          $stmt->execute();
          $row = $stmt->rowCount();
          return $row;
        }
      }
      $rowObj = new rowCountClass();
      $total_row = $rowObj->query();
      $total_page = ceil($total_row/$per_page);

      echo "<span id='pagination' class='pagination'>";
      echo "<a href='index.php?page=1'>First Page </a>";
      for ($i=1; $i < $total_page ; $i++) {
        echo "<a href='index.php?page=".$i."'>".$i."</a>";
      }
      echo "<a href='index.php?page=".$total_page."'> Last Page</a>";
      echo "</span>";
      //pegenation
    }else{ header("location:404.php");}
      ?>
		</div>
   <?php
    include("inc/sidebar.php");
    include("inc/footer.php");
  ?>
