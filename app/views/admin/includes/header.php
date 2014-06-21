<html>

<head>
    <title><?php echo $meta_title ?></title>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <style type="text/css">
        #admin-header-wrap {
            background-color: #333;
            padding: 8px;
        }
        #admin-header-wrap, #admin-header-wrap a {
            color:#fff;   
        }
        /* Side Menu */
        #admin-menu {
            height: 100%;
            overflow-y: scroll;
        }
        #admin-menu {
            padding-top: 10px;
            padding-right:0;
        }
        .nav-menu-subtitle {
            color: #bbb;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .nav-menu-item {
            padding: 10px;
        }
        .nav-item-active {
            border-right: 2px solid green;
        }
        .admin-menu-icon {
            margin-right: 15px;
        }
        
    </style>
</head>

<body>
    <div id="admin-wrap">
        <div id="admin-header-wrap">
            <div id="admin-header-left" class="container-fluid pull-left">
              <?php echo $head_title ?>  
            </div>
            <div id="admin-header-right" class="container-fluid pull-right">
                <a href="" class="admin-logout-link">Logout</a>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div id="admin-menu" class="col-sm-2">
            <?php include_once('navigation/nav.php') ?>
        </div>
        <div id="admin-content" class="col-sm-10">
        Main admin content