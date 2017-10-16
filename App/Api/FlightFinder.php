<?php
namespace App\Api;

use App\Api\MomondoFinder;
use App\Api\FlightFinderInterface;

class FlightFinder implements FlightFinderInterface
{    
    private $instance;
    
    /**
     * Using Momondo as the flight provider API.
     */
    public function __construct() 
    {
        $this->instance = new MomondoFinder;
    }
    
    /**
     * Perform a price check search using the API.
     * 
     * @param  string $startingAirport Starting airport
     * @param  string $destination     Destination
     * @param  string $fromDate        From date
     * @param  string $returnDate      Return date
     * @return float
     */
    public function getLowestPrice(string $startingAirport, string $destination, string $fromDate, string $returnDate) : float
    {
        return $this->instance->getLowestPrice($startingAirport, $destination, $fromDate, $returnDate);
    }   
}
