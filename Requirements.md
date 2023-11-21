# PHP and Vue JS Developer Test

## Purpose
The purpose of this test is to determine your proficiency with PHP and your skill
as a full-stack developer.

## Task
Build a single page application that uses data provided from the
[ATDW Atlas API](https://developer.atdw.com.au/ATDWO-api.html) to list
accommodation options in Sydney. Using the service you develop the frontend
application shall enable the user to filter results by regions, areas and cities/suburbs as defined
by the ATDW API.

This is to be build by creating a PHP backend application that consumes the data
from the Atlas API in JSON. The service will then provide the data to the frontend.

The visual result we want is to have a page that uses Vue JS to render and filter the content.
A minimum of two filters are required:
* Filter by Area
* Filter by City/Suburb

### Data source
* Data can be called using the methods defined at
  [ATDW Atlas API](https://developer.atdw.com.au/ATLAS/API/ATDWO-api.html).
  All documentation can be found via this link.
* For development the API key is: `123456789101112`

## Requirements
* The service must be written in PHP 8.2.
* The PHP code must use composer to manage any dependencies.
* Although it is overkill [Guzzle](https://docs.guzzlephp.org/en/stable/) must be used.
* Responses from the API must be handled in JSON
* The frontend must be developed using Vue JS and the composition api
* Well structured reusable components.

## What we are looking for
* How you solve the problem in code.
* Code style.
* Commit history (This is **extremely** important. Do not overlook this.)

## Bonuses
* Unit Tests (phpunit and/or vitest)
* Typescript
* Develop docker-compose file to run.
* Accommodation details in a modal overlay or redrawn component.
* Caching logic for calls.
* Unit Tests (phpunit and/or Jest)

### Hint
* The ATDW uses UTF-16LE encoding.
* Loading all content and filtering in the frontend is not an option due to the
  volume.
* Similar functionality can be seen at the bottom of this
  [page](https://int.sydney.com/destinations/sydney).
