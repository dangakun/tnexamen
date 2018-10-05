# PHP Integration Engineer Test

## The Problem

You are a part of the _Checkout & Fullfilment_ team, that is responsible to the **checkout application** that allows the consumers to complete the orders with their information, including personal information, billing and shipping addresses and payment data. 

The _Shipping_ team is about to release a new service to replace the direct access to the CEPs(1) database by a webservice that provides a RESTful API. This addresses information is needed during the checkout process in order to auto-complete the address form in our checkout. 

To make it a bit harder, the **address service** is under development and will be released on next week, but we can't wait to the service deployment to start the development, and the only reference we have is the API specification described in this document, so we need you to make it happen. 

## The Objective

Given the existing code base, and the API specification described in this document, we need you to write a new implementation to access this new service.

## Business Requirements

1 - The current implementation is not good enough and we know that. As you are implementing this new feature, **we expect** that you can improve the software design as well, so, making refactors, creating new entities, optimising statements and writing new tests are a good start point.

2 - This service is new and never went to production before, so to minimize the risks, **we need** to release it only for the stores that are a part of the beta testing program, and all the remaining stores **should use** the old implementation. Check out the **Store model** to figure out how to determine if a store is part of the beta testing program.

3 - The service is under development and will be released on next week, and as we need to move fast with the team projects, we cannot wait for a staging server, so, using the API specification described below, you need to mock-up the expected behavior in your tests to make sure that it will work when we deploy it.

4 - Finally, an error (of any type) **should never** be shown to the users, so, error handling is required in a end-to-end way.

## The API

The Address API has only one endpoint and it was designed to provide resilience and scalability in some parts of our platform.

### Base URL

The specified service will be available under: `https://shipping.tiendanube.com/v1/`

### Address Endpoint

The Address API is available in the *address* endpoint the has the following format, where *{0}* is the zipcode of requested address: `/address/{0}`.

Here are some examples of the expected behaviors:

#### Available Address 
```
$ curl -XGET -H 'Authentication bearer: YouShallNotPass' -H "Content-type: application/json" https://shipping.tiendanube.com/address/40010000

HTTP/1.1 200 OK
Server: nginx/1.12.2
Content-Type: application/json
Content-Length: 308

{
    "altitude":7.0,
    "cep":"40010000",
    "latitude":"-12.967192",
    "longitude":"-38.5101976",
    "address":"Avenida da França",
    "neighborhood":"Comércio",
    "city":{  
        "ddd":71,
        "ibge":"2927408",
        "name":"Salvador"
    },
    "state":{  
        "acronym":"BA"
    }
}
```

#### Nonexistent Address
```
$ curl -XGET -H 'Authentication bearer: YouShallNotPass' -H "Content-type: application/json" https://shipping.tiendanube.com/address/400100001

HTTP/1.1 404 Not Found
Server: nginx/1.12.2
Content-Type: application/json
Content-Length: 0
```

#### Server Error
```
$ curl -XGET -H 'Authentication bearer: YouShallNotPass' -H "Content-type: application/json" https://shipping.tiendanube.com/address/40010000

HTTP/1.1 500 Internal Server Error
Server: nginx/1.12.2
Content-Type: application/json
Content-Length: 0
```

## Instructions

- You **should** push your solution into a GitHub public repository and send to the recruited within the agreed deadline.
- You **should** read the code base to understand what is already implemented and how you can use it to help you achieve the solution.
- You **should** try to design the most well designed and maintainable solution as possible, we will evaluate the implementation details and the design choices.
- You **should not** have to care about details like framework integration, dependency injection containers, database access layer, logger implementation or any other runtime details, just trust in the available interfaces and feel free to create new ones. Remember, you're responsible to implement the business requirements, anything beyond that, is discouraged.
- You **should not** use any framework to achieve the solution, this is a part of the challenge.
- Your code **should** be tested using unit tests and integration tests, feel free to use packages to mock the expected behaviors.

## Setup

This project has some dependencies and uses composer to manage it, and you can install these packages using:

```
$ cd /path/to/the/project
$ composer install
```

## Running the tests

To run the tests, you can use the following command line:

```
$ ./vendor/bin/phpunit
```

(1) CEP stands by Código de Endereçamento Postal, that is the acronym for zipcode in Brazil.
