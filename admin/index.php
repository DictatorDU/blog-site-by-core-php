<?php include("inc/header.php");?>
﻿<?php include("inc/sidebar.php");?>

<div class="grid_10">

    <div class="box round first grid">
        <h2> Dashbord</h2>
        <div class="block">
          <?php if(isset($_SESSION["successDeletePage"])){echo "<h4 style='color:green'>You have successfuly deleted a page</h4>";}?>
        </div>
    </div>
</div>
<?php
 unset($_SESSION['successDeletePage']);
?>
<?php include("inc/footer.php");?>
