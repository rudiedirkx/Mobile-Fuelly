<?php

require 'inc.bootstrap.php';

$vehicle = $client->getVehicle($_GET['id']);

if ( isset($_POST['distance'], $_POST['amount'], $_POST['date']) ) {
	print_r($_POST);
	exit;
}

include 'tpl.header.php';

$fuelups = $client->getFuelUpsWithIds($vehicle, 60);
$max = array_reduce($fuelups, function($max, $fuelup) {
	return max($max, $fuelup->mileage->amount);
}, 0);

?>
<style>
.fuelups-history {
	width: 100%;
	overflow: auto;
	padding-bottom: 1px;
	border-bottom: solid 2px black;
	display: -webkit-box;
	display: flex;
}
.fuelups-history .date {
	align-self: center;
	line-height: 70px;
}
.fuelups-history .date.start {
	margin-right: 5px;
}
.fuelups-history .date.end {
	margin-left: 5px;
}
.fuelups-history .bars {
	height: 70px;
	display: -webkit-flex;
	display: -webkit-box;
	display: flex;
	-webkit-box-align: end;
	align-items: flex-end;
}
.fuelups-history .bar {
	width: 3px;
	background-color: black;
}
.fuelups-history .bar + .bar {
	margin-left: 1px;
}
</style>

<h1><?= html($vehicle->name) ?></h1>

<h2>Fuel up</h2>

<form method="post" action="?id=<?= (int) @$_GET['id'] ?>">
	<p>Distance: <input type="number" name="distance" /> km</p>
	<p>Fuel amount: <input type="number" name="amount" /> l</p>
	<p>Date: <input type="date" name="date" value="<?= date('Y-m-d') ?>" /></p>
	<p><button>Save</button></p>
</form>

<h2>Fuel-ups (<?= count($fuelups) ?>)</h2>

<div class="fuelups-history">
	<div class="date start"><?= reset($fuelups)->date->format('Y M') ?></div>
	<div class="bars">
		<? foreach ($fuelups as $fuelup): ?>
			<div class="bar" style="height: <?= number_format($fuelup->mileage->amount / $max * 100, 1) ?>%"></div>
		<? endforeach ?>
	</div>
	<div class="date end"><?= end($fuelups)->date->format('Y M') ?></div>
</div>

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
