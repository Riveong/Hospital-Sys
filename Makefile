.PHONY: help install serve clean test migrate migrate-rollback migrate-refresh seed cache-clear routes

# Colors for output
BLUE=\033[0;34m
GREEN=\033[0;32m
NC=\033[0m # No Color

help: ## Show this help message
	@echo "$(BLUE)Hospital-Sys CodeIgniter 4 - Available Commands$(NC)"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)%-20s$(NC) %s\n", $$1, $$2}'

install: ## Install CodeIgniter 4 and dependencies
	@echo "$(BLUE)Installing CodeIgniter 4...$(NC)"
	@chmod +x setup.sh
	@./setup.sh

serve: ## Start development server
	@echo "$(GREEN)Starting development server at http://localhost:8080$(NC)"
	@php spark serve

serve-custom: ## Start development server on custom host and port (make serve-custom HOST=0.0.0.0 PORT=8081)
	@php spark serve --host=$(HOST) --port=$(PORT)

clean: ## Clean cache and logs
	@echo "$(BLUE)Cleaning cache and logs...$(NC)"
	@php spark cache:clear
	@php spark logs:clear
	@echo "$(GREEN)Done!$(NC)"

test: ## Run tests
	@echo "$(BLUE)Running tests...$(NC)"
	@./vendor/bin/phpunit

migrate: ## Run database migrations
	@echo "$(BLUE)Running migrations...$(NC)"
	@php spark migrate
	@echo "$(GREEN)Migrations complete!$(NC)"

migrate-rollback: ## Rollback last migration
	@echo "$(BLUE)Rolling back migrations...$(NC)"
	@php spark migrate:rollback

migrate-refresh: ## Refresh all migrations
	@echo "$(BLUE)Refreshing migrations...$(NC)"
	@php spark migrate:refresh

seed: ## Run database seeders (make seed SEEDER=PatientSeeder)
	@echo "$(BLUE)Running seeders...$(NC)"
ifdef SEEDER
	@php spark db:seed $(SEEDER)
else
	@php spark db:seed DatabaseSeeder
endif

cache-clear: ## Clear application cache
	@php spark cache:clear
	@echo "$(GREEN)Cache cleared!$(NC)"

routes: ## List all routes
	@php spark routes

key-generate: ## Generate encryption key
	@php spark key:generate --force

composer-install: ## Install composer dependencies
	@composer install

composer-update: ## Update composer dependencies
	@composer update

controller: ## Create a new controller (make controller NAME=Patient)
	@php spark make:controller $(NAME)

model: ## Create a new model (make model NAME=Patient)
	@php spark make:model $(NAME)

migration: ## Create a new migration (make migration NAME=create_patients_table)
	@php spark make:migration $(NAME)

seeder: ## Create a new seeder (make seeder NAME=PatientSeeder)
	@php spark make:seeder $(NAME)

filter: ## Create a new filter (make filter NAME=AuthFilter)
	@php spark make:filter $(NAME)

entity: ## Create a new entity (make entity NAME=Patient)
	@php spark make:entity $(NAME)

setup-db: ## Create database and run migrations
	@echo "$(BLUE)Setting up database...$(NC)"
	@php -r "$$conn = new mysqli('localhost', 'root', ''); if ($$conn->connect_error) die('Connection failed'); $$conn->query('CREATE DATABASE IF NOT EXISTS hospital_sys CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); echo 'Database created\n';"
	@php spark migrate
	@echo "$(GREEN)Database setup complete!$(NC)"

dev: ## Full development setup (install + migrate + serve)
	@make install
	@make migrate
	@make serve
