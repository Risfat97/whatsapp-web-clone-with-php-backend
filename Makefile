# Variable Definitions
UID := $(shell id -u)
GID := $(shell id -g)
WEBSERVER_NAME := webserver

# Docker Network
# NETWORK_NAME := shared

# Docker Compose Command
DOCKER_COMPOSE := DOCKER_UID=$(UID):$(GID) docker compose

# Aliases
mg := migration_generate
pmg := migration_prev

# Targets
build: stack_up build_containers composer migration
up: stack_up composer migration
stop: stop_containers
down: stop_containers
clean: stop_containers remove_containers
logs: display_container_logs

stack_up:
	$(DOCKER_COMPOSE) up -d

build_containers:
	$(DOCKER_COMPOSE) build

stop_containers:
	$(DOCKER_COMPOSE) stop

remove_containers: stop_containers
	$(DOCKER_COMPOSE) rm -f

display_container_logs:
	$(DOCKER_COMPOSE) logs -f --tail=0 --follow

bash:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) bash

# Composer
composer:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) composer install --verbose

# Doctrine Migration
migration_generate:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) ./vendor/bin/doctrine-migrations generate --configuration=./config/migrations.php --db-configuration=./config/migrations-db.php

migration:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) ./vendor/bin/doctrine-migrations migrate --no-interaction --allow-no-migration --configuration=./config/migrations.php --db-configuration=./config/migrations-db.php

migration_prev:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) ./vendor/bin/doctrine-migrations migrate prev --no-interaction --allow-no-migration --configuration=./config/migrations.php --db-configuration=./config/migrations-db.php

migration_first:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) ./vendor/bin/doctrine-migrations migrate first --no-interaction --allow-no-migration --configuration=./config/migrations.php --db-configuration=./config/migrations-db.php

migration_up:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) php commands/migration-command.php upVersion --version=$(VERSION)

migration_down:
	$(DOCKER_COMPOSE) exec $(WEBSERVER_NAME) php commands/migration-command.php downVersion --version=$(VERSION)