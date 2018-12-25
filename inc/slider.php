<div class="slidersection templete clear">
        <div id="slider">
          <?php
          class selectClass{
            private $tbl_name = "tbl_slider";

            public function selectQuery(){
              $sql = "SELECT * FROM $this->tbl_name";
              $stmt = db::blogPrepare($sql);
              $stmt->execute();
              return $stmt->fetchAll();
            }
          }
          $selectObj = new selectClass();
          $result = $selectObj->selectQuery();
          $i=0;
          foreach ($result as $value) {?>
            <a href="#"><img src="admin/<?php echo $value["img"];?>" alt="nature 1" title="<?php echo $value["title"];?>" /></a>
          <?php } ?>
        </div>
</div>
