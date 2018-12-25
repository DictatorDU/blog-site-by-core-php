<link rel="icon" href="admin/<?php if(isset($logo)){echo $logo;}?>">
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.css">
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<!-- <link rel="stylesheet" href="style.css"> -->
<?php
include("style.php");
?>
<?php
class checkedClass{
  private $tbl_name = "tbl_theme";
  public function selectQuery(){
    $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
    $stmt = db::blogPrepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
$selectObj = new checkedClass();
$selectObj->selectQuery();
foreach ($selectObj->selectQuery() as $value) {
  $result = $value["theme"];
}
if($result == "default"){
  include("theme/default.php");
}elseif($result == "green"){
  include("theme/green.php");
}elseif($result == "dark"){
  include("theme/dark.php");
}elseif($result == "red"){
  include("theme/red.php");
}
?>
