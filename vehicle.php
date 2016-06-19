<?php

require 'inc.bootstrap.php';

$vehicle = $client->getVehicle($_GET['id']);

if ( isset($_POST['distance'], $_POST['amount'], $_POST['date']) ) {
	print_r($_POST);
	exit;
}

include 'tpl.header.php';

$base = function($val) {
	return round($val->to('base'), 1);
};

$fuelups = $vehicle->trend; // $client->getFuelUpsWithIds($vehicle, 60);
$stats['min_mileage'] = $stats['min_distance'] = $stats['min_amount'] = PHP_INT_MAX;
$stats['max_mileage'] = $stats['max_distance'] = $stats['max_amount'] = 0;
foreach ($fuelups as $fuelup) {
	$stats['min_mileage'] = min($stats['min_mileage'], $base($fuelup->mileage));
	$stats['min_distance'] = min($stats['min_distance'], $base($fuelup->distance));
	$stats['min_amount'] = min($stats['min_amount'], $base($fuelup->amount));
	$stats['max_mileage'] = max($stats['max_mileage'], $base($fuelup->mileage));
	$stats['max_distance'] = max($stats['max_distance'], $base($fuelup->distance));
	$stats['max_amount'] = max($stats['max_amount'], $base($fuelup->amount));
}

$max = function($qt, $fuelup) use ($base, $stats) {
	return $stats["max_$qt"] == $base($fuelup->$qt) ? 'max' : '';
};
$min = function($qt, $fuelup) use ($base, $stats) {
	return $stats["min_$qt"] == $base($fuelup->$qt) ? 'min' : '';
};

?>
<style>
.fuelups-table {
	border-collapse: collapse;
	border-spacing: 0;

}
.fuelups-table th,
.fuelups-table td {
	padding: 6px;
	border: solid 2px #ddd;
}
.fuelups-table th.sort {
	background-color: #e7e7e7;
}
.fuelups-table td {
	text-align: right;
}
.fuelups-table td.min {
	background-color: #fee;
}
.fuelups-table td.max {
	background-color: #efe;
}
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
	<p>Distance: <input type="number" name="distance" /> <?= $output->distance ?></p>
	<p>Fuel amount: <input type="number" name="amount" /> <?= $output->volume ?></p>
	<p>Date: <input type="date" name="date" value="<?= date('Y-m-d') ?>" /></p>
	<p><button>Save</button></p>
</form>

<h2>Fuel-ups (<?= count($fuelups) ?>)</h2>

<div class="fuelups-history">
	<div class="date start"><?= reset($fuelups)->date->format('Y M') ?></div>
	<div class="bars">
		<? foreach ($fuelups as $fuelup): ?>
			<div class="bar" style="height: <?= number_format($fuelup->mileage->to('kmpl') / $stats['max_mileage'] * 100, 1) ?>%"></div>
		<? endforeach ?>
	</div>
	<div class="date end"><?= end($fuelups)->date->format('Y M') ?></div>
</div>

<? foreach (array(/*'trend' => $vehicle->trend,*/ 'details' => $fuelups) as $source => $list): ?>
	<h3><?= $source ?></h3>
	<table class="fuelups-table">
		<tr>
			<th class="sort">Date</th>
			<th>Amount</th>
			<th>Distance</th>
			<th>Mileage</th>
		</tr>
		<? foreach ($list as $fuelup): ?>
			<tr>
				<td>
					<?= $fuelup->date->format('j M Y') ?>
				</td>
				<td class="<?= $max('amount', $fuelup) . ' ' . $min('amount', $fuelup) ?>">
					<?= $output->formatVolume($fuelup->amount) ?>
				</td>
				<td class="<?= $max('distance', $fuelup) . ' ' . $min('distance', $fuelup) ?>">
					<?= $output->formatDistance($fuelup->distance) ?>
				</td>
				<td class="<?= $max('mileage', $fuelup) . ' ' . $min('mileage', $fuelup) ?>">
					<?= $output->formatMileage($fuelup->mileage) ?>
				</td>
			</tr>
		<? endforeach ?>
	</table>
<? endforeach ?>

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
