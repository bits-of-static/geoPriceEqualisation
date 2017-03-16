<?php
require_once('GeoIpEconomy.php');

echo \ihde\GeoIpEconomy::$min. ' '. \ihde\GeoIpEconomy::$max;
echo PHP_EOL;
echo PHP_EOL;

$instances = [
	new \ihde\GeoIpEconomy('ch'),
	new \ihde\GeoIpEconomy('us'),
	new \ihde\GeoIpEconomy('sk'),
	new \ihde\GeoIpEconomy('cd'),
	new \ihde\GeoIpEconomy('-'),
	new \ihde\GeoIpEconomy('ewrwretwert'),
];

foreach ($instances as $each) {
	var_export($each);
	echo PHP_EOL;
	echo ($each->adapt(5));
	echo PHP_EOL;
	echo PHP_EOL;
}
