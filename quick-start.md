# Quick Start Guide

## Installation Steps

1. Clone and prepare the project:
```bash
git clone https://github.com/animan01/lucky-game-laravel.git
cd lucky-game-laravel
cp .env.example .env
```

2. Start Docker containers:
```bash
docker-compose up -d
```

3. Set up Laravel application:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

4. Visit the application:
```
http://localhost:8000
```
