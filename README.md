# 🍲 Boilerplate for Symfony DDD Projects

This repository contains the basic configuration for a complete local environment for Symfony Projects with docker

### 📘 Content:
- NGINX 1.19 container to handle HTTP requests
- PHP 8.2 container to host your Symfony application
- MySQL 8.0 container to store databases
- RabbitMQ 3 container to handle asynchronous messages
- Supervisor container to create workers for handling asynchronous messages

### 🖱️ Installation:
- Run `make build` to create all containers
- Run `make up` to spin up containers
- Run `make composer-install` to install all needed dependencies
- Enter the PHP container with `make cli`
- Run `make test-unit` and `make test-acceptance-behat` to execute unit & acceptance tests
- Move `.env.example` to `.env` and fill necessary data
- Navigate to `localhost:1000` so you can see the running application
