<?php
include("../includes/connection.php");
$stmt = $conn->prepare("SELECT * FROM privileges WHERE id = :id");
$stmt->execute(array(':id' => $_POST['id']));
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			<h6 class="modal-title">Paslaugos užsakymas</h6>
		</div>

		<div class="modal-body">
			<div class="alert alert-warning">
				Rekomenduojame pirkti paslaugas internetinės bankininkystės būdu, nes kaina yra mažesnė.
			</div>
			<div class="well">
		<?php 
		if ($data['price'] == 1) { 
			echo '<div class="alert alert-warning">Šios paslaugos SMS žinute užsakymas negalimas!</div>';
		} else {?>
			<h6>Paslaugos užsakymas SMS žinute</h6>

			<div class="alert alert-info">

				<p><b>Žinutės tekstas:</b> <?php echo $data['keyword']." ".$_POST['gamenick']; ?> </span></p>
				<p><b>Numeris:</b> <?php echo $data['number']; ?></p>
				<p><b>Žinutės kaina:</b> <?php echo $data['price'] / 100; ?> €</p>

			</div>
<?php } if ($data['makro_price'] == 1) { 
			echo '<div class="alert alert-warning">Šios paslaugos užsakymas El.bankininkyste / Apmokant grynaisiais negalimas!</div>';
		} else {
			?>
			<h6>Užsakymas Elektronine bankininkyste / Apmokant grynaisiais</h6>
			<div class="alert alert-success">
			<p>
			<b>Paslaugos kaina:</b> <?=$data['makro_price'] / 100;?> €
			<br>
			Spauskite mygtuką ir apmokėkite per PaySera.LT sistemą bankiniu pavedimu arba grynaisiais:				
			</p>
			</div>
		<a href="libwebtopay/makro.php?nick=<?php echo strtolower($_POST['gamenick']); ?>&id=<?php echo $data['id']; ?>" id="makro" class="btn btn-success">Užsakyti paslaugą</a>

			</div>
<?php } ?>
		</div>

	</div>

</div>