default: init

init: get-phpcpd composer start sql csv

test: rector phpcpd phpmd phpstan psalm

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

get-phpcpd:
	wget https://phar.phpunit.de/phpcpd.phar
	chmod +x ./phpcpd.phar

composer:
	composer update

csv:
	-php public/generatecsv.php

start:
	docker-compose up -d
	@echo "you can now open the browser to test the upload form: http://localhost:8089/public/"
	@echo "or adminer to look into the database: http://localhost:8080/?server=mysql-csvimporter&username=csvimporter&db=csv&password=csvimporterpassword"
	@echo "to shutdown docker run: make stop"

stop:
	docker-compose down

sql:
	docker exec -i csvimporter_mysql-csvimporter_1 mysql -uroot -pexample < dist/fixtures.sql
	echo "database, table and account should be created now."