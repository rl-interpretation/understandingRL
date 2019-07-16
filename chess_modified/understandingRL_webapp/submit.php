<?php 
	require_once 'dbconnect.php';

	$idx =  $_POST['idx'];
	$sal = $_POST['sal'];
	$solve = $_POST['solve'];
	$time = $_POST['time_t'];

	
	$query = "INSERT INTO studies (game_id, saliency, solved, time_taken) VALUES ($idx, $sal, $solve, $time)";
	if(mysqli_query($con, $query)) {
	    header('Location: index.php');
	}
?>
