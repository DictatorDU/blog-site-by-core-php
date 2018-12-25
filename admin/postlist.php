<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">
 <div class="box round first grid">
   <h2>Post List</h2>
   <?php
    if(isset($_SESSION['deleteccessPost'])){
      echo "<h4 style='color:green'>You have successfully deleted data...</h4>";
    }
    if(isset($_SESSION['successupdatepost'])){
      echo "<h3 style='color:green'>Successfully update data</h3>";
    }
   ?>
    <div class="block">
      <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th style="text-align:center;" width="5%">No</th>
							<th style="text-align:center;" width="15%">Post Title</th>
              <th style="text-align:center;" width="10%">Category</th>
              <th style="text-align:center;" width="8%">Image</th>
							<th style="text-align:center;" width="20%">Post Text</th>
							<th style="text-align:center;" width="10%">Author</th>
							<th style="text-align:center;" width="7%">Tags</th>
							<th style="text-align:center;" width="10%">Date</th>
							<th style="text-align:center;" width="15%">Action</th>
						</tr>
					</thead>
					<tbody>
            <?php
            class ReadClass{
              private $post_tbl = "tbl_post";
              private $cat_tbl = "tbl_cat";
              public function readQuery(){
                $sql = "SELECT $this->post_tbl.*,$this->cat_tbl.name FROM $this->post_tbl INNER JOIN $this->cat_tbl ON $this->post_tbl.cat = $this->cat_tbl.id ORDER BY $this->post_tbl.id DESC";
                $stmt = db::blogPrepare($sql);
                $stmt->execute();
                return $stmt->fetchAll();
              }
            }
            $ReadClassObj = new ReadClass();
            $result = $ReadClassObj->readQuery();

            $serial = 0;
             if($result){
             foreach ($result as $value) {
               $serial++;
                ?>
                <tr class="odd gradeX">
    							<td><?php echo $serial;?></td>
    							<td><?php echo $objFormat->adminPanelTxtShort($value["title"]);?></td>
                                <td><?php echo $value["name"];?></td>
    							<td><img width="50px" height='auto' src="<?php echo $value["img"];?>" alt=""></td>
    							<td><?php echo $objFormat->adminPanelTxtShort($value["body"]);?></td>
    							<td><?php echo $value["author"];?></td>
    							<td><?php if(empty($value["tags"])){echo "<span style='color:red'>Blank</span>";}else{echo $value["tags"];}?></td>
    							<td><span style="color:green"><?php echo $objFormat->dateFormat($value["date"]);?></span></td>
    							<td style="text-align:center;">
                    <a href="post-view.php?view_post=<?php echo $value["id"]; ?>">View</a>
                    <?php if(session::get("userID") == $value["user_id"] || session::get("role") == 1 ){?>
                    || <a href="edit-post.php?edit=<?php echo $value["id"]; ?>">Edit</a> ||
                    <a onclick="return confirm('Are you sure to delete??')" href="post-delete.php?delete=<?php echo $value["id"]; ?>">Delete</a>
                  <?php } ?>
                  </td>
    						</tr>
                <?php
                }
             }
            ?>
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
unset($_SESSION['deleteccessPost']);
unset($_SESSION['successupdatepost']);
?>
