<?php
 class readTitle{
   private $tbl_name = "tbl_slogan";
   public function readQuery(){
     $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
     $stmt = db::blogPrepare($sql);
     $stmt->execute();
     return $stmt->fetchAll();
   }
 }
$readData = new readTitle();
$sloganResult = $readData->readQuery();
foreach ($sloganResult as $slogan) {
  $logo = $slogan["logo"];
  $web_name = $slogan["web_name"];
  $slogan = $slogan["slogan"];
}
?>
<?php
  if(isset($_GET["page"])){
    $id = $_GET["page"];
    class viewPagetwo{
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
    $viewClassObj = new viewPagetwo();
    $viewClassObj->id($id);
    $resultOne = $viewClassObj->selectQuery();
    if($resultOne){
     foreach ($resultOne as $viewValue) {
       ?>
      <title><?php echo $viewValue["name"]; ?> - <?php if(isset($web_name)){echo $web_name;}?></title>
  <?php   }
     }
}elseif(isset($_GET["more"])){
      $id = $_GET["more"];
      class selectClasstwo{
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
      $queryObj = new selectClasstwo();
      $queryObj->id($id);
      $queryObj->selectQuery();
      foreach ($queryObj->selectQuery() as $value) { ?>
    <title><?php echo $value["title"]; ?> - <?php if(isset($web_name)){echo $web_name;}?></title>
  <?php }
}else{ ?>
  <title><?php echo $formatObj->title(); ?> - <?php if(isset($web_name)){echo $web_name;}?></title>
<?php  } ?>
<meta name="language" content="English">
<meta name="description" content="It is a website about education">
<meta name="keywords" content="blog,cms blog">
<meta name="author" content="Delowar">
