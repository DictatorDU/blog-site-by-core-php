<div class="sidebar clear">
  <div class="samesidebar clear">
    <h2>Latest articles</h2>
      <div class="popular clear">
        <?php
          class letestArticale{
            private $tbl_name = "tbl_post";
            public function letestQuery(){
              $sql = "SELECT * FROM $this->tbl_name ORDER BY id DESC LIMIT 3";
              $stmt = db::blogPrepare($sql);
              $stmt->execute();
              return $stmt->fetchAll();
            }
          }
          function letestArtical($txt){
            $txt = substr($txt,0,90);
            $txt = substr($txt,0,strrpos($txt," "));
            $txt = $txt." .......";
            return $txt;
          }

          $letestArticalObj = new letestArticale();
          $letestresult = $letestArticalObj->letestQuery();
          if($letestresult){
            foreach ($letestresult as $value) {
        ?>
        <h3 style="padding-top:5px;"><a href="post.php?more=<?php echo $value['id'] ?>"><?php echo $value["title"]; ?></a></h3>
        <a href="#"><img width='30px' height='auto' src="admin/<?php echo $value['img'] ?>" alt="post image"/></a>
        <p style="display:inline"><?php echo letestArtical($value['body']); ?></p>
        <div class="readmore clear">
        <a href="post.php?more=<?php echo $value['id'] ?>">Read More</a>
      </div>
        <br>
        <br>
      <?php
     }
    }else{ echo "<h4><span style='color:red'>There are have not any recent post</span></h4>";}
    ?>
      </div>
  </div>
  <div class="samesidebar clear">
    <h2>Categories</h2>
      <ul>
        <?php
         class catSelection{
           private $tbl_name = "tbl_cat";
           public function selectQuery(){
             $sql = "SELECT * FROM $this->tbl_name ORDER BY name ASC";
             $stmt = db::blogPrepare($sql);
             $stmt->execute();
             return $stmt->fetchAll();
           }
         }
         $catObj = new catSelection();
         $result = $catObj->selectQuery();
         if($result){
         foreach ($result as $value) {
           ?>
  
        <li><a href="posts.php?catagory=<?php echo $value["id"]?>"><?php echo $value["name"]?></a></li>
        <?php
        }
      }else{
        ?>
       <li><a style="font-size:20px;color:black" href="#">No Catagory Created</a></li>
      <?php } ?>
      </ul>
  </div>
</div>
</div>
