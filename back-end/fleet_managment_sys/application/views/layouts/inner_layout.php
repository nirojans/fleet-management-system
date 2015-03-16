<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title><?= $title ?></title>
		<!--  SEO meta contents keywords -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author"
		content="University Of Moratuwa Faculty Of Information Technology" />
		<meta name="description"
		content="Vehicle Tracking System for Srilanka Port Authority" />
		<meta charset="UTF-8" />
		<meta name="keywords"
		content="srilanka port authority, SLPA,UOM,FIT,vehicle tracking system" />

		<link rel="shortcut icon" href="assets/images/fav_icon/fav.png" />

		<link href=<?= base_url() . 'assets/styles/Gbuttons.css' ?> rel="stylesheet" >
		<link href=<?= base_url() . 'assets/styles/bootstrap.min.css' ?> rel="stylesheet">
		<?php $this -> load -> file("assets/google/googleAnalyticsTracking.php"); ?>

		<script src="assets/javascript/jquery-1.8.3.js"></script>
		<script src="assets/javascript/jquery-ui-1.9.2.js"></script>
		<script type="text/javascript" src=
<?= base_url() . 'assets/javascript/login.js' ?> ></script>
		<script src="assets/javascript/bootstrap.min.js"></script>
	</head>
<? $this -> load -> view($content, $content_data); ?>
</html>		