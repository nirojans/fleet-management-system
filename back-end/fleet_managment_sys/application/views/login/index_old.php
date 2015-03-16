<?php $this -> load -> file("assets/google/googleAnalyticsTracking.php"); ?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Welcome to SLPA Vehicle Tracking System</title>
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
		<link href=<?= base_url() . 'assets/styles/login.css' ?> rel="stylesheet" type="text/css" />

		<script src="assets/javascript/jquery-1.8.3.js"></script>
		<script src="assets/javascript/jquery-ui-1.9.2.js"></script>
		<script type="text/javascript" src=
<?= base_url() . 'assets/javascript/login.js' ?> ></script>
		<script src="assets/javascript/bootstrap.min.js"></script>

	</head>
	<body id="body_first">
		<div class="row fixer">
			<div class="col-md-6 col-md-offset-3 text-center">
				<h3> Welcome to SLPA Vehicle Tracking System </h3>
			</div>
			<div class="row fixer">
				<div class="col-md-8 col-md-offset-2 effect8" style="background-color: #D9D9D9;" >
					<?php if(validation_errors()){?>

					<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
							&times;
						</button>
						<?php echo validation_errors(); ?>
					</div>
					<?php } ?>
					<br />
					<div class="row fixer">

						<div class="col-md-10">

							<?php
							$attributes = array('class' => "form-horizontal", 'name' => "signin", 'id' => "login_form");
							echo form_open('authenticate', $attributes);
							?>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Computer Number</label>
								<div class="col-sm-10">
									<input class="form-control" onkeyup="check_computer_number(this)" type="text" id="login" name="username" required="required" placeholder="Computer number" autofocus  />
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input class="form-control" type="password" name="password" id="password" required="required" placeholder="Password" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button class="btn btn-primary" type="submit" id="submit_button" name="submit">
										Sign in
										<!-- <img id="error" width="16" height="16" ></img> -->
									</button>

								</div>

							</div>
							</form>
							<!-- <img style="display: none" id="loading_image" src="assets/images/images/logins/login_loading.gif" /> -->
						</div>

						<div class="col-md-2">
							<img src="assets/images/fav_icon/fav.png" id="fit11" />
						</div>

					</div>

				</div>

			</div>

		</div>

		<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
			<div class="container">

				<a class="navbar-brand" href="#">V 14.2.8</a>

				<a  rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US"><img  alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" /></a>
				<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Server Program</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="slpa.knnect.com" property="cc:attributionName" rel="cc:attributionURL">SysCall</a>
				is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US">Creative Commons Attribution-NonCommercial 3.0 Unported License</a>

			</div>
		</nav>

	</body>

</html>
