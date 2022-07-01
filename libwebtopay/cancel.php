<?php
	session_start();
	$_SESSION['parama'] = '2';
	header('location: ../index.php');