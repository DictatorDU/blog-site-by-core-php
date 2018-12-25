<div class="grid_2">
    <div class="box sidemenu">
        <div class="block" id="section-menu">
            <ul class="section menu">
               <li><a class="menuitem">Site Option</a>
                    <ul class="submenu">
                        <li><a href="titleslogan.php">Title & Slogan</a></li>
                        <li><a href="social.php">Social Media</a></li>
                        <li><a href="copyright.php">Copyright</a></li>

                    </ul>
                </li>

                 <li><a class="menuitem">Pages</a>
                    <ul class="submenu">
                        <li><a href="addpage.php">Add page</a></li>
                        <?php
                         class selectPageName{
                           private $tbl_name = "tbl_page";

                           public function selectPageQuery(){
                             $sql = "SELECT * FROM $this->tbl_name";
                             $stmt = db::blogPrepare($sql);
                             $stmt->execute();
                             return $stmt->fetchAll();
                           }
                         }
                        $pageSelectObj = new selectPageName();
                        foreach ($pageSelectObj->selectPageQuery() as $pageValue) {
                        ?>
                        <li><a href="read-page.php?pageId=<?php echo $pageValue["id"];?>"><?php echo $pageValue["name"];?></a></li>
                      <?php } ?>
                    </ul>
                </li>
                <li><a class="menuitem">Category Option</a>
                    <ul class="submenu">
                      <?php if(session::get("role") == 1 || session::get("role") == 3){ ?>
                        <li><a href="addcat.php">Add Category</a> </li>
                      <?php } ?>
                        <li><a href="catlist.php">Category List</a> </li>
                    </ul>
                </li>
                <li><a class="menuitem">Post Option</a>
                    <ul class="submenu">
                        <li><a href="addpost.php">Add Post</a> </li>
                        <li><a href="postlist.php">Post List</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
