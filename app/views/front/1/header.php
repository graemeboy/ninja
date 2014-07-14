<?php
	extract($post_data); 
	extract($site_settings); 
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $meta_title ?></title>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' />
<link rel="stylesheet" type="text/css" href="<?php echo $bootstrap ?>" />
<link rel="stylesheet" type="text/css" href="/public/fontawesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet ?>" />
<style type="text/css">
	.social-media-icon {
		font-size:32px;
		height:45px;
		width:45px;
		padding-top:2px;
		margin-right:1px;
		cursor:pointer;
		background-color:#333;
		display:inline-block;
		text-align:center;
		color: #fff;
		float:right;
	}
	.social-media-icon:hover{
		text-decoration:none;
	}
	#share-box { 

	}
	#header-container {
		height: 60px;
	}
	#header-logo, #share-box {
		height:45px;
	}
	#header-logo, #header-container #share-box {
		margin: 5px 0;
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
</style>
</head>
<body>

	<?php include_once('navbar.php'); ?>

    <header>
        <div id="header-container" class="container">
            <div id="logo" class="col-sm-8">
                <img id="header-logo" src="<?php echo $logo_url ?>">
            </div>
            <div id="share-box" class="visible-md visible-lg col-sm-4">
            	<a href="https://www.facebook.com/sharer/sharer.php" class="social-media-icon">
					<i class="fa fa-facebook"></i>
				</a>
				<a href="https://plus.google.com/share" class="social-media-icon">
					<i class="fa fa-google-plus"></i>
				</a>
				<a href="http://twitter.com/share" class="social-media-icon">
					<i class="fa fa-twitter"></i>
				</a>
				<a href="https://www.linkedin.com/shareArticle" class="social-media-icon">
					<i class="fa fa-linkedin"></i>
				</a>
            </div>        
        </div>
    </header>
    <hr>

  	
        <div id="page-content" class="container">
 			<div id="left-content" class="col-sm-9">