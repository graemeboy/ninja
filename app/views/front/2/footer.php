    </div> <!-- left content -->
    <?php include_once('sidebar.php'); ?>
    <div class="clearfix"></div>
</div> <!-- page content -->

    <hr>
    <div id="footer" class="container">
        <footer>
        	<div class="container">
                <ul class="menu-secondary"><?php
                    foreach ($secondary_menu as $slug=>$title) { ?>
                        <li style="list-style:none;display:inline-block;padding-right:10px"><a href="<?php echo $slug ?>"><?php echo $title ?></a></li>
                    <?php }
                ?></ul>
    		</div>
        </footer>
        <div id="copyright"><?php echo $copyright ?></div>
        <div class="clearfix"></div>
    </div>
</body>
</html>