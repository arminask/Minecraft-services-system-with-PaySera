<?php
require_once('WebToPay.php');
include('../includes/connection.php');

try {
    $response = WebToPay::checkResponse($_POST, array(
        'projectid' 	=> $paysera['project_id'],
        'sign_password' => $paysera['sign_password']
    ));

    $stmt = $conn->prepare("SELECT * FROM privileges WHERE id = :pageid AND makro_price = :makro_price");
        $stmt->execute(array(
        ':pageid' => $response['pageid'],
        ':makro_price' => $response['amount']
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
	$nick = str_replace("Nick: ", "", $response['orderid']);

    $stmt = $conn->prepare("SELECT * FROM sms WHERE nick = :nick");
    $stmt->execute(array(':nick' => $nick));
    $data2 = $stmt->fetch(PDO::FETCH_ASSOC);

    $timeleft = $data2['expires'] - time();

	if($response['amount'] == $data['makro_price']) {

		if($data['type'] == 1) {

            if($stmt->rowCount() == 1) {

				$stmt = $conn->prepare("UPDATE sms SET nick = :nick, keyword = :keyword, nr = :nr, expires = :expires");
				$stmt->execute(array(
					':nick' 	=> str_replace("Nick: ", "", $nick),
					':keyword' 	=> $data['keyword'],
					':nr'		=> 'Makro',
					':expires'	=> $timeleft + time() + (60*60*24*30)
				));
				echo 'OK Privilegija '.$data['keyword'].' sekmingai pratesta!';
			} else {

				$stmt = $conn->prepare("INSERT INTO sms (nick, keyword, nr, expires) VALUES (:nick, :keyword, :nr, :expires)");
				$stmt->execute(array(
					':nick' 	=> str_replace("Nick: ", "", strtolower($nick)),
					':keyword' 	=> $data['keyword'],
					':nr'		=> 'Makro',
					':expires'	=> time() + (60*60*24*30)
				));
				echo 'OK Privilegija '.$data['keyword'].' sekmingai uzsakyta!';
			}

		} else {

			$stmt = $conn->prepare("INSERT INTO paslaugos (nick, keyword, nr, expires) VALUES (:nick, :keyword, :nr, :expires)");
			$stmt->execute(array(
				':nick' 	=> str_replace("Nick: ", "", strtolower($nick)),
				':keyword' 	=> $data['keyword'],
				':nr'		=> 'Makro',
				':expires'	=> date('Y-m-d H:i')
			));
            echo 'OK Paslauga '.$data['keyword'].' sekmingai uzsakyta!';
		}

        $data['cmd'] = htmlspecialchars_decode($data['cmd']);
    	$data['cmd'] = str_replace('[nick]', $nick, $data['cmd']);
    	$cmds = explode(", ", $data['cmd']);
    	foreach($cmds as $cmd) {
      		cmd('1', $cmd);
        }


	} else {
		echo 'OK Suma neatitinka.';
	}
} catch (Exception $e) {
    echo get_class($e).': '.$e->getMessage();
}
finally
{
}

function cmd($server, $command){
include('../includes/connection.php');
if($server == '1'){
    $server_ip = "$ipas";  ///// Serverio ip
    $server_rcon_port = "$portas";    ///// Serverio rcon port
    $server_rcon_password = "$rconas";  ///// Serverio rcon slaptažodis
}
require_once('rcon.php');

$Rcon = new MinecraftRcon;

try{

$Rcon->Connect($server_ip, $server_rcon_port, $server_rcon_password);



       $command = $Rcon->Command($command);

      $Rcon->Disconnect();

      }

     catch( MinecraftRconException $e )

     {

     echo $e;

     }

}
