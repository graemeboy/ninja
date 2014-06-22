<html>

<head>
    <title>
        <?php echo $meta_title ?>
    </title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <style type="text/css">
        #admin-header-wrap {
            background-color: #333;
            padding: 8px;
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
            font-size: 15px;
        }
        .nav-menu-item, .nav-menu-title, .nav-menu-list {
            padding: 10px;
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
            font-size: 13px   
        }
        .nav-item-active {
            border-right: 2px solid green;
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
                <?php echo APPPATH ?>
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