<?php
	function sendActivationMail($fdata,$fmail){
		$to      = $fmail;
		$subject = 'Activation link';
		$message = 'To active click on a link below:'."\n\n".
					'http://sem.devrouder.cz/activation?link='.$fdata;
		$headers = 'From: noreply@lforum.com' . "\r\n" .
    				'X-Mailer: PHP/' . phpversion();

		return mail($to, $subject, $message, $headers);
	}

	function resetPasswordMail($fpass, $fmail){
		$to      = $fmail;
		$subject = 'Password change';
		$message = 'Changing password'."\n\n".
					'New password : '.$fpass."\n\n".
					'You can change your password after login.';
		$headers = 'From: noreply@lforum.com' . "\r\n" .
    				'X-Mailer: PHP/' . phpversion();

		return mail($to, $subject, $message, $headers);
	}

	function generateNewPass($length = 8) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function getAllThreads() {
		include 'auth/cnf.php';
		try {
		    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_threads ORDER BY id DESC"); 
		    $stmt->execute();
		    $row = $stmt->fetchAll();
		    return $row;
	    } catch(PDOException $e) {
	   		return $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function getThread($index){
		include 'auth/cnf.php';
		try {
		    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_threads WHERE id = :id"); 
	    	$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		    return $row;
	    } catch(PDOException $e) {
	   		return $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function addThread($title,$question){
		include 'auth/cnf.php';
		try {
			$id = $_SESSION['user_id'];
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "INSERT INTO sem_threads (P_id, t_nadpis, t_text)
		    VALUES ('$id', '$title', '$question')";
		    // use exec() because no results are returned
		    $conn->exec($sql);
		    return "New record created successfully";
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function findUser($user){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_users WHERE id = :id");
		    $stmt->bindParam(':id', $user, PDO::PARAM_INT);
		    // use exec() because no results are returned
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		    return $row;
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function getAllAnswers($thread){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_answers WHERE T_id = :id"); 
		    $stmt->bindParam(':id', $thread, PDO::PARAM_INT);
		    $stmt->execute();
		    $row = $stmt->fetchAll();
		    return $row;
		} catch(PDOException $e){
		    return $sql . "<br>" . $e->getMessage();
	    }
	}

	function addAnswer($text, $thread){
		include 'auth/cnf.php';
		try {
			$id = $_SESSION['user_id'];
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "INSERT INTO sem_answers (P_id, T_id, a_text)
		    VALUES ('$id', '$thread', '$text')";
		    // use exec() because no results are returned
		    $conn->exec($sql);
		    return true;
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function checkLastAnswer($text, $thread){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_answers WHERE T_id = :tid ORDER BY id DESC LIMIT 1");
		    $stmt->bindParam(':tid', $thread, PDO::PARAM_INT);
		    // use exec() because no results are returned
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    	if($row['a_text']==$text){
	    		return true;
	    	} else {
	    		return false;
	    	}
	    } catch(PDOException $e) {
		    return $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function checkLastThread($text){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_threads ORDER BY id DESC LIMIT 1");
		    // use exec() because no results are returned
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    	if($row['t_text']==$text){
	    		return true;
	    	} else {
	    		return false;
	    	}
	    } catch(PDOException $e) {
		    return $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function ifUserExist(){
		include 'auth/cnf.php';

		//id,name
		extract(func_get_args(), EXTR_PREFIX_ALL, "data");
		$id = $data_0;
		$name = $data_1;

		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    if(empty($id)){
		    	$stmt = $conn->prepare("SELECT * FROM sem_users WHERE name = :name");
		    	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		    } else {
		    	$stmt = $conn->prepare("SELECT * FROM sem_users WHERE id = :id");
		    	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		    }
		    // use exec() because no results are returned
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	    	if($row){
	    		return true;
	    	} else {
	    		return false;
	    	}
	    } catch(PDOException $e) {
		    return $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function findUserByName($user){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_users WHERE name = :name");
		    $stmt->bindParam(':name', $user, PDO::PARAM_STR);
		    // use exec() because no results are returned
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		    return $row;
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function numberOfThreads($user){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_threads WHERE P_id = :id");
		    $stmt->bindParam(':id', $user, PDO::PARAM_INT);
		    // use exec() because no results are returned
		    $stmt->execute();
		    //$row = $stmt->fetchAll();
		    return $row = $stmt->rowCount();
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function numberOfAnswers($user){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_answers WHERE P_id = :id");
		    $stmt->bindParam(':id', $user, PDO::PARAM_INT);
		    // use exec() because no results are returned
		    $stmt->execute();
		    //$row = $stmt->fetchAll();
		    return $row = $stmt->rowCount();
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function numberOfThreadAnswers($thread){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_answers WHERE T_id = :id");
		    $stmt->bindParam(':id', $thread, PDO::PARAM_INT);
		    // use exec() because no results are returned
		    $stmt->execute();
		    //$row = $stmt->fetchAll();
		    return $row = $stmt->rowCount();
		    } catch(PDOException $e) {
		    	return $sql . "<br>" . $e->getMessage();
		    }
		$conn = null;
	}

	function checkEmail($email){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT email FROM sem_users WHERE email = :email"); 
		    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		    if($row){return true;} else {return false;}
	    }	
		catch(PDOException $e)
	    {
	   		return $sql . "<br>" . $e->getMessage();
	    }
	    $conn = null;
	}

	function updateEmail($user, $email){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "UPDATE sem_users SET email='$email' WHERE id='$user'";
		    // Prepare statement
		    $stmt = $conn->prepare($sql);
		    // execute the query
		    $stmt->execute();

		    // echo a message to say the UPDATE succeeded
		    return "E-mailová adresa úspešne zmenená  :)";
		    }
		catch(PDOException $e)
		    {
		    return $sql . "<br>" . $e->getMessage();
		    }

		$conn = null;
	}

	function updatePass($user, $pass){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "UPDATE sem_users SET pass='$pass' WHERE id='$user'";
		    // Prepare statement
		    $stmt = $conn->prepare($sql);
		    // execute the query
		    $stmt->execute();

		    // echo a message to say the UPDATE succeeded
		    return "Heslo bolo úspešne zmenená  :)";
		    }
		catch(PDOException $e)
		    {
		    return $sql . "<br>" . $e->getMessage();
		    }

		$conn = null;
	}

	function updateInfo($user,$info){
		include 'auth/cnf.php';
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $sql = "UPDATE sem_users SET info='$info' WHERE id='$user'";
		    $stmt = $conn->prepare($sql);
		    $stmt->execute();
		    return "Info bolo úspešne zmenené  :)";
		    }
		catch(PDOException $e)
		    {
		    return $sql . "<br>" . $e->getMessage();
		    }

		$conn = null;
	}

	function addUser($user,$pass,$email,$veri){
		include 'auth/cnf.php';
		try {
				$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $sql = "INSERT INTO sem_users (name, pass, email, verif)
			    VALUES ('$user', '$pass', '$email', '$veri')";
			    // use exec() because no results are returned
			    $conn->exec($sql);
			    $_SESSION['user_r'] = $_email;
			    return true;
			    }
			catch(PDOException $e)
			    {
			    return $sql . "<br>" . $e->getMessage();
			    }
			$conn = null;
	}
?>