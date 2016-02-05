<?php

require 'inc.bootstrap.php';

$vehicle = $client->getVehicle($_GET['id']);
$fuelups = $client->getFuelUpsWithIds($vehicle);

include 'tpl.header.php';

?>
<h1><?= html($vehicle->name) ?></h1>

<h2>Fuel-ups</h2>

<ul>
	<? foreach ($fuelups as $fuelup): ?>
		<li>
			<h3><?= $fuelup->date->format('j M Y') ?></h3>
			<p>Eff.: <?= number_format($fuelup->mileage->amount, 2) ?></p>
		</li>
	<? endforeach ?>
</ul>

<details>
	<summary>Vehicle</summary>
	<pre><? print_r($vehicle) ?></pre>
</details>

<details>
	<summary>Fuel-ups</summary>
	<pre><? print_r($fuelups) ?></pre>
</details>

<?php

include 'tpl.footer.php';
