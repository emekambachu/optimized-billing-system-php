# Smart Meter Billing System by Victor Mbachu

This project is an optimized billing system for a utility company. It calculates electricity bills based on smart meter data using different rates for peak and off-peak hours.

## Features

- **MVC Architecture:** Used clean separation of concerns.
- **Billing Calculation:** Used the Strategy pattern for peak and off-peak rate calculations.
- **Dependency Injection:** Used dependency injection for decoupled and testable code.
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

**Run the tests:**
   ```bash
   vendor/bin/phpunit --configuration phpunit.xml
```

**Run the application in docker:**
   ```bash
   docker-compose up --build
```