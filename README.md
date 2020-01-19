# kollex Coding Challenge – Wholesaler Integration

kollex digitalizes the traditional B2B wholesale by building a digital beverage ecosystem. With our platform gastronomy 
customers can order everything in a one-stop-shop from their associated wholesalers.

It's a decentralized concept, which implies, that kollex integrates with many different wholesalers and gastronomy 
systems in all kind of ways and formats - from enterprise ERP systems to modern hypermedia APIs to classic CSV files. 

One of the essential information that is synced with the kollex platform to allow gastronomy customers ordering products 
from their associated wholesalers is the wholesaler's product assortment.


## Your Task
Your task is building a small peace of software, which is able to verify and interpret assortment and product 
information from different sources in different data formats. The amount of data and the exemplary "Product" schema 
is very simplified for the purpose of this coding challenge.

The challenge is to create a modern, maintainable, testable and extendable application, which:
- follows a pragmatic, but clean approach by 
  - building a smart software architecture 
  - e.g. utilizing the right design patterns without over-engineering
- follows best practices 
- can easily be extended to integrate additional sources or data formats
- is fully testable for continuous integration and delivery 


## The Data
In the `/data` folder, you find examples of assortment data in two different formats:
- wholsesaler_a.csv  
provides assortment data in CSV format
- wholsesaler_b.json  
provides assortment data in a JSON format


## The Goal
The goal is an application, which integrates different data formats (see "The Data") and maps those into the target
schema, which you can find in the `swagger.yaml`. This file does not describe a web API, but only defines 
the "Product" schema.

Your application should read the given data files (see "The Data") and return a JSON structure with a list of products 
as defined in the Swagger definition.

#### The Product Interface
The project provides the empty Interface `\kollex\Dataprovider\Assortment\Product`. Please implement this (based on the 
Product schema mentioned above) and/or all additionally required Interfaces or other types of Classes, which you think 
fit best for the given scenario.

#### Entrypoint
Your application **does not need** to expose a web API or a CLI interface. A simple PHP file as entrypoint is good 
enough. The focus of this task is the implementation of the data integration, validation and mapping.  


## What We expect
- clean, well structured code, that follows best practices
- tests. It's up to you which type of tests you want to write
- documentation of code, concepts or possible extensions in a way you think it fits best 


## Voluntary Tasks
- Docker setup: a Dockerfile and a docker-compose file, to run the whole stack via `docker-compose up`
- descriptions, why you chose a specific structure or pattern, framework or library compared to other options 
- an description of how you decided what tests to write

## Solution
`composer install`

`docker-compose up -d`

open `http://localhost:8023/` - to see the result

run `php vendor/phpunit/phpunit/phpunit test` for tests
