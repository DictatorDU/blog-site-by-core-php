<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>
<div class="grid_10">
    <div class="box round first grid">
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
      <?php
      if(!isset($_GET["inbox"]) && !isset($_GET["seen"])){
        echo "<strong><h1 style='color:red'>Error</h1></strong><br /><h3>Not found data..!!</h3>";
      }
      if(isset($_GET["inbox"])){?>
        <div id="testId"><h3><a id="active" href="inbox.php?inbox">Inbox</a></h3><h3><a href="inbox.php?seen">Seen</a><h3></div>
        <div class="block">
          <?php
           class upChk{
             private $tbl_name = "tbl_contact";
             public function newmsgquery(){
               $sql = "UPDATE $this->tbl_name SET newmsg=1";
               $stmt = db::blogPrepare($sql);
               return $stmt->execute();
             }
           }
           $newMsgObj = new upChk();
           $newMsgObj->newmsgquery();
          ?>
        <table class="data display datatable" id="example">
	<thead>
		<tr>
			<th style="text-align:center;" width="5%">No.</th>
			<th style="text-align:center;" width="10%">First Name</th>
			<th style="text-align:center;" width="10%">Last Name</th>
			<th style="text-align:center;" width="15%">Email</th>
			<th style="text-align:center;" width="20%">Message</th>
			<th style="text-align:center;" width="15%">Date</th>
			<th style="text-align:center;" width="20%">Action</th>
		</tr>
	</thead>
	<tbody>
      <?php
        class selectMsgClass{
          private $tbl_name = "tbl_contact";
          public function selectMsgQuery(){
            $sql = "SELECT * FROM $this->tbl_name WHERE status = 0 ORDER BY id DESC";
            $stmt = db::blogPrepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
          }
        }
        $selectMsgObj = new selectMsgClass();
        $selectMsgObj->selectMsgQuery();
        if($selectMsgObj->selectMsgQuery()){
          $i=0;
          foreach ($selectMsgObj->selectMsgQuery() as $value) {
          $i++;
      ?>
      <tr class="odd gradeX">
			<td><?php echo $i;?></td>
			<td><?php echo $value["first_name"];?></td>
			<td><?php echo $value["last_name"];?></td>
			<td><?php echo $value["email"];?></td>
			<td style="line-height:15px;"><?php echo $objFormat->adminMsgTxtShort($value["msg"]);?></td>
			<td style="line-height:15px;"><?php echo $objFormat->dateFormat($value["date"]);?></td>
      <td>
        <a href="inbox-read.php?inbox=<?php echo $value["id"];?>">View</a> ||
        <a href="reply-msg.php?reply=<?php echo $value["id"];?>"> Reply</a> ||
        <a href="delete-inbox.php?delete_from_inbox=<?php echo $value["id"];?>">Delete</a> ||
        <a href="seen-inbox.php?seen=<?php echo $value["id"];?>">Seen</a>
      </td>
		</tr>
    <?php
    }
  }
    ?>
	</tbody>
</table>
       </div>
     <?php }
     if(isset($_GET["seen"])){?>
      <div id="testId"><h3><a href="inbox.php?inbox">Inbox</a></h3><h3><a id="active" href="inbox.php?seen">Seen</a><h3></div>
      <div class="block">
      <table class="data display datatable" id="example">
<thead>
  <tr>
    <th style="text-align:center;" width="5%">No.</th>
    <th style="text-align:center;" width="10%">First Name</th>
    <th style="text-align:center;" width="10%">Last Name</th>
    <th style="text-align:center;" width="15%">Email</th>
    <th style="text-align:center;" width="25%">Message</th>
    <th style="text-align:center;" width="15%">Date</th>
    <th style="text-align:center;" width="15%">Action</th>
  </tr>
</thead>
<tbody>
    <?php
      class selectMsgClass{
        private $tbl_name = "tbl_contact";
        public function selectMsgQuery(){
          $sql = "SELECT * FROM $this->tbl_name WHERE status = 1 ORDER BY id DESC";
          $stmt = db::blogPrepare($sql);
          $stmt->execute();
          return $stmt->fetchAll();
        }
      }
      $selectMsgObj = new selectMsgClass();
      $selectMsgObj->selectMsgQuery();
      if($selectMsgObj->selectMsgQuery()){
        $i=0;
        foreach ($selectMsgObj->selectMsgQuery() as $value) {
        $i++;
    ?>
    <tr class="odd gradeX">
    <td><?php echo $i;?></td>
    <td><?php echo $value["first_name"];?></td>
    <td><?php echo $value["last_name"];?></td>
    <td><?php echo $value["email"];?></td>
    <td style="line-height:15px;"><?php echo $objFormat->adminMsgTxtShort($value["msg"]);?></td>
    <td style="line-height:15px;"><?php echo $objFormat->dateFormat($value["date"]);?></td>
    <td>
      <a href="inbox-read.php?inbox=<?php echo $value["id"];?>">View</a> ||
      <a href="reply-msg.php?reply=<?php echo $value["id"];?>"> Reply</a> ||
      <a href="delete-inbox.php?delete_from_seen=<?php echo $value["id"];?>">Delete</a></td>
  </tr>
  <?php
  }
}
  ?>
</tbody>
</table>
     </div>
   <?php
  }
    ?>
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
