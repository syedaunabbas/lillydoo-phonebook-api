# About

This scope of task is to implement a RESTful API for before-mentioned phone-book to be used by our frontend developers. Customers should be able to perform the following actions:

- Add other customers as contact
- Edit created contacts.
- Delete existing contacts
- Search for contacts by name

### `Each contact will need the following information:`
- first name
- last name
- address information
- phone number
- birthday
- email address
- Picture (optional)


## Demo Screenshots
![Phonebook API Swagger](/readme-media/Swagger.jpeg "Phonebook API Swagger")
![Phonebook API Doc](/readme-media/API-Doc.jpeg "Phonebook API Doc")
![Phonebook API Doc](/readme-media/DB.jpeg "Phonebook API Doc")

# Code Documentation

Phonebook-Api Application core business logic persists in `src` folder. Uses the MVC architecture with loosely coupled code and follows the best practices SOLID principle.

## API Details 
- The application CRUD services can be access via
- **API Swagger URL:** `BASE_URL/api/`
- **API Doc URL:** `BASE_URL/api/docs?ui=re_doc`

I uses the [API Platform Component](https://api-platform.com/) with `Symfony` which conforms to the Open API specification, also get auto-generated documentation via Swagger. 

## Code Business Logic
- `src/Entity/Contacts.php` is our Entity file which have all the fields/properties related to contacts table.
- The most important thing to note is the inclusion of `@ApiResource` which declares this entity to be used as an API.
- `src/Controller/SearchByName.php`, expose a new route that’s different than the default ones to search name in `contact table`  
- `src/Controller/ContactProfileController.php` Modify/Upate the existing POST route to achieve profile image upload functionality 

## Test Cases
- Feature test cases class `ContactsTest.php` will be found in `test/Feature`.
- I covered all the positive and negative test cases of `GET & POST` in this class.

# Run Application via Symfony CLI

## Requirements
- [Composer](https://getcomposer.org/download/)
- [Symfony binary/installer](https://symfony.com/download)

## Setup
1. Clone the repository.
1. Copy .env.example to .env `cp .env.example .env`
1. Install packages by running `composer install`.

## Database Configurations
For demonstration purpose, I used database named `phonebook`. Configurations can be visited in `.env` file located at the root of the project. 
- `DATABASE_URL="mysql://root:click1234@172.23.0.2:3306/phonebook?serverVersion=5.7&charset=utf8mb4"`.

You can change your DB changes
- `DATABASE_URL="mysql://DB_USER:DB_PASSWORD@IP:PORT/DB_NAME?serverVersion=5.7&charset=utf8mb4"`.

Now, create database via doctrine command
- `php ./bin/console doctrine:database:create`

Now, add `contacts` table schema via doctrine command
- `php bin/console doctrine:schema:update --force`


## Run
1. Run application `symfony server:start`

## How to use
* Visit started development server [localhost:PORT/api](http://localhost:PORT/api)

## Running PHPUnit

* To run the application test suite, it is required to create test database in our case `phonebook_test` 
* Command run the unit test suite `php bin/phpunit`