# Boilerplate for projects with PHP 8.2 FPM, MySQL 8.0 and Nginx with Docker & Docker Compose

This repository contains the basic configuration for a complete local environment for Laravel Projects with docker

### Content:
- NGINX 1.19 container to handle HTTP requests
- PHP 8.2 container to host your Laravel application
- MySQL 8.0 container to store databases

### Installation:
- Run `make container-names name=desired-container-names` to change the default `app-docker` container names
- Run `make build` to create all containers
- Run `make up` to spin up containers
- Enter the PHP container with `make ssh-be`
- Install the desired PHP framework
  + Laravel: `composer create-project laravel/laravel app`
  + Symfony: `composer create-project symfony/skeleton:"6.3.*" app`
- Move the content to the root folder with `mv app/* .`. This is necessary since Composer won't install the project if the folder already contains data.
- Copy the hidden files in the app folder `.gitignore .env .env.example` and paste it in the root's folder
- Remove `app` folder (not needed anymore)
- Navigate to `localhost:1000` so you can see the running webserver
