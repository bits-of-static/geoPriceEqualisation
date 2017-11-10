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

echo 'Adapting value 5:';
foreach ($instances as $each) {
	var_export($each);
	echo PHP_EOL;
	echo ($each->adapt(5));
	echo PHP_EOL;
	echo PHP_EOL;
}

echo 'Testing toString:';
echo PHP_EOL;
echo '0 -> '. $instances[0]->toString(0);
echo PHP_EOL;
echo '1.1 -> '. $instances[0]->toString(1.1);
echo PHP_EOL;
echo '2.22 -> '. $instances[0]->toString(2.22);
echo PHP_EOL;
echo '3.333 -> '. $instances[0]->toString(3.333);
echo PHP_EOL;

