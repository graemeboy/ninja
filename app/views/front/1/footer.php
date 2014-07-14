    </div> <!-- left content -->
    <?php include_once('sidebar.php'); ?>
    <div class="clearfix"></div>
</div> <!-- page content -->

    <hr>
    <div id="footer" class="container">
    	<div class="container">
            <div class="row">
                <ul>
                    <?php
                    if (!empty($primary_menu)) {
                      foreach ($primary_menu as $slug=>$title) {
                        echo "<li style='list-style:none;display:inline-block;padding-right:10px'><a href=\"$slug\">$title</a></li>";
                      }
                    }
                    ?>
                </ul>
            </div>
    	</div>
        <div class="clearfix"></div>
    </div>
</body>
</html>