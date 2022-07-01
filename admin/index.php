<?php
include_once '../includes/config.php';
include_once '../includes/connection.php';
include_once '../includes/functions.php';
include_once '../forms.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$title?> | Administravimas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="css/flat-ui.min.css" rel="stylesheet">
    <link href="css/stilius.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
    <script src="../tinymce/tinymce.min.js"></script>
    <script>tinymce.init({
            selector:'textarea',
            plugins: "advlist, image, autolink, link, textcolor colorpicker, autosave",
            toolbar: "undo redo | styleselect | text size | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | imagetools | forecolor | autosave"
        });</script>
</head>

<?php
$weburls = str_replace('admin','', $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
$weburl = "http://".$weburls;
?>
  <body class="login-screen">
  <div class="main_body">
    <div class="container">
      <div class="headline">
        <h1 class="logo">
          <?=$title?> - Administravimas
        </h1>
      </div> <!-- /demo-headline -->
      <!-- /navbar -->
      <div class="row">
        <div class="col-xs-12">
          <nav class="navbar navbar-inverse navbar-embossed" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <a class="navbar-brand" href=""><img src="img/logo.png" height="35px"></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
              <ul class="nav navbar-nav navbar-left">
              <!-- /linkai -->
                <li><a href="../../">Pagrindinis</a></li>
                <li><a href="/paslaugos">Paslaugos <span class="navbar-unread"></span></a></li>
              <!-- linkai -->
               </ul>
              <?php if($_SESSION['username']) { 
                echo '
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><p class="navbar-text navbar-left">Sveiki</p>'.$_SESSION['username'].' <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../logout.php">Atsijungti</a></li>
              </ul>
            </li>
          </ul>';} ?>
            </div><!-- /.navbar-collapse -->
          </nav><!-- /navbar -->
        </div>
      </div> <!-- /row -->

    <div id="lygiavimas">

            <?php if(isset($_GET['page']) && $_GET['page'] == 'editpriv' && isset($_SESSION['username'])) { ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Privilegijos</h3>
                <div class="divider"></div>
                        <?php

                        $stmt = $conn->query("SELECT * FROM privileges");
                        $data = $stmt->fetchAll();

                        ?>

                        <label for="privileges">Privilegijos:</label>
                        <select class="form-control" id="privileges">
                            <option value="0">--- Pasirinkit privilegiją ---</option>
                            <?php foreach($data as $privileges) { ?>
                                <option value="<?php echo $privileges['id']; ?>"><?php echo $privileges['title'] ?></option>
                            <?php } ?>
                        </select>
                        <br><a class="btn btn-success" id="edit" href="#">Redaguoti privilegiją</a>
                        <a class="btn btn-danger" id="delete" href="#">Trinti privilegiją</a>
                        <a class="btn btn-info pull-right" href="index.php?page=addpriv">Pridėti naują privilegiją</a>
        </div>
        </div>
      </div>

                <?php
                if(isset($_GET['id'])) {
                    if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                    if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Privilegijos redagavimas</h3>
                    <div class="divider"></div>

                            <?php

                            $stmt = $conn->prepare("SELECT * FROM privileges WHERE id = :id");
                            $stmt->execute(array('id' => $_GET['id']));
                            $data = $stmt->fetch(PDO::FETCH_ASSOC);
                            $stmt = $conn->query("SELECT * FROM privgroups");
                            $data2 = $stmt->fetchAll();

                            ?>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="ptitle">Pavadinimas</label>
                                    <input type="text" class="form-control" id="ptitle" name="ptitle" value="<?php echo $data['title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="keyword">Raktažodis</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $data['keyword']; ?>">
                                </div>
                                <label for="type">Tipas</label>
                            <pre><small><b>Privilegija - privilegijoms pvz.: vip,admin ir t.t uzsakymui</b><br><b>Paslauga - paslaugoms pvz.: pinigu, daiktu ir t.t uzsakymui</b></small></pre>
                                <div class="form-group">
                                    <select class="form-control" id="type" name="type">
                                        <option value="0">--- Pasirinkit tipą ---</option>
                                        <option value="1" <?php echo ($data['type'] == 1 ? " selected" : ""); ?>>Privilegija</option>
                                        <option value="2" <?php echo ($data['type'] == 2 ? " selected" : ""); ?>>Paslauga</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pgroup">Pasirinkit grupę</label>
                                    <select class="form-control" id="pgroup" name="pgroup">
                                        <option value="0">--- Pasirinkit grupę ---</option>
                                        <?php foreach($data2 as $groups) { ?>
                                            <option value="<?php echo $groups['id']; ?>" <?php echo ($data['groupid'] == $groups['id'] ? " selected" : ""); ?>><?php echo $groups['title'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pprice">Mikro kaina (veskite 0.01 jei norite išjungti)</label>
                                    <input type="text" class="form-control" id="pprice" name="pprice" value="<?php echo $data['price'] / 100; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="makroprice">Makro kaina (veskite 0.01 jei norite išjungti)</label>
                                    <input type="text" class="form-control" id="makroprice" name="makroprice" value="<?php echo $data['makro_price'] / 100; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="pnum">Numeris, kuriuo reikės siųsti</label>
                                    <input type="text" class="form-control" id="pnum" name="pnum" value="<?php echo $data['number']; ?>">
                                </div>
                            <label for="cmd">Įvykdoma komanda išsiuntus SMS (Jeigu norit, kad įvykdytų daugiau komandų pridėkit kablelį kaip siame PVZ jei viena komanda - kablelio nereik)</label>
                            <pre><b>PVZ:</b> pex user [nick] group add VIP "" 2592000<b><i>,</i></b> eco give [nick] 10000</pre>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="cmd" name="cmd" value="<?php echo $data['cmd']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="pcontent">Apie privilegiją/paslaugą</label>
                                    <textarea class="form-control" id="pcontent" name="pcontent" rows="3"><?php echo $data['content']; ?></textarea>
                                </div>
                                <br><button type="submit" class="btn btn-success pull-right" name="psave">Atnaujinti privilegiją</button>
                            </form>
                            <div class="clearfix"></div>
        </div>
        </div>
      </div>
                <?php }

                } else if(isset($_GET['page']) && $_GET['page'] == 'addpriv' && isset($_SESSION['username'])) {
                    if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                    if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }

                $stmt = $conn->query("SELECT * FROM privgroups");
                $data = $stmt->fetchAll();

                ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Privilegijos pridėjimas</h3>
                    <div class="divider"></div>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="ptitle">Pavadinimas</label>
                                <input type="text" class="form-control" id="ptitle" name="ptitle" placeholder="VIP">
                            </div>
                            <div class="form-group">
                                <label for="keyword">Raktažodis</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="VIP">
                            </div>
                            <label for="type">Tipas</label>
                            <pre><small><b>Privilegija - privilegijoms pvz.: vip,admin ir t.t uzsakymui</b><br><b>Paslauga - paslaugoms pvz.: pinigu, daiktu ir t.t uzsakymui</b></small></pre>
                                <div class="form-group">
                                    <select class="form-control" id="type" name="type">
                                        <option value="0">--- Pasirinkit tipą ---</option>
                                        <option value="1" <?php echo ($data['type'] == 1 ? " selected" : ""); ?>>Privilegija</option>
                                        <option value="2" <?php echo ($data['type'] == 2 ? " selected" : ""); ?>>Paslauga</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label for="pgroup">Pasirinkit grupę</label>
                                <select class="form-control" id="pgroup" name="pgroup">
                                    <option value="0">--- Pasirinkit grupę ---</option>
                                    <?php foreach($data as $groups) { ?>
                                        <option value="<?php echo $groups['id']; ?>"><?php echo $groups['title'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pprice">Mikro kaina (veskite 0.01 jei norite išjungti)</label>
                                <input type="text" class="form-control" id="pprice" name="pprice" placeholder="1.00">
                            </div>
                            <div class="form-group">
                                <label for="makroprice">Makro kaina (veskite 0.01 jei norite išjungti)</label>
                                <input type="text" class="form-control" id="makroprice" name="makroprice" placeholder="0.50">
                            </div>
                            <div class="form-group">
                                <label for="pnum">Numeris, kurio reikės siųsti</label>
                                <input type="text" class="form-control" id="pnum" name="pnum" placeholder="1398">
                            </div>
                            <label for="cmd">Įvykdoma komanda išsiuntus SMS (Jeigu norit, kad įvykdytų daugiau komandų pridėkit kablelį kaip siame PVZ jei viena komanda - kablelio nereik)</label>
                            <pre><b>PVZ:</b> pex user [nick] group add VIP "" 2592000<b><i>,</i></b> eco give [nick] 10000</pre>
                            <div class="form-group">
                            <input type="text" class="form-control" id="cmd" name="cmd" placeholder='pex user [nick] group add VIP "" 2592000'>
                            </div>
                            <div class="form-group">
                                <label for="pcontent">Apie privilegiją/paslaugą</label>
                                <textarea class="form-control" id="pcontent" name="pcontent" rows="10"></textarea>
                            </div>
                            <label for=""><b>PaySera atsakomosios  žinutės  tekstas  arba  projekto  interneto  adresas  (URL):</b></label>
                            <?php $adresas = str_replace('admin','', $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));?>
                            <pre><?=$adresas.'libwebtopay/callback.php';?></pre>
                            <br><button type="submit" class="btn btn-success pull-right" name="padd">Pridėti privilegiją</button>
                        </form>
                        <div class="clearfix"></div>
        </div>
        </div>
      </div>
            <?php } else if(isset($_GET['page']) && $_GET['page'] == 'editpgroup' && isset($_SESSION['username'])) { ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Grupių redagavimas</h3>
                <div class="divider"></div>
                        <?php

                        $stmt = $conn->query("SELECT * FROM privgroups");
                        $data = $stmt->fetchAll();

                        ?>

                        <label for="groups">Grupės:</label>
                        <select class="form-control" id="groups">
                            <option value="0">--- Pasirinkit grupę ---</option>
                            <?php foreach($data as $group) { ?>
                                <option value="<?php echo $group['id']; ?>"><?php echo $group['title'] ?></option>
                            <?php } ?>
                        </select>
                        <br><a class="btn btn-success" id="edit" href="#">Redaguoti grupę</a>
                        <a class="btn btn-danger" id="delete" href="#">Trinti grupę</a>
                        <a class="btn btn-info pull-right" href="index.php?page=addpgroup">Pridėti naują grupę</a>
        </div>
        </div>
      </div>

                <?php
                if(isset($_GET['id'])) {
                    if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                    if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Privilegijos grupių redagavimas</h3>
                <div class="divider"></div>

                            <?php

                            $stmt = $conn->prepare("SELECT * FROM privgroups WHERE id = :id");
                            $stmt->execute(array('id' => $_GET['id']));
                            $data = $stmt->fetch(PDO::FETCH_ASSOC);

                            ?>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="gtitle">Grupės pavadinimas</label>
                                    <input type="text" class="form-control" id="gtitle" name="gtitle" value="<?php echo $data['title']; ?>">
                                </div>
                                <br><button type="submit" class="btn btn-success pull-right" name="gsave">Atnaujinti grupę</button>
                            </form>
                            <div class="clearfix"></div>
        </div>
        </div>
      </div>
                <?php }

                } else if(isset($_GET['page']) && $_GET['page'] == 'addpgroup' && isset($_SESSION['username'])) {
                    if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                    if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; } ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Grupės pridėjimas</h3>
                <div class="divider"></div>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="gtitle">Grupės pavadinimas</label>
                                <input type="text" class="form-control" id="gtitle" name="gtitle" placeholder="Daiktų užsakymas, privilegijos ir t.t..">
                            </div>
                            <br><button type="submit" class="btn btn-success pull-right" name="gadd">Pridėti grupę</button>
                        </form>
                        <div class="clearfix"></div>
        </div>
        </div>
      </div>
            <?php } else if (isset($_GET['page']) && $_GET['page'] == 'serveris' && isset($_SESSION['username'])) {
                if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                    //serveris
                    $servuks = $conn->query("SELECT * FROM `serveris`");
                    $servas = $servuks->fetch(PDO::FETCH_BOTH);
                    $ipa = $servas['ip'];
                    $porta = $servas['port'];
                    $rcona = $servas['rcon'];
                    $sport = $servas['sport'];
                    ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Serverio informacija</h3>
                <div class="divider"></div>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="ipas">Serverio IP</label>
                                <input type="text" class="form-control" id="ipas" name="ipas" value="<?=$ipa?>">
                            </div>
                            <div class="form-group">
                                <label for="ipas">Serverio <b>PORT</b></label>
                                <input type="text" class="form-control" id="sport" name="sport" value="<?=$sport?>">
                            </div>
                            <div class="form-group">
                                <label for="ipas">Serverio <b>RCON</b> PORT</label>
                                <input type="text" class="form-control" id="port" name="port" value="<?=$porta?>">
                            </div>
                            <div class="form-group">
                                <label for="ipas">Serverio <b>RCON</b> slaptažodis</label>
                                <input type="password" class="form-control" id="rcon" name="rcon" value="<?=$rcona?>">
                            </div>
                            <br><button type="submit" class="btn btn-success pull-right" name="servas">Atnaujinti</button>
                            <div class="clearfix"></div>
                        </form>
        </div>
        </div>
      </div>

            <?php } else if (isset($_GET['page']) && $_GET['page'] == 'uzsisake' && isset($_SESSION['username'])) {
                if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                    ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Žaidėjai kurie užsisakė privilegijas (iš viso: <?=$allsms?>)</h3>
          <div class="divider"></div>
                       <table class="table">
                         <thead>
                            <tr>
                              <th>#</th>
                              <th>Nick</th>
                              <th>Tipas (Mikro/Makro)</th>
                              <th>Paslauga</th>
                              <th>Galiojimo laikas</th>
                            </tr>
                          </thead>
                          <tbody>
                    <?php
                        $stmt = $conn->query("SELECT * FROM sms ORDER BY expires DESC LIMIT 50");
                        $data = $stmt->fetchAll();

                        foreach($data as $listas ) {
                          $stmttas = $conn->prepare("SELECT * FROM privileges WHERE keyword = ?");
                          $stmttas->execute(array($listas['keyword'])); 
                          $datukasz = $stmttas->fetch(PDO::FETCH_ASSOC);
                          $listas['keyword'] = $datukasz['title'];
                          $galiojimas = date('Y-m-d H:i', $listas['expires']);
                          $galioja = $galiojimas;
                          if ($listas['nr'] == "Makro") {
                                $listas['nr'] = "Makro";
                          } else if ($listas['nr'] == $listas['nr']) {
                                $listas['nr'] = "Mikro";
                          }
                            if($galiojimas > date('Y-m-d H:i')) {
                    ?>
                            <tr>
                              <th scope="row">#</th>
                              <td><b><?=$listas['nick']?></b></td>
                              <td><b><?=$listas['nr']?></b></td>
                              <td><b><?=$listas['keyword']?></b></td>
                              <td><b><?=$galioja?></b></td>
                            </tr>
                            <?php } } ?>
                          </tbody>
                        </table>
        </div>
        </div>
      </div>

            <?php } else if (isset($_GET['page']) && $_GET['page'] == 'uzsisakep' && isset($_SESSION['username'])) {
                if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                    ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Žaidėjai kurie užsisakė paslaugas (iš viso: <?=$smspp?>)</h3>
          <div class="divider"></div>
                       <table class="table">
                         <thead>
                            <tr>
                              <th>#</th>
                              <th>Nick</th>
                              <th>Tipas (Mikro/Makro)</th>
                              <th>Paslauga</th>
                              <th>Užsakymo laikas</th>
                            </tr>
                          </thead>
                          <tbody>
                    <?php
                        $stmt = $conn->query("SELECT * FROM paslaugos ORDER BY expires DESC LIMIT 50");
                        $data = $stmt->fetchAll();

                        foreach($data as $listas ) {
                          $stmttas = $conn->prepare("SELECT * FROM privileges WHERE keyword = ?");
                          $stmttas->execute(array($listas['keyword'])); 
                          $datukasz = $stmttas->fetch(PDO::FETCH_ASSOC);
                          $listas['keyword'] = $datukasz['title'];                          
                          if ($listas['nr'] == "Makro") {
                                $listas['nr'] = "Makro";
                          } else if ($listas['nr'] == $listas['nr']) {
                                $listas['nr'] = "Mikro";
                          }
                          $galioja = $listas['expires'];
                    ?>
                            <tr>
                              <th scope="row">#</th>
                              <td><?=$listas['nick']?></td>
                              <td><?=$listas['nr'];?></td>
                              <td><?=$listas['keyword']?></td>
                              <td><?=$galioja?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
        </div>
        </div>
      </div>

            <?php } else if (isset($_GET['page']) && $_GET['page'] == 'logs' && isset($_SESSION['username'])) {
                if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; }
                    ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Administracijos logai. (Rodoma 30 paskutintu veiksmų.)</h3>
        <div class="divider"></div>
                       <table class="table">
                         <thead>
                            <tr>
                              <th>#</th>
                              <th>Nick</th>
                              <th>Ip adresas</th>
                              <th>Veiksmas</th>
                              <th>Data</th>
                            </tr>
                          </thead>
                          <tbody>
                    <?php
                        $logs = $conn->query("SELECT * FROM logs ORDER BY id DESC LIMIT 30");
                        $datalog = $logs->fetchAll();

                        foreach($datalog as $log ) {
                            $useris = $log['user'];
                            $kada = date('Y-m-d H:i', $log['kada']);
                            $ip = $log['ip'];
                            $veiksmas = $log['action'];
                    ?>
                            <tr>
                              <th scope="row">#</th>
                              <td><?=$useris?></td>
                              <td><?=$ip?></td>
                              <td><?=$veiksmas?></td>
                              <td><?=$kada?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
        </div>
        </div>
      </div>

            <?php } else if (isset($_GET['page']) && $_GET['page'] == 'settings' && isset($_SESSION['username'])) {
                if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; } ?>
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
          <h3 class="panel-title text-left">Nustatymai</h3>

                <?php $stmt = $conn->prepare("SELECT * FROM settings");
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC); ?>

                <div class="panel-body">

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="webtitle">Svetainės pavadinimas (title).</label>
                            <input type="text" class="form-control" name="webtitle" id="webtitle" placeholder="Įrašykit svetainės pavadinimą" value="<?php echo $data['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="forumurl">Svetainės forumo url paieškai. (pvz.: http://www.dworks.lt/forumas/)</label><br>
                                <div class="checkas">
                                Pasirinkite forumo tipa:<br>
                                <input type="checkbox" class="checkas" id="checkas" name="check" value="1" onclick="forum(this);" />IPB 
                                <input type="checkbox" class="checkas" id="checkas" name="check" value="2" onclick="forum(this);" />IPS</div>
                                <p id="insertinputs"></p>
                        </div>
                        <div class="form-group">
                            <label for="projectid">PaySera projekto id (project_id)</label>
                            <input type="text" class="form-control" name="projectid" id="projectid" placeholder="Įrašykit projekto id" value="<?php echo $data['project_id']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="signpassword">PaySera projekto slaptažodis (sign_password)</label>
                            <input type="password" class="form-control" name="signpassword" id="signpassword" placeholder="Įrašykit projekto slaptažodį" value="<?php echo $data['sign_password']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="kontaktai">PaySera projekto kontaktai (email bei tel nr)</label>
                            <input type="number" class="form-control" name="telnr" id="kontaktai" placeholder="Įrašykit projekto tel nr" value="<?php echo $data['telnr']; ?>"><br/>
                            <input type="email" class="form-control" name="emailp" id="kontaktai" placeholder="Įrašykit projekto el.pašto adresa" value="<?php echo $data['email']; ?>">
                        </div>
                        <br><button type="submit" class="btn btn-success pull-right" name="paysera">Saugoti</button>
                    </form>
                    <div class="clearfix"></div>
                </div>

            </div>


            <?php }

            ?>

        </div>

            <?php

            $stmt = $conn->query("SELECT * FROM users");

            if($stmt->rowCount() > 0) {

                if(!isset($_SESSION['username'])) { ?>                        
      <!-- menu1 -->
        <div class="login">
          <div class="login-icon col-xs-3">
            <img src="img/clip.png" height="100px" class="center-block" />
            <h5>Administravimas <small>Kiekvienas prisijungimas fiksuojamas</small></h5>
          </div>

          <div class="login-form col-xs-9">
            <form action="index.php" method="POST" role="login">
            <div class="form-group">
              <input type="text" class="form-control login-field" name="username" placeholder="Slapyvardis" id="login-name" />
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
              <input type="password" class="form-control login-field" name="password" placeholder="Slaptažodis" id="login-pass" />
              <label class="login-field-icon fui-lock" for="login-pass"></label>
            </div>
            <?php if(isset($msg)) { echo "<p style='color:green'>" . $msg . "</p>"; }
                        if(isset($err)) { echo "<p style='color:red'>" . $err . "</p>"; } ?>
            <button class="btn btn-primary btn-lg btn-block" name="submit">Prisijungti</button>
            </form>
          </div> 
          </div><!-- /menu1 -->
                <?php } else { ?>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
              <img src="img/groupclip.png" class="tile-image big-illustration">
              <h3 class="tile-title"><i class="fa fa-bar-chart" aria-hidden="true"></i> Grupių redagavimas</h3>
              <p>Grupiu redagavimas, trinimas, pridėjimas bei kt.<br/>
              <b>Iš viso <?=$groupz?> grupių.</b></p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=editpgroup">Eiti</a>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/clip.png" class="tile-image big-illustration">
                <h3 class="tile-title"><i class="fa fa-bars" aria-hidden="true"></i> Privilegijų redagavimas</h3>
                <p>Privilegiju redagavimas, trinimas, pridėjimas bei kt.<br/>
                <b><?=$fpriv?> viso privilegiju</b></p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=editpriv">Eiti</a>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/settings.png" class="tile-image big-illustration">
                <h3 class="tile-title"><i class="fa fa-bars" aria-hidden="true"></i> Tinklapio nustatymai</h3>
                <p>PaySera projekto, svetainės pavadinimo, forumo url<br/>
                <b>nustatymai</b>.</p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=settings">Eiti</a>
              </div>
            </div>
             
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/server.png" class="tile-image big-illustration">
                <h3 class="tile-title"><i class="fa fa-bars" aria-hidden="true"></i> Serverio nustatymai</h3>
                 <p>Žaidimo minecraft serverio RCON sujungimas su paslaugom<br/>
                 <b>nustatymai</b>.</p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=serveris">Eiti</a>
              </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/priv.png" class="tile-image big-illustration">
                <h3 class="tile-title">Užsakytos privilegijos</h3>
                <p>Žaidėjai kurie užsisakė admin, vip, superadmin bei kt. <br/> <b>sąrašas</b></span></p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=uzsisake">Eiti</a>
              </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/okay.png" class="tile-image big-illustration">
                <h3 class="tile-title">Užsakytos paslaugos</h3>
                <p>Žaidėjai kurie užsisakė pinigų, unban, deimantu ir kt. <br/> 
                <b>sąrašas</b></p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=uzsisakep">Eiti</a>
              </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">
              <div class="tile">
                <img src="img/book.png" class="tile-image big-illustration">
                <h3 class="tile-title">Įvykių žurnalas</h3>
                <p->Paskutinti administracijos atliktų įvykių <br/>
                <b>sąrašas</b></p>
                <a class="btn btn-primary btn-large btn-block" href="index.php?page=logs">Eiti</a>
              </div>
            </div>
          </div>
        </div>
                <?php }
            } else if($stmt->rowCount() == 0) {?>
      <!-- menu1 -->
        <div class="login">
          <div class="login-icon col-xs-3">
            <img src="img/clip.png" height="100px" class="center-block" />
            <h5>Administravimas <small>Užregistruokite pirma vartotoja!</small></h5>
          </div>

          <div class="login-form col-xs-9">
                        <?php if(isset($msg)) { echo "<div class='alert alert-success'>" . $msg . "</div>"; }
                        if(isset($err)) { echo "<div class='alert alert-danger'>" . $err . "</div>"; } ?>
                        <form action="index.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control login-field" name="rusername" placeholder="Slapyvardis">
                                <label class="login-field-icon fui-user" for="login-name"></label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control login-field" name="rpassword" placeholder="Slaptažodis">
                                <label class="login-field-icon fui-lock" for="login-pass"></label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control login-field" name="rpassword2" placeholder="Pakartokit slaptažodį">
                                <label class="login-field-icon fui-lock" for="login-pass"></label>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">Registruotis</button>
                        </form>
          </div> 
          </div><!-- /menu1 -->
            <?php } ?>
    </div>
  </div>
</body>
<script src="js/vendor/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
function forum(cbox) {
      if (cbox.checked) {
        var input = document.createElement("input");
        input.type = "url";
        input.name = "forumurl";
        input.value = "<?=$forum?>";
        input.id = "forumurl";
        input.className = "form-control";
        input.placeholder = "Įrašykit svetainės forumo url";
        var div = document.createElement("div");
        div.id = cbox.name;
        if(cbox.value == 1){
        var checkboxs = document.createElement("input");
        checkboxs.type = "checkbox";
        checkboxs.name = "check";
        checkboxs.value = cbox.value;
        checkboxs.id = "checkas";
        checkboxs.checked = "checked";
        checkboxs.className = "form-control hidden";
        div.innerHTML = "Įveskite IPB forumo adresa: ";
        } else if(cbox.value == 2) {
        var checkboxs = document.createElement("input");
        checkboxs.type = "checkbox";
        checkboxs.name = "check";
        checkboxs.value = cbox.value;
        checkboxs.id = "checkas";
        checkboxs.checked = "checked";
        checkboxs.className = "form-control hidden";
        div.innerHTML = "Įveskite IPS forumo adresa: ";
        }
        div.appendChild(checkboxs);
        div.appendChild(input);
        document.getElementById("insertinputs").appendChild(div);
      } else {
        document.getElementById(cbox.name).remove();
      }
            var numberOfChecked = $('input:checkbox:checked').length;
            if (numberOfChecked > 0){
                $(".checkas").remove(this.checked);
            }
    }

    $('#privileges').change(function() {
        var id = $(this).val();
        $('#edit').attr('href', 'index.php?page=editpriv&id=' + id);
        $('#delete').attr('href', 'index.php?delete=privileges&id=' + id);
    });
    $('#groups').change(function() {
        var id = $(this).val();
        $('#edit').attr('href', 'index.php?page=editpgroup&id=' + id);
        $('#delete').attr('href', 'index.php?delete=groups&id=' + id);
    });
</script>
</html>
