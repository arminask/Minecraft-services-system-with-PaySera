<?php
error_reporting('0');
ini_set('display_errors', 0);
date_default_timezone_set('Europe/Vilnius');
$dbhost = "localhost"; //Serverio adresas
$dbname = "paslaugos"; //Duomenų bazės pavadinimas
$dbuser = ""; //Duomenų bazės vartotojo vardas
$dbpass = ""; //slaptažodis

try {
	$conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname.";charset=UTF8", $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo "KLAIDA: " . $e->getMessage();
}

$stmt = $conn->prepare("SELECT * FROM settings");
$stmt->execute();
$paysera = $stmt->fetch(PDO::FETCH_ASSOC);
$forum = $paysera['forumurl'];
$telnr = $paysera['telnr'];
$email = $paysera['email'];

if ($paysera['forumtype'] == 1) {
	$forumas = $forum.'index.php?app=core&amp;module=search&amp;do=search&amp;fromMainBar=1';
} else if ($paysera['forumtype'] == 2) {
	$forumas = 'action="'.$forum.'index.php?/search/" method="post"';
}

$titlez = $paysera['title'];
if ($titlez == '') {
	$title = "pavadinimas.lt";
	} else {
	$title = $titlez;
	}
//serveris
$squery = $conn->query("SELECT * FROM `serveris`");
$serveris = $squery->fetch(PDO::FETCH_BOTH);
$ipas = $serveris['ip'];
$portas = $serveris['port'];
$rconas = $serveris['rcon'];
$sport = $serveris['sport'];
$monpav = $serveris['smonitorp'];
//adminkes privilegijos
$privi = $conn->query("SELECT * FROM `privileges`");
$fpriv = $privi->rowCount();
//adminkes grupes
$groups = $conn->query("SELECT * FROM `privgroups`");
$groupz = $groups->rowCount();
//adminkes paslaugos
$sms = $conn->query("SELECT * FROM `sms`");
$allsms = $sms->rowCount();
$listaszdel = $sms->fetchAll();
$galiojimasdown = date('Y-m-d H:i', $listaszdel['expires']);
if($galiojimasdown < date('Y-m-d H:i')) {
$trynimas = $conn->query("DELETE FROM `sms` WHERE expires < ( UNIX_TIMESTAMP( NOW( ) ) -2592000 )");
}


$iplog = $_SERVER['REMOTE_ADDR'];
