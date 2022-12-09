define do_exec
	docker-compose exec -it --user=$$(id -u):$$(id -g)${1}
endef

.PHONY: run composer/install up stop down destroy
.DEFAULT_GOAL := run

run: up composer/install

composer/install:
	$(call do_exec, php composer install)

.env:
	cp .env.dist $@

up: .env
	docker-compose up --remove-orphans --detach

stop:
	docker-compose stop --remove-orphans

down:
	docker-compose down --remove-orphans

destroy:
	docker-compose down --remove-orphans -v
