<?php 
	session_start();
	include 'functions.php';

	if(!isset($_SESSION['user']) || $_SESSION['user'] == "" || !isset($_GET['id'])){
		header("Location: http://sem.devrouder.cz/");
		die();
	}

	if(!is_numeric($_GET['id'])){
		header("Location: /home");
		die();
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_err = $_suc = "";
		echo $_POST['answer'];
		if(!empty($_POST['answer'])){
			$_answ = htmlentities($_POST['answer'], ENT_QUOTES);
			if(!checkLastAnswer($_answ,$_GET['id'])){
				$ret = addAnswer($_answ,$_GET['id']);
				if($ret){
					$_suc = "Úspešne pridané";
				} else {
					$_err = $ret;
				}
			}
		} else {
			$_err = "Musíte vyplniť!";
		}
	}

	$row = getThread($_GET['id']);
	$r_id = $row['id'];
	$r_user = $row['P_id'];
	$r_thread = $row['t_nadpis'];
	$r_text = $row['t_text'];
	$r_date = $row['date'];


    if($r_thread == "" || !isset($r_thread)){
    	$conn = null;
    	header("Location: /home");
		die();
    }

    $row = findUser($r_user);
	$u_name = $row['name'];
    if(empty($u_name))$u_name = "Anonym";
    $_SESSION['page']=1;
    $title = "LForum - príspevok";
	include 'begin.php';
	include 'header.php';
?>
	
	<div class="container p-t">
		<?php echo $_suc;?>
		<div id="new-q">
			<div class="row">
				<form method="post">
					<div class="row col-sm-8 col-md-offset-2 text-center m-b-s">
						<label class="col-md-3 col-md-offset-1">Vložte komentár:</label>
						<input class="col-md-4" type="text" name="answer" placeholder="Tu vlož komentár!">
						<?php echo $_err;?>
					</div>
					<div class="col-md-8 col-sm-2 col-md-offset-2 text-center m-b">
						<input type="submit" name="submit" value="Odoslať">
					</div>
				</form>
			</div>
		</div>
		<div class="row mh-sm">
			<div class="col-md-2 col-md-offset-1 m-t-md">
				<div class="fc-b1"><?php echo date_format(date_create($r_date), "d.m.Y H:i:s");?></div>
				<div class="">
					<a href="/profile?user=<?php echo$u_name;?>"><?php echo $u_name;?></a>
				</div>
			</div>
			<div class="col-md-7">
				<div class=""><h3><?php echo $r_thread;?></h3></div>
				<div class=""><?php echo $r_text;?></div>
			</div>
		</div>
		<div class="row">
			<div class="line col-md-10 col-md-offset-1"></div>
		</div>
		<?php
			$row = getAllAnswers($r_id);
			$count = 0;
		    foreach ($row as $row){	    	
		    	$a_user = findUser($row['P_id'])['name'];
		    	$date = date_create($row['date']);
		    	$date = date_format($date, "d.m.Y H:i:s");
		    	if(empty($a_user))$a_user = "Anonym";
		    	include 'templateAnswer.php';
		    	$count++;
		    	if($count == 15)break;
		    }
		    if (numberOfThreadAnswers($r_id) > 15){?>
		    	<div class="text-center col-md-12" id="more"><div id="_more" class="_answers">Načítať viac</div></div>
	    <?php 
			}
		    if (empty($row)){
    	?>
    		<div class="row">
    			<div class="text-center">Žiadne komentáre.</div>
    		</div>
    	<?php
		    }
		?>
	</div>
<?php 
	include 'end.php';
?>