<div class="clear">
</div>
</div>
<div class="clear">
</div>
<div id="site_info">
  <?php
  class copyrightselectfoo{
    private $tbl_name = "tbl_copyright";
    public function copyrightQuery(){
      $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
      $stmt = db::blogPrepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }
  $copySelectObj = new copyrightselectfoo();
  $copySelectObj->copyrightQuery();
  foreach ($copySelectObj->copyrightQuery() as  $value) {
    $copyrightResult = $value["copyright_txt"];
  }
  ?>
<p>
<?php if(isset($copyrightResult)){echo $copyrightResult;}  ?>
</p>
</div>
</body>
</html>
