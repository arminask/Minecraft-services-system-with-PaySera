<?php
include_once '../includes/connection.php';
if ($_GET['data']) {
	# code...
	session_start();
	$_SESSION['parama'] = '1';
	header('location: ../index.php');
}
header('location: ../index.php');

?>
