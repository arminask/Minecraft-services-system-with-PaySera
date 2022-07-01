<?php
	ini_set('display_errors', 0);
	if(isset($_POST['submit'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$action = "Vartotojas ".$username." prisijunge."; 		
		$data = $conn->prepare("SELECT * FROM users WHERE nick = :username");
		$data->execute(array("username" => $username));
		$user = $data->fetch(PDO::FETCH_ASSOC);

		if($data->rowCount() == 1) {

			if(($user['nick'] == $username) && password_verify($password, $user['password'])) {
				$_SESSION['username'] = $username;
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));				
			} else {
				$err = "Slaptažodis neteisingas!";
			}

		} 
		elseif (empty($username)) {
			$err = "Užpildykite visus laukelius!";
		}	
		elseif (empty($password)) {
			$err = "Užpildykite visus laukelius!";
		}
		else {
			$err = "Slapyvardis neegzistuoja!";
		}

	}

	if(isset($_POST['servas'])) {
		$ip = $_POST['ipas'];
		$portas = $_POST['port'];
		$sport = $_POST['sport'];
		$rconas = $_POST['rcon'];
		$action = "Serveris ".$ip.":".$portas." atnaujintas.";
		$stmt = $conn->prepare("SELECT * FROM serveris");
		$stmt->execute(); 	
		if(empty($ip)) {
			$err = "Serverio IP laukelis negali būti tuščias!";
		} else if(empty($portas)) {
			$err = "Serverio <b>RCON</b> PORT laukelis negali būti tuščias!";
		} else if(empty($sport)) {
			$err = "Serverio <b>PORT</b> laukelis negali būti tuščias!";
		} else if(empty($rconas)) {
			$err = "Serverio <b>RCON</b> Slaptažodžio laukelis negali būti tuščias!";
		} else {
		if($stmt->rowCount() == 0) {
			$stmt = $conn->prepare("INSERT INTO serveris (ip, port, sport, rcon) VALUES (?, ?, ?, ?)");
			$stmt->execute(array($ip, $portas, $sport, $rconas));	
		}
		else { 
			$stmt = $conn->prepare("UPDATE serveris SET ip = ?, port = ?, sport = ?, rcon = ?");
			$stmt->execute(array($ip, $portas, $sport, $rconas));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
		}
			$msg = "Serverio informacija atnaujinta!";
		
		}
	}

	if(isset($_POST['padd'])) {
		$ptitle = $_POST['ptitle'];
		$action = "Privilegija ".$ptitle." pridėta.";
		$type = $_POST['type'];
		$keyword = $_POST['keyword'];
		$pgroup = $_POST['pgroup'];
		$pprice = str_replace('0.', "", $_POST['pprice'] * 100);
		$makroprice = str_replace('0.', "", $_POST['makroprice'] * 100);
		$pnum = $_POST['pnum'];
		$cmd = htmlentities($_POST['cmd']);
		$pcontent = $_POST['pcontent'];
		if(empty($ptitle)) {
			$err = "Nenurodei privilegijos pavadinimo!";
		} else if($type == 0) {
			$err = "Nenurodei tipo!";
		} else if(empty($keyword)) {
			$err = "Nenurodei privilegijos raktažodžio!";
		} else if($pgroup == 0) {
			$err = "Nenurodei privilegijos grupės!";
		} else if(empty($pprice)) {
			$err = "Nenurodei privilegijos mikro kainos!";
		} else if(empty($makroprice)) {
			$err = "Nenurodei privilegijos makro kainos!";
		} else if(empty($pnum)) {
			$err = "Nenurodei kokiu numeriu paslaugą reikės užsisakyti!";
		} else if(empty($cmd)) {
			$err = "Nenurodei kokia komanda bus įvykdoma išsiuntus SMS!";
		} else {
			$stmt = $conn->prepare("INSERT INTO privileges (groupid, title, type, keyword, price, makro_price, number, cmd, content) VALUES (:pgroup, :ptitle, :type, :keyword, :pprice, :makroprice, :pnum, :cmd, :pcontent)");
			$stmt->execute(array(
				':pgroup' 		=> $pgroup,
				':ptitle'   	=> $ptitle,
				':type' 		=> $type,
				':keyword' 		=> $keyword,
				':pprice'   	=> $pprice,
				':makroprice' 	=> $makroprice,
				':pnum' 		=> $pnum,
				':cmd' 			=> $cmd,
				':pcontent' 	=> $pcontent
			));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
			$msg = "Privilegija sėkmingai pridėta!";
		}
	}

	if(isset($_POST['gadd'])) {
		$gtitle = $_POST['gtitle'];
		$action = "Sukurta ".$gtitle." grupe."; 
		if(empty($gtitle)) {
			$err = "Nenurodei grupės pavadinimo!";
		} else {
			$stmt = $conn->prepare("INSERT INTO privgroups (title) VALUES (:gtitle)");
			$stmt->execute(array(
				':gtitle'   => $gtitle
			));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
			$msg = "Grupė sėkmingai pridėta!";
		}
	}

	if(isset($_POST['psave'])) {
		$ptitle = $_POST['ptitle'];
		$action = "Atnaujinta ".$ptitle." privilegija."; 
		$type = $_POST['type'];
		$keyword = $_POST['keyword'];
		$pgroup = $_POST['pgroup'];
		$pprice = str_replace('0.', "", $_POST['pprice'] * 100);
		$makroprice = str_replace('0.', "", $_POST['makroprice'] * 100);
		$pnum = $_POST['pnum'];
		$cmd = htmlentities($_POST['cmd']);
		$pcontent = $_POST['pcontent'];
		if(empty($ptitle)) {
			$err = "Nenurodei privilegijos pavadinimo!";
		} else if($type == 0) {
			$err = "Nenurodei tipo!";
		} else if(empty($keyword)) {
			$err = "Nenurodei privilegijos raktažodžio!";
		} else if($pgroup == 0) {
			$err = "Nenurodei privilegijos grupės!";
		} else if(empty($pprice)) {
			$err = "Nenurodei privilegijos kainos!";
		} else if(empty($pnum)) {
			$err = "Nenurodei kokiu numeriu paslaugą reikės užsisakyti!";
		} else if(empty($cmd)) {
			$err = "Nenurodei kokia komanda bus įvykdoma išsiuntus SMS!";
		} else {
			$stmt = $conn->prepare("UPDATE privileges SET groupid = :pgroup, title = :ptitle, type = :type, keyword = :keyword, price = :pprice, makro_price = :makroprice, number = :pnum, cmd = :cmd, content = :pcontent WHERE id = :id");
			$stmt->execute(array(
				':id'			=> $_GET['id'],
				':pgroup' 		=> $pgroup,
				':ptitle'   	=> $ptitle,
				':type'			=> $type,
				':keyword' 		=> $keyword,
				':pprice'   	=> $pprice,
				':makroprice' 	=> $makroprice,
				':pnum' 		=> $pnum,
				':cmd' 			=> $cmd,
				':pcontent' 	=> $pcontent
			));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
			$msg = "Privilegija sėkmingai atnaujinta!";
		}
	}

	if(isset($_GET['delete']) && $_GET['delete'] == "privileges" && isset($_GET['id']) && isset($_SESSION['username'])) {
		$logdel = $conn->prepare("SELECT * FROM privileges WHERE id = :id");
		$logdel->execute(array(':id' => $_GET['id']));
		$logdelname = $logdel->fetch(PDO::FETCH_ASSOC);
		$logname = $logdelname['title'];
		$stmt = $conn->prepare("DELETE FROM privileges where id = :id");
		$stmt->execute(array(':id' => $_GET['id']));
		$action = "Ištrinta ".$logname." privilegija."; 
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
		header('Location: index.php?page=editpriv');
	}

	if(isset($_GET['delete']) && $_GET['delete'] == "groups" && isset($_GET['id']) && isset($_SESSION['username'])) {
		$logdel = $conn->prepare("SELECT * FROM privgroups WHERE id = :id");
		$logdel->execute(array(':id' => $_GET['id']));
		$logdelname = $logdel->fetch(PDO::FETCH_ASSOC);
		$logname = $logdelname['title'];
		$stmt = $conn->prepare("DELETE FROM privgroups where id = :id");
		$stmt->execute(array(':id' => $_GET['id']));
		$action = "Ištrinta ".$logname." grupė."; 
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
		header('Location: index.php?page=editpgroup');
	}

	if(isset($_POST['gsave'])) {
		$gtitle = $_POST['gtitle'];
		$action = "Atnaujinta ".$gtitle." grupe."; 
		if(empty($gtitle)) {
			$err = "Nenurodei grupės pavadinimo!";
		} else {
			$stmt = $conn->prepare("UPDATE privgroups SET title = :gtitle WHERE id = :id");
			$stmt->execute(array(
				':gtitle'   => $gtitle,
				':id'		=> $_GET['id']
			));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
			$msg = "Grupė sėkmingai atnaujinta!";
		}
	}

	if(isset($_POST['register'])) {
		$rusername = $_POST['rusername'];
		$rpassword = $_POST['rpassword'];
		$rpassword2 = $_POST['rpassword2'];
		$action = "Užregistruotas ".$rusername." vartotojas."; 
		if (strlen($rusername) < 6) {
			$err = "Slapyvardis per trumpas!";
		} else if (strlen($rpassword) < 6) {
			$err = "Slaptažodis per trumpas!";
		} else if ($rpassword != $rpassword2) {
			$err = "Slaptažodžiai nesutampa!";
		} else {
			$stmt = $conn->prepare("INSERT INTO users (nick, password) VALUES (:rusername, :rpassword)");
			$stmt->execute(array(
				':rusername' => $rusername,
				':rpassword' => password_hash($rpassword, PASSWORD_DEFAULT)
			));
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($rusername, $action, $iplog, time() 
			));
			$msg = "Sėkmingai užsiregistravot!";
		}
	}

	if(isset($_POST['paysera'])) {
		$webtitle = $_POST['webtitle'];
		$projectid = $_POST['projectid'];
		$signpass = $_POST['signpassword'];
		$forumtype = $_POST['check'];
		$forumurl = $_POST['forumurl'];
		$emailp = $_POST['emailp'];
		$telnrp = $_POST['telnr'];
		$action = "Atnaujinti $webtitle svetaines nustatymai."; 
		$stmt = $conn->prepare("SELECT * FROM settings");
		$stmt->execute();

		if($stmt->rowCount() == 0) {
			$stmt = $conn->prepare("INSERT INTO settings (title, project_id, sign_password, forumtype, forumurl, telnr, email) VALUES (:webtitle, :projectid, :signpass, :forumtype, :forumurl, :telnr, :emailp)");
			$stmt->execute(array(
				':webtitle' => $webtitle,
				':projectid' => $projectid,
				':signpass' => $signpass,
				':forumtype' => $forumtype,
				':forumurl' => $forumurl,
				':telnr' => $telnrp,
				':emailp' => $emailp
			));
		} else {
			$stmt = $conn->prepare("UPDATE settings SET title = :webtitle, project_id = :projectid, sign_password = :signpass, forumtype = :forumtype, forumurl = :forumurl, telnr = :telnr, email = :emailp");
			$stmt->execute(array(
				':webtitle' => $webtitle,
				':projectid' => $projectid,
				':signpass' => $signpass,
				':forumtype' => $forumtype,
				':forumurl' => $forumurl,
				':telnr' => $telnrp,
				':emailp' => $emailp
			));			
		}
			$log = $conn->prepare("INSERT INTO logs (user, action, ip, kada) VALUES (?, ?, ?, ?)");
			$log->execute(array($_SESSION['username'], $action, $iplog, time() 
			));
		$msg = "Nustatymai sėkmingai atnaujinti!";

	}