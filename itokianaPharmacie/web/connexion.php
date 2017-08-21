<?php
	try {
		$database = new PDO('mysql:host=localhost;dbname=itokianapharmacienew','root','');
	} catch(Exception $e){
		print_r($e);
	}
?>