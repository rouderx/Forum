<?php 
	session_start();
	include 'auth/cnf.php';
	include 'functions.php';

	$_SESSION['user_r'] = "";
	$title = "LForum - aktivácia";
	include 'begin.php';
	include 'header.php';
?>

<div class="flex-center position-ref full-height container">

<?
	if(isset($_GET['success'])){
?>

	<div>
		Váš účet bol úspešne zaregistrovaný! 
		Na Vami zadaný registračný e-mail bol zaslaný aktivačný kód. Pred prihlásením si prosím aktivujte svoj účet z linku zaslanom na Váš e-mail.
	</div>


<?php 
	}elseif(isset($_GET['link'])){
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT id FROM sem_users WHERE verif = :link"); 
		    $stmt->bindParam(':link', $_GET['link'], PDO::PARAM_INT);
		    $stmt->execute();
		    $row = $stmt->fetchAll();

		    foreach($row as $row){
		        $r_id = $row['id'];
		    }
	    } catch(PDOException $e) {
		    echo $sql . "<br>" . $e->getMessage();
	    }
	    if (empty($r_id)) {
	    	echo "<div>Aktivačný link je neplatný. Prosím registrujte sa znova.</div>";
			$conn = null;
		} else {
			try {
			    $sql = "UPDATE sem_users SET verif='NULL' WHERE id=" . $r_id;
			    // Prepare statement
			    $stmt = $conn->prepare($sql);
			    // execute the query
			    $stmt->execute();
			    // echo a message to say the UPDATE succeeded
			    echo "Váš účet bol úspešne aktivovaný :)";
			    //echo $stmt->rowCount() . " records UPDATED successfully";
			} catch(PDOException $e) {
			    echo $sql . "<br>" . $e->getMessage();
			}

		}
	}elseif(isset($_GET['reset'])){
		if (isset($_POST['submit']) && $_POST['submit']=="Odoslať") {
			$_POST['submit'] = "";
			$_err = $_email = "";
			$_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
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
			    }
			    if(!empty($r_id)){
			    	$_newPass = generateNewPass();
			    	resetPasswordMail($_newPass,$_email);
			    	$_newPass = password_hash($_newPass, PASSWORD_DEFAULT);
			    	$sql = "UPDATE sem_users SET pass='".$_newPass."' WHERE id=" . $r_id;
				    // Prepare statement
				    $stmt = $conn->prepare($sql);
				    // execute the query
				    $stmt->execute();
				    // echo a message to say the UPDATE succeeded
				    //echo $stmt->rowCount() . " records UPDATED successfully";
				    ?>
				    	<div class="col-md-12">
				    		Na Vami zadaný e-mail bolo zaslané nové heslo.
				    	</div>
				    </div>
				    <?php
				    include 'end.php';
				    die();
				} else {
					$_err = "Zle zadaný e-mail!";
				}
				$conn = null;
				
		    } catch(PDOException $e) {
			    echo $sql . "<br>" . $e->getMessage();
		    }			
		}
	?>
	<div>
		<form method="post">
			Zadajte e-mail pre zmenu hesla:<br>
			<input type="email" name="email"><?php echo $_err;?><br>
			<input type="submit" name="submit" value="Odoslať">
		</form>
	</div>
<?php } ?>

</div>

<?php
	include 'end.php';
?>
