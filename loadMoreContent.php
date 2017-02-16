<?php 
	session_start();
	$q = $_POST["content"];
	if($q == "_threads"){threads();}
	if($q == "_answers"){answers();}

	function threads(){
		include 'auth/cnf.php';
		include 'functions.php';
		$lim = $_SESSION['page'] * 10;
		$_SESSION['page']++;
		try {
		    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_threads ORDER BY id DESC LIMIT :lim, 10");
		    $stmt->bindParam(':lim', $lim, PDO::PARAM_INT);
		    $stmt->execute();
		    $row = $stmt->fetchAll();
		    $arrayUsers = array();
		    $arrayAnswers = array();
		    foreach ($row as $_row){
		    	array_push($arrayUsers, findUser($_row['P_id'])['name']);
		    	array_push($arrayAnswers, numberOfThreadAnswers($_row['id']));
		    }
		    $return = $row;
		    $return = array_merge($return, $arrayUsers);
		    $return = array_merge($return, $arrayAnswers);
		    echo json_encode($return);
	    } catch(PDOException $e) {
	   		echo $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}

	function answers(){
		include 'auth/cnf.php';
		include 'functions.php';
		$id = $_POST['id'];
		$lim = $_SESSION['page'] * 15;
		$_SESSION['page']++;
		try {
		    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM sem_answers WHERE T_id = :id LIMIT :lim, 15");
		    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
		    $stmt->bindParam(':lim', $lim, PDO::PARAM_INT);
		    $stmt->execute();
		    $row = $stmt->fetchAll();
		    $arrayUsers = array();
		    foreach ($row as $_row){
		    	array_push($arrayUsers, findUser($_row['P_id'])['name']);
		    }
		    $return = $row;
		    $return = array_merge($return, $arrayUsers);
		    echo json_encode($return);
	    } catch(PDOException $e) {
	   		echo $sql . "<br>" . $e->getMessage();
	    }
		$conn = null;
	}
?>