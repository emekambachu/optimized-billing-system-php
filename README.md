# Smart Meter Billing System by Victor Mbachu

This project is an optimized billing system for a utility company. It calculates electricity bills based on smart meter data using different rates for peak and off-peak hours.

## Features

- **MVC Architecture:** Used clean separation of concerns.
- **Billing Algorithm**: Groups meter data by meter_id and calculates individual bills.
- **Dynamic Rate Update**: Update peak and off-peak rates directly from the web page using an input form.
- **JSON Data Source**: Meter data is populated from a JSON file (It's usually from an API or database but for this test purpose i will use a json file).
- **Error Handling**: Uses try–catch blocks and error reporting to manage invalid input or file errors. (I know the question states we should assume the data is always correct but I still added this feature for good practice).
- **Dependency Injection**: Uses constructor injection for services.
- **Testing:** Installed and used php unit version 9.5 for Unit and Integration test.
- **Containerization:** Installed and setup Docker and Docker Compose configurations are included.
- **Modern PHP Practices:** Adhered to Sensible type declarations, encapsulation, and PSR-12.
- **Git version Control:** Designed for a collaborative workflow using Git with feature branches and pull requests.

## PHP Version
- **v8.0 or higher but preferably v8.2**

## Installation
**Clone the repository:**
   ```bash
   git clone https://github.com/emekambachu/optimized-billing-system-php.git
   cd optimized-billing-system-php
```
   
**Install dependencies:**
   ```bash
   composer install
```
**Run the application in docker:**
   ```bash
   docker-compose up --build
```

**Run application outside docker:**
   ```bash
   php -S localhost:8000 -t public
```

**Access the application:**
   ```bash
   http://localhost:8000
```

**Run the tests:**
   ```bash
   vendor\bin\phpunit
```