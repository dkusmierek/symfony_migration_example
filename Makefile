build:
	docker run --rm -v $(CURDIR):/app -w /app composer --optimize-autoloader install

start:
	docker-compose up -d
	docker-compose run --rm app php bin/console cache:clear
	docker-compose run --rm app php legacy/symfony cache:clear

stop:
	docker-compose down
