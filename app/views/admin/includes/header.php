<html>

<head>
    <title>
        <?php echo $meta_title ?>
    </title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/dashicons/css/dashicons.css" rel="stylesheet">
    
    <script src="/public/js/jQuery/jquery.min.js"></script>
    <script src="/public/js/jQuery/jquery.migrate.min.js"></script>
<!--    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>-->
    <?php
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
/*            font-family: 'Open Sans', 'Lucida Grande', helvetica, sans-serif;*/
            font-family: sans-serif;
            font-weight: lighter; 
            color: white;
            background:  linear-gradient(to bottom, #668188 0%,#3c5760  100%);
        }
        .form-control {
            background: rgba(0,0,0,0.15);
            border: none;
            color: #fff;
/*
            height: 40px;
            padding: 10px 14px;
*/
            border-radius: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
        }
        /* Tables */
        .admin-table td, label {
            font-weight: lighter;   
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
            background:  linear-gradient(to right, #668188 0%,#3c5760  100%);
        }
        #admin-header-wrap {
            background-color: #333;
            padding: 10px;
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
            background-color: #3d3f3e
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
            padding: 5px;
            margin: 5px 0 5px 10px;
        }
        .nav-menu-list {
            padding-right:0;   
        }
        .nav-menu-title {
            display: block;
            width: 100%;
            padding: 10px 10px 10px 20px;
        }
        .nav-inner-menu {
            padding: 0 0 5px 0;
            margin-left: 36px;
            display: none;
        }
        .inner-menu-active {
            /*background-color: #2f3130;*/
            background: rgba(0, 0, 0, 0.1);
        }
        .nav-inner-menu a {
            font-size: 14px   
        }
        .nav-inner-menu a:hover, a.nav-menu-title:hover  {
            text-decoration: none;
        }
        a.nav-menu-title:hover {
            background: rgba(0, 0, 0, 0.1);
        }
        .nav-menu-item a:hover {
            color: #daf2fa !important;
        }
        .nav-item-active {
            border-right: 5px solid #5dd680;
        }
        .admin-menu-icon {
            margin-right: 15px;
        }
        #dashboard-splash {
            background-color: #fff;
        }
        h2.page-title, h3.page-title {
            font-weight: 100;
        }
        h2.page-title {
            margin: 30px;
            font-size: 34px;   
        }
        h3.page-title {
            margin: 15px 0 15px 30px;
            font-size: 22px;
        }
        textarea.edit-post-content, textarea.edit-page-content {
            height: 200px;   
        }
        .btn {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 0;
            border: none;
            font-weight: lighter;
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
        
        .edit-page-icon, .edit-page-title {
            text-align:center;   
        }
        .edit-page-icon {
            font-size: 22px;
            margin-bottom: 5px;
        }
        a.edit-page-action {
            display:inline-block;
            padding:10px;
            text-align:center
        }
        td.edit-post-actions {
            padding: 0 !important;   
        }
        a.edit-page-action:hover {
            background: rgba(255,255,255,0.1);   
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="admin-wrap">
        <div id="admin-header-wrap">
            <div id="admin-header-left" class="container-fluid pull-left">
                <span id="admin-head-title"><?php echo SITETITLE ?></span>
            </div>
            <div id="admin-header-right" class="container-fluid pull-right">
                <a href="" class="admin-logout-link"><i class="dashicons dashicons-migrate" style="font-size:1.3em;height:auto;width:auto;"></i> Logout</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- #admin-header-wrap -->

        <div id="admin-menu" class="col-sm-2">
            <?php include_once( 'navigation/nav.php') ?>
        </div>
        <div id="admin-content" class="col-sm-10">