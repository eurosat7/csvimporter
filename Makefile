default: init

init: get-phpcpd composer start docker-test docker-sql docker-php-csv docker-php-test

test: rector phpcpd phpmd phpstan psalm

get-phpcpd:
	wget https://phar.phpunit.de/phpcpd.phar -nc -O ./phpcpd.phar || true
	chmod +x ./phpcpd.phar

composer:
	composer update

start:
	docker-compose up -d
	@echo "you can now open the browser to test the upload form: http://localhost:8089/public/"
	@echo "or adminer to look into the database: http://localhost:8080/?server=mysql-csvimporter&username=csvimporter&db=csv&password=csvimporterpassword"
	@echo "or telnet with memcached: tcp://localhost:12221"
	@echo "to shutdown docker run: make stop"

stop:
	docker-compose down

docker-sql:
	docker exec -i csvimporter_mysql-csvimporter_1 mysql -uroot -pexample < dist/fixtures.sql
	echo "database, table and account should be created now."

docker-php-csv:
	docker-compose exec webserver php public/generatecsv.php

rector:
	./vendor/bin/rector -n

phpcpd:
	./phpcpd.phar src

phpmd:
	./vendor/bin/phpmd src text cleancode,codesize,controversial,design,unusedcode

phpstan:
	php vendor/bin/phpstan

psalm:
	./vendor/bin/psalm

docker-php-test:
	docker-compose exec webserver php test/test.php

docker-test:
	docker-compose exec webserver make test

