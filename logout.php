<?php 
	session_start(); 
	session_destroy(); 
	header("Location: http://sem.devrouder.cz");
	die();
