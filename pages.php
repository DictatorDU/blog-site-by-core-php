<?php
  include("inc/header.php");
?>
<?php
if(isset($_GET['page']) && $_GET["page"] != NULL){
  $id = $_GET["page"];
?>
	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
        <?php
        class viewPageClass{
          private $tbl_name = "tbl_page";
          private $id;
          public function id($id){
            $this->id = $id;
          }
          public function selectQuery(){
            $sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
            $stmt = db::blogPrepare($sql);
            $stmt->bindValue(":id",$this->id);
            $stmt->execute();
            return $stmt->fetchAll();
          }
        }
        $viewClassObj = new viewPageClass();
        $viewClassObj->id($id);
        $result = $viewClassObj->selectQuery();
        if($result){
         foreach ($result as $viewValue) {
           ?>
				<h2><?php echo $viewValue["name"];?></h2>
        <p><?php echo $viewValue["body"];?></p>
   <?php
    }
  }
  ?>
    </div>
</div>
<?php
}else{
  header("location:404.php");
}
 include("inc/sidebar.php");
 include("inc/footer.php");
?>
