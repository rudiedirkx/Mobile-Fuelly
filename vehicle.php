<?php

require 'inc.bootstrap.php';

$vehicle = $client->getVehicle($_GET['id']);

include 'tpl.header.php';

?>
<pre><? print_r($vehicle) ?></pre>
