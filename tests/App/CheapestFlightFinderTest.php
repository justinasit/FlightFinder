<?php
namespace tests\App;

use PHPUnit\Framework\TestCase;
use App\CheapestFlightFinder;

class CheapestFlightFinderTest extends TestCase
{   
    /**
     * Used for invoking private/protected methods
     */
    private function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testFindMinPriceReturnsPrice() 
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA'], 'JKT', '2018-02-01', 14, 0);
        $results = $cheapestFlightFinder->findMinPrice();
        
        $this->assertTrue(is_array($results));
        $this->assertTrue(isset($results['searchMinPrice']));
    }

    public function testFindMinPriceReturnsTheCheapestPrice() 
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA', 'CPH'], 'JKT', '2018-02-01', 14, 0);
        $results = $cheapestFlightFinder->findMinPrice();

        foreach ($cheapestFlightFinder->flights as $flight) {
            if (!isset($minPrice) || $flight['searchMinPrice'] < $minPrice) {
                $minPrice = $flight['searchMinPrice'];
            }
        }
        
        $this->assertEquals($minPrice, $results['searchMinPrice']);
    }

    public function testIncrementDate()
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA', 'CPH'], 'JKT', '2018-02-01', 14, 0);
        $date = $this->invokeMethod($cheapestFlightFinder, 'incrementDate', ['2018-02-01', 2]);

        $this->assertEquals($date, '2018-02-03');
    }

    public function testIsPriceLowerReturnsTrueIfLowerPriceIsSent()
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA', 'CPH'], 'JKT', '2018-02-01', 14, 0);
        $minPriceFlight = [
            'searchMinPrice' => 20,
        ];
        $response = $this->invokeMethod($cheapestFlightFinder, 'isPriceLower', [$minPriceFlight, 15]);

        $this->assertTrue($response);
    }

    public function testIsPriceLowerReturnsTrueIfNoMininumSet()
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA', 'CPH'], 'JKT', '2018-02-01', 14, 0);
        $response = $this->invokeMethod($cheapestFlightFinder, 'isPriceLower', [null, 15]);

        $this->assertTrue($response);
    }

    public function testIsPriceLowerReturnsFalseIfCurrentPriceIsZero()
    {
        $cheapestFlightFinder = new CheapestFlightFinder(['FRA', 'CPH'], 'JKT', '2018-02-01', 14, 0);
        $minPriceFlight = [
            'searchMinPrice' => 20,
        ];
        $response = $this->invokeMethod($cheapestFlightFinder, 'isPriceLower', [$minPriceFlight, 0]);

        $this->assertFalse($response);
    }
}
