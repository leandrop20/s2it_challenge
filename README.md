# S2IT Challenge

This is the S2IT Challenge 2018

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

This project require Composer, Symfony 2.8 and mysql db

### Installing

1. clone this repository

2. go to path/your/project

3. $ composer install

4. configure the database
```
#app/config/parameters.yml
parameters:
	database_host:		localhost
	database_name:		s2it_test
	database_user:		root
	database_password:	
```

5. run a mysql service

6. $ php app/console doctrine:database:create

7. $ php app/console doctrine:schema:update --force

8. $ php app/console server:run

## Usage

Go to localhost:8000 in your browser to send yours files

sample of files format accepted:

```
<?xml version="1.0" encoding="UTF-8"?>
<product type="car">
	<name>Fusca</name>
	<brand>Volkswagen</brand>
	<color>White</color>
	<year>1970</year>
</product>

OR

<?xml version="1.0" encoding="UTF-8"?>
<product type="cellphone">
	<brand>Motorola</brand>
	<model>Z3</model>
	<color>black</color>
</product>
```

## API Documentation and Tests

Go to the localhost:8000/api/doc

To register a new user, enable the below line: 

	# - { path: ^/api/users/new, roles: [IS_AUTHENTICATED_ANONYMOUSLY] }

and send a request from localhost:8000/api/doc (/api/users/new) or you can use the postman to test the api

body request to register a new user:
```
{ 
	"name":"User Test",
	"username": "usertest",
	"password": 123123
}
```

body request to get a auth token
```
{
	"username": "usertest",
	"password": "123123"
}
```

## Unit and Functional Tests

$ path/your/project/bin/simple-phpnuit -c ../app

## Built With

* [Composer](https://getcomposer.org/)
* [Symfony](http://www.symfony.com/doc/2.8/)
* [Doctrine](https://www.doctrine-project.org/)
* [Mysql](https://www.mysql.com/)

## License

Free
