<html>

<head>
    <title>
        <?php echo $meta_title ?>
    </title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <style type="text/css">
        body {
            font-family: 'Open Sans', 'Lucida Grande', helvetica, sans-serif;
            font-weight: lighter; 
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
            padding-top: 10px 0;
            padding-right: 0;
            padding-left:0; 
        }
        .nav-menu-title {
            font-size: 16px;
        }
        .nav-menu-title, .nav-menu-list {
            padding: 10px;
        }
        .nav-menu-item {
            padding: 5px;
            margin: 5px 0 5px 10px;
        }
        .nav-menu-list {
            padding-right:0;   
        }
        .nav-menu-title {
        }
        .nav-inner-menu {
            margin-top: 5px;
            margin-left: 36px;
            display: none;
        }
        .inner-menu-active {
            background-color: #2f3130;
        }
        .nav-inner-menu a {
            font-size: 14px   
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
    </style>
</head>

<body>
    <div id="admin-wrap">
        <div id="admin-header-wrap">
            <div id="admin-header-left" class="container-fluid pull-left">
                <span id="admin-head-title"><?php echo SITETITLE ?></span>
            </div>
            <div id="admin-header-right" class="container-fluid pull-right">
                <a href="" class="admin-logout-link">Logout</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- #admin-header-wrap -->

        <div id="admin-menu" class="col-sm-2">
            <?php include_once( 'navigation/nav.php') ?>
        </div>
        <div id="admin-content" class="col-sm-10">