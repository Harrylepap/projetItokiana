<?php
 header("Access-Control-Allow-Origin: *");
	try {
		$database = new PDO('mysql:host=localhost;dbname=itokianaPharmacie','root','');
	} catch(Exception $e){
		print_r($e);
	}

	$collection = $_GET['collection'];

	$query = "SELECT * FROM $collection";

	$resultset = $database->prepare($query);

	$resultset->execute();

	$rows = $resultset->fetchAll();



	$rows = json_encode($rows);
	
	print_r($rows);
	
?>