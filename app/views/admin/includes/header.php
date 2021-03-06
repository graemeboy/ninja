<html>

<head>
    <title>
        <?php echo $meta_title ?>
    </title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/dashicons/css/dashicons.css" rel="stylesheet">
    
    <script src="/public/js/jQuery/jquery.min.js" type="text/javascript"></script>
    <script src="/public/js/jQuery/jquery.migrate.min.js" type="text/javascript"></script>
    <script src="/public/js/utils.js" type="text/javascript"></script>
<!--     <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
 -->    <?php
    // Load any other scripts that a particular view requires.
    if (!empty($scripts)) {
        foreach ($scripts as $script_src) {
            echo "<script src=\"$script_src\" type=\"text/javascript\"></script>";
        } // foreach
    } // if
    if (!empty($styles)) {
        foreach ($styles as $href) {
            echo "<link href=\"$href\" type=\"text/css\" rel=\"stylesheet\">";
        } // foreach
    } // if
    ?>
    
    <style type="text/css">
        body {
            /*font-family: 'Open Sans', 'Lucida Grande', helvetica, sans-serif;*/
            /*font-family: sans-serif;*/
            font-family: 'Helvetica Neue', sans-serif;
            font-weight: 300;
            color: white;
        }
        h1,h2,h3,h4 {
            font-weight: 100;
            /*font-weight: normal*/
        }
        .form-control {
            background: rgba(0,0,0,0.15);
            border: none;
            color: #fff;
/*
            height: 40px;
            padding: 10px 14px;
*/
            font-weight: 300;
            border-radius: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
        }
        /* Tables */
        .admin-table {
            background:rgba(0,0,0,0.1);
        }
        .edit-page-action {
            height:45px;
        }
        .action-col {
            text-align: center;
        }
        .edit-page-icon, .edit-page-title {
            text-align:center;   
        }
        .edit-page-icon {
            font-size: 22px;
            margin-bottom: 5px;
        }
        td.edit-post-actions {
            padding: 0 !important;   
        }
        .admin-table a:hover {
            text-decoration: none;
        }
        table.admin-table>tbody>tr>td, table.admin-table>thead>tr>th {
            height:60px;
            padding: 0 15px;
            vertical-align: middle;
        }
        table.admin-table>tbody>tr>td:hover {
            background:rgba(255,255,255,0.1);
        }
        table.admin-table>tbody>tr>td, table.admin-table>thead>tr>th {
            border-color: rgba(0,0,0,0.1);
        }
        .admin-table td, label {
            font-weight: 300;   
        }
        .admin-table td a, .admin-table th {
            font-weight: normal;   
        }
        .table-select {
            width: 30px;
        }
        .admin-table a {
            color: #fff;
        }
        .form-control:focus {
            border: none;
            box-shadow:  none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            transition: none;
            -moz-transition: none;
            -webkit-transition: none;
        }
        .form-control::-webkit-input-placeholder { /* WebKit browsers */
            color:    #fff;
        }
        .form-control:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color:    #fff;
            opacity:  1;
        }
        .form-control::-moz-placeholder { /* Mozilla Firefox 19+ */
            color:    #fff;
            opacity:  1;
        }
        .form-control:-ms-input-placeholder { /* Internet Explorer 10+ */
            color:    #fff;
        }
        
        #admin-header-wrap {
            background-color: #333;
            padding: 10px;
            font-weight: 300;
        }
        #admin-head-title {
            font-size: 16px
        }
        #admin-header-wrap,
        #admin-header-wrap a {
            color: #fff;
        }
        /* Side Menu */
        #admin-menu {
            height: 100%;
            overflow-y: scroll;
            background-color: #3d3f3e;
            font-weight: 300;
        }
        #admin-menu a {
            color: #fff;   
        }
        #admin-menu {
            padding: 0;
            background: rgba(255, 255, 255, 0.1);
        }
        #admin-menu, #admin-header-wrap {
            box-shadow: 0 0 15px 2px rgba(0, 0, 0, 0.1);   
        }
        .nav-menu-title {
            font-size: 16px;
        }
        .nav-menu-item {

        }
        .nav-menu-list {
            padding-right:0;   
        }
        .nav-menu-title {
            display: block;
            width: 100%;
            padding: 15px 10px 10px 20px;
            height: 65px;
        }
        .nav-inner-menu {
            padding: 0;
            display: none;
            text-align: center;
        }
        .inner-menu-active {
            /*background-color: #2f3130;*/
            background: rgba(0, 0, 0, 0.1);
        }
        .nav-inner-menu a {
            font-size: 15px;
            display: inline-block;
            padding: 10px 5px 10px 15px;
            width:100%;
            /*border-bottom: 1px solid rgba(0,0,0,0.05);*/
        }
        .nav-inner-menu a:hover, a.nav-menu-title:hover  {
            text-decoration: none;
        }
        a.nav-menu-title:hover {
            background: rgba(0, 0, 0, 0.1);
        }
        .nav-menu-item a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .nav-item-active {
            border-right: 5px solid #5dd680;
            font-weight: 400;
            background:rgba(255,255,255,0.1);
        }
        .admin-menu-icon {
            margin-right: 15px;
            font-size: 35px;
        }
        #dashboard-splash {
            background-color: #fff;
        }
        h2.page-title, h3.page-title {
            /*font-weight: 100;*/
            /*font-weight: normal*/
        }
        h2.page-title {
            margin: 30px 0;
            font-size: 37px;
        }
        h3.page-title {
            margin: 15px 0 15px 30px;
            font-size: 22px;
        }
        h3.page-subtitle {
            font-size: 29px;
        }
        textarea.edit-content {
            height: 200px;   
        }
        .btn {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 0;
            border: none;
            font-weight: 300;
        }
        .btn-success:hover, .btn-success:active, .btn-success:focus {
            background:rgba(255,255,255,0.3);
        }
        
/*
 * Mark it up
 */
        
.markItUpHeader {
    margin-bottom: 5px;
}
.markItUpHeader ul {
    padding-left: 0;
}
.markItUpHeader ul li	{
	list-style:none;
    display:inline-block;
}
.markItUpHeader ul .markItUpDropMenu li {
	margin-right:0px;
}
.markItUpHeader ul a {
	display:block;
	padding: 10px;
    width: 45px;
    text-align:center;
    color: #fff;
    background: rgba(0,0,0,0.2);
    line-height:14px;
}
        .markItUpHeader ul a:hover {
            text-decoration: none;
            background: rgba(255,255,255,0.1);
        }
        

        /*
            Appearance page
         */
        .appearance-item {
            display: block;
            float:left;
            margin-right:5px;
            margin-bottom:5px;
            padding:5px;
            height:250px;
            width:250px;
            background:rgba(0,0,0,0.1);
        }
        .appearance-item:hover {
            background:rgba(0,0,0,0.5);
        }
        .appearance-preview {
            height:240px;
            width:240px;
            background-repeat: no-repeat;
        }
        .appearance-active {
            background:rgba(255,255,255,0.5);
        }

        /*
            Notifications
         */
        .notification-wrapper {
            display:none;
        }
        .notification {
            height: 40px;
            padding: 11px 20px;
            font-size: 16px;
            line-height: 18px;
            background: rgba(0,0,0,0.3);
            margin: 5px 0;
            display: inline-block;
            position:fixed;top:30px;left:40%;
        }

        /*
            Add content styles
         */
        .embed-code {
            border: 1px solid rgba(0,0,0,0.1);
            margin: 10px 0;
            padding: 10px;
            font-family: monospace;
            white-space: pre-wrap;       /* css-3 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
        .embed-item {
            margin-bottom: 10px;
        }
        /*
            Admin Panel
         */
        .admin-panel {
            background: rgba(0,0,0,0.1);
        }
        .admin-panel .panel-heading {
            background: rgba(0,0,0,0.1);
        }

        /*
            Menu Settings Page
         */
         label.menu-check-label {
            font-weight: 400;
         }
         div.menu-check-wrap {
            margin:15px 0;
         }

         /*
            Sidebar Settings Page
          */
         
         textarea.widget-textarea {
            height: 187px;
         }

         /*
            Theme Settings
          */
         


         /*
            Sea Foam Theme
          */
         body.samurai {
            background: linear-gradient(to bottom, #668188 0%,#3c5760 100%);
         }
        body.samurai #admin-header-wrap {
            background:  linear-gradient(to right, #668188 0%,#3c5760  100%);
        }

         /*
            Ninja Theme
          */
         body.ninja {
            background: linear-gradient(to bottom, #474747 0%,#242424 100%);
         }
         body.ninja #admin-header-wrap {
            background: linear-gradient(to right, #474747 0%,#242424 100%);
         }

         body.geisha {
            background: linear-gradient(to bottom, #FF5E5E 0%,rgba(168, 24, 168, 0.79) 100%);
         }
         body.geisha #admin-header-wrap {
            background: linear-gradient(to right, #FF5E5E 0%,rgba(168, 24, 168, 0.79) 100%);
         }

         body.tiger {
            background: linear-gradient(to bottom, rgba(255, 199, 79, 1) 0%, #665B4E 100%);
         }
        body.tiger #admin-header-wrap {
            background: linear-gradient(to right, rgba(255, 199, 79, 1) 0%, #665B4E 100%);
            /*background:linear-gradient(to bottom, #55 0%, #333 100%);*/
         }

         body.emperor {
            background: linear-gradient(to bottom, #3E315F 0%,rgba(112, 97, 165, 0.79) 100%);
         }

         body.emperor #admin-header-wrap {
            background: linear-gradient(to right, #3E315F 0%,rgba(112, 97, 165, 0.79) 100%);
         }

         body.zen {
            background: linear-gradient(to bottom, rgba(89, 235, 255, 1) 0%, #3E5D64 100%);
         }

         body.zen #admin-header-wrap {
            background: linear-gradient(to right, rgba(79,185,200, 0.3) 0%, rgba(79,185,200, 0) 100%);
         }

         body.jade {
            background: linear-gradient(to bottom, rgba(121, 175, 123, 1) 0%, #1A3D20 100%);
         }

         body.jade #admin-header-wrap {
            background: linear-gradient(to right, rgba(67,110,71, 0.4) 0%, rgba(67,110,71, 0) 100%);
         }
    </style>
</head>

<body class="<?php echo $admin_theme ?>">
    <div id="admin-wrap">
        <!-- <div id="admin-header-wrap">
            <div id="admin-header-left" class="container-fluid pull-left">
                <span id="admin-head-title" class="site-title"><a href="/"><?php echo $site_title ?></a> - <?php echo $site_subtitle ?></span>
            </div>
            <div id="admin-header-right" class="container-fluid pull-right">
                <a href="" class="admin-logout-link"><i class="dashicons dashicons-migrate" style="font-size:1.3em;height:auto;width:auto;"></i> Logout</a>
            </div>
            <div class="clearfix"></div>
        </div> -->
        <!-- #admin-header-wrap -->

        <div id="admin-menu" class="col-sm-1">
            <?php include_once( 'navigation/nav.php') ?>
        </div>
        <div id="admin-content" class="col-sm-11">
            <div class="container-fluid">