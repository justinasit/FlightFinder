<?php

require 'vendor/autoload.php';

$cheapestFlightFinder = new App\CheapestFlightFinder(['FRA', 'LON'], 'STO', '2018-10-01', 14, 1);
$results = $cheapestFlightFinder->findMinPrice();
//List of available flights
var_dump($cheapestFlightFinder->flights);
//Final Result (cheapest flight)
var_dump($results);
