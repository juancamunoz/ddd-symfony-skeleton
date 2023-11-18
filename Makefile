#!/bin/bash

DOCKER_BE = ddd-skeleton-be
UID = $(shell id -u)

#Colours
greenColour=\e[0;32m\033[1m
close=\033[0m\e[0m
redColour=\e[0;31m\033[1m
blueColour=\e[0;34m\033[1m
yellowColour=\e[0;33m\033[1m
purpleColour=\e[0;35m\033[1m
turquoiseColour=\e[0;36m\033[1m
grayColour=\e[0;37m\033[1m

help: ## Show this help message
	@echo
	@echo "$(greenColour)======= Usage:$(close) make $(purpleColour)[target]$(close) $(greenColour)======= $(close)"
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

up: ## Start the containers
	$(MAKE) copy-files
	U_ID=${UID} docker-compose up -d

down: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	$(MAKE) copy-files
	U_ID=${UID} docker-compose build

copy-files: ## Creates a copy of .env and docker-compose.yml.dist file to use locally
	cp -n .env .env.local || true
	cp -n docker-compose.yml.dist docker-compose.yml || true

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

cli: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

container-names: ## Change default container names (need param name)
	find . -type f -exec sed -i 's/ddd-skeleton/$(name)/g' {} +

reset-symfony-test-cache: ## Clear testing cache
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console cache:clear --env=test

recreate-db: ## Recreate database
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console d:sc:drop -n -q -f --full-database
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console d:mi:mi -n

load-db-fixtures: ## Load fixtures
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console d:f:load -n

test-unit: ## Execute unit tests
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/phpunit

test-acceptance-behat: ## Execute behat tests
	make reset-symfony-test-cache
	make load-db-fixtures
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} vendor/bin/behat
