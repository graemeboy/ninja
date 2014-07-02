<?php
	extract($post_data);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $meta_title ?></title>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $bootstrap ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $stylesheet ?>" />
<link rel="stylesheet" type="text/css" media="all" href="/public/fontawesome/css/font-awesome.min.css" />
<style type="text/css">
	.social-media-icon {
		font-size:40px;
		margin-right:5px;
		cursor:pointer;
		float:right;
	}
	.social-media-icon:hover{
		text-decoration:none;
	}
	#share-box { 

	}
	#header-container {
		height: 100px;
	}
	#header-logo, #menu-wrapper {
		height:45px;
	}
	#menu {
		height:30px;
	}
	#header-logo {
		margin: 40px 0;
	}
	#header-container #menu {
		margin:55px 0 0 0;
		border-bottom-width:3px;
		border-bottom-style:solid;
		float: left;
	}
	#logo {
		height:100%;
	}
	#footer {
		padding:10px 0;
	}
	#page-content {
		min-height:300px;
	}
	#copyright {
		text-align: center;
	}
</style>
</head>
<body>

    <header>
        <div id="header-container" class="container">
            <div id="logo" class="col-sm-5">
                <img id="header-logo" src="<?php echo $logo_url ?>">
            </div>
            <div id="menu-wrapper" class="col-sm-7">
            	<div id="menu">
            		Menu goes here
            	</div>
            </div>        
        </div>
    </header>
    <hr>

        <div id="page-content" class="container">
 			<div id="left-content" class="col-sm-9">