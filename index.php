<?php
include_once 'includes/config.php';
include_once 'includes/connection.php';
include_once 'forms.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$title?> - Paslaugos</title>
    <!-- Loading Bootstrap -->
    <link href="css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,  minimum-scale=1.0">
    <!-- Loading Flat UI -->
    <link href="css/flat-ui.min.css" rel="stylesheet">
    <link href="css/stilius.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="main_body">
    <div class="container">
      <div class="headline">
        <h1 class="logo">
          <a href=""><img src="img/logo.png" width="216.5" height="115"></a>
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
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
              <ul class="nav navbar-nav navbar-left">
              <!-- linkai -->
                <li><a href="/">Pagrindinis</a></li>
                <li><a href="">Paslaugos <span class="navbar-unread"></span></a></li>
		<li><a href="/vote">Balsavimas</a></li>
              <!-- /linkai -->
               </ul>
               <?php
               if ($paysera['forumtype'] == 2) {
                echo '<form class="navbar-form navbar-right" '.$forumas.' role="search">';
               } elseif ($paysera['forumtype'] == 1) {
                echo '<form class="navbar-form navbar-right" action="'.$forumas.'" role="search">';
               }
               ?>
                <div class="form-group">
                  <div class="input-group">
                  <?php
                  if ($paysera['forumtype'] == 2) {
                    echo '<input class="form-control" id="navbarInput-01" name="q" type="search" placeholder="Paieška forume..">';
              echo'<span class="input-group-btn">
                      <button type="submit" class="btn"><span class="fui-search"></span></button>
                    </span>';
                  } elseif ($paysera['forumtype'] == 1) {
                    echo '<input class="form-control" id="navbarInput-01" type="search" placeholder="Paieška forume..">';
              echo'<span class="input-group-btn">
                      <button type="submit" class="btn"><span class="fui-search"></span></button>
                    </span>';
                  }
                  ?>
                  </div>
                </div>
              </form>
            </div><!-- /.navbar-collapse -->
          </nav><!-- /navbar -->
        </div>
      </div> <!-- /row -->

      <?php 
      if(isset($_SESSION['parama']))
          {
            if($_SESSION['parama'] == '1')
            {
              echo '<button type="button" class="btn btn-success btn-lg btn-block">Apmokėjimas sėkmingai įvykdytas!</button><br/>';
              session_destroy();
              unset($_SESSION['parama']);
            }
            if($_SESSION['parama'] == '2')
            {
              echo '<button type="button" class="btn btn-danger btn-lg btn-block">Apmokėjimas atšauktas!</button><br/>';
              session_destroy();
              unset($_SESSION['parama']);
            }
          }
      ?>
      <!-- menu1 -->

      <div class="menu1">
      <div class="row">
       <div class="col-xs-12">
       <div class="tile">
       <h3 class="panel-title text-left">Jūsų slapyvardis žaidime</h3>
       <div class="divider"></div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" placeholder="Įveskite savo vardą žaidime" class="form-control" id="nick" />
              <span class="input-group-btn"><button type="submit" class="btn" id="next"><span class="fui-export"></span></button></span>
            </div>
          </div>
        </div>
        </div>
      </div>

      </div> <!-- /menu1 -->

      <!-- menu2 -->
      <div class="menu2" style="display: none;">
      <div class="row samples">
        <div class="col-xs-12">
        <div class="col-xs-3">
          <div class="row tiles">
            <div class="col-xs-11">
              <div class="tile">
                <h3 class="tile-title usernick nickname"></h3>
                <img id="user-img" class="tile-image">
                <div class="user-info"></div>
              </div>
            </div>
          </div>
        </div><!-- /.col-xs-7 -->

        <div class="col-xs-9">
          <div class="row">
              <div class="tile">
                <h3 class="panel-title text-left">Paslaugų užsakymas</h3>
                <div class="divider"></div>
                <div class="panel-group" id="accordion">

                <?php
                $stmt = $conn->prepare("SELECT * FROM privgroups");
                $stmt->execute();
                $data = $stmt->fetchAll();
                $data2 = $data;

                foreach($data as $groups) { ?>
                <div class="panel panel-default">

                  <div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#accordion<?php echo $groups['id']; ?>"><?php echo $groups['title']; ?></a></div>

                    <div id="accordion<?php echo $groups['id']; ?>" class="<?php if($data2[0]['id'] == $groups['id']) { echo "panel-collapse collapse in"; } else { echo "panel-collapse collapse"; } ?>">

                      <table class="table table-hover table-striped">
                        <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM privileges");
                        $data = $stmt->fetchAll();

                        foreach($data as $privileges) { ?>

                          <?php if($groups['id'] == $privileges['groupid']) { ?>

                          <tr>
                            <td><?php echo $privileges['title']; ?></td>
                            <td style="width: 150px;"><button type="button" data-pid="<?php echo $privileges['id']; ?>" class="btn btn-warning btn-sm info" data-toggle="modal" data-target="#modalinfo"><span class="glyphicon glyphicon-info-sign"></span> Detaliau apie paslaugą</button></td>
                            <td style="width: 130px;"><button type="button" data-pid="<?php echo $privileges['id']; ?>" class="btn btn-success btn-sm buy" data-toggle="modal" data-target="#modalbuy"><span class="glyphicon glyphicon-shopping-cart"></span> Pirkti paslaugą</button></td>
                          </tr>

                        <?php }
                        } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                  <?php } ?>

            </div>
              </div>
          </div>
        </div>
    </div>
      </div> <!-- /menu2 -->

    </div>
    <!-- /.container -->
  
    <div class="modal fade" id="modalinfo"></div>
    <div class="modal fade" id="modalbuy"></div>

    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/application.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $( "#next" ).click(function() {
        if($("#nick").val() == "")
        {
          alert("Jūs neįrašėte savo slapyvardžio");
        } else {
          $(".menu1").fadeOut(1000);
          $("#nickas").html($("#nick").val());
          $(".menu2").delay(1000).slideDown(1000);
          $(".nickname").html($("#nick").val());
          $("#user-img").attr("src", "https://minotar.net/body/" + $("#nick").val() + "/100.png");
          $.post('ajax/user-info.php', { gamenick: $("#nick").val() }, function(data) {
            $('.user-info').html(data);
          });
          $( ".buy" ).click(function() {
            $.post('ajax/buy.php', { gamenick: $("#nick").val(), id: $(this).attr('data-pid') }, function(data) {
              $('#modalbuy').html(data);
            });
          });
          $( ".info" ).click(function() {
            $.post('ajax/info.php', { id: $(this).attr('data-pid') }, function(data) {
              $('#modalinfo').html(data);
            });
          });
        }
      });
    </script>
  </body>
</html>
