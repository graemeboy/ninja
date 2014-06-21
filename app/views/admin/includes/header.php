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
        
        <div id="admin-menu" class="col-sm-3">
            <?php include_once('navigation/nav.php') ?>
        </div>
        <div id="admin-content" class="col-sm-9">
        