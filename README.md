# Preview
![Kapture 2025-01-21 at 09 43 42](https://github.com/user-attachments/assets/b39d9975-1dc4-4e4f-9cb3-34f9f8cb5bf2)


# Lucky Game

A simple web-based game built with Laravel 11, PostgreSQL, and Redis.

## Tech Stack

- PHP 8.2
- Laravel 11
- PostgreSQL 15
- Redis
- Docker & Docker Compose
- Tailwind CSS

## Requirements

- Docker
- Docker Compose
- Git

## Installation

1. Clone the repository:
```bash
git clone https://github.com/animan01/lucky-game-laravel.git
cd lucky-game-laravel
```

2. Copy the environment file:
```bash
cp .env.example .env
```

3. Start Docker containers:
```bash
docker-compose up -d
```

4. Install PHP dependencies:
```bash
docker-compose exec app composer install
```

5. Generate application key:
```bash
docker-compose exec app php artisan key:generate
```

6. Run database migrations:
```bash
docker-compose exec app php artisan migrate
```

7. Visit the application:
```
http://localhost:8000
```

## Game Rules

1. Register with username and phone number
2. Get a unique link valid for 7 days
3. Play the game by clicking "I'm Feeling Lucky"
4. Win or lose based on random number:
   - Even number = Win
   - Odd number = Lose
5. Win amount calculation:
   - Number > 900: 70% of the number
   - Number > 600: 50% of the number
   - Number > 300: 30% of the number
   - Number ≤ 300: 10% of the number

## Container Management

### View running containers:
```bash
docker-compose ps
```

### View container logs:
```bash
docker-compose logs -f [service_name]
```

### Stop containers:
```bash
docker-compose down
```

### Rebuild containers:
```bash
docker-compose up -d --build
```

## Database Management

### Fresh migration:
```bash
docker-compose exec app php artisan migrate:fresh
```

## Cache Management

### Clear application cache:
```bash
docker-compose exec app php artisan cache:clear
```

### Clear config cache:
```bash
docker-compose exec app php artisan config:clear
```

## Troubleshooting

1. If the site is not accessible:
   - Check if all containers are running: `docker-compose ps`
   - Check nginx logs: `docker-compose logs nginx`
   - Ensure port 8000 is not in use

2. Database connection issues:
   - Verify database credentials in .env
   - Check if PostgreSQL container is running
   - Check database logs: `docker-compose logs database`

3. Permission issues:
   - Run: `docker-compose exec app chown -R www-data:www-data storage`
   - Run: `docker-compose exec app chmod -R 775 storage`

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

The GPL-3.0 license. Please see [License File](LICENSE) for more information.
