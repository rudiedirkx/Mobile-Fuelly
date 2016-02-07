<?php

require 'inc.bootstrap.php';

$vehicle = $client->getVehicle($_GET['id']);

if ( isset($_POST['distance'], $_POST['amount'], $_POST['date']) ) {
	print_r($_POST);
	exit;
}

include 'tpl.header.php';

$fuelups = $client->getFuelUpsWithIds($vehicle);

?>
<h1><?= html($vehicle->name) ?></h1>

<h2>Fuel up</h2>

<form method="post" action="?id=<?= (int) @$_GET['id'] ?>">
	<p>Distance: <input type="number" name="distance" /> km</p>
	<p>Fuel amount: <input type="number" name="amount" /> l</p>
	<p>Date: <input type="date" name="date" value="<?= date('Y-m-d') ?>" /></p>
	<p><button>Save</button></p>
</form>

<h2>Fuel-ups</h2>

<ul>
	<? foreach ($fuelups as $fuelup): ?>
		<li>
			<h3><?= $fuelup->date->format('j M Y') ?></h3>
			<p>Eff.: <?= number_format($fuelup->mileage->amount, 2) ?></p>
		</li>
	<? endforeach ?>
</ul>

<? /*
<details>
	<summary>Vehicle</summary>
	<pre><? print_r($vehicle) ?></pre>
</details>

<details>
	<summary>Fuel-ups</summary>
	<pre><? print_r($fuelups) ?></pre>
</details>
*/ ?>

<?php

include 'tpl.footer.php';
