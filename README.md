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
   

## How to Use Product Feeder?
  We have created an command to handle multiple api sources by using only one command. 
  Give it a try? Here is the command
  ./vendor/bin/sail php artisan app:product-feed $sourceName
  $sourceName is a variable to pick which feed you would like to update or insert into your system.
