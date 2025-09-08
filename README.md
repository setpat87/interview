- Instructions to run: docker-compose up --build

	I've used laravel sail which is inbuilt in laravel for docker

	# Step1:
	You'll have to install sail globally

	`composer require laravel/sail --dev`

	# Step2:

	Install sail into the laravel project

	`php artisan sail:install`

	# Step3:
	Start the sail(Docker)

	`./vendor/bin/sail up`

	you can stop with this command

	`./vendor/bin/sail down`


	# Running Artisan commands locally...
	`php artisan {command}`
	 
	# Running Artisan commands within Laravel Sail...
	`sail artisan {command}`


	but if docker-compose file is required, I have added it in git repo.



- How to test login and call the API (e.g., using curl/Postman)

	You can test the get top customer api using postman

	URL : http://localhost/api/




- A list of API endpoints with methods, URLs, and authentication info

	GET http://localhost/api/top-customers