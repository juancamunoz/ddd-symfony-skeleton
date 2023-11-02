#!/bin/bash

DOCKER_BE = ddd-skeleton-be
UID = $(shell id -u)

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
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

ssh-be: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

container-names: ## change default container names (need param name)
	find . -type f -exec sed -i 's/ddd-skeleton/$(name)/g' {} +
