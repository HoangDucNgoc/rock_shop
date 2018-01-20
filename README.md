# Description 
	- Service gateway wrote follow  Lumen Microservice Skeleton
		- [About]
		- [Installation]
		- [Configuration]
		- [Features]
		    - [Calling other microservices]
		    - [Circuit Breaker]
		    - [Requests Limiter]
	- facade.php new class : objectservice and objectendpoint 
	- Each service can log request, response , and error

# Document 

# Technology
	- php 7.0
	- lumen laravel 5.5
	
# Install
	- filter ip via apache
# Config
	- soure : https://github.com/HoangDucNgoc/rock_shop
	- composer update 
	- copy .env.example --> .env 
		- config ip service
		- config PRIVATE_GATEWAY_KEY
		- config PRIVATE_REQUEST_KEY (value must same PRIVATE_GATEWAY_KEY)
# how to run
   	- create NameService : name , uri  
   	- create NameEndPoint : url api, method , async