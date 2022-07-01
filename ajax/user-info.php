<?php
include("../includes/connection.php");
$stmt = $conn->prepare("SELECT * FROM sms WHERE LOWER (nick) = LOWER (:nick)");
$stmt->execute(array(':nick' => $_POST['gamenick']));
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtt = $conn->prepare("SELECT * FROM privileges WHERE keyword = ?");
$stmtt->execute(array($data['keyword']));	
$dataa = $stmtt->fetch(PDO::FETCH_ASSOC);

$data['keyword'] = $dataa['title'];

if($stmt->rowCount() == 1 && $data['expires'] >= time()) {
	echo '<a class="btn btn-primary btn-large btn-block"><small>Jūs turite užsakytą <span style="text-decoration: underline;">'.$data['keyword'].'</span> paslaugą</small></a>';
	echo '<a class="btn btn-info btn-block"><small>Paslauga galioja iki: <b>'.date('Y-m-d H:i', $data['expires']).'</b></small></a>';
} else {
	echo '<a class="btn btn-block btn-lg btn-danger"><small>Jūs neturite užsakytų paslaugų</small></a>';
}