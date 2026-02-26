DOCKER_COMPOSE = docker compose
EXEC_PHP = $(DOCKER_COMPOSE) exec php
EXEC_NODE = $(DOCKER_COMPOSE) exec node
EXEC_MYSQL = $(DOCKER_COMPOSE) exec mysql

.PHONY: migrate docker-down docker-up docker-down-force npm-install npm-build

docker-up:
	$(DOCKER_COMPOSE) up -d --build

docker-down:
	docker compose down

docker-down-force:
	docker compose down -v

keys:
	$(EXEC_PHP) php artisan key:generate
	

composer-install:
	$(EXEC_PHP) composer install

database-drop-data:
	sudo rm -rf docker/database/data
	mkdir docker/database/data

set-env:
	$(EXEC_PHP) cp .env.example .env

migrate:
	$(EXEC_PHP) php artisan migrate --seed

npm-install:
	$(EXEC_NODE) npm install

npm-build:
	$(EXEC_NODE) npm run build

init: docker-up set-env composer-install keys migrate npm-install npm-build

