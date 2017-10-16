<?php
namespace App\Api;

interface FlightFinderInterface
{
    public function getLowestPrice(string $startingAirport, string $destination, string $fromDate, string $returnDate) : float;
}

