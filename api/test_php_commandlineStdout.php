<?php
require_once('GeoIpEconomy.php');

echo \ihde\GeoIpEconomy::$min. ' '. \ihde\GeoIpEconomy::$max;
echo PHP_EOL;
echo PHP_EOL;

$instances = [
	new \ihde\GeoIpEconomy('CH'),
	new \ihde\GeoIpEconomy('US'),
	new \ihde\GeoIpEconomy('SK'),
	new \ihde\GeoIpEconomy('CD'),
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
