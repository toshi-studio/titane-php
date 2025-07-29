.PHONY: help dev up down build logs shell db-shell clean setup ssl-cert

# Default target
help:
	@echo "Titane Development Commands"
	@echo "=========================="
	@echo "make dev       - Start all services in development mode"
	@echo "make up        - Start all services in background"
	@echo "make down      - Stop all services"
	@echo "make build     - Build/rebuild Docker images"
	@echo "make logs      - View container logs"
	@echo "make shell     - Access PHP container shell"
	@echo "make db-shell  - Access MariaDB shell"
	@echo "make clean     - Clean up containers and volumes"
	@echo "make setup     - Initial project setup"
	@echo "make ssl-cert  - Generate SSL certificates"

# Start development environment
dev:
	docker compose up --build

# Start services in background
up:
	docker compose up -d

# Stop services
down:
	docker compose down

# Build/rebuild images
build:
	docker compose build --no-cache

# View logs
logs:
	docker compose logs -f

# Access PHP container shell
shell:
	docker compose exec -u symfony ttn-php bash

# Access MariaDB shell
db-shell:
	docker compose exec ttn-mariadb mysql -u${DB_USER:-titane} -p${DB_PASSWORD:-titane} ${DB_DATABASE:-titane}

# Clean up everything
clean:
	docker compose down -v
	rm -rf titane/var/cache/*
	rm -rf titane/var/log/*

# Initial setup
setup: ssl-cert
	@if [ ! -f .env ]; then cp .env.example .env; echo "Created .env file from .env.example"; fi
	@echo "Creating titane directory for Symfony project..."
	@mkdir -p titane
	@echo "Setup complete! Run 'make dev' to start the development environment."

# Generate SSL certificates
ssl-cert:
	@echo "Generating self-signed SSL certificates..."
	@mkdir -p docker/apache/ssl
	@openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
		-keyout docker/apache/ssl/selfsigned.key \
		-out docker/apache/ssl/selfsigned.crt \
		-subj "/CN=localhost" 2>/dev/null || true
	@echo "SSL certificates generated in docker/apache/ssl/"