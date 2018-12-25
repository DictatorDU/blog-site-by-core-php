<?php
$cat_postID = $value["cat"];
class readCatClass{
  private $tbl_name = "tbl_cat";
  private $cat_postID;
  public function cat_postID($cat_postID){
  $this->cat_postID = $cat_postID;
  }
public function readCatQuery(){
$sql = "SELECT * FROM $this->tbl_name WHERE id=:id";
$stmt = db::blogPrepare($sql);
$stmt->bindValue(":id",$this->cat_postID);
$stmt->execute();
return $stmt->fetchAll();
  }
}//end of the catagory read class(readCat)


$readCatObj = new readCatClass();
$readCatObj->cat_postID($cat_postID);
$readCatObj->readCatQuery();
foreach ($readCatObj->readCatQuery() as $catName) {
?>
<td><?php echo $catName['name']; ?></td>
<?php  } ?>
