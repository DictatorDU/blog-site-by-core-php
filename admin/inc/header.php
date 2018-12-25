<?php
include("lib/session.php");
session::init();
session::chkSession();
include("lib/db-connection/db.php");
include("lib/format.php");
$objFormat = new FormatClass();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title> Admin pannel</title>
    <?php
     class readTitle{
       private $tbl_name = "tbl_slogan";
       public function readQuery(){
         $sql = "SELECT * FROM $this->tbl_name LIMIT 1";
         $stmt = db::blogPrepare($sql);
         $stmt->execute();
         return $stmt->fetchAll();
       }
     }
    $readData = new readTitle();
    $sloganResult = $readData->readQuery();
    foreach ($sloganResult as $slogan) {
      $web_nameName = $slogan["web_name"];
      $sloganName = $slogan["slogan"];
      $logoImg = $slogan["logo"];
    }
    ?>
    <link rel="icon" href="<?php if(isset($logoImg)){echo $logoImg;}?>">
    <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
    <link href="css/table/demo_page.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN: load jquery -->

    <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.accordion.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.slide.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.sortable.min.js" type="text/javascript"></script>
    <script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
    <!-- END: load jquery -->
    <script type="text/javascript" src="js/table/table.js"></script>
    <script src="js/setup.js" type="text/javascript"></script>
	 <script type="text/javascript">
        $(document).ready(function () {
            setupLeftMenu();
		    setSidebarHeight();
        });
    </script>

</head>
<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <div id="branding">
                <div class="floatleft logo">
                    <img src="<?php if(isset($logoImg)){echo $logoImg;}?>" alt="Logo" />
				</div>
				<div class="floatleft middle">
					<h1><?php if(isset($web_nameName)){echo $web_nameName;} ?></h1>
					<p><?php  if(isset($sloganName)){echo $sloganName;} ?></p>
				</div>
                <div class="floatright">
                    <div class="floatleft">
                        <img src="img/img-profile.jpg" alt="Profile Pic" /></div>
                    <div class="floatleft marginleft10">
                        <ul class="inline-ul floatleft">
                            <li><?php
                            $username = session::get("username");
                            $user_role = session::get("role");
                            function user_role($user_role){
                              if($user_role == 1){
                                return $user_role = "Admin";
                              }elseif($user_role == 2){
                                return $user_role = "Author";
                              }elseif($user_role == 3){
                                return $user_role = "Editor";
                              }
                            }
                            echo $username." (".user_role($user_role).")";
                            ?></li>
                            <?php
                              if(isset($_GET["action"]) && $_GET["action"] == "logout"){
                                session::sessionDestroy();
                              }
                            ?>
                            <li><a href="?action=logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
          <?php
          $path = $_SERVER['SCRIPT_FILENAME'];
          $c_page = basename($path,".php");
          ?>
          <style media="screen">
            #menu{
              background: #204562;
            }
          </style>
            <ul class="nav main">
                <li class="ic-dashboard"><a
                  <?php if($c_page == "index"){echo "id='menu'";}?>
                  href="index.php"><span>Dashboard</span></a> </li>
                <li class="ic-form-style"><a
                  <?php if($c_page == "user-profile"){echo "id='menu'";}?>
                  href="user-profile.php"><span>User Profile</span></a></li>
				<li class="ic-typography"><a
          <?php if($c_page == "changepassword"){echo "id='menu'";}?>
          href="changepassword.php">Change Password</a>
        </li>
        <?php
        class countUnseen{
          private $tbl_name = "tbl_contact";
          public function selectMsgQuery(){
            $sql = "SELECT * FROM $this->tbl_name WHERE newmsg = 0 ORDER BY id DESC";
            $stmt = db::blogPrepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
          }
        }
        $selectMsgObj = new countUnseen();
        $unseenMsg = $selectMsgObj->selectMsgQuery();
        ?>
				<li class="ic-grid-tables"><a
          <?php if($c_page == "inbox"){echo "id='menu'";}?>
          href="inbox.php?inbox"><span>Inbox<?php echo "(".$unseenMsg.")"?>
        </span></a></li>
                <?php if(session::get("role") == 1){?>
                <li class="ic-charts"><a
                  <?php if($c_page == "adduser"){echo "id='menu'";}?>
                  href="adduser.php"><span>Add user</span></a>
                </li>
              <?php } ?>
                <li class="ic-charts"><a
                  <?php if($c_page == "user-list"){echo "id='menu'";}?>
                   href="user-list.php"><span>User List</span></a></li>
                <?php if(session::get("role") == 1){?>
                <li class="ic-grid-tables"><a
                  <?php if($c_page == "slider"){echo "id='menu'";}?>
                   href="slider.php?add-slider"><span>Slider</span></a>
                 </li>
               <?php } ?>
                <?php if(session::get("role") == 1){?>
                <li class="ic-form-style"><a
                  <?php if($c_page == "theme"){echo "id='menu'";}?>
                   href="theme.php?theme"><span>Theme</span></a>
                 </li>
               <?php } ?>
            </ul>
        </div>
        <div class="clear">
        </div>
