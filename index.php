<?php

require 'inc.bootstrap.php';

$vehicles = $client->getVehicles();

include 'tpl.header.php';

?>

<h1>Vehicles</h1>

<ul>
	<? foreach ($vehicles as $vehicle): ?>
		<li><a href="vehicle.php?id=<?= html($vehicle['id']) ?>"><?= html($vehicle['name']) ?></a></li>
	<? endforeach ?>
</ul>

<?php

include 'tpl.footer.php';
