<?php
namespace App\Api;

use vendor\Momondo;
use App\Api\FlightFinderInterface;

class MomondoFinder implements FlightFinderInterface
{
    /**
     * Finds the cheapest price of a flight using Momondo API.
     * 
     * @param  string $startingAirport Starting airport
     * @param  string $destination     Destination
     * @param  string $fromDate        From date
     * @param  string $returnDate      Return date
     * @return float
     */
    public function getLowestPrice(string $startingAirport, string $destination, string $fromDate, string $returnDate) : float
    {
        $momondo = new Momondo();
        $url = $momondo->search_url($startingAirport, $destination, $fromDate, $returnDate);
        if ($url) {
            $searchResults = $momondo->search_results($url);
            $searchMinPrice = $searchResults[count($searchResults)-1]['Summary']['MinPrice'];

            return $searchMinPrice;
        }
    }
    
}
