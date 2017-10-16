<?php
namespace App;

use App\Api\FlightFinder;

class CheapestFlightFinder {

    private $flightFinder;
    private $destinations;
    private $startingAirport;
    private $startingDate;
    private $duration;
    private $flexibility;

    public $flights = [];

    /**
     * Defines search parameters.
     * 
     * @param array $destinations     Array of destination airports, e.g. ['FRA', 'LON', 'CPH']
     * @param string $startingAirport Starting airport, e.g. ['MAN']
     * @param string $startingDate    Date of the flight in YYYY-MM-DD format, e.g. '2018-03-01'
     * @param int $duration           Duration of the trip in days, e.g. 14
     * @param int $flexibility        Flexibility of the starting date, e.g. 10 means any time between 2018-03-01 and 2018-03-11 if the starting date is 2018-03-01 
     */
    public function __construct(array $destinations, string $startingAirport, string $startingDate, int $duration, int $flexibility) {
        $this->flightFinder    = new FlightFinder();
        $this->destinations    = $destinations;
        $this->startingAirport = $startingAirport;
        $this->startingDate    = $startingDate;
        $this->duration        = $duration;
        $this->flexibility     = $flexibility;
    }

    /**
     * Loops through days and destinations to find the cheapest flight price.
     * @return array 
     */
    public function findMinPrice() : array {
        $minPriceFlight = null;
        foreach (range(0, $this->flexibility) as $index) {
            $fromDate = $this->incrementDate($this->startingDate, $index);
            $returnDate = $this->incrementDate($fromDate, $this->duration);
            foreach ($this->destinations as $destination) {
                $searchMinPrice = $this->flightFinder->getLowestPrice($this->startingAirport, $destination, $fromDate, $returnDate);
                $this->flights[] = compact('searchMinPrice', 'destination', 'fromDate', 'returnDate');
                if ($this->isPriceLower($minPriceFlight, $searchMinPrice)) {
                    $minPriceFlight = compact('searchMinPrice', 'destination', 'fromDate', 'returnDate');
                }
            }
        }

        return $minPriceFlight;
    }

    /**
     * Increment date by a specified number of days.
     * 
     * @param  string $fromDate Initial date
     * @param  string $index Number of days
     * @return string
     */
    private function incrementDate(string $fromDate, int $index) : string {
        $returnDay = strtotime("+" . $index . " day", strtotime($fromDate));
        return date('Y-m-d', $returnDay);
    }

    /**
     * Check if the new price from the search results is lower than the current one.
     * 
     * @param  array/null  $minPriceFlight Flight array with the current minimum price information
     * @param  float  $newPrice      New price used for comparison
     * @return bool 
     */
    private function isPriceLower(?array $minPriceFlight, float $newPrice) : bool {
        if ((!isset($minPriceFlight['searchMinPrice']) || $newPrice < $minPriceFlight['searchMinPrice']) && $newPrice > 0) {
            return true;
        }

        return false;
    }
}
