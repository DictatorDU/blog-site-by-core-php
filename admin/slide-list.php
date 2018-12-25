<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
    <?php if(session::get("role") == 1){?>
      <style media="screen">
        #testId{
          background-color:#E6F0F3;
          width:1119px;
          height:35px;
          margin:-10px;
          border-radius: 5px 5px 0px 0px;
        }
        #testId h3{
          display: inline;
        }
        #testId h3 a{
          padding: 0px 10px 15px 10px;
        }
        #active{
          color:#204562;
          background: #FFFFFF;
        }
      </style>
      <?php if(isset($_GET["list"])){?>
      <div id="testId"><h3><a href="slider.php?add-slider">New Slide</a></h3><h3><a id="active" href="slide-list.php?list">Slide list</a><h3></div>
        <div class="block">
          <?php
          if(isset($_SESSION["delsliderSuc"])){
            echo "<h3 style='color:green'>You have successfully delete a slide image...</h3>";
          }
          if(isset($_SESSION["presentFile"])){
            echo "<h3 style='color:green'>You have successfully update your slider...</h3>";
          }
          if(isset($_SESSION["absentFile"])){
            echo "<h3 style='color:green'>You have successfully update your slider...</h3>";
          }
          ?>
          <table class="data display datatable" id="example">
              <thead>
                <tr class="odd gradeX">
                  <th style="text-align:center;">No</th>
                  <th style="text-align:center;">Slide Title</th>
                  <th style="text-align:center;">Post Title</th>
                  <th style="text-align:center;">Action</th>
                </tr>
              </thead>
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
           foreach ($result as $value) {
             $i++;
             ?>
             <tr>
               <td style="text-align:center;"><?php echo $i;?></td>
               <td style="text-align:center;"><?php echo $value["title"];?></td>
               <td style="text-align:center;"><img width="200px" src="<?php echo $value['img'];?>" alt=""></td>
               <td style="text-align:center;">
                 <a href="slide-edit.php?slide-edit=<?php echo $value['id'];?>">Edit</a>||
                 <a href="slide-delete.php?delete-slide=<?php echo $value['id'];?>">Delete</a>
               </td>
             </tr>
          <?php } ?>
      <?php }else{
        echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
      } ?>
    </table>
  <?php }else{echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";}?>
    </div>
</div>
<script type="text/javascript">
      $(document).ready(function () {
          setupLeftMenu();
          $('.datatable').dataTable();
		setSidebarHeight();
      });
  </script>
<?php
unset($_SESSION["delsliderSuc"]);
unset($_SESSION["absentFile"]);
unset($_SESSION["presentFile"]);
?>
<?php include("inc/footer.php");?>
