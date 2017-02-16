<?php 
	include 'cnf.php';
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LForum</title>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<!--<link rel="stylesheet" type="text/css" href="bootstrap-theme.min.css">-->
	<style type="text/css">
		#logo {
			width: 50px;
		}

		.navbar-default {
			background-color: white;
		}

		.navbar {
		    -webkit-box-shadow: 0px 0px 9px 0px rgba(153, 153, 153, 0.26);
		    -moz-box-shadow: 0px 0px 9px 0px rgba(153, 153, 153, 0.26);
		    box-shadow: 0px 0px 9px 0px rgba(153, 153, 153, 0.26);
		    border-radius: 0px !important;
		    border-top: 0px;
		    border-left: 0px;
		    border-right: 0px;
		    /* the rest of your styling */
		}

		.container {
			min-width: 240px;
		}

		.navbar-brand {
			padding: 0 0 0 15px;
		}
	</style>
</head>
<body>
		<nav class="navbar navbar-default">
		  <div class="container container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">
		        <img alt="Brand" src="logo.png" id="logo">
		      </a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li><a href="#">Home</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="#">Prihlásenie/Registrácia</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<div class="container">
			<div class="row col-md-6">
				<div class="col-md-6">eefasdfadfa</div>
				<div class="col-md-6">bbb</div>
			</div>
			<div class="row col-md-6">
				<div class="col-md-6">
					ccdasdfadsdsfsdfsdf
				</div>
				<div class="col-md-6">
					dsfadaffsdfdsf
				</div>
			</div>
		</div>
	

		<!--<div class="registracia">
			<h4>Registrácia!</h4>
			<form method="POST" id="register-form">
				Username:
				<input type="text" name="username">
				<br>Password:
				<input type="password" name="password">
				<br>Again password:
				<input type="password" name="password2">
				<br>E-mail:
				<input type="email" name="email">
				<br><input type="submit" name="submit" value="Odoslať" onclick="return submitForm('reg')">
			</form>
		</div>
		<div class="prihlasenie">
			<h4>Prihlásenie!</h4>
			<form method="POST" id="login-form">
				Username:
				<input type="text" name="username">
				<br>Password:
				<input type="password" name="password">
				<br><input type="submit" name="submit" value="Prihlásiť" onclick="submitForm('log')">
			</form>
		</div>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
</body>
</html>