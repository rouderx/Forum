<?php
	include 'cnf.php';
	include '../functions.php';
	session_start();
	if (isset($_POST['submit'])&&$_POST['submit']!="") {
		$_POST['success'] = false;
		$nameErr = $emailErr = $passErr = $pass2Err = "";
		$_name = $_email = $_pass = "";
		if (empty($_POST["username"])) {
		    $nameErr = "Potrebné vyplniť!";
	  	} else {
	  		$_name = str_replace(' ', '-', $_POST["username"]); // Replaces all spaces with hyphens.
			$_name = preg_replace('/[^A-Za-z0-9\-\_]/', '', $_name);
		    if (strlen($_name) < 4) {
		    	$nameErr = "Meno je príliš krátke! Min 4 znaky.";
		    } elseif (strlen($_name) > 20) {
		    	$nameErr = "Meno je príliš dlhé! Max 20 znakov.";
		    }
		    if(ifUserExist(NULL,$_name))$nameErr = "Zadané meno už existuje!";
	  	}

	 	if (empty($_POST["email"])) {
		    $emailErr = "Potrebné vyplniť!";
	  	} else {
		    // Remove all illegal characters from email
			$_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
			if (!filter_var($_email, FILTER_VALIDATE_EMAIL) === false) {
			    if(checkEmail($_email)){$emailErr = "Zadaný e-mail už existuje!";}
			} else {
    			$emailErr = "E-mail nie je platný!";
			}
	  	}

	  	if (empty($_POST["password"])) {
		    $passErr = "Potrebné vyplniť!";
	  	} else if (empty($_POST["password2"])) {
		    $pass2Err = "Potrebné vyplniť";
	  	} else if ($_POST["password"] != $_POST["password2"]) {
		    $passErr = "Heslá sa nezhodujú!";
	  	} else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
	  		$passErr = "Povolené znaky sú a-z A-Z 0-9";
	  	} else if (strlen($_POST['password']) < 6){
	  		$passErr = "Heslo je príliš krátke! Min 6 znakov.";
	  	} else {
	  		$_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
	  	}
		
	  	if (empty($nameErr) && empty($emailErr) && empty($passErr) && empty($pass2Err)) {
	  		$_veri = uniqid();
			$ret = addUser($_name,$_pass,$_email,$_veri);
			
			if($ret == true){
				sendActivationMail($_veri,$_email);
				header("Location: http://sem.devrouder.cz/activation?success");
				die();
			} else {
				echo $ret;
			}
		    
	  	}

	}
	$title = "LForum - registrácia";
	include '../begin.php';
	include '../header.php';
?>

<div class="full-height container">
	<div class="row text-center m-b"><h3>Registrácia nového používateľa</h3></div>
	<div class="row col-md-6 col-md-offset-3">
		<form method="post">
			<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">Meno:</span>
				<input class="col-md-5" type="text" name="username"><?php echo "$nameErr";?><br>
			</div>
			<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">Email:</span>
				<input class="col-md-5" type="email" name="email"><?php echo "$emailErr";?><br>
			</div>
			<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">Heslo:</span>
				<input class="col-md-5" type="password" name="password"><?php echo "$passErr";?><br>
			</div>
			<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">Znovu:</span>
				<input class="col-md-5" type="password" name="password2"><?php echo "$pass2Err";?><br>
			</div>
			<div class="text-center">
				<input type="submit" name="submit" value="Odoslať">
			</div>
		</form>
	</div>
</div>

<?php include '../end.php'; ?>