<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">
  <div class="box round first grid">
      <h2>Category List</h2>
      <?php
      if(isset($_SESSION['successEdit'])){
        echo "<h4 style='color:green;margin-top:15px;'>You have Successfully updated..</h4>";
      }
      if(isset($_SESSION['successDeleted'])){
        echo "<h4 style='color:green;margin-top:15px;'>You have Successfully Deleted..</h4>";
      }
      if(isset($_SESSION['addedSuccess'])){
        echo "<h4 style='color:green;margin-top:15px;'>You have Successfully Added catagory..</h4>";
      }
      ?>
      <div class="block">
        <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th style="text-align:center;">Serial No.</th>
							<th style="text-align:center;">Category Name</th>
              <?php if(session::get("role") == 1 || session::get("role") == 3){ ?>
							<th style="text-align:center;">Action</th>
            <?php } ?>
						</tr>
					</thead>
					<tbody>
            <?php
               class catlistClass{
                 private $tbl_name = "tbl_cat";
                 public function catlistQuery(){
                   $sql = "SELECT * FROM $this->tbl_name ORDER BY name ASC";
                   $stmt = db::blogPrepare($sql);
                   $stmt->execute();
                   return $stmt->fetchAll();
                 }
               }
               $catlistObj = new catlistClass();
               $result = $catlistObj->catlistQuery();
               $i=0;
               foreach ($result as $value) {
                 $i++;
            ?>
						<tr class="odd gradeX">
							<td style="text-align:center;"><?php echo $i;?></td>
							<td style="text-align:center;"><?php echo $value["name"];?></td>
							<td style="text-align:center;">
                <?php if(session::get("role") == 1 || session::get("role") == 3){ ?>
                <a href="edit-cat-list.php?cat_id=<?php echo $value["id"];?>">Edit</a>
                || <a href="delete-cat.php?delete=<?php echo $value["id"];?>">Delete</a></td>
                <?php }?>
						</tr>
            <?php } ?>
					</tbody>
				</table>
       </div>
    </div>
</div>
        <script type="text/javascript">

            $(document).ready(function () {
                setupLeftMenu();

                $('.datatable').dataTable();
          setSidebarHeight();


            });
        </script>

<?php include("inc/footer.php");?>
<?php
 unset($_SESSION['successEdit']);
 unset($_SESSION['successDeleted']);
 unset($_SESSION['addedSuccess']);
?>
