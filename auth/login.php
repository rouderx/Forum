<?php 
	include 'cnf.php';
	session_start();
	
	if (isset($_POST['submit'])&&$_POST['submit']!="") {
		$_err = $_errVerif = "";
		$_email = $_pass = "";
		if(empty($_POST['email']) || empty($_POST['password'])){
			$_err = "Všetky polia usia byť vyplnené!";
		} else {
			$_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
			$_pass = stripslashes($_POST['password']);
			try {
			    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $stmt = $conn->prepare("SELECT * FROM sem_users WHERE email = :email"); 
			    $stmt->bindParam(':email', $_email, PDO::PARAM_STR);

			    $stmt->execute();
			    $row = $stmt->fetchAll();
			    foreach($row as $row){
			    	$r_id = $row['id'];
			        $r_pass = $row['pass'];
			        $r_user = $row['name'];
			        $r_veri = $row['verif'];
			    }
			    if(password_verify($_pass, $r_pass)){
			    	if($r_veri != 'NULL'){
			    		$_errVerif = "Váš účet ešte nebol aktivovaný. Prosím aktivujte si ho!";
			    	} else {
			    		$_SESSION['user'] = $r_user;
			    		$_SESSION['user_id'] = $r_id;
			    		header("Location: http://sem.devrouder.cz/home");
						die();
			    	}
			    	
			    } else {
			    	$_err = "Zadané údaje sa nezhodujú!";
			    }
		    }	
			catch(PDOException $e)
		    {
		   		echo $sql . "<br>" . $e->getMessage();
		    }
			$conn = null;
		}
	}
	$title  = "LForum - prihlásenie";
	include '../begin.php';
	include '../header.php';
?>
	<div class="full-height container">
		<div class="row text-center m-b"><h3>Prihlásenie</h3></div>
		<div class="row col-md-5 col-md-offset-4">
			<form method="post">
				<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">E-mail:</span>
				<input class="col-md-5" type="email" name="email"><br>
				</div>
				<div class="text-center col-md-12 m-b-s">
				<span class="col-md-3">Heslo:</span>
				<input class="col-md-5" type="password" name="password"><br><?php echo "<div class='text-center col-md-12 warning'>$_err</div>"; ?>
				</div>
				<div class="text-center">
				<a class="col-md-5" href="/activation?reset">Zabudnuté heslo?</a>
				<input class="col-md-3" type="submit" name="submit" value="Odoslať">
				</div>
			</form>
		</div>
		<?php echo $_errVerif;?>
	</div>
<?php include '../end.php'; ?>
