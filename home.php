<?php 
	session_start();
	include 'functions.php';
	if(!isset($_SESSION['user']) || $_SESSION['user'] == ""){
		header("Location: http://sem.devrouder.cz/");
		die();
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_errQ = $_errN = $_quest = $_title = "";
		if(empty($_POST['title']) || empty($_POST['question'])){
			if(empty($_POST['question'])) $_errN = "Musíte vyplniť nadpis!";
			if(empty($_POST['question'])) $_errQ = "Musíte vyplniť otázku!";
		} else {
			$_quest = htmlentities($_POST['question'], ENT_QUOTES);
			$_title = htmlentities($_POST['title'], ENT_QUOTES);
		    if(!checkLastThread($_quest)){
				addThread($_title,$_quest);
		    }
		}
	}
	$_SESSION['page']=1;
	$title = "LForum";
	include 'begin.php';
	include 'header.php';
?>
<div class="container p-t" id="data">
	<div id="new-q">
		<div class="row">
			<form method="post">
				<div class="row col-sm-8 col-md-offset-2 text-center m-b-s">
					<label class="col-md-3 col-md-offset-1">Zadajte nadpis:</label>
					<input class="col-md-4" type="text" name="title" placeholder="Tu vlož nadpis!">
					<?php echo $_errN;?>
				</div>
				<div class="row col-sm-8 col-md-offset-2 text-center m-b-s">
					<label class="col-md-3 col-md-offset-1">Zadajte otázku:</label>
					<input class="col-md-4" type="text" name="question" placeholder="Tu zadaj otázku!">
					<?php echo $_errQ;?>
				</div>
				<div class="col-md-8 col-sm-2 col-md-offset-2 text-center m-b">
					<input type="submit" name="submit" value="Odoslať">
				</div>
			</form>
		</div>
	</div>
	<div class="row" id="content">
		<?php 
		    $row = getAllThreads();
		    $count = 0;
			foreach ($row as $row) {
				$count++;
				$user = findUser($row['P_id']);
				$__name = $user['name'];
				if (strlen($row['t_text']) > 200){
					$__text = substr($row['t_text'], 0, 200)."...";
				} else {
					$__text = $row['t_text'];
				}
				$__nadpis = $row['t_nadpis'];
				include 'templateThread.php';
				if($count == 10)break;
			}
		?>
		<div class="text-center col-md-12" id="more"><div id="_more" class="_threads">Načítať viac</div></div>
	</div>
</div>
<?php
	include 'end.php';
?>