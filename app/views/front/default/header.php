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
		cursor:pointer;
	}
	.social-media-icon:hover{
		text-decoration:none;
	}
	#share-box { 

	}
	#header-container {
		height: 90px;
	}
	#header-logo, #share-box {
		height:45px;
	}
	#header-logo, #header-container #share-box {
		margin: 20px 0;
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

    <header>
        <div id="header-container" class="container">
            <div id="logo" class="col-sm-8">
                <img id="header-logo" src="<?php echo $logo_url ?>">
            </div>
            <div id="share-box" class="col-sm-4">
            	<a href="https://www.facebook.com/sharer/sharer.php" class="social-media-icon">
					<i class="fa fa-facebook-square"></i>
				</a>
				<a href="https://plus.google.com/share" class="social-media-icon">
					<i class="fa fa-google-plus-square"></i>
				</a>
				<a href="http://twitter.com/share" class="social-media-icon">
					<i class="fa fa-twitter-square"></i>
				</a>
				<a href="https://www.linkedin.com/shareArticle" class="social-media-icon">
					<i class="fa fa-linkedin-square"></i>
				</a>
            </div>        
        </div>
    </header>

  	<?php include_once('navbar.php'); ?>
        <div id="page-content" class="container">
 			<div id="left-content" class="col-sm-9">