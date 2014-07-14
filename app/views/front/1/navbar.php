<?php ?>

<nav class="navbar navbar-default" role="navigation" style="border-radius:0;-webkit-border-radius:0;-moz-border-radius:0;">
  <div class="container">
    <span class="navbar-brand"><?php echo $site_title ?> - <?php echo $site_subtitle ?></span>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav pull-right">
        <?php
        if (!empty($primary_menu)) {
          foreach ($primary_menu as $slug=>$title) {
            echo "<li><a href=\"$slug\">$title</a></li>";
          }
        }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>