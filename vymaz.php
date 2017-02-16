<?php 
	session_start();
	include 'auth/cnf.php';
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=""){
		try {
		    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $id = $_SESSION['user_id'];
		    // sql to delete a record
		    $sql = "DELETE FROM sem_users WHERE id=$id";
		    // use exec() because no results are returned
		    $conn->exec($sql);
		    $_SESSION['user'] = "";
		    $_SESSION['user_id'] = "";
		    echo "true";
		    }
		catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		    }

		$conn = null;
	}

?>