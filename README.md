# API Data Conversion and Storage Project

This project aims to retrieve data from external APIs and store it in the program's database after converting the API response to a custom object format. The API responses can be in JSON or XML format, and the mapping process is defined using YAML configuration files.

## Features

- Fetch data from multiple APIs with different formats (JSON or XML).
- Convert API response into custom object format using YAML configuration.
- Store converted data in the database.

## Installation

1. Clone the repository:

git clone https://github.com/uozanozyildirim/api-data-mapping.git

2. Copy .env.example file to .env

3. Use the Laravel Sail to start up which is an interface to Docker

    open the terminal in the project and in terminal write

    ./vendor/bin/sail up

   this will take some minutes to run your development enviroment.

3. Migrate the project
   ./vendor/bin/sail php artisan migrate

## How to run the tests?

    ./vendor/bin/sail php test

To see failing and passing test.
    
## How to Use Product Feeder?
  We have created an command to handle multiple api sources by using only one command. 
  Give it a try? Here is the command
  
    ./vendor/bin/sail php artisan app:product-feed $sourceName
  
  $sourceName is a variable to pick which feed you would like to update or insert into your system.

## What is the purpose of this project and what we have done?

In the project we've worked on, we used the Dependency Injection design pattern, which allows us to inject the required dependencies into classes instead of hardcoding them inside the class. This makes the code more flexible, testable, and loosely coupled.

We used the Adapter design pattern to convert the API response into our desired format. The ApiClient class acted as an adapter that handles different content types (JSON and XML) and converts them into arrays.

Regarding SOLID principles:

## Single Responsibility Principle (SRP):

The classes in the project have clear and single responsibilities. For example, the ApiClient class is responsible for making API calls and converting responses.


## Open/Closed Principle (OCP):
The code seems to be open for extension and closed for modification. We can easily add support for new API sources or formats without modifying the existing code.

## Liskov Substitution Principle (LSP): 
The code appears to follow LSP as there are no apparent issues with substituting derived classes for their base classes.
Interface Segregation Principle (ISP): Since we don't have large interfaces, we don't violate ISP. Each class implements only the methods it needs but for the add more Sources this source.php should have implement to SourceInterface.

## Dependency Inversion Principle (DIP):
The code adheres to DIP by depending on abstractions rather than concrete implementations. For instance, the ApiClient class depends on the ClientInterface rather than a specific HTTP client library.

## Regarding Clean Code:
The code is reasonably organized into classes and follows PSR coding standards for PHP, which improves readability and maintainability.
We use meaningful variable and method names, making the code self-explanatory and easier to understand.
Unit tests are added to validate the functionality of the classes and methods, ensuring the code's correctness.
The project has a clear directory structure, making it easy to navigate and find relevant files.


## Change Log

https://github.com/uozanozyildirim/Api-Data-Mapping/blob/main/changeLog.md
