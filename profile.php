<?php 
	session_start();
	include 'functions.php';
	if (!isset($_SESSION['user'])||$_SESSION['user']==""){
		header("Location: http://sem.devrouder.cz/");
		die();
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if ($_POST['submit'] == "Zmeniť e-mail"){
			$_err = $_succ = $_old_mail = $_new_mail = "";
			if(empty($_POST["old-mail"]) || empty($_POST["new-mail"])){
				$_err = "Všetky údaje musia byť vyplnené!";
			} else {
				$_old_mail = filter_var($_POST["old-mail"], FILTER_SANITIZE_EMAIL);
				$_new_mail = filter_var($_POST["new-mail"], FILTER_SANITIZE_EMAIL);

				if (!filter_var($_old_mail, FILTER_VALIDATE_EMAIL) === false || !filter_var($_new_mail, FILTER_VALIDATE_EMAIL) === false) {
					if(findUserByName($_SESSION['user'])['email']==$_old_mail){
						if (!checkEmail($_new_mail)){
							$_succ = updateEmail($_SESSION['user_id'],$_new_mail);
						} else {
							$_err = "Zle zadané údaje!";
						}
					} else {
						$_err = "Zle zadané údaje!";
					}
				} else {
	    			$_err = "E-mail nie je platný!";
				}
			}
		} else if ($_POST['submit'] == "Zmeniť heslo"){
			$_err = $_succ = "";
			if(empty($_POST["old-pass"]) || empty($_POST["new-pass"])){
				$_err = "Všetky údaje musia byť vyplnené!";
			} else {
				if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["old-pass"]) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["new-pass"])) {
			  		$_err = "Heslo/á obsahuje/ú nepovolené znaky! Povolené znaky sú a-z A-Z 0-9";
			  	} else if (strlen($_POST['new-pass']) < 6){
			  		$_err = "Nové heslo je príliš krátke! Min 6 znakov.";
			  	} else if (!password_verify($_POST['old-pass'], findUserByName($_SESSION["user"])['pass'])){
			  		$_err = "Staré heslo sa nezhoduje!";
			  	} else {
			  		$_pass = password_hash($_POST['new-pass'], PASSWORD_DEFAULT);
			  		$_succ = updatePass($_SESSION['user_id'],$_pass);
			  	}
			}
		} else {
			$_err = $_succ = "";
			if(empty($_POST['info'])){
				$_err = "Všetky údaje musia byť vyplnené!";
			} else {
				$_info = htmlentities($_POST['info'], ENT_QUOTES);
				if(findUser($_SESSION['user_id'])['info'] != $_info){
					$_succ = updateInfo($_SESSION['user_id'],$_info);
				}
			}
		}
	}

	$title = "LForum - Profile";
	include 'begin.php';
	include 'header.php';
?>
	<div class="container p-t">
		<?php 
			if(isset($_GET['user'])){
				$user = htmlentities($_GET['user'], ENT_QUOTES);
				if (!ifUserExist(NULL,$user)){ ?>
					<div class="col-md-12 text-center"><h3>Hľadaný používateľ neexistuje!</h3></div>
		<?php	} else { 
					$user = findUserByName($user); ?>
					<div class="col-md-2 col-md-offset-2">
						<img class="img-responsive p-pict" src="<?php echo $user['profile-image'];?>" alt="<?php echo $user['name'];?>">
					</div>
					<div class="col-md-6 info">
						<div class="col-md-12">
							<h2 class="b-b-1-lg"><?php echo $user['name'];?></h2>
						</div>
						<div class="col-md-12 m-b-s"><?php echo $user['info'];?></div>
						<div class="col-md-4 fs-17 col-sm-4 col-xs-10">Počet príspevkov:</div>
						<div class="col-md-2 fs-17 col-sm-2 col-xs-2"><?php echo numberOfThreads($user['id']);?></div>
						<div class="col-md-4 fs-17 col-sm-4 col-xs-10">Počet komentárov:</div>
						<div class="col-md-2 fs-17 col-sm-2 col-xs-2"><?php echo numberOfAnswers($user['id']);?></div>
					</div>
		<?php	}
			} else { 
				$user = findUser($_SESSION['user_id']);
				echo '<div class="col-md-12 text-center warning"><h4>'. $_err . $_succ ."</h4></div>"; ?>
				<div class="col-md-2 col-md-offset-2">
					<img class="img-responsive p-pict" src="<?php echo $user['profile-image'];?>" alt="<?php echo $user['name'];?>">
				</div>
				<div class="col-md-6 info">
					<div class="col-md-12"><h2 class="b-b-1-lg"><?php echo $user['name'];?></h2></div>
					<div class="row col-md-12" id="info" onclick="changeInfo();">&emsp;Zmeniť popis</div>
					<div class="row col-md-12" id="email" onclick="changeEmail();"">&emsp;Zmeniť e-mail</div>
					<div class="row col-md-12" id="pass" onclick="changePass();">&emsp;Zmeniť heslo</div>
					<button class="remove" id="<?php echo $_SESSION['user_id'];?>">Odstrániť</button>
					<div class="col-md-12 m-b-s"><div class="b-t-1-lg m-t-sm p-t-s"><?php echo $user['info'];?></div></div>
					<div class="col-md-4 col-sm-4 col-xs-10 fs-17">Počet príspevkov:</div>
					<div class="col-md-2 col-sm-2 col-xs-2 fs-17"><?php echo numberOfThreads($user['id']);?></div>
					<div class="col-md-4 col-sm-4 col-xs-10 fs-17">Počet komentárov:</div>
					<div class="col-md-2 col-sm-2 col-xs-2 fs-17"><?php echo numberOfAnswers($user['id']);?></div>
				</div>
		<?php } ?>	
	</div>
<?php include 'end.php'; ?>