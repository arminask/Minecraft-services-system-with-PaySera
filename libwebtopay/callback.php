<?php
require_once('WebToPay.php');
include('../includes/connection.php');

$get = removeQuotes($_POST);

try {
    $response = WebToPay::checkResponse($get, array(
        'projectid'     => $paysera['project_id'],
        'sign_password' => $paysera['sign_password']
    ));

    $sms = explode(' ', $response['sms']);
    $kaina = $response['amount'];
    $nr = $response['from'];
    $raktazodis = $sms[0];
    $nick = strtolower($sms[1]);

    $stmt = $conn->prepare("SELECT * FROM privileges WHERE keyword = :keyword AND price = :price");
    $stmt->execute(array(
        ':keyword' => $raktazodis,
        ':price'   => $kaina
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $conn->prepare("SELECT * FROM sms WHERE nick = :nick");
    $stmt->execute(array(':nick' => $nick));
    $data2 = $stmt->fetch(PDO::FETCH_ASSOC);

    $timeleft = $data2['expires'] - time();


    if ($data['price'] != $kaina) {

        echo 'OK Suma neatitinka';

    } else {

        if ($nick != ""){
            $data['cmd'] = htmlspecialchars_decode($data['cmd']);
            $data['cmd'] = str_replace('[nick]', $nick, $data['cmd']);


            if($data['type'] == 1) {

                if($stmt->rowCount() == 1) {

                    $stmt = $conn->prepare("UPDATE sms SET nick = :nick, keyword = :keyword, nr = :nr, expires = :expires WHERE nick = :nick");
                    $stmt->execute(array(
                        ':nick'     => $nick,
                        ':keyword'  => $raktazodis,
                        ':nr'       => $nr,
                        ':expires'  => $timeleft + time() + (60*60*24*30)
                    ));
                    echo 'OK Privilegija '.$data['keyword'].' sekmingai pratesta!';
                } else {

                    $stmt = $conn->prepare("INSERT INTO sms (nick, keyword, nr, expires) VALUES (:nick, :keyword, :nr, :expires)");
                    $stmt->execute(array(
                        ':nick'     => $nick,
                        ':keyword'  => $raktazodis,
                        ':nr'       => $nr,
                        ':expires'  => time() + (60*60*24*30)
                    ));
                    echo 'OK Privilegija '.$data['keyword'].' sekmingai uzsakyta!';
                }

            } else if ($data['type'] == 2) {
                    $stmt = $conn->prepare("INSERT INTO paslaugos (nick, keyword, nr, expires) VALUES (:nick, :keyword, :nr, :expires)");
                    $stmt->execute(array(
                        ':nick'     => $nick,
                        ':keyword'  => $raktazodis,
                        ':nr'       => $nr,
                        ':expires'  => date('Y-m-d H:i')
                    ));
                    echo 'OK Paslauga '.$data['keyword'].' sekmingai uzsakyta!';
            }
            $cmds = explode(", ", $data['cmd']);
            foreach($cmds as $cmd) {
                cmd('1', $cmd);
            }
        } else {
            echo 'OK Neivedet nicko!';
        }
    }
}
catch (Exception $e) {
    echo 'OK '.get_class($e).': '.$e->getMessage();
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

function removeQuotes($post) {
    if (get_magic_quotes_gpc()) {
        foreach ($post as &$var) {
            if (is_array($var)) {
                $var = removeQuotes($var);
            } else {
                $var = stripslashes($var);
            }
        }
    }
    return $post;
}
