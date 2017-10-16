# FlightFinder Overview

* This program allows you to find the cheapest flight from your home airport to specified destinations. It is useful for situations when you want to book a holiday and have multiple cities in mind, but have a tight budget.
* A list of all flights found is also stored and can be printed out.
* Other websites usually don't allow this functionality because of long search times and complicated search algorithm.
* Uses Momondo API (PHP library created by https://github.com/5ms/Momondo-API). The program was created with an idea in mind of easily switching to another API in case it's needed.
* Example usage can be found in the `example.php` file.

# Prerequisites:
* PHP 7.1+
* Composer

# Set up FlightFinder:
1. Clone flightfinder repository.
2. Run `composer dump-autoload` to create a class map.
3. (Optional) For running tests, run `composer install` to install PHPUnit dependencies.

# Notes
* The more airports you enter and the bigger the flexibility is - the longer the search is going to take. Request time out might need to be adjusted on the web server for longer search times.
